<?php

namespace Src\Recommendation\Services;

use App\Facades\ImageServiceFacade;
use App\Facades\PdfFacade;
use App\Services\PdfService;
use App\Traits\HelperDate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;
use Src\Recommendation\Enums\RecommendationStatusEnum;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Recommendation\Models\ApplyRecommendationDocument;
use Src\Recommendation\Models\Recommendation;
use App\Facades\FileFacade;
use Src\Recommendation\Traits\RecommendationTemplate;

class RecommendationService
{
    use RecommendationTemplate;
    protected $path;

    public function __construct()
    {
        $this->path = config('src.Recommendation.recommendation.path');
    }

    public function create($data, $customer): ?ApplyRecommendation
    {
        $recommendation = Recommendation::where('id', $data->recommendation_id)->first();
        DB::beginTransaction();
        try {
            $documents = [];
            $dataArray = $data->data;

            $this->handleFileData($dataArray, $documents);

            $recommendation = ApplyRecommendation::create([
                'customer_id' => $customer->id,
                'recommendation_id' => $data->recommendation_id,
                'data' => json_encode($dataArray),
                'status' => $data->status ?? RecommendationStatusEnum::PENDING,
                'remarks' => $data->remarks,
                'ward_id' => $data->ward_id,
                'local_body_id' => $data->local_body_id,
                'is_visible_to_public' => true,
                'is_ward' => $recommendation->is_ward_recommendation,
                'signee_id' => $data->signee_id ?? null,
                'signee_type' => $data->signee_type ?? null,
                'recommendation_medium' => $data->recommendation_medium ?? null,
                'fiscal_year_id' => $data->fiscal_year_id ?? key(getSettingWithKey('fiscal-year')),
                'created_at_en' => $data->created_at_en ?? null
            ]);

            foreach ($documents as &$document) {
                $document['apply_recommendation_id'] = $recommendation->id;
            }
            ApplyRecommendationDocument::insert($documents);
            DB::commit();
            return $recommendation;
        } catch (\Exception $exception) {
            logger($exception);
            DB::rollBack();
            return null;
        }
    }

    public function getAppliedRecommendations($customer): Collection
    {
        return QueryBuilder::for(ApplyRecommendation::class)
            ->where('customer_id', $customer->id)
            ->whereNull('deleted_by')
            ->allowedFilters(['id', 'status'])
            ->with([
                'documents',
                'recommendation',
                'recommendation.recommendationCategory',
                'recommendation.form:id,title,fields,module'
            ])
            ->allowedSorts(['created_at'])
            ->get();
    }

    public function getRecommendations($id): Collection
    {
        return QueryBuilder::for(Recommendation::class)
            ->allowedFilters(['id', 'title', 'revenue'])
            ->where('recommendation_category_id', $id)
            ->whereNull('deleted_at')
            ->whereNull('deleted_by')
            ->with([
                'recommendationCategory:id,title',
                'form:id,title,fields,module'
            ])
            ->allowedSorts(['created_at'])
            ->get();
    }
    public function getRecommendationForm($id): Collection
    {
        return QueryBuilder::for(Recommendation::class)
            ->allowedFilters(['id', 'title', 'revenue'])
            ->where('id', $id)
            ->with([
                'recommendationCategory:id,title',
                'form:id,title,fields,module'
            ])
            ->allowedSorts(['created_at'])
            ->get();
    }

    public function update(ApplyRecommendation $applyRecommendation, $dto, $customer)
    {
        DB::beginTransaction();
        try {
            $documents = [];
            $data = json_decode(json_encode($dto->data), true);

            $this->handleFileData($data, $documents);
            $applyRecommendation->update([
                'customer_id' => $customer->id,
                'recommendation_id' => $dto->recommendation_id,
                'data' => json_encode($data),
                'remarks' => $dto->remarks,
                'updated_at' => now(),
                'status' => RecommendationStatusEnum::PENDING,
                'signee_id' => $dto->signee_id ?? null,
                'signee_type' => $dto->signee_type ?? null,
                'recommendation_medium' => $dto->recommendation_medium?->value,
                'fiscal_year_id' => $dto->fiscal_year_id
            ]);

            foreach ($documents as &$document) {
                $document['apply_recommendation_id'] = $applyRecommendation->id;
            }

            ApplyRecommendationDocument::insert($documents);

            DB::commit();
            return $applyRecommendation;
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
            return null;
        }
    }

    public function delete(ApplyRecommendation $applyRecommendation)
    {
        $authUser = Auth::guard(Auth::getDefaultDriver())->user();

        return tap($applyRecommendation)->update([
            'deleted_by' => $authUser?->id,
            'deleted_at' => now(),
        ]);
    }

    public function getAppliedRecommendationDetail($appliedRecommendation): ?ApplyRecommendation
    {
        $applyRecommendation = ApplyRecommendation::with('recommendation', 'recommendation.recommendationCategory', 'form:id,title,fields,module')->findOrFail($appliedRecommendation);
        $data = json_decode($applyRecommendation->data, true);

        foreach ($data as $key => $value) {
            if ($value['type'] === 'file' && isset($value['value'])) {
                $fileUrls = array_map(fn($file) => ImageServiceFacade::getImage($this->path, $file, 'local'), $value['value']);
                $data[$key]['value'] = $fileUrls;
            }
        }

        $applyRecommendation->data = json_encode($data);
        return $applyRecommendation;
    }


    private function handleFileData(array &$dataArray, &$documents)
    {
        foreach ($dataArray as $key => &$item) {
            if ($item['type'] === 'file' && !empty($item['value'])) {
                foreach ($item['value'] as $index => $file) {
                    if (ImageServiceFacade::isBase64($file)) {
                        $savedFilePath = ImageServiceFacade::base64Save($file, $this->path, 'local');
                        $item['value'][$index] = $savedFilePath;
                    }

                    $documents[] = [
                        'title' => $item['label'],
                        'document' => $item['value'][$index],
                        'status' => RecommendationStatusEnum::PENDING,
                    ];
                }
            }
        }
    }

    public function getLetter(ApplyRecommendation $applyRecommendation, $request = 'web')
    {
        try {
            $is_draft = $applyRecommendation->records->first()?->reg_no ? false : true;

            // if($applyRecommendation->additional_letter)
            // {
            //     RecommendationService::updateAdditionalLetter($applyRecommendation, $applyRecommendation->records->first()?->reg_no);
            // }

            $html = $applyRecommendation->additional_letter ?? $this->resolveRecommendationTemplate($applyRecommendation);
            $url = PdfFacade::saveAndStream(
                content: $html,
                file_path: config('src.Recommendation.recommendation.certificate'),
                file_name: "recommendation_{$applyRecommendation->id}",
                disk: "local",
                is_draft: false,
                styles: $applyRecommendation->recommendation?->form?->styles
            );
            if ($request === 'web') {
                return redirect()->away($url);
            }

            return $url;
        } catch (\Exception $exception) {
            logger('Exception: ' . $exception->getMessage() . ' in ' . $exception->getFile() . ' on line ' . $exception->getLine());
            logger('Stack trace: ' . $exception->getTraceAsString());
            return null;
        }
    }

    public function updateAdditionalLetter(ApplyRecommendation $applyRecommendation, int $regNumber)
    {
        $additionalLetter = $applyRecommendation->additional_letter;
        $number = replaceNumbers($regNumber, 'nepali');

        $updatedLetter = str_replace(
            'चलानी नं./Dis. No.:</td>',
            'चलानी नं./Dis. No.: ' . $number . '</td>',
            $additionalLetter
        );

        $applyRecommendation->update([
            'additional_letter' => $updatedLetter,
        ]);

        return $applyRecommendation;
    }

}

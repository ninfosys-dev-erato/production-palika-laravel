<?php

namespace Src\Recommendation\Services;

use App\Facades\FileTrackingFacade;
use App\Jobs\RecommendationStatusLogJob;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Src\Recommendation\DTO\ApplyRecommendationShowDto;
use Src\Recommendation\DTO\RecommendationAdminDto;
use Src\Recommendation\Enums\RecommendationLevel;
use Src\Recommendation\Enums\RecommendationStatusEnum;
use Src\Recommendation\Models\Recommendation;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Recommendation\Models\RecommendationCategory;
use Src\Roles\Models\Role;

class RecommendationAdminService
{
    public function store(RecommendationAdminDto $recommendationAdminDto, $selectedRoles, $selectedDepartments)
    {
        return DB::transaction(function () use ($recommendationAdminDto, $selectedRoles, $selectedDepartments) {
            $recommendation = Recommendation::create([
                'title' => $recommendationAdminDto->title,
                'recommendation_category_id' => $recommendationAdminDto->recommendation_category_id,
                'form_id' => $recommendationAdminDto->form_id,
                'revenue' => $recommendationAdminDto->revenue,
                'is_ward_recommendation' => $recommendationAdminDto->is_ward_recommendation ?? 0,
                // 'notify_to' => $recommendationAdminDto->notify_to,
                // 'accepted_by' => $recommendationAdminDto->accepted_by,
                'created_at' => now(),
                'created_by' => Auth::user()->id,
            ]);
            $recommendation->roles()->sync($selectedRoles);
            $recommendation->departments()->sync($selectedDepartments);
            if (!empty($recommendationAdminDto->recommendationDocuments)) {
                foreach ($recommendationAdminDto->recommendationDocuments as $recommendationDocument) {
                    $recommendation->recommendationDocuments()->create([
                        'title' => $recommendationDocument['title'] ?? '',
                        'is_required' => $recommendationDocument['is_required'] ?? false,
                        'accept' => $recommendationDocument['accept'] ?? '',
                    ]);
                }
            }


            return $recommendation;
        });
    }

    public function update(Recommendation $recommendation, RecommendationAdminDto $recommendationAdminDto, $selectedRoles, $selectedDepartments)
    {
        return DB::transaction(function () use ($recommendation, $recommendationAdminDto, $selectedRoles, $selectedDepartments) {
            $recommendation->update([
                'title' => $recommendationAdminDto->title,
                'recommendation_category_id' => $recommendationAdminDto->recommendation_category_id,
                'form_id' => $recommendationAdminDto->form_id,
                'revenue' => $recommendationAdminDto->revenue,
                'is_ward_recommendation' => $recommendationAdminDto->is_ward_recommendation,
                // 'notify_to' => $recommendationAdminDto->notify_to,
                // 'accepted_by' => $recommendationAdminDto->accepted_by,
                'updated_at' => now(),
                'updated_by' => Auth::user()->id,
            ]);
            $recommendation->roles()->sync($selectedRoles);
            $recommendation->departments()->sync($selectedDepartments);

            if (!empty($recommendationAdminDto->recommendationDocuments)) {
                foreach ($recommendationAdminDto->recommendationDocuments as $recommendationDocument) {
                    if (array_key_exists('id', $recommendationDocument)) {
                        $recommendation->recommendationDocuments
                            ->where('id', $recommendationDocument['id'])
                            ?->first()
                            ?->update([
                                'title' => $recommendationDocument['title'] ?? '',
                                'is_required' => $recommendationDocument['is_required'] ?? false,
                                'accept' => $recommendationDocument['accept'] ?? '',
                            ]);
                    } else {
                        $recommendation->recommendationDocuments()->create([
                            'title' => $recommendationDocument['title'] ?? '',
                            'is_required' => $recommendationDocument['is_required'] ?? false,
                            'accept' => $recommendationDocument['accept'] ?? '',
                        ]);
                    }
                }
            }

            return $recommendation;
        });
    }

    public function delete(Recommendation $recommendation)
    {
        return tap($recommendation)->update([
            'deleted_at' => date('Y-m-d H:i:s', strtotime('now')),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        Recommendation::whereIn('id', $numericIds)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function uploadBill(ApplyRecommendation $applyRecommendation, $applyRecommendationShowDto, bool $customer = false)
    {
        FileTrackingFacade::recordFile($applyRecommendation, customer: $customer);
        $originalAttributes = $applyRecommendation->getOriginal();
        tap($applyRecommendation)->update([
            'ltax_ebp_code' => $applyRecommendationShowDto->ltax_ebp_code,
            'bill' => $applyRecommendationShowDto->bill,
            'status' => RecommendationStatusEnum::BILL_UPLOADED->value,
            'rejected_by' => null,
            'rejected_reason' => null,
            'rejected_at' => null,
        ]);
        $newAttributes = $applyRecommendation->getAttributes();
        RecommendationStatusLogJob::dispatch(
            $applyRecommendation,
            $originalAttributes,
            $newAttributes
        );
        return $applyRecommendation;
    }

    public function reject(ApplyRecommendation $applyRecommendation, ApplyRecommendationShowDto $applyRecommendationShowDto)
    {
        FileTrackingFacade::recordFile($applyRecommendation);
        $originalAttributes = $applyRecommendation->getOriginal();
        tap($applyRecommendation)->update([
            'rejected_by' => Auth::user()->id,
            'rejected_reason' => $applyRecommendationShowDto->rejected_reason,
            'rejected_at' => now(),
            'status' => RecommendationStatusEnum::REJECTED->value
        ]);
        $newAttributes = $applyRecommendation->getAttributes();
        RecommendationStatusLogJob::dispatch(
            $applyRecommendation,
            $originalAttributes,
            $newAttributes
        );

        return $applyRecommendation;
    }

    public function accept(ApplyRecommendation $applyRecommendation): ApplyRecommendation
    {
        FileTrackingFacade::recordFile($applyRecommendation);
        $originalAttributes = $applyRecommendation->getOriginal();

        tap($applyRecommendation)->update([
            'accepted_at' => now(),
            'accepted_by' => Auth::user()->id,
            'status' => RecommendationStatusEnum::ACCEPTED->value,
            'rejected_by' => null,
            'rejected_reason' => null,
            'rejected_at' => null,
        ]);
        $newAttributes = $applyRecommendation->getAttributes();
        RecommendationStatusLogJob::dispatch(
            $applyRecommendation,
            $originalAttributes,
            $newAttributes
        );
        return $applyRecommendation;
    }

    public function review(ApplyRecommendation $applyRecommendation): ApplyRecommendation
    {
        FileTrackingFacade::recordFile($applyRecommendation);
        $originalAttributes = $applyRecommendation->getOriginal();
        tap($applyRecommendation)->update([
            'reviewed_at' => now(),
            'reviewed_by' => Auth::user()->id,
            'status' => RecommendationStatusEnum::SENT_FOR_APPROVAL->value,
            'rejected_by' => null,
            'rejected_reason' => null,
            'rejected_at' => null,
        ]);
        $newAttributes = $applyRecommendation->getAttributes();
        RecommendationStatusLogJob::dispatch(
            $applyRecommendation,
            $originalAttributes,
            $newAttributes
        );

        return $applyRecommendation;
    }

    public function sentForPayment(ApplyRecommendation $applyRecommendation): ApplyRecommendation
    {
        FileTrackingFacade::recordFile($applyRecommendation);

        $originalAttributes = $applyRecommendation->getOriginal();
        $revenue = $applyRecommendation->recommendation->revenue ?? 0;
        $status = $revenue <= 0
            ? RecommendationStatusEnum::SENT_FOR_APPROVAL->value
            : $applyRecommendation->status;

        tap($applyRecommendation)->update([
            'status' => $status,
            'rejected_by' => null,
            'rejected_reason' => null,
            'rejected_at' => null,
        ]);
        $newAttributes = $applyRecommendation->getAttributes();
        RecommendationStatusLogJob::dispatch(
            $applyRecommendation,
            $originalAttributes,
            $newAttributes
        );
        return $applyRecommendation;
    }


    public function sendToApprover(ApplyRecommendation $applyRecommendation)
    {
        FileTrackingFacade::recordFile($applyRecommendation);
        $originalAttributes = $applyRecommendation->getOriginal();
        tap($applyRecommendation)->update([
            'status' => RecommendationStatusEnum::SENT_FOR_APPROVAL->value,

        ]);
        $newAttributes = $applyRecommendation->getAttributes();
        RecommendationStatusLogJob::dispatch(
            $applyRecommendation,
            $originalAttributes,
            $newAttributes
        );

        return $applyRecommendation;
    }

    public function setSignee(ApplyRecommendation $applyRecommendation , Model $signee)
    {
        DB::transaction(function () use ($applyRecommendation, $signee) {
            $applyRecommendation->refresh();
            $applyRecommendation->forceFill([
                'signee_id' => $signee->id,
                'signee_type' => get_class($signee),
            ])->save();
        });

        
    }

    public function categoryTree(RecommendationLevel $level = null) : RecommendationCategory | Collection
    {
        return RecommendationCategory::with([
            'recommendations' => function ($query) use ($level) {
                if ($level !== null) {
                    $query->where('is_ward_recommendation', $level->is_ward());
                }
                $query->whereNull('deleted_at') // whereNull recommendations ko lagi
                ->whereNull('deleted_by') ;//

            }
        ])
            ->select('id', 'title')
            ->whereNull('deleted_at') // whereNull categories ko lagi
            ->whereNull('deleted_by')
            ->withCount('recommendations')
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'title' => $category->title,
                    'recommendations_count' => $category->recommendations_count,
                    'recommendations' => $category->recommendations->map(function ($rec) {
                        return [
                            'id' => $rec->id,
                            'title' => $rec->title,
                            'is_ward_recommendation' => $rec->is_ward_recommendation,
                        ];
                    }),
                ];
            });
    }
}

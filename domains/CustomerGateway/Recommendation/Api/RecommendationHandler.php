<?php

namespace Domains\CustomerGateway\Recommendation\Api;

use App\Facades\FileFacade;
use App\Facades\ImageServiceFacade;
use App\Http\Controllers\Controller;
use App\Services\FileService;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\Recommendation\DTO\ApplyRecommendationDto;
use Domains\CustomerGateway\Recommendation\Requests\ApplyRecommendationRequest;
use Domains\CustomerGateway\Recommendation\Resources\ApplyRecommendationResource;
use Domains\CustomerGateway\Recommendation\Resources\RecommendationResource;
use Domains\CustomerGateway\Recommendation\Services\ApplyRecommendationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Src\Recommendation\DTO\ApplyRecommendationShowDto;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Recommendation\Models\RecommendationCategory;
use Src\Recommendation\Services\RecommendationAdminService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class RecommendationHandler extends Controller
{
    use ApiStandardResponse;

    protected $applyRecommendationService;

    public function __construct(ApplyRecommendationService $applyRecommendationService)
    {
        $this->applyRecommendationService = $applyRecommendationService;
    }

    public function create(ApplyRecommendationRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $dto = ApplyRecommendationDto::fromValidatedRequest($data);

            $customer = Auth::guard('api-customer')->user();
            $response = $this->applyRecommendationService->createRecommendation($dto, $customer);

            $recommendation = new ApplyRecommendationResource($response);

            return $this->generalSuccess([
                'message' => __('Recommendation created successfully'),
                'data' => $recommendation
            ]);
        } catch (\Exception $exception) {
            return $this->generalFailure([
                'error' => __('Failed to create recommendation.'),
                'details' => $exception->getMessage()
            ]);
        }
    }

    public function update( int $id, ApplyRecommendationRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $applyRecommendation = $this->findAndAuthorizeRecommendation($id);

            if ($applyRecommendation instanceof JsonResponse) {
                return $applyRecommendation;
            }

            $dto = ApplyRecommendationDto::fromValidatedRequest($data);

            $customer = Auth::guard('api-customer')->user();
            $response = $this->applyRecommendationService->updateRecommendation($applyRecommendation,$dto, $customer);

            $recommendation = new ApplyRecommendationResource($response);

            return $this->generalSuccess([
                'message' => __('Recommendation updated successfully'),
                'data' => $recommendation
            ]);
        } catch (\Exception $exception) {
            return $this->generalFailure([
                'error' => __('Failed to create recommendation.'),
                'details' => $exception->getMessage()
            ]);
        }
    }

    public function getAppliedRecommendations(): AnonymousResourceCollection
    {
        $customer = Auth::guard('api-customer')->user();
        $response = $this->applyRecommendationService->getAppliedRecommendations($customer);
        return ApplyRecommendationResource::collection($response);
    }

    public function getRecommendationCategory()
    {
        $category = RecommendationCategory::whereNull('deleted_at')->whereNull('deleted_by')->get();

        return $this->generalSuccess([
            'message' => __("Recommendation categories."),
            'data' => $category
        ]);
    }

    public function getRecommendations(int $id)
    {
        $response = $this->applyRecommendationService->getRecommendations($id);
        $filteredData = $response->map(function ($recommendation) {
            return [
                'id' => $recommendation->id,
                'title' => $recommendation->title,
            ];
        });

        return $this->generalSuccess([
            'message' => __("Recommendations by categories."),
            'data' => $filteredData
        ]);
    }

    public function getRecommendationsForm(int $id): AnonymousResourceCollection
    {
        $response = $this->applyRecommendationService->getRecommendationForm($id);
        return RecommendationResource::collection($response);
    }

    public function getAppliedRecommendationDetail(int $id): JsonResponse
    {
        $applyRecommendation = $this->findAndAuthorizeRecommendation($id);

        if ($applyRecommendation instanceof JsonResponse) {
            return $applyRecommendation;
        }

        $data = $this->applyRecommendationService->getAppliedRecommendationDetail($id);

        return $this->generalSuccess([
            'message' => __("Applied Recommendation detail"),
            'data' => $data ? new ApplyRecommendationResource($data) : null
        ]);
    }

    public function uploadBill(Request $request, $id)
    {
        $applyRecommendation = $this->findAndAuthorizeRecommendation($id);

        if ($applyRecommendation instanceof JsonResponse) {
            return $applyRecommendation;
        }

        $applyRecommendation = ApplyRecommendation::where('id', $id)->first();

        if (!$applyRecommendation) {
            return $this->generalFailure(['message' => __('Recommendation not found')], 404);
        }
        

        $data = $request->validate(rules: [
            'ltax_ebp_code' => ['nullable', 'string'],
            'bill' => ['required']
        ]);
    
        $data['bill'] = ImageServiceFacade::base64Save($data['bill'], config('src.Recommendation.recommendation.bill'), 'local');
        $applyRecommendation->bill =  $data['bill'];
        $applyRecommendation->ltax_ebp_code = $data['ltax_ebp_code'] ?? str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);

        $dto = ApplyRecommendationShowDto::fromModel($applyRecommendation);
        $service = new RecommendationAdminService();

        $service->uploadBill($applyRecommendation, $dto, customer: true);

        return $this->generalSuccess([
            'message' => __('Bill uploaded successfully'),
        ]);
    }

    public function sendToApprover(int $id)
    {
        $applyRecommendation = $this->findAndAuthorizeRecommendation($id);

        if ($applyRecommendation instanceof JsonResponse) {
            return $applyRecommendation;
        }

        $applyRecommendation = ApplyRecommendation::where('id', $id)->first();
        if (!$applyRecommendation) {
            return $this->generalFailure(['message' => __('Recommendation not found')], 404);
        }

        $service = new RecommendationAdminService();

        $service->sendToApprover($applyRecommendation);

        return $this->generalSuccess([
            'message' => __('The recommendation has been sent for approval. Please wait until it is reviewed and approved by the approver.'),
        ]);
    }

    public function getletter(int $id)
    {
        $applyRecommendation = $this->findAndAuthorizeRecommendation($id);

        if ($applyRecommendation instanceof JsonResponse) {
            return $applyRecommendation;
        }

        $applyRecommendation = ApplyRecommendation::where('id', $id)->first();

        $response = $this->applyRecommendationService->getLetter($applyRecommendation);

        return $this->generalSuccess([
            'message' => 'PDF stored successfully!',
            'url' => $response
        ]);
    }

    private function findAndAuthorizeRecommendation(int $id)
    {
        $customer = Auth::guard('api-customer')->user();
        $applyRecommendation = ApplyRecommendation::find($id);

        if (!$applyRecommendation) {
            return $this->generalFailure(['error' => __('Recommendation not found.')]);
        }

        if ($applyRecommendation->customer_id !== $customer->id) {
            return $this->generalFailure([
                'error' => __('You are not authorized to update this recommendation.')
            ], 403);
        }

        return $applyRecommendation;
    }
}

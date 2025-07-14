<?php

namespace Domains\AdminGateway\StatusUpdate\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;
use Src\Recommendation\Enums\RecommendationStatusEnum;
use Src\Recommendation\Models\ApplyRecommendation;
use Exception;

class AdminStatusUpdateHandler extends Controller
{
    use ApiStandardResponse;

    public function updateRecommendationStatus(Request $request): JsonResponse
    {
        try {
            // Validate request
            $validated = $request->validate([
                'id' => 'required|integer',
                'status' => ['required', new Enum(RecommendationStatusEnum::class)],
                'remarks' => 'nullable|string',
            ]);

            // Manually fetch recommendation with soft delete check
            $recommendation = ApplyRecommendation::where('id', $validated['id'])
                ->whereNull('deleted_at')->first();

            // If not found, return error using generalFailure()
            if (!$recommendation) {
                return $this->generalFailure([
                    'message' => 'The given data was invalid.',
                    'errors' => [
                        'id' => ['The selected recommendation ID is invalid or has been deleted.'],
                    ],
                ], 422);
            }

            $recommendation->status = $validated['status'];
            $recommendation->save();

            // Return success response
            return $this->generalSuccess([
                'message' => 'Status changed successfully to ' . $validated['status']
            ]);

        } catch (ValidationException $e) {
            return $this->generalFailure([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return $this->generalFailure([
                'message' => 'Something went wrong while updating the status.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

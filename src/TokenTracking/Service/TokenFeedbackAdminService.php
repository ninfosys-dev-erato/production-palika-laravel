<?php

namespace Src\TokenTracking\Service;

use Illuminate\Support\Facades\Auth;
use Src\TokenTracking\DTO\TokenFeedbackAdminDto;
use Src\TokenTracking\Models\TokenFeedback;

class TokenFeedbackAdminService
{
    public function store(TokenFeedbackAdminDto $tokenFeedbackAdminDto)
    {
        return TokenFeedback::create([
            'token_id' => $tokenFeedbackAdminDto->token_id,
            'feedback' => $tokenFeedbackAdminDto->feedback,
            'rating' => $tokenFeedbackAdminDto->rating,
            'service_quality' => $tokenFeedbackAdminDto->service_quality,
            'service_accesibility' => $tokenFeedbackAdminDto->service_accesibility,
            'citizen_satisfaction' => $tokenFeedbackAdminDto->citizen_satisfaction,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(TokenFeedback $tokenFeedback, TokenFeedbackAdminDto $tokenFeedbackAdminDto)
    {
        return tap($tokenFeedback)->update([
            'token_id' => $tokenFeedbackAdminDto->token_id,
            'feedback' => $tokenFeedbackAdminDto->feedback,
            'rating' => $tokenFeedbackAdminDto->rating,
            'service_quality' => $tokenFeedbackAdminDto->service_quality,
            'service_accesibility' => $tokenFeedbackAdminDto->service_accesibility,
            'citizen_satisfaction' => $tokenFeedbackAdminDto->citizen_satisfaction,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(TokenFeedback $tokenFeedback)
    {
        return tap($tokenFeedback)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        TokenFeedback::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}

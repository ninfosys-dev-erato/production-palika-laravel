<?php

namespace Src\Recommendation\Services;

use Illuminate\Support\Facades\Auth;
use Src\Recommendation\DTO\RecommendationCategoryAdminDto;
use Src\Recommendation\Models\RecommendationCategory;

class RecommendationCategoryAdminService
{
    public function store(RecommendationCategoryAdminDto $recommendationCategoryAdminDto){
        return RecommendationCategory::create([
            'title' => $recommendationCategoryAdminDto->title,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(RecommendationCategory $recommendationCategory, RecommendationCategoryAdminDto $recommendationCategoryAdminDto){
        return tap($recommendationCategory)->update([
            'title' => $recommendationCategoryAdminDto->title,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(RecommendationCategory $recommendationCategory){
        return tap($recommendationCategory)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids){
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        RecommendationCategory::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

}

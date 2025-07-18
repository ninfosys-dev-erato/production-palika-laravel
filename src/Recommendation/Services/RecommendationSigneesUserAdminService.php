<?php

namespace Src\Recommendation\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Src\Recommendation\DTO\RecommendationSigneesUserAdminDto;
use Src\Recommendation\Models\RecommendationSigneesUser;

class RecommendationSigneesUserAdminService
{
    public function toggleUserAccess(RecommendationSigneesUserAdminDto $recommendationSigneesUserAdminDto){
        $row = RecommendationSigneesUser::where('user_id', $recommendationSigneesUserAdminDto->user_id)
            ->where('ward_id', $recommendationSigneesUserAdminDto->ward_id)
            ->where('recommendation_type_id', $recommendationSigneesUserAdminDto->recommendation_type_id);
        if($row->exists()){
            $this->delete($row);
        }else{
            $this->store($recommendationSigneesUserAdminDto);
        }

    }
    public function store(RecommendationSigneesUserAdminDto $recommendationSigneesUserAdminDto){
        return RecommendationSigneesUser::create([
            'user_id' => $recommendationSigneesUserAdminDto->user_id,
            'ward_id' => $recommendationSigneesUserAdminDto->ward_id,
            'recommendation_type_id' => $recommendationSigneesUserAdminDto->recommendation_type_id,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }

    public function delete(RecommendationSigneesUser | Builder $recommendationSigneesUser){
        return $recommendationSigneesUser->delete();
    }
}



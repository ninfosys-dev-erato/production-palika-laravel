<?php

namespace Domains\AdminGateway\Recommendation\Service;

use App\Facades\GlobalFacade;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Src\Recommendation\Models\ApplyRecommendation;

class ApplyRecommendationService {

    public function getRecommendations(User $user)  :Builder
    {
        $userDepartmentIds = $user->departments?->pluck('id')->toArray() ?? [];
        $userWardIds = (array) GlobalFacade::ward(); // Ensure it's an array
        $userRoleIds = $user->roles->pluck('id')->toArray() ?? [];

        $query = ApplyRecommendation::query()
            ->with(['customer.kyc', 'roles', 'recommendation.branches','records'])
            ->whereNull('rec_apply_recommendations.deleted_by')
            ->whereNull('rec_apply_recommendations.deleted_at')
            ->orderByDesc('rec_apply_recommendations.created_at');

        // Super Admins see all
        if ($user->hasRole('super-admin')) {
            return $query;
        }

        $query->where(function ($q) use ($userDepartmentIds, $userWardIds, $userRoleIds) {
            // Ward-based recommendations
            $q->where(function ($wardQ) use ($userWardIds, $userDepartmentIds) {
                $wardQ->where('rec_apply_recommendations.is_ward', true)
                    ->where(function ($innerQ) use ($userWardIds, $userDepartmentIds) {
                        $innerQ->whereIn('rec_apply_recommendations.ward_id', $userWardIds)
                            ->orWhereHas('recommendation.branches', function ($branchQ) use ($userDepartmentIds) {
                                $branchQ->whereIn('mst_branches.id', $userDepartmentIds);
                            });
                    });
            });

            // Department/Role-based recommendations
            $q->orWhere(function ($nonWardQ) use ($userDepartmentIds, $userRoleIds) {
                $nonWardQ->where('rec_apply_recommendations.is_ward', false)
                    ->where(function ($innerQ) use ($userDepartmentIds, $userRoleIds) {
                        $innerQ->whereHas('recommendation.branches', function ($branchQ) use ($userDepartmentIds, $userRoleIds) {
                            $branchQ->whereIn('mst_branches.id', $userDepartmentIds)
                                ->orWhereHas('users.roles', function ($roleQ) use ($userRoleIds) {
                                    $roleQ->whereIn('roles.id', $userRoleIds);
                                });
                        });
                    });
            });
        });

        return $query;
    }

}
<?php

namespace App\Services;

use Illuminate\Contracts\Database\Eloquent\Builder;

class FilterQueryService
{
    public function filterByRole(Builder $query, array $userRoleIds, $table_name = ""): Builder
    {
        if (empty($userRoleIds)) {
            return $query;
        }
        $query->whereHas('roles', function ($roleQuery) use ($userRoleIds) {
            $roleQuery->whereIn('roles.id', $userRoleIds);
        });
        return $query;
    }

    public function filterByWard(Builder $query, array $userWardIds,$table_name = ""): Builder
    {
        if (empty($userWardIds)) {
            return $query;
        }
        $query->where(function ($subQuery) use ($userWardIds, $table_name) {
            $subQuery->where(($table_name !== "" ? "{$table_name}." : "") . "is_ward", true)
                ->orWhere(function ($wardQuery) use ($userWardIds) {
                    $wardQuery
                        ->whereIn('ward_id', $userWardIds);
                });
        });
        return $query;
    }

    public function filterByDepartment(Builder $query, array $userDepartmentIds,$table_name = ""): Builder
    {
        if (empty($userDepartmentIds)) {
            return $query;
        }

        $query->whereHas(($table_name !== "" ? "{$table_name}." : "").'departments', function ($deptQuery) use ($userDepartmentIds,$table_name) {
            $deptQuery->whereIn('mst_branches.id', $userDepartmentIds);
        });

        return $query;
    }
}

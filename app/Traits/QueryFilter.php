<?php

namespace App\Traits;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait QueryFilter
{
    public static function filterByRole(Builder $query, string $relationShip, array $roleIds, string $relationKey = 'id'): Builder
    {
        if (empty($roleIds)) {
            return $query;
        }

        $query->whereHas($relationShip, function ($relationQuery) use ($roleIds, $relationKey) {
            $relationQuery->whereIn($relationKey, $roleIds);
        });

        return $query;
    }

    public static function filterByWard(Builder $query, array $wardIds, string $flag = "is_ward", string $relationKey = "ward_id"): Builder
    {
        if (empty($wardIds)) {
            return $query;
        }

        $query->where(function ($subQuery) use ($wardIds, $flag, $relationKey) {
            $subQuery->where($flag, false)->orWhere(function ($wardQuery) use ($wardIds, $flag, $relationKey) {
                $wardQuery->where($flag, true)->whereIn($relationKey, $wardIds);
            });
        });

        return $query;
    }
}

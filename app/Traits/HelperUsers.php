<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Src\Users\Models\UserWard;

trait HelperUsers
{
    public function usersByWardLocalBody(array $wards, array $localBodies = []) : Collection
    {
        $query =  UserWard::whereIn('ward', $wards);
        if($localBodies){
            $query->whereIn('local_body_id', $localBodies);
        }
        return $query->with('user')
            ->get()
            ->groupBy('ward')
            ->map(function ($items) {
                return $items->pluck('user')->mapWithKeys(function ($user) {
                    return [$user->id => $user]; // Use user ID as the key and user as the value
                });
            });
    }

}
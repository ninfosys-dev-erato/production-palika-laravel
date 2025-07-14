<?php

namespace Domains\CustomerGateway\Location\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;
use Src\Address\Models\District;
use Src\Address\Models\LocalBody;
use Src\Address\Models\Province;

class LocationHandler extends Controller
{
    use ApiStandardResponse;
    public function getProvince(): JsonResponse
    {
        $data = QueryBuilder::for(Province::class)
            ->allowedFilters(['id', 'title'])
            ->get();

        return $this->generalSuccess([
            'message' => 'All the provinces',
            'data' =>$data
        ]);

    }

    public function getDistrict(Request $request): JsonResponse
    {
        $request->validate([
            'province_id' => ['required', Rule::exists('add_provinces', 'id')]
        ]);

        $districts = QueryBuilder::for(District::class)
        ->allowedFilters(['id', 'title'])
        ->where('province_id', $request->province_id)
        ->get();

        return $this->generalSuccess([
            'message' => 'All the districts of the province',
            'data' => $districts
        ]);
    }

    public function getLocalBodies(Request $request): JsonResponse
    {
        $request->validate([
            'district_id' => ['required', Rule::exists('add_districts', 'id')]
        ]);

        $localBodies = QueryBuilder::for(LocalBody::class)
        ->allowedFilters(['id', 'title'])
        ->where('district_id', $request->district_id)
        ->get();

        return $this->generalSuccess([
            'message' => 'All the local bodies of the district',
            'data' => $localBodies
        ]);
    }

    public function getWards(Request $request): JsonResponse
    {
        $request->validate([
            'local_body_id' => ['required', Rule::exists('add_local_bodies', 'id')]
        ]);

        $wards = getWards(getLocalBodies(localBodyId: $request->local_body_id)->wards);
        
        return $this->generalSuccess([
            'message' => 'Wards',
            'data' => $wards
        ]);

    }

}
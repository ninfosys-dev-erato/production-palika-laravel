<?php

namespace Domains\CustomerGateway\Location\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Illuminate\Http\JsonResponse;
use Src\Address\Models\District;

class GetAllDistrict extends Controller
{
    use ApiStandardResponse;
    public function getAllDistricts(): JsonResponse
    {
        $data = District::all();

        return $this->generalSuccess([
            'message' => 'All the districts',
            'data' =>$data
        ]);

    }

}
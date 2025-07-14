<?php

namespace Domains\CustomerGateway\Branch\Api;
use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\Branch\Resources\BranchResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Src\Employees\Models\Branch;

class BranchHandler extends Controller
{
    use ApiStandardResponse;
    public function getBranches(Request $request): JsonResponse
    {
        $response = QueryBuilder::for(Branch::class)
        ->allowedFilters(['id', 'title', 'title-en'])
        ->get();

        $branches =  BranchResource::collection($response);

        return $this->generalSuccess([
            'message' => 'All the Branches',
            'data' => $branches
        ]);
    }

}
<?php

namespace Domains\AdminGateway\Recommendation\Api;

use App\Http\Controllers\Controller;
use Domains\AdminGateway\Recommendation\Resources\ApplyRecommendationResource;
use Domains\AdminGateway\Recommendation\Service\ApplyRecommendationService;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AdminApplyRecommendationHandler extends Controller

{
    public $applyRecommendationService;
    public function __construct()
    {
        $this->applyRecommendationService = new ApplyRecommendationService();
    }
    public function index(Request $request)
    {
        $user = $request->user(); // or Auth::user()
        $query = $this->applyRecommendationService ->getRecommendations($user);
        $queryBuilder = QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::exact('status'),
                AllowedFilter::exact('reg_no','records.reg_no'),
                AllowedFilter::exact('name','customer.name'),
                AllowedFilter::exact('mobile_no','customer.mobile_no'),
            ])
            ->defaultSort('-rec_apply_recommendations.created_at')
            ->allowedSorts('rec_apply_recommendations.created_at', 'rec_apply_recommendations.updated_at');
        $recommendations = $queryBuilder->paginate(15); // or ->get()
        return ApplyRecommendationResource::collection($recommendations);
    }
}
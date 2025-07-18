<?php

namespace Domains\AdminGateway\BusinessRegistration\Api;

use App\Http\Controllers\Controller;
use Domains\AdminGateway\BusinessRegistration\Resources\BusinessRegistrationResource;
use Domains\AdminGateway\BusinessRegistration\Service\BusinessRegistrationService;
use Illuminate\Support\Facades\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BusinessRegistrationHandler extends Controller
{
    public $businessRegistrationService;
    public function __construct()
    {
        $this->businessRegistrationService = new BusinessRegistrationService();
    }

    public function index( Request $request)
    {
        $query = $this->businessRegistrationService->businessRegistrationList();
        $queryBuilder=  QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::exact('entity_name'),
                AllowedFilter::exact('bill_no'),
                AllowedFilter::exact('registration_number'),
                AllowedFilter::exact('certificate_number'),
            ])
            ->defaultSort('-brs_business_registration.created_at')
            ->allowedSorts('brs_business_registration.created_at', 'brs_business_registration.updated_at');
        return BusinessRegistrationResource::collection($queryBuilder->paginate(15));
    }
}
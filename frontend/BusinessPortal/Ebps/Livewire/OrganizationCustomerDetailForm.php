<?php

namespace Frontend\BusinessPortal\Ebps\Livewire;

use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Ebps\DTO\CantileverDetailAdminDto;
use Src\Ebps\DTO\DistanceToWallAdminDto;
use Src\Ebps\DTO\HighTensionLineDetailAdminDto;
use Src\Ebps\DTO\MapApplyDetailAdminDto;
use Src\Ebps\DTO\RoadAdminDto;
use Src\Ebps\DTO\StoreyDetailAdminDto;
use Src\Ebps\Enums\AcceptanceTypeEnum;
use Src\Ebps\Enums\PurposeOfConstructionEnum;
use Src\Ebps\Models\BuildingConstructionType;
use Src\Ebps\Models\BuildingRoofType;
use Src\Ebps\Models\LandUseArea;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Models\MapApplyDetail;
use Src\Ebps\Models\Storey;
use Src\Ebps\Service\CantileverDetailAdminService;
use Src\Ebps\Service\DistanceToWallAdminService;
use Src\Ebps\Service\HighTensionLineDetailAdminService;
use Src\Ebps\Service\MapApplyDetailAdminService;
use Src\Ebps\Service\RoadAdminService;
use Src\Ebps\Service\StoreyDetailAdminService;

class OrganizationCustomerDetailForm extends Component
{
    use WithFileUploads, SessionFlash, HelperDate;

    public ?MapApply $mapApply;
    public ?MapApplyDetail $mapApplyDetail;
    public int $currentStep = 1;
    public float $progressPercentage = 0;
    public array $districts = [];
    public array $provinces = [];
    public array $localBodies = [];
    public array $wards = [];
    public Collection $landUseAreas;
    public array $constructionPurposes = [];
    public array $acceptanceTypes = [];
    public Collection $storeys;
    public array $constructionStoreyPurpose = [];
    public float $totalPurposedArea = 0;
    public float $totalFormerArea = 0;
    public float $totalCombinedArea = 0;
    public float $totalHeight = 0;
    public Collection $buildingConstructionTypes;
    public Collection $buildingRoofTypes;
    public array $distanceToWall = [];
    public array $roads = [];
    public array $cantileverDetails = [];
    public array $highTensionDetails = [];
    public $todayDate;

    public function rules(): array
{
    $rules =  [
        'mapApplyDetail.organization_id'              => ['nullable', 'string'],
        'mapApplyDetail.land_use_area_id'             => ['nullable', 'string'],
        'mapApplyDetail.land_use_area_changes'        => ['nullable', 'string'],
        'mapApplyDetail.usage_changes'                => ['nullable', 'string'],
        'mapApplyDetail.change_acceptance_type'       => ['nullable', 'string'],
        'mapApplyDetail.field_measurement_area'       => ['nullable', 'string'],
        'mapApplyDetail.building_plinth_area'         => ['nullable', 'string'],
        'mapApplyDetail.building_construction_type_id'=> ['nullable', 'string'],
        'mapApplyDetail.building_roof_type_id'        => ['nullable', 'string'],
        'mapApplyDetail.other_construction_area'      => ['nullable', 'string'],
        'mapApplyDetail.former_other_construction_area'=> ['nullable', 'string'],
        'mapApplyDetail.public_property_name'         => ['nullable', 'string'],
        'mapApplyDetail.material_used'                => ['nullable', 'string'],
        'mapApplyDetail.distance_left'                => ['nullable', 'string'],
        'mapApplyDetail.area_unit'                    => ['nullable', 'string'],
        'mapApplyDetail.length_unit'                  => ['nullable', 'string'],
    ];

    foreach ($this->constructionStoreyPurpose as $index => $purpose) {
        $rules["constructionStoreyPurpose.$index.storey_id"] = 'nullable|exists:ebps_storeys,id';
        $rules["constructionStoreyPurpose.$index.purposed_area"] = 'nullable|numeric|min:0';
        $rules["constructionStoreyPurpose.$index.former_area"] = 'nullable|numeric|min:0';
        $rules["constructionStoreyPurpose.$index.height"] = 'nullable|numeric|min:0';
        $rules["constructionStoreyPurpose.$index.remarks"] = 'nullable|string';
    }


    foreach ($this->roads as $index => $label) {
        $rules["roads.$index.width"] = 'nullable|numeric';
        $rules["roads.$index.dist_from_middle"] = 'nullable|numeric';
        $rules["roads.$index.min_dist_from_middle"] = 'nullable|numeric';
        $rules["roads.$index.dist_from_side"] = 'nullable|numeric';
        $rules["roads.$index.min_dist_from_side"] = 'nullable|numeric';
        $rules["roads.$index.dist_from_right"] = 'nullable|numeric';
        $rules["roads.$index.min_dist_from_right"] = 'nullable|numeric';
        $rules["roads.$index.setback"] = 'nullable|numeric';
        $rules["roads.$index.min_setback"] = 'nullable|numeric';
    }

    foreach ($this->distanceToWall as $index => $label) {
    
        $rules["distanceToWall.$index.direction"] = 'nullable|string';
        $rules["distanceToWall.$index.has_road"] = 'nullable';
        $rules["distanceToWall.$index.does_have_wall_door"] = 'nullable';
        $rules["distanceToWall.$index.dist_left"] = 'nullable|numeric|min:0';
        $rules["distanceToWall.$index.min_dist_left"] = 'nullable|numeric|min:0';
    }

    foreach ($this->cantileverDetails as $index => $label) {
        $rules["cantileverDetails.$index.direction"] = 'nullable|string';
        $rules["cantileverDetails.$index.distance"] = 'nullable|numeric|min:0';
        $rules["cantileverDetails.$index.minimum"] = 'nullable|numeric|min:0';
    }


    foreach ($this->highTensionDetails as $index => $label) {
        $rules["highTensionDetails.$index.direction"] = 'nullable|string';
        $rules["highTensionDetails.$index.distance"] = 'nullable|numeric|min:0';
        $rules["highTensionDetails.$index.minimum"] = 'nullable|numeric|min:0';
    }

    return $rules;
}

public function mount(MapApply $mapApply, MapApplyDetail $mapApplyDetail): void
{
    $this->mapApply = $mapApply->load(
        'landDetail',
        'constructionType',
        'fiscalYear',
        'mapApplySteps',
        'storeyDetails',
        'distanceToWalls',
        'roads',
        'cantileverDetails',
        'highTensionLineDetails'
    );

    $this->mapApplyDetail = MapApplyDetail::where('map_apply_id', $mapApply->id)->first();
    $this->constructionStoreyPurpose = $this->mapApply->storeyDetails->isNotEmpty() ? $this->mapApply->storeyDetails->toArray() : [];
    $this->distanceToWall = $this->mapApply->distanceToWalls->isNotEmpty()
                            ? $this->mapApply->distanceToWalls->mapWithKeys(function ($item) {
                                return [$item['direction'] => $item];
                            })->toArray()
                            : [];
    $this->roads = $this->mapApply->roads->isNotEmpty() 
                        ? $this->mapApply->roads->mapWithKeys(function ($item) {
                            return [$item['direction'] => $item];
                        })->toArray()
                        : [];

    $this->cantileverDetails = $this->mapApply->cantileverDetails->isNotEmpty()
                        ? $this->mapApply->cantileverDetails->mapWithKeys(function ($item) {
                            return [$item['direction'] => $item];
                        })->toArray()
                        : [];
    $this->highTensionDetails = $this->mapApply->highTensionLineDetails->isNotEmpty() 
                        ? $this->mapApply->highTensionLineDetails->mapWithKeys(function ($item) {
                            return [$item['direction'] => $item];
                        })->toArray()
                        : [];

    $this->landUseAreas = LandUseArea::whereNull('deleted_at')->get();
    $this->constructionPurposes = PurposeOfConstructionEnum::getValuesWithLabels();
    $this->acceptanceTypes = AcceptanceTypeEnum::getValuesWithLabels();
    $this->storeys = Storey::whereNull('deleted_at')->get();
    $this->buildingConstructionTypes = BuildingConstructionType::whereNull('deleted_at')->get();
    $this->buildingRoofTypes = BuildingRoofType::whereNull('deleted_at')->get();
    $this->todayDate = $this->convertEnglishToNepali(\Carbon\Carbon::today()->toDateString());
}


    public function updateTotalArea($index)
    {
        $purposed = floatval($this->constructionStoreyPurpose[$index]['purposed_area'] ?? 0);
        $former = floatval($this->constructionStoreyPurpose[$index]['former_area'] ?? 0);
    
        $this->constructionStoreyPurpose[$index]['total_area'] = $purposed + $former;
    
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->totalPurposedArea = 0;
        $this->totalFormerArea = 0;
        $this->totalCombinedArea = 0;
        $this->totalHeight = 0;

        foreach ($this->constructionStoreyPurpose as $item) {
            $this->totalPurposedArea += floatval($item['purposed_area'] ?? 0);
            $this->totalFormerArea += floatval($item['former_area'] ?? 0);
            $this->totalCombinedArea += floatval($item['total_area'] ?? 0);
            $this->totalHeight += floatval($item['height'] ?? 0);
        }
    }

    public function render(): Factory|View|Application
    {
        return view("BusinessPortal.Ebps::livewire.template");
    }

    public function addStoreyPurpose()
    {
        $this->constructionStoreyPurpose[] = [
            'storey_id' => null,
            'purposed_area' => null,
            'former_area' => null,
            'total_area' => 0,
            'height' => null,
            'remarks' => '',
        ];
    
        $index = array_key_last($this->constructionStoreyPurpose); 
        $this->calculateTotals();
    }

    public function removeStoreyPurpose($index)
    {
        unset($this->constructionStoreyPurpose[$index]);
        $this->constructionStoreyPurpose = array_values($this->constructionStoreyPurpose);

        $this->calculateTotals();
    }

    public function save()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            $dto = MapApplyDetailAdminDto::fromLiveWireModel($this->mapApplyDetail);
            $service = new MapApplyDetailAdminService();
            $storeyService = new StoreyDetailAdminService();
            $distacneToWallservice = new DistanceToWallAdminService();
            $cantileverService = new CantileverDetailAdminService();
            $highTensionService = new HighTensionLineDetailAdminService();
           
            $roadService = new RoadAdminService();
            $detail = $service->update($this->mapApplyDetail, $dto);

            $mapApplyId = $detail->map_apply_id; 
            $cantileverService->deleteByMapApplyId($mapApplyId);
            $roadService->deleteByMapApplyId($mapApplyId);
            $storeyService->deleteByMapApplyId($mapApplyId);
            $distacneToWallservice->deleteByMapApplyId($mapApplyId);
            $highTensionService->deleteByMapApplyId($mapApplyId);

            foreach ($this->constructionStoreyPurpose as $storeyData) {
                $storeyData['map_apply_id'] = $mapApplyId;
                $storeyDto = StoreyDetailAdminDto::fromArray($storeyData);             
                $storeyService->store($storeyDto);
            }
            
            foreach ($this->distanceToWall as $direction => $wallData) {
                $wallData['map_apply_id'] = $mapApplyId;
                $wallData['direction'] = $direction;
                $wallDto = DistanceToWallAdminDto::fromArray($wallData);
                $distacneToWallservice->store($wallDto);
            }
            foreach ($this->roads as $direction => $roadData) {
                $roadData['map_apply_id'] = $mapApplyId;
                $roadData['direction'] = $direction;
                $roadDto = RoadAdminDto::fromArray($roadData);
                $roadService->store($roadDto);
            }
            foreach ($this->cantileverDetails as $direction => $cantileverData) {
                $cantileverData['map_apply_id'] = $mapApplyId;
                $cantileverData['direction'] = $direction;
                $cantileverDto = CantileverDetailAdminDto::fromArray($cantileverData);
                $cantileverService->store($cantileverDto);
            }
            foreach ($this->highTensionDetails as $direction => $highTensionData) {
                $highTensionData['map_apply_id'] = $mapApplyId;
                $highTensionData['direction'] = $direction;
                $highTensionDto = HighTensionLineDetailAdminDto::fromArray($highTensionData);
                $highTensionService->store($highTensionDto);
            }

            DB::commit();
            $this->successFlash("Map Apply Detail Created Successfully");
    
        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            $this->errorFlash(__("An error occurred during operation. Please try again later"));
        }
   
    }
    
}





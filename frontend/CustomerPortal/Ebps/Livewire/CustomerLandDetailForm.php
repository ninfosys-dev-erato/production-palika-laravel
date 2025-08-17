<?php

namespace Frontend\CustomerPortal\Ebps\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Frontend\CustomerPortal\Ebps\DTO\CustomerLandDetailDto;
use Src\Ebps\DTO\FourBoundaryAdminDto;
use Src\Ebps\Enums\LandOwernshipEnum;
use Src\Ebps\Models\CustomerLandDetail;
use Src\Ebps\Models\FourBoundary;
use Src\Ebps\Service\CustomerLandDetailService;
use Src\Ebps\Service\FourBoundaryAdminService;

class CustomerLandDetailForm extends Component
{
    use SessionFlash;

    public ?CustomerLandDetail $customerLandDetail;
    public ?Action $action;

    public $localBodies;
    public $wards;
    public $ownerships;
    public $fourBoundaries = [];
    public bool $is_boundary = false;

    public function rules(): array
    {
        $rules =  [
            'customerLandDetail.local_body_id' => ['required'],
            'customerLandDetail.former_local_body' => ['nullable'],
            'customerLandDetail.former_ward_no' => ['nullable'],
            'customerLandDetail.ward' => ['required'],
            'customerLandDetail.tole' => ['required'],
            'customerLandDetail.area_sqm' => ['required'],
            'customerLandDetail.lot_no' => ['required'],
            'customerLandDetail.seat_no' => ['required'],
            'customerLandDetail.ownership' => ['required'],
            'customerLandDetail.is_landlord' => ['nullable'],
        ];

        return $rules;
    }

    public function addFourBoundaries()
    {
        $this->fourBoundaries[] = [
            'title' => '',
            'direction' => '',
            'distance' => '',
            'lot_no' => ''
        ];
    }

    public function removeFourBoundaries($index)
    {
        unset($this->fourBoundaries[$index]);
        $this->fourBoundaries = array_values($this->fourBoundaries);

        if($index == 0)
        {
            $this->is_boundary = !$this->is_boundary;
        }
    }

    public function render(){
        return view("CustomerPortal.Ebps::livewire.land-detail-form");
    }

    public function loadWards(): void
    {
        $this->wards = getWards(getLocalBodies(localBodyId: $this->customerLandDetail->local_body_id)->wards);
    }

    public function mount(CustomerLandDetail $customerLandDetail, Action $action)
    {
        $this->customerLandDetail = $customerLandDetail;
        $this->action = $action;
        $this->localBodies = getLocalBodies(district_ids: key(getSettingWithKey('palika-district')))->pluck('title', 'id')->toArray();
        $this->ownerships = LandOwernshipEnum::cases();
        $this->wards = [];

        if ($action === Action::UPDATE) {
            $this->loadFourBoundaries($customerLandDetail);
        }
    }

    public function loadFourBoundaries($customerLandDetail)
    {
        $fourBoundaries = FourBoundary::where('land_detail_id', $customerLandDetail->id)->get();

        $this->fourBoundaries = [];

        foreach ($fourBoundaries as $boundary) {
            $this->fourBoundaries[] = [
                'title' => $boundary->title ?? '',
                'direction' => $boundary->direction ?? '',
                'distance' => $boundary->distance ?? '',
                'lot_no' => $boundary->lot_no ?? '',
            ];
        }
    }

    public function save()
    {
        $this->validate();
        $dto = CustomerLandDetailDto::fromLiveWireModel($this->customerLandDetail);
        $service = new CustomerLandDetailService();
        $fourBoundaryService = new FourBoundaryAdminService();
        DB::beginTransaction();
        try{
            switch ($this->action){
                case Action::CREATE:
                    $landDetail = $service->store($dto);
                    foreach ($this->fourBoundaries as $fourBoundary) {
                        $fourBoundary['land_detail_id'] = $landDetail->id;
                        $boundaryDto = FourBoundaryAdminDto::fromArray($fourBoundary);
                        $fourBoundaryService->store($boundaryDto);
                    }
                    DB::commit();
                    $this->successFlash(message: __("ebps::ebps.customer_land_detai_created_successfully"));
                    return redirect()->route('customer.ebps.land-detail-index');
                    break;
                case Action::UPDATE:
                    $service->update($this->customerLandDetail,$dto);
                    FourBoundary::where('land_detail_id', $this->customerLandDetail->id)->delete();
                    foreach ($this->fourBoundaries as $fourBoundary) {
                        $fourBoundary['land_detail_id'] = $this->customerLandDetail->id;
                        $boundaryDto = FourBoundaryAdminDto::fromArray($fourBoundary);
                        $fourBoundaryService->store($boundaryDto);
                    }
                    DB::commit();
                    $this->successFlash(__("ebps::ebps.customer_land_detai_updated_successfully"));
                    return redirect()->route('customer.ebps.land-detail-index');
                    break;
                default:
                    return redirect()->route('customer.ebps.land-detail-index');
                    break;
            }
        } catch (\Exception $e) {

            logger($e);
            DB::rollBack();
            $this->errorFlash(__("ebps::ebps.an_error_occurred_during_operation_please_try_again_later"));
        }
    }
}

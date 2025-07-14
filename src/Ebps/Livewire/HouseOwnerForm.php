<?php

namespace Src\Ebps\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Customers\Models\Customer;
use Src\Ebps\Models\HouseOwnerDetail;
use Src\FourBoundaries\Controllers\FourBoundaryAdminController;
use Src\Ebps\DTO\FourBoundaryAdminDto;
use Src\Ebps\Models\FourBoundary;
use Src\Ebps\Service\FourBoundaryAdminService;
use Livewire\Attributes\On;

class HouseOwnerForm extends Component
{
    use SessionFlash;
    public ?HouseOwnerDetail $houseOwnerDetail;
    public ?Action $action;
    public $constructionTypes;

    public $uploadedImage;
    public $mapDocuments;
    public $uploadedFiles = [];
    public $customer_id;
    public bool $openModal = false;
    public bool $isModalForm = true;
    public bool $addLandForm = false;
    public $ownerships;
    public $provinces = [];
    public $districts = [];
    public $localBodies = [];
    public $wards = [];
    public $issuedDistricts= [];
    public $buildingStructures;
    public $mapProcessTypes;
    public $fiscalYears;
    public $usageOptions;

    public function rules(): array
    {
        return [
            'houseOwnerDetail.owner_name'  => ['required', 'string', 'max:255'],
            'houseOwnerDetail.mobile_no'  => ['required'],
            'houseOwnerDetail.father_name' => ['required', 'string', 'max:255'],
            'houseOwnerDetail.grandfather_name' => ['required', 'string', 'max:255'],
            'houseOwnerDetail.citizenship_no' => ['required'],
            'houseOwnerDetail.citizenship_issued_at' => ['required'],
            'houseOwnerDetail.citizenship_issued_date' => ['required'],
            'houseOwnerDetail.province_id' => ['required'],
            'houseOwnerDetail.district_id' => ['required'],
            'houseOwnerDetail.local_body_id' => ['required'],
            'houseOwnerDetail.ward_no' => ['required'],
        ];
    }

    public function render(){
        return view("Ebps::livewire.house-owner.house-owner-form");
    }

    public function mount(HouseOwnerDetail $houseOwnerDetail,Action $action)
    {
        $this->houseOwnerDetail = $houseOwnerDetail;

      
        $this->action = $action;
    }

     #[On('search-user')]
    public function restructureData(array $result)
    {
        dd('hello');
        if($result['type'] === 'Customer')
        {
            $customer = Customer::with('kyc')->where('id', $result['id'])->first();

            $this->houseOwnerDetail->owner_name = $customer->name;
            $this->houseOwnerDetail->mobile_no = $customer->mobile_no;
            $this->houseOwnerDetail->father_name = $customer->kyc->father_name;
            $this->houseOwnerDetail->grandfather_name = $customer->kyc->grandfather_name;
            $this->houseOwnerDetail->citizenship_no = $customer->kyc->document_number;
            $this->houseOwnerDetail->citizenship_issued_date = $customer->kyc->document_issued_date_nepali;
            $this->houseOwnerDetail->citizenship_issued_at = $customer->kyc->document_issued_at;
            $this->houseOwnerDetail->province_id = $customer->kyc->permanent_province_id;
            $this->getDistricts();
            $this->houseOwnerDetail->district_id = $customer->kyc->permanent_district_id;
            $this->getLocalBodies();
            $this->houseOwnerDetail->local_body_id = $customer->kyc->permanent_local_body_id;
            $this->getWards();
            $this->houseOwnerDetail->ward_no = $customer->kyc->permanent_ward;
            $this->houseOwnerDetail->permanent_tole = $customer->kyc->permanent_tole;

        }else{

            $this->houseOwnerDetail->owner_name = $result['name'];
            $this->houseOwnerDetail->mobile_no = $result['mobile_no'];
        }

    }

    public function save()
    {
        $this->validate();
        try{
            $dto = FourBoundaryAdminDto::fromLiveWireModel($this->fourBoundary);
            $service = new FourBoundaryAdminService();
            switch ($this->action){
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ebps::ebps.four_boundary_created_successfully'));
                    return redirect()->route('admin.four_boundaries.index');
                    break;
                case Action::UPDATE:
                    $service->update($this->fourBoundary,$dto);
                    $this->successFlash(__('ebps::ebps.four_boundary_updated_successfully'));
                    return redirect()->route('admin.four_boundaries.index');
                    break;
                default:
                    return redirect()->route('admin.four_boundaries.index');
                    break;
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(((__('ebps::ebps.something_went_wrong_while_saving') . $e->getMessage())));
        }
    }
}

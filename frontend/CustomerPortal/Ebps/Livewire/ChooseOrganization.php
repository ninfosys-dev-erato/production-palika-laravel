<?php

namespace Frontend\CustomerPortal\Ebps\Livewire;

use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ebps\DTO\MapApplyDetailAdminDto;
use Src\Ebps\Models\MapApplyDetail;
use Src\Ebps\Models\Organization;
use Src\Ebps\Service\MapApplyDetailAdminService;

class ChooseOrganization extends Component
{
    use SessionFlash;

    public ?MapApplyDetail $mapApplyDetail;
    public $organizations = [];
    public int $mapApplyId;
    protected $listeners = ['setMapApplyId'];
    public bool $hasSelectedOrganization = false;

    public function setMapApplyId($id)
    {
        $this->mapApplyId = $id;


        $mapApplyDetail = MapApplyDetail::where('map_apply_id', $this->mapApplyId)->first();

        if ($mapApplyDetail) {

            $this->mapApplyDetail = $mapApplyDetail;
            $this->hasSelectedOrganization = !$this->hasSelectedOrganization;
        } else {

            $this->mapApplyDetail = new MapApplyDetail();

        }
    }


    public function rules(): array
    {
        $rules =  [
            'mapApplyDetail.organization_id' => ['required'],
        ];

        return $rules;
    }

    public function mount(MapApplyDetail $mapApplyDetail)
    {
        $this->mapApplyDetail = $mapApplyDetail;
        $this->organizations = Organization::whereNull('deleted_at')->get();

    }

    public function render()
    {
        return view("CustomerPortal.Ebps::livewire.choose-organization");

    }

    public function saveOrganization()
    {
       $this->validate();
        try{

           $this->mapApplyDetail->map_apply_id = $this->mapApplyId;

           $dto = MapApplyDetailAdminDto::fromLiveWireModel($this->mapApplyDetail);
           $service = new MapApplyDetailAdminService();
           $this->hasSelectedOrganization ? $service->update($this->mapApplyDetail, $dto) :$service->store($dto);
           $this->successFlash(__("ebps::ebps.organization_has_been_chosen_successfully."));
           $this->dispatch('close-modal');

        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('ebps::ebps.something_went_wrong_while_saving.' . $e->getMessage())));
        }

    }
}

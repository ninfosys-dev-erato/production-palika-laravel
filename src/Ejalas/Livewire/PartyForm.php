<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\PartyAdminDto;
use Src\Ejalas\Models\Party;
use Src\Ejalas\Service\PartyAdminService;
use Src\Address\Models\District;
use Src\Address\Models\Province;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Src\Customers\Models\Customer;

class PartyForm extends Component
{
    use SessionFlash;

    public ?Party $party;
    public ?Action $action = Action::CREATE;
    public $reg_no;
    public $type;
    public $isModal = false;
    public $phone;
    public bool $searchResult = false;

    public $provinces;
    public $districts = [];
    public $localBodies = [];
    public $wards = [];
    public $temporaryDistricts = [];
    public $temporaryLocalBodies = [];
    public $temporaryWards = [];

    public array $selectedParties = [];

    protected $listeners = [
        'partyDeleted' => 'updatePartiesArray',
        'edit-party' => 'editParty',
        'reset-form' => 'resetParty'
    ];


    public function rules(): array
    {
        return [
            'party.name' => ['required'],
            'party.age' => ['required'],
            'party.phone_no' => ['required'],
            'party.citizenship_no' => ['required'],
            'party.gender' => ['required'],
            'party.grandfather_name' => ['nullable'],
            'party.father_name' => ['nullable'],
            'party.spouse_name' => ['nullable'],
            'party.permanent_province_id' => ['nullable'],
            'party.permanent_district_id' => ['nullable'],
            'party.permanent_local_body_id' => ['nullable'],
            'party.permanent_ward_id' => ['nullable'],
            'party.permanent_tole' => ['nullable'],
            'party.temporary_province_id' => ['nullable'],
            'party.temporary_district_id' => ['nullable'],
            'party.temporary_local_body_id' => ['nullable'],
            'party.temporary_ward_id' => ['nullable'],
            'party.temporary_tole' => ['nullable'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.party.form");
    }



    public function mount(Party $party, Action $action, $reg_no = null, $type = null, $isModal = false)
    {
        $this->party = $party;
        $this->action = $action;
        $this->isModal = $isModal; //checks if it is modal for redirecting purpose
        $this->type = $type;
        $this->provinces = Province::pluck('title', 'id');
    }

    public function getDistrict()
    {
        $this->districts = getDistricts($this->party->permanent_province_id)->pluck('title', 'id')->toArray();
        $this->localBodies = [];
        $this->wards = [];
    }
    public function getLocalBody()
    {
        $this->localBodies = getLocalBodies($this->party['permanent_district_id'])->pluck('title', 'id')->toArray();

        // $this->localBodies = getLocalBodies($this->businessRegistration['district_id'])->pluck('title', 'id')->toArray();
    }
    public function getWard()
    {
        $this->wards = getWards(getLocalBodies(localBodyId: $this->party['permanent_local_body_id'])->wards);
    }
    public function getTemporaryDistrict()
    {
        // Get districts based on the selected temporary province
        $this->temporaryDistricts = getDistricts($this->party['temporary_province_id'])->pluck('title', 'id');
    }

    public function getTemporaryLocalBody()
    {
        // Get local bodies based on the selected temporary district
        $this->temporaryLocalBodies = getLocalBodies(['district_ids' => $this->party['temporary_district_id']])->pluck('title', 'id');
    }

    public function getTemporaryWard()
    {

        $this->temporaryWards = getWards(getLocalBodies(localBodyId: $this->party['temporary_local_body_id'])->wards);
    }

    public function save()
    {
        // $this->selectedParties[] = [
        //     'id' => rand(5, 30),
        //     'type' => ['Defender', 'Complainer'][rand(0, 1)],
        // ];
        // $this->dispatch('partyAdded', $this->selectedParties);
        $this->validate();
        try {
            $dto = PartyAdminDto::fromLiveWireModel($this->party);
            $service = new PartyAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $party = $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.party_created_successfully'));
                    $this->selectedParties[] = [
                        'id' => $party->id,
                        'type' => $this->type,
                    ];
                    // Dispatch event with the array
                    $this->dispatch('partyAdded', $this->selectedParties);

                    $this->dispatch('close-modal');
                    // $this->resetForm();

                    break;
                case Action::UPDATE:
                    $service->update($this->party, $dto);
                    $this->successFlash(__('ejalas::ejalas.party_updated_successfully'));
                    // return redirect()->route('admin.ejalas.parties.index');

                    $this->dispatch('close-modal');
                    // $this->resetForm();

                    break;
            }
            if ($this->isModal) {
                $this->dispatch('close-modal');
            } else {
                return redirect()->route('admin.ejalas.parties.index');
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
        // Log::info('Save method triggered');
    }
    public function updatePartiesArray($parties)
    {
        $this->selectedParties = $parties;
    }

    public function editParty(Party $party)
    {
        $this->party = $party;
        $this->action = Action::UPDATE;
        $this->loadDependentDropDown();
        $this->dispatch('open-modal');
    }
    // public function search()
    // {
    //     $party = Party::whereNull('deleted_at')->where('phone_no', $this->phone)->first();
    //     if ($party) {
    //         $this->party = $party;
    //         $this->searchResult = true;
    //         $this->loadDependentDropDown();
    //         $this->successToast(__('ejalas::ejalas.data_found_successfully'));
    //     } else {
    //         $this->errorToast(__('ejalas::ejalas.no_data_found'));
    //     }
    // }
    #[On('search-user')]
    public function restructureData($result)
    {
        if ($result['type'] === 'Customer') {
            $customer = Customer::with('kyc')->where('id', $result['id'])->first();

            if ($customer) {

                $this->party->name = $customer->name ?? '';
                $this->party->phone_no = $customer->mobile_no ?? '';
                $this->party->gender = $customer->gender->value ?? '';


                // Populate KYC data if available
                if ($customer->kyc) {
                    $this->party->father_name = $customer->kyc->father_name ?? '';
                    $this->party->grandfather_name = $customer->kyc->grandfather_name ?? '';
                    $this->party->citizenship_no = $customer->kyc->document_number ?? '';

                    // Populate permanent address information if available
                    if ($customer->kyc->permanent_province_id) {
                        $this->party->permanent_province_id = $customer->kyc->permanent_province_id;
                    }
                    if ($customer->kyc->permanent_district_id) {
                        $this->party->permanent_district_id = $customer->kyc->permanent_district_id;
                    }
                    if ($customer->kyc->permanent_local_body_id) {
                        $this->party->permanent_local_body_id = $customer->kyc->permanent_local_body_id;
                    }
                    if ($customer->kyc->permanent_ward) {
                        $this->party->permanent_ward_id = $customer->kyc->permanent_ward;
                    }
                    if ($customer->kyc->permanent_tole) {
                        $this->party->permanent_tole = $customer->kyc->permanent_tole;
                    }

                    if ($customer->kyc->temporary_province_id) {
                        $this->party->temporary_province_id = $customer->kyc->temporary_province_id;
                    }
                    if ($customer->kyc->temporary_district_id) {
                        $this->party->temporary_district_id = $customer->kyc->temporary_district_id;
                    }
                    if ($customer->kyc->temporary_local_body_id) {
                        $this->party->temporary_local_body_id = $customer->kyc->temporary_local_body_id;
                    }
                    if ($customer->kyc->temporary_ward) {
                        $this->party->temporary_ward_id = $customer->kyc->temporary_ward;
                    }
                    if ($customer->kyc->temporary_tole) {
                        $this->party->temporary_tole = $customer->kyc->temporary_tole;
                    }
                    $this->loadDependentDropDown();
                }

                // $this->searchResult = true;

                $this->successToast(__('ejalas::ejalas.customer_data_loaded_successfully'));
            } else {
                $this->errorToast(__('ejalas::ejalas.no_customer_found'));
            }
        }
    }

    public function addSearchResult()
    {
        $this->selectedParties[] = [
            'id' => $this->party->id,
            'type' => $this->type,
        ];
        $this->dispatch('partyAdded', $this->selectedParties);
        $this->dispatch('close-modal');
    }

    public function resetParty()
    {
        $this->reset(['party', 'action', 'phone', 'searchResult']);
        $this->party = new Party();
    }
    private function loadDependentDropDown()
    {
        // Load Permanent Address Data
        if ($this->party->permanent_province_id) {
            $this->districts = getDistricts($this->party->permanent_province_id)->pluck('title', 'id')->toArray();
        }
        if ($this->party->permanent_district_id) {
            $this->localBodies = getLocalBodies($this->party->permanent_district_id)->pluck('title', 'id')->toArray();
        }
        if ($this->party->permanent_local_body_id) {
            $this->wards = getWards(getLocalBodies(localBodyId: $this->party->permanent_local_body_id)->wards);
        }

        // Load Temporary Address Data (if needed)
        if ($this->party->temporary_province_id) {
            $this->temporaryDistricts = getDistricts($this->party->temporary_province_id)->pluck('title', 'id')->toArray();
        }
        if ($this->party->temporary_district_id) {
            $this->temporaryLocalBodies = getLocalBodies($this->party->temporary_district_id)->pluck('title', 'id')->toArray();
        }
        if ($this->party->temporary_local_body_id) {
            $this->temporaryWards = getWards(getLocalBodies(localBodyId: $this->party->temporary_local_body_id)->wards);
        }
    }
}

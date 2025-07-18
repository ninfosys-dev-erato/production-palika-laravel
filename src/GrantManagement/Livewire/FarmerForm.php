<?php

namespace Src\GrantManagement\Livewire;

use App\Enums\Action;
use App\Facades\ImageServiceFacade;
use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Maatwebsite\Excel\Files\TemporaryFile;
use Src\GrantManagement\DTO\FarmerAdminDto;
use Src\GrantManagement\Models\Farmer;
use Src\GrantManagement\Service\FarmerAdminService;
use Livewire\WithFileUploads;
use Src\Customers\Enums\GenderEnum;
use Illuminate\Support\Facades\DB;
use Src\GrantManagement\Enums\MaritalStatus;
use Src\GrantManagement\Enums\RelationShipEnum;
use Src\GrantManagement\Models\Cooperative;
use Src\GrantManagement\Models\Enterprise;
use Src\GrantManagement\Models\Group;
use Livewire\Attributes\On;
use App\Facades\FileFacade;
use Src\Customers\Models\Customer;
use Src\Customers\Models\CustomerKyc;



class FarmerForm extends Component
{
    use SessionFlash, WithFileUploads;

    public ?Farmer $farmer;
    public ?Action $action = Action::CREATE;

    public string $modalType = '';
    public $customer = [];
    public $districts = [];
    public $provinces = [];
    public $localBodies = [];
    public $wards = [];
    public $genders = [];
    public $farmersArray = [];
    public $maritalStatuses = [];
    public $relationshipsArray = [];
    public $cooperatives = [];
    public $enterprises = [];
    public $groups = [];
    public array $selectedGroups = [];
    public array $selectedEnterprises = [];
    public array $selectedFarmers = [];
    public array $selectedRelationship = [];
    public array $selectedCooperatives = [];
    public $uploadedImage;
    public $showSelectedFarmerModal = true;
    public $showCooperativeModal = false;
    public $showGroupModal = false;
    public $showEnterpriseModal = false;
    public ?string $activeModal = null;


    public function rules(): array
    {
        $isCreate = $this->action->value === 'create';

        return [
            'farmer.first_name' => ['nullable'],
            'farmer.middle_name' => ['nullable'],
            'farmer.last_name' => ['nullable'],
            'farmer.gender' => ['required'],
            'farmer.marital_status' => ['required'],
            'farmer.spouse_name' => ['nullable'],
            'farmer.father_name' => ['required'],
            'farmer.grandfather_name' => ['required'],
            'farmer.citizenship_no' => ['required'],
            'farmer.farmer_id_card_no' => ['required'],
            'farmer.national_id_card_no' => ['required'],
            'farmer.user_id' => $isCreate ? ['required'] : ['nullable'],
            'farmer.phone_no' => ['required'],
            'farmer.province_id' => ['required'],
            'farmer.district_id' => ['required'],
            'farmer.local_body_id' => ['required'],
            'farmer.ward_no' => ['required'],
            'farmer.village' => ['required'],
            'farmer.tole' => ['required'],
            'uploadedImage' => ['nullable'],
            'selectedFarmers' => ['nullable', 'array'],
            'selectedRelationship' => ['nullable', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'farmer.first_name.required' => __('grantmanagement::grantmanagement.first_name_is_required'),
            'farmer.middle_name.nullable' => __('grantmanagement::grantmanagement.middle_name_is_optional'),
            'farmer.last_name.required' => __('grantmanagement::grantmanagement.last_name_is_required'),
            'farmer.gender.required' => __('grantmanagement::grantmanagement.gender_is_required'),
            'farmer.marital_status.required' => __('grantmanagement::grantmanagement.marital_status_is_required'),
            'farmer.spouse_name.nullable' => __('grantmanagement::grantmanagement.spouse_name_is_optional'),
            'farmer.father_name.required' => __('grantmanagement::grantmanagement.father_name_is_required'),
            'farmer.grandfather_name.required' => __('grantmanagement::grantmanagement.grandfather_name_is_required'),
            'farmer.citizenship_no.required' => __('grantmanagement::grantmanagement.citizenship_no_is_required'),
            'farmer.farmer_id_card_no.required' => __('grantmanagement::grantmanagement.farmer_id_card_no_is_required'),
            'farmer.national_id_card_no.required' => __('grantmanagement::grantmanagement.national_id_card_no_is_required'),
            'farmer.phone_no.required' => __('grantmanagement::grantmanagement.phone_no_is_required'),
            'farmer.province_id.required' => __('grantmanagement::grantmanagement.province_id_is_required'),
            'farmer.district_id.required' => __('grantmanagement::grantmanagement.district_id_is_required'),
            'farmer.local_body_id.required' => __('grantmanagement::grantmanagement.local_body_id_is_required'),
            'farmer.ward_no.required' => __('grantmanagement::grantmanagement.ward_no_is_required'),
            'farmer.village.required' => __('grantmanagement::grantmanagement.village_is_required'),
            'farmer.tole.required' => __('grantmanagement::grantmanagement.tole_is_required'),
            'uploadedImage.required' => __('grantmanagement::grantmanagement.uploadedimage_is_required'),
            'selectedFarmers.nullable' => __('grantmanagement::grantmanagement.selectedfarmers_is_optional'),
            'selectedFarmers.array' => __('grantmanagement::grantmanagement.selectedfarmers_must_be_an_array'),
            'selectedRelationship.nullable' => __('grantmanagement::grantmanagement.selectedrelationship_is_optional'),
            'selectedRelationship.array' => __('grantmanagement::grantmanagement.selectedrelationship_must_be_an_array'),
        ];
    }

    public function render()
    {
        return view("GrantManagement::livewire.farmers-form");
    }


    public function mount(Farmer $farmer, Action $action, bool $showSelectedFarmerModal = true, bool $showCooperativeModal = false, bool $showGroupModal = false, bool $showEnterpriseModal = false)
    {


        $this->action = $action;
        $this->farmer = $farmer->load(['groups', 'cooperatives', 'enterprises']);

        $this->showCooperativeModal = $showCooperativeModal;
        $this->showGroupModal = $showGroupModal;
        $this->showEnterpriseModal = $showEnterpriseModal;
        
            // $this->customer = Customer::whereNotNull('kyc_verified_at')
            //     ->pluck('name', 'id');
            $this->customer = Customer::whereNotNull('kyc_verified_at')
                ->whereNotIn('id', Farmer::pluck('user_id'))
                ->pluck('name', 'id');

        $this->provinces = getProvinces()->pluck('title', 'id')->toArray();
        $this->showSelectedFarmerModal = $showSelectedFarmerModal;
        $this->genders = GenderEnum::getValuesWithLabels();
        $this->maritalStatuses = MaritalStatus::getValuesWithLabels();
        $this->relationshipsArray = RelationShipEnum::getValuesWithLabels();
        $this->groups = Group::whereNull('deleted_by')->get()->pluck('name', 'id')->toArray();
        $this->enterprises = Enterprise::whereNull('deleted_by')->get()->pluck('name', 'id')->toArray();
        $this->cooperatives = Cooperative::whereNull('deleted_by')->get()->pluck('name', 'id')->toArray();
        $this->farmersArray = Farmer::whereNull('deleted_by')->get()
            ->mapWithKeys(function ($farmer) {
                $fullName = collect([$farmer->first_name, $farmer->middle_name, $farmer->last_name])
                    ->filter()
                    ->implode(' ');
                return [$farmer->id => $fullName];
            })->toArray();

        if ($action === Action::UPDATE) {
            $this->uploadedImage = $farmer->photo;
            $this->selectedGroups = $farmer->groups->pluck('id')->toArray();
            $this->selectedEnterprises = $farmer->enterprises->pluck('id')->toArray();
            $this->selectedCooperatives = $farmer->cooperatives->pluck('id')->toArray();
        }
    }


    #[On('group-created')]
    public function refreshGroups()
    {
        $this->groups = Group::whereNull('deleted_by')->get()->pluck('name', 'id')->toArray();
    }

    public function showUserData($id)
    {
        $customer = Customer::whereNotNull('kyc_verified_at')
            ->with([
                'kyc.permanentProvince',
                'kyc.permanentDistrict',
                'kyc.permanentLocalBody'
            ])
            ->find($id);



        if (!$customer || !$customer->kyc) {
            return;
        }

        if ($customer->kyc->status->value === 'accepted') {

            $kyc = $customer->kyc;


            $this->farmer->phone_no = $customer->mobile_no ?? '';
            $this->uploadedImage = $customer->avatar ?? '';

            $this->farmer->gender = $customer->gender->value ?? '';

            $this->farmer->province_id = $kyc->permanent_province_id ?? '';

            if ($this->farmer->province_id) {
                $this->getDistricts();

                $this->farmer->district_id = $kyc->permanent_district_id ?? '';
                if ($this->farmer->district_id) {
                    $this->getLocalBodies();

                    $this->farmer->local_body_id = $kyc->permanent_local_body_id ?? '';
                    if ($this->farmer->local_body_id) {
                        $this->getWards();
                    }
                }
            }

            $this->farmer->district_id = $kyc->permanent_district_id ?? '';


            $this->farmer->local_body_id = $kyc->permanent_local_body_id ?? '';

            $this->farmer->ward_no = $kyc->permanent_ward ?? '';
            $this->farmer->tole = $kyc->permanent_tole ?? '';
            $this->farmer->village = $kyc->temporary_tole ?? '';
            $this->farmer->grandfather_name = $kyc->grandfather_name ?? '';
            $this->farmer->father_name = $kyc->father_name ?? '';
        }
    }
    private function loadDependentDropDown()
    {
        if ($this->farmer->province_id) {
            $this->getDistricts();
        }
        if ($this->farmer->district_id) {

            $this->getLocalBodies();
        }
        if ($this->farmer->local_body_id) {
            $this->getWards();
        }
    }

    public function openModal($type)
    {
        $this->activeModal = $type;
    }

    public function closeModal()
    {
        $this->activeModal = null;
    }

    public function openCooperativeModal()
    {
        $this->showCooperativeModal = true;
    }

    public function closeCooperativeModal()
    {
        $this->showCooperativeModal = false;
    }

    public function openGroupModal()
    {
        $this->showGroupModal = true;
    }

    public function closeGroupModal()
    {
        $this->showGroupModal = false;
    }

    public function openEnterpriseModal()
    {
        $this->showEnterpriseModal = true;
    }

    public function closeEnterpriseModal()
    {
        $this->showEnterpriseModal = false;
    }

    public function updateSelectedFarmer($value)
    {
        $this->selectedFarmers = $value;
    }

    public function updateSelectedRelationship($value)
    {
        $this->selectedRelationship = $value;
    }

    public function updatedFarmerProvinceId($value)
    {
        $this->getDistricts();
    }

    public function updatedFarmerDistrictId($value)
    {
        $this->getLocalBodies();
    }

    public function updatedFarmerLocalBodyId($value)
    {
        $this->getWards();
    }

    public function getDistricts(): void
    {
        $this->districts = getDistricts($this->farmer['province_id'])->pluck('title', 'id')->toArray();
        $this->localBodies = [];
        $this->wards = [];
    }

    public function getLocalBodies(): void
    {
        $this->localBodies = getLocalBodies($this->farmer['district_id'])->pluck('title', 'id')->toArray();
        $this->wards = [];
    }

    public function getWards(): void
    {
        $this->wards = getWards(getLocalBodies(localBodyId: $this->farmer['local_body_id'])->wards);
    }

    public function save()
    {
        $this->validate();

        if ($this->uploadedImage instanceof TemporaryUploadedFile) {
            $this->farmer->photo = ImageServiceFacade::compressAndStoreImage($this->uploadedImage, config('src.GrantManagement.grant.photo'), 'local');
        }

        if ($this->selectedFarmers) {
            $this->farmer->farmer_ids = $this->selectedFarmers ?? [];
        }

        if ($this->selectedRelationship) {
            $this->farmer->relationships = $this->selectedRelationship ?? [];
        }

        // dd($this->farmer, $this->uploadedImage);
        $dto = FarmerAdminDto::fromLiveWireModel($this->farmer);
        $service = new FarmerAdminService();
        DB::beginTransaction();
        try {
            if ($this->action === Action::CREATE) {


                $farmer = $service->store($dto);
                $farmer->groups()->sync($this->selectedGroups);
                $farmer->cooperatives()->sync($this->selectedCooperatives);
                $farmer->enterprises()->sync($this->selectedEnterprises);

                DB::commit();
                $this->successFlash(__('grantmanagement::grantmanagement.farmer_created_successfully'));

                if (!$this->showSelectedFarmerModal) {
                    $this->dispatch('close-modal');
                    $this->resetForm();
                } else {
                    return redirect()->route('admin.farmers.index');
                }
            } else if ($this->action === Action::UPDATE) {
                $service->update($this->farmer, $dto);
                $this->farmer->groups()->detach();
                $this->farmer->cooperatives()->detach();
                $this->farmer->enterprises()->detach();

                $this->farmer->groups()->sync($this->selectedGroups);
                $this->farmer->cooperatives()->sync($this->selectedCooperatives);
                $this->farmer->enterprises()->sync($this->selectedEnterprises);
                DB::commit();
                $this->successFlash(__('grantmanagement::grantmanagement.farmers_updated_successfully'));

                return redirect()->route('admin.farmers.index');
            }
        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            $this->errorFlash(__('grantmanagement::grantmanagement.an_error_occurred_during_operation_please_try_again_later'));
        }
    }

    // public function updateSelectedFarmers($value)
    // {
    //     dd($value);

    //     $this->selectedFarmers = array_unique(array_merge($this->selectedFarmers, (array) $value));
    // }

    // public function updateSelectedRelationships($value)
    // {
    //     $this->selectedRelationship = array_unique(array_merge($this->selectedRelationship, (array) $value));
    // }


    private function storeFile($file): string
    {
        if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            if (in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])) {
                return ImageServiceFacade::compressAndStoreImage($file, config('src.GrantManagement.grant.photo'));
            }

            return FileFacade::saveFile(
                path: config('src.DigitalBoard.notice.notice_path'),
                filename: null,
                file: $file
            );
        }

        return '';
    }


    #[On('edit-farmer')]
    public function editFarmer(Farmer $farmer)
    {
        $this->farmer = $farmer;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['farmer', 'action']);
        $this->farmer = new Farmer();
    }
    #[On('reset-form')]
    public function resetFarmer()
    {
        $this->resetForm();
    }
}

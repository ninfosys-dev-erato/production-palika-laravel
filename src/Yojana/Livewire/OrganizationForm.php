<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\Controllers\OrganizationAdminController;
use Src\Yojana\DTO\OrganizationAdminDto;
use Src\Yojana\Enums\OrganizationTypes;
use Src\Yojana\Models\Organization;
use Src\Yojana\Service\OrganizationAdminService;

class OrganizationForm extends Component
{
    use SessionFlash;

    public ?Organization $organization;
    public ?Action $action;
    public $organizations;

    public function rules(): array
    {
        return [
            'organization.type' => ['required'],
            'organization.name' => ['required'],
            'organization.address' => ['required'],
            'organization.pan_number' => ['required', 'numeric'],
            'organization.phone_number' => ['required', 'numeric', 'digits:10'],
            'organization.bank_name' => ['required'],
            'organization.branch' => ['required'],
            'organization.account_number' => ['required', 'numeric'],
            'organization.representative' => ['required'],
            'organization.post' => ['required'],
            'organization.representative_address' => ['required'],
            'organization.mobile_number' => ['required', 'numeric', 'digits:10'],
        ];
    }
    public function messages(): array
    {
        return [
            'organization.type.required' => __('yojana::yojana.type_is_required'),
            'organization.name.required' => __('yojana::yojana.name_is_required'),
            'organization.address.required' => __('yojana::yojana.address_is_required'),
            'organization.pan_number.required' => __('yojana::yojana.pan_number_is_required'),
            'organization.pan_number.numeric' => __('yojana::yojana.pan_number_must_be_a_number'),
            'organization.phone_number.required' => __('yojana::yojana.phone_number_is_required'),
            'organization.phone_number.numeric' => __('yojana::yojana.phone_number_must_be_a_number'),
            'organization.phone_number.digits:10' => __('yojana::yojana.phone_number_has_invalid_validation_digits'),
            'organization.bank_name.required' => __('yojana::yojana.bank_name_is_required'),
            'organization.branch.required' => __('yojana::yojana.branch_is_required'),
            'organization.account_number.required' => __('yojana::yojana.account_number_is_required'),
            'organization.account_number.numeric' => __('yojana::yojana.account_number_must_be_a_number'),
            'organization.representative.required' => __('yojana::yojana.representative_is_required'),
            'organization.post.required' => __('yojana::yojana.post_is_required'),
            'organization.representative_address.required' => __('yojana::yojana.representative_address_is_required'),
            'organization.mobile_number.required' => __('yojana::yojana.mobile_number_is_required'),
            'organization.mobile_number.numeric' => __('yojana::yojana.mobile_number_must_be_a_number'),
            'organization.mobile_number.digits:10' => __('yojana::yojana.mobile_number_has_invalid_validation_digits'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.organizations-form");
    }

    public function mount(Organization $organization, Action $action)
    {
        $this->organization = $organization;
        $this->action = $action;
        $this->organizations = OrganizationTypes::getForWeb();
    }

    public function save()
    {
        $this->validate();
        $dto = OrganizationAdminDto::fromLiveWireModel($this->organization);
        $service = new OrganizationAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $created = $service->store($dto);
                if ($created instanceof Organization) {
                    $this->successFlash(__('yojana::yojana.organization_created_successfully'));
                } else {
                    $this->errorFlash(__('yojana::yojana.organization_failed_to_create'));
                }
                return redirect()->route('admin.organizations.index');
            case Action::UPDATE:
                $updated = $service->update($this->organization, $dto);
                if ($updated instanceof Organization) {
                    $this->successFlash(__('yojana::yojana.organization_updated_successfully'));
                } else {
                    $this->errorFlash(__('yojana::yojana.organization_failed_to_update'));
                }
                return redirect()->route('admin.organizations.index');
            default:
                $this->errorFlash(__('yojana::yojana.invalid_action'));
                break;
        }
    }
}

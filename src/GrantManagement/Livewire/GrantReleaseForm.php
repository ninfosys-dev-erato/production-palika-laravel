<?php

namespace Src\GrantManagement\Livewire;

use App\Enums\Action;
use Livewire\Component;
use Src\GrantManagement\Models\GrantProgram;
use Src\GrantManagement\Models\GrantRelease;
use Src\GrantManagement\DTO\GrantReleaseAdminDto;
use Src\GrantManagement\Service\GrantReleaseAdminService;
use App\Traits\SessionFlash;
use Src\GrantManagement\Enums\GranteeTypesEnum;
use Src\GrantManagement\Models\Farmer;
use Src\GrantManagement\Models\Cooperative;
use Src\GrantManagement\Models\Enterprise;
use Src\GrantManagement\Models\Group;

class GrantReleaseForm extends Component
{
    use SessionFlash;

    public ?GrantRelease $grantRelease;
    public ?Action $action = Action::CREATE;
    public $selectedGrantPrograms = [];
    public $granteeType = [];
    public $grantees = [];
    public $grantProgram = [];

    public function rules(): array
    {
        return [
            'grantRelease.grantee_id' => 'required',
            'grantRelease.grantee_type' => 'required',
            'grantRelease.investment' => 'required',
            'grantRelease.is_new_or_ongoing' => 'required',
            'grantRelease.last_year_investment' => 'required',
            'grantRelease.plot_no' => 'required',
            'grantRelease.location' => 'required',
            'grantRelease.contact_person' => 'required',
            'grantRelease.contact_no' => 'required',
            'grantRelease.condition' => 'required',
            'grantRelease.grant_program' => 'required',
            'grantRelease.grant_expenses' => 'nullable',
            'grantRelease.private_expenses' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'grantRelease.grantee_id.required' => __('grantmanagement::grantmanagement.grantee_id_is_required'),
            'grantRelease.grantee_type.required' => __('grantmanagement::grantmanagement.grantee_type_is_required'),
            'grantRelease.investment.required' => __('grantmanagement::grantmanagement.investment_is_required'),
            'grantRelease.is_new_or_ongoing.required' => __('grantmanagement::grantmanagement.is_new_or_ongoing_is_required'),
            'grantRelease.last_year_investment.required' => __('grantmanagement::grantmanagement.last_year_investment_is_required'),
            'grantRelease.plot_no.required' => __('grantmanagement::grantmanagement.plot_no_is_required'),
            'grantRelease.location.required' => __('grantmanagement::grantmanagement.location_is_required'),
            'grantRelease.contact_person.required' => __('grantmanagement::grantmanagement.contact_person_is_required'),
            'grantRelease.contact_no.required' => __('grantmanagement::grantmanagement.contact_no_is_required'),
            'grantRelease.condition.required' => __('grantmanagement::grantmanagement.condition_is_required'),
            'grantRelease.grant_program.required' => __('grantmanagement::grantmanagement.grant_program_is_required'),
            'grantRelease.grant_expenses.required' => __('grantmanagement::grantmanagement.grant_expenses_is_required'),
            'grantRelease.private_expenses.required' => __('grantmanagement::grantmanagement.private_expenses_is_required'),
        ];
    }



    public function render()
    {
        return view('GrantManagement::livewire.grant-release-form');
    }

    public function mount(GrantRelease $grantRelease, Action $action)
    {
        $this->grantRelease = $grantRelease;
        $this->granteeType = GranteeTypesEnum::getValuesWithLabels();
        $this->filterGrantee();
        $this->grantProgram = GrantProgram::whereNull('deleted_by')->get()->pluck('program_name', 'id')->toArray();
        $this->action = $action;
    }

    public function filterGrantee()
    {
        $this->grantees = [];

        $selectedGrantType = $this->grantRelease->grantee_type;

        if ($selectedGrantType !== null) {

            $query = $selectedGrantType::whereNull('deleted_by');
            if ($selectedGrantType === \Src\GrantManagement\Models\Farmer::class) {
                $query->with('user');
            }

            $this->grantees = $query->get()
                ->mapWithKeys(function ($grantee) {
                    return [$grantee->id => $grantee->grantee_name];
                })
                ->toArray();
        }
    }


    public function updategrantee()
    {
        $selectedGrantType = $this->grantRelease->grantee_type;
        $userid = $this->grantRelease->grantee;

        $user = null;

        if ($selectedGrantType === 'group') {
            $user = Group::whereNull('deleted_by')->find($userid);
        } elseif ($selectedGrantType === 'enterprise') {
            $user = Enterprise::whereNull('deleted_by')->find($userid);
        } elseif ($selectedGrantType === 'cooperative') {
            $user = Cooperative::whereNull('deleted_by')->find($userid);
        } elseif ($selectedGrantType === 'farmer') {
            $user = Farmer::whereNull('deleted_by')->find($userid);
        }

        $this->grantRelease->contact_no = $user->phone_no ?? null;
    }



    public function save()
    {
        $this->validate();


        $userid = $this->grantRelease->grantee;


        // Create DTO from form data
        $dto = GrantReleaseAdminDto::fromLiveWireModel($this->grantRelease);

        $service = new GrantReleaseAdminService();

        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('grantmanagement::grantmanagement.grant_release_created_successfully'));

                return redirect()->route('admin.grant_release.index');

                break;
            case Action::UPDATE:
                $service->update($this->grantRelease, $dto);
                $this->successFlash(__('grantmanagement::grantmanagement.grant_release_updated_successfully'));
                return redirect()->route('admin.grant_release.index');

                break;
            default:
                return redirect()->route('admin.grant_release.index');
                break;
        }
    }
}

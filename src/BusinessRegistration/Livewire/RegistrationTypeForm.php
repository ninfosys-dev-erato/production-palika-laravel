<?php

namespace Src\BusinessRegistration\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Src\BusinessRegistration\DTO\RegistrationTypeAdminDto;
use Src\BusinessRegistration\Enums\BusinessRegistrationType;
use Src\BusinessRegistration\Enums\RegistrationCategoryEnum;
use Src\BusinessRegistration\Models\RegistrationType;
use Src\BusinessRegistration\Service\RegistrationTypeAdminService;
use Src\Employees\Models\Branch;
use Src\Settings\Models\Form;
use Livewire\Attributes\On;

class RegistrationTypeForm extends Component
{
    use SessionFlash;

    public ?RegistrationType $registrationType;
    public Action $action = Action::CREATE;
    public  $forms = [];
    public  $registrationCategories = [];
    public  $departments = [];
    private $category_title;
    public bool $isBusiness = false;
    public array  $businessActions = [];
    public $registration_category_enums;

    public function rules(): array
    {
        $rules = [
            'registrationType.title' => ['required'],
            'registrationType.action' => ['nullable'],
            'registrationType.form_id' => ['sometimes', 'nullable', Rule::exists('mst_forms', 'id')],
            'registrationType.registration_category_id' => ['sometimes', 'nullable'],
            'registrationType.department_id' => ['nullable'],
            'registrationType.registration_category_enum' => ['required'],
        ];

        // if ($this->isBusiness) {
        //     $rules['registrationType.department_id'] = ['required', Rule::exists('mst_branches', 'id')];
        // }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'registrationType.title.required' => __('businessregistration::businessregistration.the_title_is_required'),
            'registrationType.form_id.sometimes' => __('businessregistration::businessregistration.the_form_id_is_optional_but_if_provided_it_must_exist_in_the_forms_table'),
            'registrationType.registration_category_id.sometimes' => __('businessregistration::businessregistration.the_registration_category_id_is_optional_but_if_provided_it_must_exist_in_the_registration_categories_table'),
            'registrationType.department.required' => __('businessregistration::businessregistration.the_departmet_is_required'),
            'registrationType.registration_category_enum.required' => __('businessregistration::businessregistration.the_registration_category_enum_is_required'),
        ];
    }


    public function mount(RegistrationType $registrationType, Action $action): void
    {

        $this->registrationType = $registrationType;
        $this->action = $action;
        $this->isBusiness = false;
        $this->forms = Form::where('module', 'business-registration')->whereNull('deleted_by')->pluck('id', 'title')->toArray();
        // Use RegistrationCategoryEnum for registration categories
        $this->registration_category_enums = RegistrationCategoryEnum::getForWeb();
        $this->departments = Branch::whereNull('deleted_at')->whereNull('deleted_by')->pluck('id', 'title')->toArray();

        $this->businessActions = BusinessRegistrationType::cases();
    }

    public function render(): View
    {
        return view('BusinessRegistration::livewire.registration-types.form');
    }

    public function save()
    {
        $this->validate();

        try {
            $dto = RegistrationTypeAdminDto::fromLiveWireModel($this->registrationType);
            $service = new RegistrationTypeAdminService();

            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('businessregistration::businessregistration.registration_type_created_successfully'));
                    return redirect()->route('admin.business-registration.registration-types.index');

                case Action::UPDATE:
                    $service->update($dto, $this->registrationType);
                    $this->successFlash(__('businessregistration::businessregistration.registration_type_updated_successfully'));
                    return redirect()->route('admin.business-registration.registration-types.index');

                default:
                    return redirect()->route('admin.business-registration.registration-types.index');
            }
        } catch (\Exception $e) {
            logger()->error($e);
            $this->errorFlash('Something went wrong while rejecting.', $e->getMessage());
        }
    }

    // public function registationCategory()
    // {
    //     $this->registrationType->registration_category_id;
    //     $category = RegistrationCategory::where('id', $this->registrationType->registration_category_id)->first();
    //     if ($category->title === "Business") {
    //         $this->isBusiness = !$this->isBusiness;
    //     }
    // }

    private function getCategoryTitle()
    {
        $this->category_title = getAppLanguage() === 'en' ? 'title' : 'title_ne';
    }

    #[On('edit-registrationtype')]
    public function editRegistrationType(RegistrationType $registrationType)
    {
        $this->registrationType = $registrationType;
        $this->action = Action::UPDATE;
        $this->isBusiness = true;
        $this->dispatch('open-modal');
    }

    #[On('reset-form')]
    public function resetForm()
    {
        $this->reset(['registrationType', 'action']);
        $this->registrationType = new RegistrationType();
        $this->action = Action::CREATE;
    }
}

<?php

namespace Src\BusinessRegistration\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Src\BusinessRegistration\DTO\RegistrationCategoryAdminDto;
use Src\BusinessRegistration\Models\RegistrationCategory;
use Src\BusinessRegistration\Service\RegistrationCategoryAdminService;
use Livewire\Attributes\On;


class RegistrationCategoryForm extends Component
{
    use SessionFlash;

    public ?RegistrationCategory $registrationCategory;
    public Action $action = Action::CREATE;

    public function mount(RegistrationCategory $registrationCategory, Action $action)
    {
        $this->registrationCategory = $registrationCategory;
        $this->action = $action;
    }

    public function rules(): array
    {
        $rules = [
            'registrationCategory.title' => ['required'],
            'registrationCategory.title_ne' => ['required'],
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'registrationCategory.title.required' => __('businessregistration::businessregistration.the_title_is_required'),
            'registrationCategory.title_ne.required' => __('businessregistration::businessregistration.the_nepali_title_is_required'),
        ];
    }

    public function render(): View
    {
        return view('BusinessRegistration::livewire.registration-category.form');
    }

    public function save()
    {
        $this->validate();
        try{

            $dto = RegistrationCategoryAdminDto::fromLiveWireModel($this->registrationCategory);
            $service = new RegistrationCategoryAdminService();

            switch ($this->action) {

                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('businessregistration::businessregistration.registration_category_created_successfully'));
                    return redirect()->route('admin.business-registration.registration-category.index');

                case Action::UPDATE:
                    $service->update($this->registrationCategory, $dto);
                    $this->successFlash(__('businessregistration::businessregistration.registration_category_updated_successfully'));
                    return redirect()->route('admin.business-registration.registration-category.index');

                default:
                    return redirect()->route('admin.business-registration.registration-category.index');
            }
        } catch (\Exception $e) {
            logger()->error($e);
            $this->errorFlash('Something went wrong while rejecting.', $e->getMessage());
        }
    }

    #[On('edit-registrationCategory')]
    public function editRegistrationCategroy(RegistrationCategory $registrationCategory)
    {
        $this->registrationCategory = $registrationCategory;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }

    #[On('reset-form')]
    public function resetForm()
    {
        $this->reset(['registrationCategory', 'action']);
        $this->registrationCategory = new RegistrationCategory();
        $this->action = Action::CREATE;
    }
}

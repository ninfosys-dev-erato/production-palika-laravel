<?php

namespace Src\Profile\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Profile\DTO\ProfilePasswordAdminDto;
use Src\Profile\Service\ProfileAdminService;

class OrganizationChangePasswordForm extends Component
{
    use SessionFlash, WithFileUploads;

    public array $form;

    public function rules(): array
    {
        return [
            'form.current_password' => ['required', 'string'],
            'form.password' => ['required', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'form.current_password.required' => __('The current password field is required.'),
            'form.current_password.string' => __('The current password must be a string.'),
            'form.password.required' => __('The password field is required.'),
            'form.password.min' => __('The password must be at least 8 characters.'),
            'form.password.confirmed' => __('The password confirmation does not match.'),
        ];
    }

    public function render()
    {
        return view("Profile::livewire.password_form");
    }

    public function save()
    {
        $this->validate();
        try{
            if (!Hash::check($this->form['current_password'], auth('organization')->user()->password)) {
                $this->errorFlash(__('Current Password does not match'));
                return redirect()->route('organization.profile.password-index');
            }
            $dto = ProfilePasswordAdminDto::fromLiveWireModel($this->form);
            $service = new ProfileAdminService();
            $service->updateOrganizationPassword($dto);
            $this->successFlash(__("Password Updated Successfully"));
            return redirect()->route('organization.dashboard');
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}

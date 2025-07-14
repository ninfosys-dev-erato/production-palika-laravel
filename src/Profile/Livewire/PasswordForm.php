<?php

namespace Src\Profile\Livewire;

use App\Enums\Action;
use App\Models\User;
use App\Services\ImageService;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Agendas\DTO\AgendaAdminDto;
use Src\Agendas\Models\Agenda;
use Src\Agendas\Service\AgendaAdminService;
use Src\Profile\DTO\ProfileAdminDto;
use Src\Profile\DTO\ProfilePasswordAdminDto;
use Src\Profile\Service\ProfileAdminService;

class PasswordForm extends Component
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

    public function render()
    {
        return view("Profile::livewire.password_form");
    }

    public function save()
    {
        $this->validate();
        try{
            if (Hash::check($this->form['current_password'], auth()->user()->password)) {
                $this->errorFlash(__('Current Password does not match'));
            }
            $dto = ProfilePasswordAdminDto::fromLiveWireModel($this->form);
            $service = new ProfileAdminService();
            $service->updatePassword($dto);
            $this->successFlash("Password Updated Successfully");
            return redirect()->route('admin.profile.password-index');
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}

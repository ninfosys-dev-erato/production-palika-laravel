<?php

namespace Src\Profile\Livewire;

use App\Enums\Action;
use App\Facades\ImageServiceFacade;
use App\Models\User;
use App\Services\ImageService;
use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Agendas\DTO\AgendaAdminDto;
use Src\Agendas\Models\Agenda;
use Src\Agendas\Service\AgendaAdminService;
use Src\Profile\DTO\ProfileAdminDto;
use Src\Profile\Service\ProfileAdminService;

class ProfileForm extends Component
{
    use SessionFlash, WithFileUploads;

    public User $user;

    public function rules(): array
    {
        return [
            'user.name' => ['required', 'string'],
            'user.email' => ['required', 'email'],
            'user.signature' => ['required', 'image', 'max:1024'],
        ];
    }

    public function render()
    {
        return view("Profile::livewire.form");
    }

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function save()
    {
        $this->validate();
        try{
            if (!is_string($this->user['signature'])) {
                $this->user->signature = ImageServiceFacade::compressAndStoreImage($this->user['signature'], config('src.Profile.profile.path'), getStorageDisk('public'));
            }
            $dto = ProfileAdminDto::fromLiveWireModel($this->user);
            $service = new ProfileAdminService();
            $service->updateProfile($dto);
            $this->successFlash(__("Profile Updated Successfully"));
            return redirect()->route('admin.profile.index');
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}

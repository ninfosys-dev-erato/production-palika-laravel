<?php

namespace Src\Grievance\Livewire;

use App\Enums\Action;
use App\Models\User;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Src\Grievance\DTO\GrievanceDetailAdminDto;
use Src\Grievance\Models\GrievanceDetail;
use Src\Grievance\Service\GrievanceService;

class GrievanceDetailChangeAssignedUserForm extends Component
{
    use SessionFlash;

    public ?GrievanceDetail $grievanceDetail;
    public Action $action;
    public $users = [];

    public function rules(): array
    {
        return [
            'grievanceDetail.assigned_user_id' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'grievanceDetail.assigned_user_id.required' => __('grievance::grievance.assigned_user_id_is_required'),
        ];
    }

    public function render()
    {
        return view("Grievance::livewire.grievanceDetail.assignUser");
    }

    public function mount(GrievanceDetail $grievanceDetail): void
    {
        $this->grievanceDetail = $grievanceDetail->fresh('grievanceType.departments.users');
        $departmentUsers = $this->grievanceDetail->grievanceType->departments
            ->flatMap(fn($department) => $department->users)
            ->unique('id');

        $currentUserId = Auth::guard('web')->id();
        $this->users = $departmentUsers->filter(function ($user) use ($currentUserId) {
            return $user->id !== $currentUserId;
        })->map(fn($user) => [
            'id' => $user->id,
            'name' => $user->name,
        ])->toArray();
    }

    public function save()
    {
        $originalGrievanceDetail = GrievanceDetail::find($this->grievanceDetail->id);
        $fromUserId = $originalGrievanceDetail->assigned_user_id;
        
        $this->validate();
        try{
            $dto = GrievanceDetailAdminDto::fromLiveWireModel($this->grievanceDetail, null, null);
            $service = new GrievanceService();
            switch ($this->action) {
                case Action::UPDATE:
                    $service->updateAssignedUser($this->grievanceDetail, $dto, $fromUserId);
                    $this->successFlash(__('grievance::grievance.grievance_detail_updated_successfully'));
                    break;
            }
            return redirect()->route('admin.grievance.grievanceDetail.show', $this->grievanceDetail->id);
        } catch (\Throwable $e) { 
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}


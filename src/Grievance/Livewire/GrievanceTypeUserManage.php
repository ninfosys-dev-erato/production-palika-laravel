<?php

namespace Src\Grievance\Livewire;

use App\Models\User;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Grievance\Models\GrievanceType;
use Src\Grievance\Service\GrievanceService;

class GrievanceTypeUserManage extends Component
{
    use SessionFlash;

    public $grievanceTypes;
    public $users;

    public function mount()
    {
        $this->grievanceTypes = GrievanceType::with('users')->get();
        $this->users = User::with('grievanceTypes')->get();
    }

    public function render()
    {
        return view("Grievance::livewire.grievanceType.manage", [
            'users' => $this->users,
            'grievanceTypes' => $this->grievanceTypes,
        ]);
    }

    public function toggleAssignment(int $userId, int $grievanceTypeId)
    {
        $service = new GrievanceService();
        $service->toggleGrievanceTypeUser($userId, $grievanceTypeId);
        $this->grievanceTypes = GrievanceType::with('users')->get();
        $this->users = User::with('grievanceTypes')->get();
    }
}

<?php

namespace Src\Recommendation\Livewire;

use App\Traits\HelperUsers;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Concurrency;
use Livewire\Component;
use Src\Address\Models\LocalBody;
use Src\Employees\Models\Branch;
use Src\Recommendation\DTO\RecommendationSigneesUserAdminDto;
use Src\Recommendation\Models\Recommendation;
use Src\Recommendation\Models\RecommendationDepartment;
use Src\Recommendation\Services\RecommendationSigneesUserAdminService;
use Src\Users\Models\UserWard;

class RecommendationSigneesManage extends Component
{
    use SessionFlash,HelperUsers;

    public ?Recommendation $recommendation;
    public $wards = [];
    public $selectedDepartmentUsers = [];
    public $departmentUser = [];
    public $wardUser = []; 

    public function mount(Recommendation $recommendation)
    {
        $this->recommendation = $recommendation;
        $signees = $recommendation->signees;
        $body= getSettingWithKey('palika-local-body');
        $body = array_key_first($body);
        $this->wards = getWards(LocalBody::where('id', $body)->first()->wards);
        $this->departmentUser =$this->getDepartmentsUsers($recommendation);
        $this->wardUser = $this->usersByWardLocalBody(wards:$this->wards,localBodies:[key(getSettingWithKey('palika-local-body'))] );
        $this->wardUser = collect($this->wardUser->toArray() + array_fill_keys($this->wards, []))
        ->map(function ($user){
           return $user +  $this->departmentUser;
        })->toArray();
        ksort($this->wardUser);
        $this->selectedDepartmentUsers = $signees->load('user') // Load the related user data
        ->groupBy('ward_id') // Group by ward ID
        ->map(function ($items) {
            return $items->pluck('user.id'); // Extract the 'user' relation from each grouped item
        })->toArray();
    }

    public function render()
    {
        return view('Recommendation::livewire.recommendation.manage-signees');
    }


    public function getDepartmentsUsers(Recommendation $recommendation): array
    {
        $usersFromBranch = [];
        $departments = $recommendation->load('departments.users')->departments;
        foreach ($departments as $department) {
            foreach ($department->users as $user) {
                $usersFromBranch[$user->id] = $user->toArray();
            }
        }
        return $usersFromBranch;
    }


    public function save(int $userId , int $wardId,bool $value)
    {
        $service = new RecommendationSigneesUserAdminService();
        $dto = RecommendationSigneesUserAdminDto::fromLiveWireModel(
            user_id:$userId,
            ward_id:$wardId,
            recommendation_type_id:$this->recommendation->id,
        );
        $service->toggleUserAccess($dto);
    }

}

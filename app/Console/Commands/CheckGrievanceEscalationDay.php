<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Src\Grievance\Models\GrievanceAssignHistory;
use Src\Grievance\Models\GrievanceDetail;
use Illuminate\Support\Carbon;
use Src\Grievance\Models\GrievanceSetting;
use Src\Users\Models\UserWard;
use Src\Users\Notifications\GrievanceAssignedUserNotification;

class CheckGrievanceEscalationDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:escalation-day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle()
    {
        $grievanceSetting = GrievanceSetting::first();
        $grievances = GrievanceDetail::with('grievanceType.departments.users')->where('escalation_date', '<', Carbon::now())->get();

        foreach ($grievances as $grievance) {
            $currentAssignedUser = $grievance->assigned_user_id;

            $newAssignedUserId = $this->getNewAssignedUserId($grievance, $currentAssignedUser);

            $this->updateGrievance($grievance, $newAssignedUserId, $grievanceSetting);
            $this->createGrievanceAssignHistory($grievance, $currentAssignedUser, $newAssignedUserId);
        }
        }

    private function getNewAssignedUserId(GrievanceDetail $grievance, $currentAssignedUser)
    {
        if ($grievance->grievanceType->is_ward) {
            return $this->getWardPresident($grievance->ward_id);
        } else {
            return $this->getDepartmentHead($grievance, $currentAssignedUser);
        }
    }

    private function getWardPresident($wardId)
    {
        $usersInWard = UserWard::where('ward', $wardId)->with('user')->get();
        $wardPresident = $usersInWard->filter(function ($userWard) {
            return $userWard->user->hasRole('ward_president');
        })->first();

        if ($wardPresident) {
            return $wardPresident->user->id;
        }

        return null; 
    }

    private function getDepartmentHead(GrievanceDetail $grievance, $currentAssignedUser)
    {
        $department = $grievance->grievanceType->departments;
        $currentUserBranch = $this->findUserBranch($department, $currentAssignedUser);

        if ($currentUserBranch) {
            return $this->getDepartmentHeadFromBranch($currentUserBranch, $currentAssignedUser);
        }

        $randomBranch = $department->random();
        return $this->getDepartmentHeadFromBranch($randomBranch, $currentAssignedUser);
    }

    private function findUserBranch($departments, $currentAssignedUser)
    {
        foreach ($departments as $branch) {
            if ($branch->users->contains($currentAssignedUser)) {
                return $branch;
            }
        }
        return null;
    }

    private function getDepartmentHeadFromBranch($branch, $currentAssignedUser)
    {
        $departmentHead = $branch->users()->wherePivot('is_department_head', true)->first();

        if ($departmentHead) {
            return $departmentHead->id;
        }

        $randomUser = $branch->users()->inRandomOrder()->first();
        return $randomUser ? $randomUser->id : $currentAssignedUser;
    }

    private function updateGrievance(GrievanceDetail $grievance, $newAssignedUserId, $grievanceSetting)
    {
        $grievance->update([
            'assigned_user_id' => $newAssignedUserId,
            'escalation_date' => Carbon::now()->addDays($grievanceSetting->escalation_days),
        ]);

        $assignedUser = User::find($newAssignedUserId);
        $assignedUser->notify(new GrievanceAssignedUserNotification($grievance));
    }

    private function createGrievanceAssignHistory(GrievanceDetail $grievance, $currentAssignedUser, $newAssignedUserId)
    {
        GrievanceAssignHistory::create([
            'grievance_detail_id' => $grievance->id,
            'from_user_id' => $currentAssignedUser,
            'to_user_id' => $newAssignedUserId,
            'old_status' => null,
            'new_status' => null,
        ]);
    }


}
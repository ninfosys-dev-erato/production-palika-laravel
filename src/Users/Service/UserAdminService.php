<?php

namespace Src\Users\Service;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Src\Users\DTO\UserAdminDto;
use App\Models\User;
use Src\Employees\Models\Branch;
use Src\Users\DTO\UserDepartmentDto;
use Src\Users\Models\UserWard;

class UserAdminService
{
    public function store(UserAdminDto $userAdminDto): array | User
    {
        $user =  User::create([
            'name' => $userAdminDto->name,
            'email' => $userAdminDto->email,
            'password' => $userAdminDto->password,
            'mobile_no' => $userAdminDto->mobile_no,
            'active' => $userAdminDto->active,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
        
        return $user;
    }

    public function update(User $user, UserAdminDto $userAdminDto): bool
    {
        $updateData = [
            'name' => $userAdminDto->name,
            'email' => $userAdminDto->email,
            'password' => $userAdminDto->password,
            'mobile_no' => $userAdminDto->mobile_no,
            'active' => $userAdminDto->active,
            'updated_at' => now(),
            'updated_by' => Auth::user()->id,
        ];

        //        if (!empty($userAdminDto->password)) {
        //            $updateData['password'] = $userAdminDto->password;
        //        }
        $user->fill($updateData);

        // Save the updated user
        return $user->save();
    }

    public function delete(User $user)
    {
        return tap($user)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function toggleUserStatus(User $user): void
    {
        $active = !$user->active;
        $user->update([
            'active' => $active,
            'updated_at' => now(),
            'updated_by' => Auth::user()->id
        ]);
        if (!$active) {
            DB::table('sessions')
                ->where('user_id', $user->id)
                ->delete();
        }
    }

    public function saveUserDepartments(User $user, array $userDepartmentDtos): void
    {
        $departments = [];

        foreach ($userDepartmentDtos as $dto) {
            if ($dto->is_department_head) {
                $existingHead = User::whereHas('departments', function ($query) use ($dto) {
                    $query->where('branch_id', $dto->department_id)
                        ->where('is_department_head', true);
                })->first();

                if ($existingHead && $existingHead->id !== $user->id) {
                    $departmentName = Branch::find($dto->department_id)->title ?? 'Unknown Department';
                    throw new \Exception(
                        __("The department head for '{$departmentName}' has already been assigned to {$existingHead->name}. Please remove them first.")
                    );
                }
            }

            $departments[$dto->department_id] = [
                'is_department_head' => $dto->is_department_head,
            ];
        }

        $user->departments()->sync($departments);
    }


    public function saveUserWard(User $user, array $userWardDtos): void
    {
        UserWard::where('user_id', $user->id)->delete();

        $wardsData = [];

        foreach ($userWardDtos as $dto) {
            $wardsData[] = [
                'user_id' => $user->id,
                'local_body_id' => $dto->local_body_id,
                'ward' => $dto->ward,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        UserWard::insert($wardsData);
    }

    public function saveUserRoles(User $user, array $userRoleDto): void
    {
        $roles = array_map(fn($dto) => $dto->role_id, $userRoleDto);
        $user->syncRoles($roles);
    }
}

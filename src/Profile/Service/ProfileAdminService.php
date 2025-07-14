<?php

namespace Src\Profile\Service;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Src\Agendas\DTO\AgendaAdminDto;
use Src\Agendas\Models\Agenda;
use Src\Profile\DTO\ProfileAdminDto;
use Src\Profile\DTO\ProfilePasswordAdminDto;

class ProfileAdminService
{
    public function updateProfile(ProfileAdminDto $profileAdminDto)
    {
        return auth()->user()->update([
            'name' => $profileAdminDto->name,
            'email' => $profileAdminDto->email,
            'signature' => $profileAdminDto->signature,
        ]);
    }

    // public function updatePassword(ProfilePasswordAdminDto $profilePasswordAdminDto)
    // {
    //     return Auth::guard('customer')->user()->update([
    //         'password' => $profilePasswordAdminDto->password,
    //     ]);
    // }

    public function updatePassword(ProfilePasswordAdminDto $profilePasswordAdminDto)
    {
        $user = Auth::user();
        if (!$user) {
            throw new \Exception('No authenticated customer found.');
        }
        return $user->update([
            'password' => $profilePasswordAdminDto->password,  // Make sure to hash the password!
        ]);
    }

    public function updateOrganizationPassword(ProfilePasswordAdminDto $profilePasswordAdminDto)
    {
        return Auth::guard('organization')->user()->update([
            'password' => Hash::make($profilePasswordAdminDto->password),
        ]);
    }
}



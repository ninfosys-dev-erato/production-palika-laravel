<?php

namespace Src\Users\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Users\Models\User;

class UsersExport implements FromCollection
{
    public $users;

    public function __construct($users) {
        $this->users = $users;
    }

    public function collection()
    {
        return User::select([
'name',
'email',
'email_verified_at',
'password',
'remember_token',
'active'
])
        ->whereIn('id', $this->users)->get();
    }
}



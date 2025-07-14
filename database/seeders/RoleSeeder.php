<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Src\Roles\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'ward_secratory', 'guard' => 'web'],
            ['name' => 'ward_president', 'guard' => 'web'],
        ];

        Role::insert($roles);
    }
}

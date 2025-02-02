<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ownerRole = Role::create([
            'name' => 'owner'
        ]);
        $studentRole = Role::create([
            'name' => 'student'
        ]);
        $teacherRole = Role::create([
            'name' => 'teacher'
        ]);

        $userOwner = User::create([
            'name' => 'superadmin',
            'occupation' => 'CEO',
            'avatar' => 'images/default-avatar.png',
            'email' => 'team@mycourse.com',
            'balance'=> 0,
            'password' => bcrypt('teamutama'),
        ]);

        $userOwner->assignrole($ownerRole);


    }
}

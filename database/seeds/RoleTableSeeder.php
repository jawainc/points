<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = new Role();
        $role_admin->name = 'Admin';
        $role_admin->description = 'A admin panel user';
        $role_admin->save();

        $role_mentor = new Role();
        $role_mentor->name = 'Mentor';
        $role_mentor->description = 'A mentor user';
        $role_mentor->save();

        $role_student = new Role();
        $role_student->name = 'Student';
        $role_student->description = 'A student user';
        $role_student->save();
    }
}

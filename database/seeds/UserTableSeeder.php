<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$users = factory(User::class, 10000)->create();
     //    $role_employee = Role::where('name', 'employee')->first();
	    // $role_manager  = Role::where('name', 'admin')->first();
	    // $employee = new User();
	    // $employee->name = 'Employee Name';
	    // $employee->email = 'employee@example.com';
	    // $employee->password = bcrypt('123456');
	    // $employee->save();
	    // $employee->roles()->attach($role_employee);
	    // $manager = new User();
	    // $manager->name = 'Admin Name';
	    // $manager->email = 'admin@example.com';
	    // $manager->password = bcrypt('123456');
	    // $manager->save();
	    // $manager->roles()->attach($role_manager);
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
  		$userRole = new Role();
    	$userRole->name = 'user';
    	$userRole->desc = 'Regular user. Create/edit tasks and lists';
    	$userRole->save();

  		$userRole = new Role();
    	$userRole->name = 'moderator';
    	$userRole->desc = 'Moderator user. Create/edit tasks and lists';
    	$userRole->save();    	

    	$adminRole = new Role();
    	$adminRole->name = 'admin';
    	$adminRole->desc = 'Manage the application and the users';
    	$adminRole->save();
    }
}

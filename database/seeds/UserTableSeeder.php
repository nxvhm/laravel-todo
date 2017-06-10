<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Role;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$adminRole = Role::where('name', 'admin')->first();
    	$userRole  = Role::where('name', 'user')->first();

    	# Add demo user
    	$demoUser = new User();
    	$demoUser->name = 'John Doe';
    	$demoUser->email = 'user@gmail.com';
    	$demoUser->password = bcrypt('demouser');
    	$demoUser->save();
    	$demoUser->roles()->attach($userRole);

    	# add demo admin
    	$admin = new User();
    	$admin->name = 'Johny Bravo';
    	$admin->email = 'admin@gmail.com';
    	$admin->password = bcrypt('adminuser');
    	$admin->save();
    	$admin->roles()->attach($userRole);    	
    	$admin->roles()->attach($adminRole);    

        $users = [
            ['name' => 'Test User', 'email' => 'test@world.com', 'password'=> '123456'],
            ['name' => 'Bob Jones', 'email' => 'Bob@gmail.com.com', 'password'=> '123456'],
            ['name' => 'christina wood', 'email' => 'christina.wood74@example.com', 'password'=> '123456'],
            ['name' => 'Aaron Brown', 'email' => 'aaron@brown.com', 'password'=> '123456'],
            ['name' => 'Abe Mathers', 'email' => 'Abe@world.com', 'password'=> '123456'],
            ['name' => 'Jessica User', 'email' => 'essica@world.com', 'password'=> '123456'],
            ['name' => 'wilma brooks', 'email' => 'hello@world.com', 'password'=> '123456'],
            ['name' => 'jeremy bailey', 'email' => 'jeremy.bailey94@example.com', 'password'=> '123456'],
            ['name' => 'marcus adams', 'email' => 'marcus.adams33@example.com', 'password'=> '123456'],
            ['name' => 'louise hawkins', 'email' => 'louise.hawkins49@example.com', 'password'=> '123456'],

        ];	

        foreach ($users as $user) {
            $demoUser = new User();
            $demoUser->name = $user['name'];
            $demoUser->email = $user['email'];
            $demoUser->password = bcrypt($user['password']);
            $demoUser->save();
            $demoUser->roles()->attach($userRole);
        }


    }
}

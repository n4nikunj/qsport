<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i <= 1; $i++) {
	    	if($i == 0){
	    		$role = Role::where('name','Developer')->first();
	    		$phone = '1234567890';
	    	}else if($i == 1){
	    		$role = Role::where('name','Admin')->first();
	    		$phone = '4569078123';
	    	}
	    	$user = User::create([
			            'name' => $role->name,
			            'email' => strtolower($role->name).'@mail.com',
			            'phone_number' => $phone,
			            'password' => Hash::make('12345678'),
			            'user_type' => $role->name
			        ]);
   			$user->assignRole([$role->id]);
    	}
    	factory('App\Models\User', 10)->create();
    }
}

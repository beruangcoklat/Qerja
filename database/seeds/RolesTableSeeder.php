<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['member', 'admin'];
        for($i=0 ; $i<sizeof($roles) ; $i++){
        	$new = new Role;
        	$new->name = $roles[$i];
        	$new->save();
        }
    }
}

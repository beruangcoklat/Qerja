<?php

use Illuminate\Database\Seeder;
use App\AvailableJobs;

class AvailableJobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for($i=0 ; $i < 1000 ; $i++){
        	$data = new AvailableJobs;
        	$data->position_id = ($i % 26) + 1;
        	$data->company_id = ($i % 40) + 1;
        	$data->salary = rand(1000, 2000);
        	$data->description = substr($faker->text(), 0, 150);
        	$data->save();
        }
    }
}

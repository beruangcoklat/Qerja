<?php

use Illuminate\Database\Seeder;
use App\CompanyCategory;

class CompanyCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['category 1', 'category 2'];
        foreach ($names as $name) {
        	$data = new CompanyCategory;
        	$data->name = $name;
        	$data->save();
        }
    }
}

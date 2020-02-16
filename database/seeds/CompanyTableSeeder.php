<?php

use Illuminate\Database\Seeder;
use App\Company;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for($i=0 ; $i < 40 ; $i++){
            $com = new Company;
            $com->name = $faker->company();
            $com->description = substr($faker->text(), 0, 150);
            $com->image = 'pepsi.png';
            $com->city_id = rand(1, 2);
            $com->company_category_id = rand(1, 2);
            $com->save();
        }
    }
}

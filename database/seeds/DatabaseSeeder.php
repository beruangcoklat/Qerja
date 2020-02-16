<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);

        $this->call(PositionsTableSeeder::class);

        $this->call(CountryTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(CompanyCategoryTableSeeder::class);
        $this->call(CompanyTableSeeder::class);
        
        $this->call(ReviewTableSeeder::class);
        $this->call(HelpfulTableSeeder::class);
        
        $this->call(SalaryTableSeeder::class);
        $this->call(AvailableJobsTableSeeder::class);
    }
}

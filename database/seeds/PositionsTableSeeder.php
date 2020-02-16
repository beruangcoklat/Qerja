<?php

use Illuminate\Database\Seeder;
use App\Position;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = ['Accountant',
                    'Actuary',
                    'Aircraft Mechanic',
                    'Airline Pilot',
                    'Animal Groomer',
                    'Architect',
                    'Auto Mechanic',
                    'Bank Teller',
                    'Bartender',
                    'Biomedical Engineer',
                    'Brick Mason',
                    'Budget Analyst',
                    'Cashier',
                    'Chef',
                    'Chemist',
                    'Computer Programmer',
                    'Construction Laborer',
                    'Consultant',
                    'Correctional Officer',
                    'Court Reporter',
                    'Curator',
                    'Database Administrator',
                    'Dental Hygienist',
                    'Dentist',
                    'Dietitian/Nutritionist',
                    'Doctor'];

        foreach ($positions as $key) {
        	$p = new Position;
        	$p->name = $key;
        	$p->save();
        }
    }
}

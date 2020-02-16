<?php

use Illuminate\Database\Seeder;
use App\Salary;

class SalaryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    for($i=0 ; $i < 1000 ; $i++){
	        $s = new Salary;
	        $s->city_id = 1;
	        $s->company_id = ($i % 40) + 1;
	        $s->position_id = ($i % 26) + 1;
	        $s->status = 'masih';
	        $s->gaji = rand(1000, 10000);
	        $s->periode = 'bulan';
	        $s->save();
	    }
    }
}

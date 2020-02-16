<?php

use Illuminate\Database\Seeder;
use App\Review;

class ReviewTableSeeder extends Seeder
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
            $rev = new Review;
            $rev->company_id = rand(1, 40);

            $a = rand(1, 5);
            $b = rand(1, 5);
            $c = rand(1, 5);
            $d = rand(1, 5);
            $e = rand(1, 5);

            $rev->gaji_tunjangan = $a;
            $rev->jenjang_karir = $b;
            $rev->manajemen_senior = $c;
            $rev->work_life_balance = $d;
            $rev->nilai_budaya = $e;
            $rev->star = ($a + $b + $c + $d + $e) / 5;

            $rev->positive = substr($faker->text() . $faker->text(), 0, 150);
            $rev->negative = substr($faker->text(), 0, 150);

            $rev->position_id = ($i % 26) + 1;
            $rev->city_id = 1;
            $rev->lama_bekerja = 'Kurang dari setahun';
            $rev->status_karyawan = 'masih';
            $rev->gaji = '123';
            $rev->periode = 'tahun';
            
            $rev->save();
        }
    }
}

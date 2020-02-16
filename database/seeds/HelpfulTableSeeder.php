<?php

use Illuminate\Database\Seeder;
use App\Helpful;

class HelpfulTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0 ; $i<10 ; $i++){
            $h = new Helpful;
            $h->user_id = 2;
            $h->review_id = $i + 1;
            $h->save();
        }
        $h = new Helpful;
        $h->user_id = 2;
        $h->review_id = 1;
        $h->save();
    }
}

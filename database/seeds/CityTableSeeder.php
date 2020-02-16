<?php

use Illuminate\Database\Seeder;
use App\City;

class CityTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
	     $cities=[
		['city_name' => 'Taloqan','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Shīnḏanḏ','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Shibirghān','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Shahrak','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Sar-e Pul','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Sang-e Chārak','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Aībak','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Rustāq','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Qarqīn','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Qarāwul','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Pul-e Khumrī','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Paghmān','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Nahrīn','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Maymana','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Mehtar Lām','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Mazār-e Sharīf','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Lashkar Gāh','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Kushk','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Kunduz','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Khōst','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Khulm','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Khāsh','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Khanabad','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Karukh','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Kandahār','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Kabul','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Jalālābād','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Jabal os Saraj','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Herāt','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Ghormach','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Ghazni','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
		['city_name' => 'Gereshk','country_id' =>1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]];

	    foreach ($cities as $city) {
	    	$c = new City;
	    	$c->name = $city['city_name'];
	    	$c->country_id = $city['country_id'];
	    	$c->save();
	    }
	}
}

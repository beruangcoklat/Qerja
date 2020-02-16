<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    public function getAll(Request $request){
    	$country = $request->country;
    	$cities = DB::table('cities')
    				->join('countries', 'countries.id', '=', 'cities.country_id')
    				->select('cities.name', 'cities.id')
    				->where('countries.name', 'like', $country)
    				->get();
    	return response()->json([
    		'cities' => $cities
    	]);
    }
}

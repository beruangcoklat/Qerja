<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompanyCategory;

class CompanyCategoryController extends Controller
{
    public function getAll(){
    	$categories = CompanyCategory::all();
    	return response()->json([
    		'categories' => $categories
    	]);
    }
}

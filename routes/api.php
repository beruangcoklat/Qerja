<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'UserController@register');
Route::post('/resend', 'UserController@resend');

Route::get('/getCompany/mostReviewed', 'CompanyController@mostReviewed');
Route::get('/getCompany/paging', 'CompanyController@getCompaniesPaging');
Route::get('/getCompany/all', 'CompanyController@getAll');
Route::get('/getCompany/profile', 'CompanyController@getProfile');
Route::get('/getCompany/feeds', 'CompanyController@feeds');
Route::get('/getCompany/search', 'CompanyController@search');
Route::get('/getCompany/reviewid', 'CompanyController@getCompanyFromReview');
Route::get('/getCompany/salaryid', 'CompanyController@getCompanyFromSalary');
Route::get('/getCountry/all', 'CountryController@getAll');
Route::get('/getCity/all', 'CityController@getAll');
Route::get('/getCompanyCategories/all', 'CompanyCategoryController@getAll');
Route::get('/getSalary/mostReviewed', 'SalaryController@mostReviewed');
Route::get('/getSalary/salariesFromCompany', 'SalaryController@salariesFromCompany');
Route::get('/getSalary/paging', 'SalaryController@getSalariesPaging');
Route::get('/getReview/reviewsFromCompany', 'ReviewJobController@reviewsFromCompany');
Route::get('/getReview/paging', 'ReviewJobController@getReviewsPaging');
Route::get('/getUser/byId', 'UserController@getUserById');
Route::get('/getAvailableJob/byId', 'AvailableJobsController@byId');
Route::get('/getAvailableJob/paging', 'AvailableJobsController@paging');

Route::post('/salary/submitReview', 'SalaryController@submitReview');
Route::post('/reviewCompany/submitReview', 'ReviewJobController@submitReview');
Route::post('/addCompany', 'CompanyController@insert');
Route::get('/helpful', 'ReviewJobController@helpful');
Route::get('/follow', 'CompanyController@follow');

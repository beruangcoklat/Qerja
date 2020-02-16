<?php

Route::group(['middleware' => 'CheckMember'], function(){
	Route::get('/pengaturan', 'MyController@showPengaturan');
	Route::get('/reviewCompany', 'MyController@showReviewCompany');
	Route::get('/salary', 'MyController@showSalary');
	Route::get('/feeds', 'MyController@showFeeds');
});

Route::group(['middleware' => 'CheckMemberAndGuest'], function(){
	Route::get('/company', 'MyController@showCompany');
	Route::get('/companyDetail', 'MyController@showCompanyDetail');
	Route::get('/', 'MyController@showHome');
});

Route::group(['middleware' => 'CheckAdmin'], function(){
	Route::get('/addCompany', 'MyController@showAddCompany');
});

Route::group(['middleware' => 'CheckLogin'], function(){
	Route::get('/chat', 'MyController@showChat');
});


Route::get('/confirmEmail/{token}', 'UserController@verify');
Route::get('/login', 'UserController@login');
Route::get('/logout', 'UserController@logout');
Route::get('/getLoggedUser', 'UserController@getLoggedUser');
Route::post('/updatePassword', 'UserController@updatePassword');
Route::post('/updateProfilePicture', 'UserController@updateProfilePicture');
Route::get('/setSessionCompanyId', 'MyController@setSessionCompanyId');
Route::get('/getSessionCompanyId', 'MyController@getSessionCompanyId');
Route::get('/setSessionCompanyList', 'MyController@setSessionCompanyList');
Route::get('/getSessionCompanyList', 'MyController@getSessionCompanyList');

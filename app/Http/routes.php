<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]); //Authorisation Route

Route::get('/', 'PagesController@index'); //Route for the home page

Route::get('jobcard/{id?}', 'JobCardController@getAll'); //Get Route for JobCard
Route::post('jobcard/{id?}', 'JobCardController@getAll'); //POST Route for JobCard
Route::patch('jobcard/update', 'JobCardController@update'); //PATCH route for JobCard
Route::get('jobcard/edit/{id}', 'JobCardController@edit'); //Edit Route for JobCard

Route::post('employeeadmin/all', 'EmployeeAdminController@getAll'); //POST Route for Employee Admin
Route::get('employeeadmin/all', 'EmployeeAdminController@getAll'); //GET Route for Employee Admin
Route::get('employeeadmin/all/{id}', 'EmployeeAdminController@employeehistory'); //GET Route for Employee Admin Filter

Route::resource('employeeadmin', 'EmployeeAdminController'); //Resource Route for Employee Admin

Route::resource('jobcodeadmin', 'JobCodeController'); //Resource Route for Job Code Admin
Route::get('jobcodeadmin/show/{id}', 'JobCodeController@jobhistory'); //Route for Job Code Filter



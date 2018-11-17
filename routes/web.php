<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('reg','Userscontroller@return_register');

//routing for registering user in the system
Route::POST('registration','Userscontroller@validate_user_input');

//routing for user login
Route::get('login','Userscontroller@return_login');

//routing for user login logic
 Route::POST('login_user','Userscontroller@user_login');


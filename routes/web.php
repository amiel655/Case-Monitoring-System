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

Route::get('/login', ['middleware' => 'guest', function () {
    return view('auth.login');
}]);

Route::get('/', function(){
    return view('home');
});
// Route::resource('client-profile', 'FormController');

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::post('/access' , 'CaseController@index');

Route::get('{path}', 'HomeController@index')->where('path', '([A-z\d-\/_.]+)?');

Route::post('case-search', 'FormController@searchCase');


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


Auth::routes(); 
Route::get('/', 'FrontendController@index')->name('home');
Route::get('/ajaxGetCities', 'FrontendController@ajaxGetCities');
Route::get('/ajaxSearchWheaterForCity', 'FrontendController@ajaxSearchWheaterForCity')->name('ajaxSearchWheaterForCity');



Route::group(['middleware'=>'auth'],function(){  
    
 Route::get('/cities/getOne', 'Cities@getOne')->name('getOne');
Route::post('/cities/setDefault', 'Cities@setDefault')->name('setDefault');
Route::resource('cities', cities::class);  
    
    
});
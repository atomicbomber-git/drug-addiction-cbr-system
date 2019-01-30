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

Route::get('/', function() {
    return redirect()->route('guest.home');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::view('/guest_about', 'guest.about')->name('guest.about');
Route::view('/guest_home', 'guest.home')->name('guest.home');
Route::view('/guest_help', 'guest.help')->name('guest.help');

Route::group(['prefix' => '/base_case', 'as' => 'base_case.'], function() {
    Route::get('/index', 'BaseCaseController@index')->name('index');
    Route::get('/create', 'BaseCaseController@create')->name('create');
    Route::post('/store', 'BaseCaseController@store')->name('store');
    Route::get('/edit/{base_case}', 'BaseCaseController@edit')->name('edit');
    Route::post('/update/{base_case}', 'BaseCaseController@update')->name('update');
    Route::post('/delete/{base_case}', 'BaseCaseController@delete')->name('delete');
});

Route::group(['prefix' => '/unverified_case', 'as' => 'unverified_case.'], function() {
    Route::get('/index', 'UnverifiedCaseController@index')->name('index');
    Route::get('/create', 'UnverifiedCaseController@create')->name('create');
    Route::get('/guest_create', 'UnverifiedCaseController@guestCreate')->name('guest_create');
    Route::post('/guest_store', 'UnverifiedCaseController@guestStore')->name('guest_store');
    Route::get('/guest_retrieve', 'UnverifiedCaseController@guestRetrieve')->name('guest_retrieve');
    Route::post('/store', 'UnverifiedCaseController@store')->name('store');
    Route::get('/edit/{case}', 'UnverifiedCaseController@edit')->name('edit');
    Route::get('/retrieve/{case}', 'UnverifiedCaseController@retrieve')->name('retrieve');
    Route::post('/update/{case}', 'UnverifiedCaseController@update')->name('update');
    Route::post('/verify/{case}', 'UnverifiedCaseController@verify')->name('verify');
    Route::post('/delete/{case}', 'UnverifiedCaseController@delete')->name('delete');
});
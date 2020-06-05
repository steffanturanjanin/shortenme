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
})->name('home');

Route::get('/{shorten_url}', 'UrlController@redirection')->name('redirection');
Route::post('/url', 'UrlController@store')->name('store');
Route::get('/details/{shorten_url}', 'UrlController@index')->name('details');


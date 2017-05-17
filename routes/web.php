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

Route::get('/', 'IndexController@index');

Route::get('api/getpoetryinfo', 'ApiController@getPoetryInfo');
Route::get('api/getpoetinfo', 'ApiController@getPoetInfo');
Route::get('api/poet', 'ApiController@getPoetById');
Route::get('api/poetry', 'ApiController@getPoetryById');
Route::get('api/poetry_relate', 'ApiController@getPoetryByPoetid');
Route::get('api/search', 'ApiController@search');

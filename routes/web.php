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
    return view('index');
});


Route::resource('article','ArticleController');

Route::view('add_image', 'add_image');

Route::view('update_image', 'update_image');

Route::get('image_list', 'ArticleController@image_list');

Route::get('article', 'ArticleController@image_list');

Route::view('use', 'use_method');

Route::get('recognite', 'FeatrueController@recognite');
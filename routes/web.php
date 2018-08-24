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
    return view('fb_home');
});


    Route::get('/album', function () {
    return view('album');
});

 Route::get('/data', function () {
    return view('data');
});
Route::get('/logout', function () {
    return view('logout');
});

Auth::routes();

// Route::get('/Album',['as' => 'home','uses' => 'HomeController@index']);

//Route::get('/home',['as' => 'home','uses' => 'HomeController@index']);
//Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
//Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/facebook', ['as' => 'auth/facebook','uses' => 'Auth\LoginController@redirectToProvider']);
Route::get('/callback', ['as' => 'auth/facebook/callback', 'uses' => 'Auth\LoginController@handleProviderCallback']);
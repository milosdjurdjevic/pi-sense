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
Route::get('/fire', 'IndexController@fire');
Route::get('/fire-write', 'IndexController@fireWrite');
Route::get('/max-temperature-alert', function () {
    $json = [[
        'action' => 'talk',
        'voiceName' => 'Russell',
        'text' => 'Greenhouse is on fire!',
    ]];

    return response()->json($json);
});

Route::get('/min-temperature-alert', function () {
    $json = [[
        'action' => 'talk',
        'voiceName' => 'Russell',
        'text' => 'Greenhouse is as cold as ice!',
    ]];

    return response()->json($json);
});
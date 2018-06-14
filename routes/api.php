<?php

use Dingo\Api\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$api = app(Router::class);

$api->version('v1', function (Router $api) {

    $api->get('fire', function () {
        event(new \App\Events\ReadTemperatureEvent());
    });

    $api->group([
        'prefix' => 'auth',
        'namespace' => 'App\Http\Controllers\Api\v1',
    ], function ($api) {
        $api->post('login', 'AuthController@login');
        $api->post('logout', 'AuthController@logout');
        $api->post('refresh', 'AuthController@refresh');
        $api->post('me', 'AuthController@me');
    });

    $api->group([
        'middleware' => 'jwt.auth',
        'namespace' => 'App\Http\Controllers\Api\v1',
    ], function ($api) {
        /*
        |--------------------------------------------------------------------------
        | Authenticated Routes
        |--------------------------------------------------------------------------
        */
        // Users
        $api->get('users/all', 'UsersController@allUsers');
        $api->get('users', 'UsersController@index');
        $api->get('users/{id}', 'UsersController@show');
        $api->post('users', 'UsersController@store');
        $api->put('users/{id}', 'UsersController@update');
        $api->put('users/{id}/password', 'UsersController@updatePassword');
        $api->delete('users/{id}', 'UsersController@destroy');

        // Settings
        $api->get('settings', 'SettingsController@index');
        $api->get('settings/{id}', 'SettingsController@show');
        $api->put('settings/{id}', 'SettingsController@update');
        $api->put('settings', 'SettingsController@activateSetting');
        $api->delete('settings/{id}', 'SettingsController@deleteSetting');
        $api->post('settings', 'SettingsController@createProgram');

        // Readings
        $api->get('stats', 'ReadingsController@index');
    });

});
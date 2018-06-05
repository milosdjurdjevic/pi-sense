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
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://sesamoid-jackal-7649.dataplicity.io/fire");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);

        return response()->json(json_encode(['response' => $response]));
    });

//    $api->group([
//        'namespace' => 'App\Http\Controllers\Api\v1',
//    ], function ($api) {
//        $api->post('/authenticate', 'AuthController@authenticate');
//        // login
//        $api->post('auth/login', 'AuthController@login');
//        // refresh jwt token
//        $api->post('auth/login/refresh', 'AuthController@refreshToken');
//    });

    $api->group([

//        'middleware' => 'api',
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


        // Test route
        $api->get('test', 'TestController@index');

        /*
        |--------------------------------------------------------------------------
        | Authenticated Routes
        |--------------------------------------------------------------------------
        */
//        $api->group([
//            'middleware' => 'jwt.auth'
//        ], function ($api) {
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
//        });
    });

});
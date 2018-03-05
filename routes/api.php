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
    $api->group([
        'middleware' => 'api',
        'namespace' => 'App\Http\Controllers\Api\v1',
    ], function ($api) {
        $api->post('/authenticate', 'AuthController@authenticate');
        // login
        $api->post('auth/login', 'AuthController@login');
        // refresh jwt token
        $api->post('auth/login/refresh', 'AuthController@refreshToken');

        /*
        |--------------------------------------------------------------------------
        | Authenticated Routes
        |--------------------------------------------------------------------------
        */
        $api->group([
            'middleware' => 'jwt.auth'
        ], function ($api) {
            // User
            $api->get('users', 'UsersController@index');
            $api->get('users/{id}', 'UsersController@show');
            $api->post('users', 'UsersController@store');
            $api->put('users/{id}', 'UsersController@update');
            $api->put('users/{id}/password', 'UsersController@updatePassword');
            $api->delete('users/{id}', 'UsersController@destroy');
        });
    });

});
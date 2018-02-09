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
            $api->get('user', 'UserController@index');
            $api->get('user/{id}', 'UserController@show');
            $api->post('user', 'UserController@store');
            $api->put('user/{id}', 'UserController@update');
            $api->delete('user/{id}', 'UserController@destroy');
            
            // Product
            $api->get('product', 'ProductController@index');
            $api->get('product/{id}', 'ProductController@show');
            $api->post('product', 'ProductController@store');
            $api->put('product/{id}', 'ProductController@update');
            $api->delete('product/{id}', 'ProductController@destroy');
        });
    });

});
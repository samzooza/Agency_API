<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function($api){
    $api->group(['prefix'=>'oauth'], function($api){
        $api->post('token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
    });

    //$api->group(['namespace'=>'App\Http\Controllers', 'middleware'=>['auth:api', 'cors']], function($api){
    $api->group(['namespace'=>'App\Http\Controllers', 'middleware'=>['cors']], function($api){
        // controller route
        $api->get('users', 'UserController@show');
    });

    // $api->group(['prefix' => 'samples'], function($api) {
    //     $api->group(['middleware'=>'auth'], function($api) {
    //         $api->post('update/{id}', 'SampleController@update');
    //     });
    // });  
});

/* user register */
$router->group(['prefix' => 'api'], function($router) {
    $router->group(['prefix' => 'user'], function($router) {
        $router->post('login', 'UserController@login');
        $router->post('register', 'UserController@register');
        $router->post('fileupload', [
            'as' => 'file', 'uses' => 'FileController@fileupload'
        ]);
    });

    $router->get('occupation/get', 'DirectDBController@getoccupation');
});



/* sample */
$router->group(['prefix' => 'api/samples'], function($router) {
    $router->get('get', 'SampleController@get');
    $router->get('get/{id}', 'SampleController@getById');

    // token required for
    $router->group(['middleware'=>'auth'], function($router) {
        $router->post('create', 'SampleController@create');
        $router->post('update/{id}', 'SampleController@update');
        $router->post('delete/{id}', 'SampleController@delete');
    });
});
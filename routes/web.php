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

$router->group(['prefix' => 'api'], function () use ($router) {

    // Website add
    $router->get('website', 'WebsiteController@index');
    $router->post('website-store', 'WebsiteController@store');

    $router->get('post/{webID}', 'PostController@show');
    $router->post('post-store', 'PostController@store');

    /*$router->get('user/{webID}', 'UserController@show');*/
    $router->post('user-store', 'UserController@store');

    $router->get('/subscribe/list', 'SubscribeController@index');
    $router->post('subscribe-store', 'SubscribeController@store');
});
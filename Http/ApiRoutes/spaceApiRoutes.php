<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => 'spaces'], function (Router $router) {

    //Route create
    $router->post('/', [
        'as' => 'api.space.space.create',
        'uses' => 'SpaceApiController@create',
        'middleware' => ['auth:api']
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.space.space.get.items.by',
        'uses' => 'SpaceApiController@index',
        //'middleware' => ['auth:api']
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.space.space.get.item',
        'uses' => 'SpaceApiController@show',
        //'middleware' => ['auth:api']
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.space.space.update',
        'uses' => 'SpaceApiController@update',
        'middleware' => ['auth:api']
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.space.space.delete',
        'uses' => 'SpaceApiController@delete',
        'middleware' => ['auth:api']
    ]);
});

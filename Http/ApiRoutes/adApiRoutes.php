<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => 'ads'], function (Router $router) {
    //Route create
    $router->post('/', [
        'as' => 'api.space.ad.create',
        'uses' => 'AdApiController@create',
        'middleware' => ['auth:api']
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.space.ad.index',
        'uses' => 'AdApiController@index',
        //'middleware' => ['auth:api']
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.space.ad.show',
        'uses' => 'AdApiController@show',
        //'middleware' => ['auth:api']
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.space.ad.update',
        'uses' => 'AdApiController@update',
        'middleware' => ['auth:api']
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.space.ad.delete',
        'uses' => 'AdApiController@delete',
        'middleware' => ['auth:api']
    ]);

});

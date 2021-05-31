<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->bind('space', function ($id) {
    return app(\Modules\Adsense\Repositories\SpaceRepository::class)->find($id);
});
$router->bind('ad', function ($id) {
    return app(\Modules\Adsense\Repositories\AdRepository::class)->find($id);
});

$router->group(['prefix' => '/adsense'], function (Router $router) {
    $router->get('spaces', ['as' => 'admin.adsense.space.index', 'uses' => 'SpaceController@index']);
    $router->get('spaces/create', ['as' => 'admin.adsense.space.create', 'uses' => 'SpaceController@create']);
    $router->post('spaces', ['as' => 'admin.adsense.space.store', 'uses' => 'SpaceController@store']);
    $router->get('spaces/{space}/edit', ['as' => 'admin.adsense.space.edit', 'uses' => 'SpaceController@edit']);
    $router->put('spaces/{space}', ['as' => 'admin.adsense.space.update', 'uses' => 'SpaceController@update']);
    $router->delete('spaces/{space}', ['as' => 'admin.adsense.space.destroy', 'uses' => 'SpaceController@destroy']);

    $router->get('adsense/{space}/ad', ['as' => 'admin.adsense.ad.index', 'uses' => 'AdController@index']);
    $router->get('adsense/{space}/ad/create', ['as' => 'admin.adsense.ad.create', 'uses' => 'AdController@create']);
    $router->post('adsense/{space}/ad', ['as' => 'admin.adsense.ad.store', 'uses' => 'AdController@store']);
    $router->get('adsense/{space}/ad/{ad}/edit', ['as' => 'admin.adsense.ad.edit', 'uses' => 'AdController@edit']);
    $router->put('adsense/{space}/ad/{ad}', ['as' => 'admin.adsense.ad.update', 'uses' => 'AdController@update']);
    $router->delete('adsense/{space}/ad/{ad}', ['as' => 'admin.adsense.ad.destroy', 'uses' => 'AdController@destroy']);

    $router->get('stat', ['as' => 'admin.adsense.stat.index', 'uses' => 'StatController@index']);


});

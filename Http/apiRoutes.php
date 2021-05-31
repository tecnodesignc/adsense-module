<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => '/ad'], function (Router $router) {
  $router->get('/', [
    'as' => 'api.ad.index',
    'uses' => 'AdApiController@index'
  ]);

  $router->get('/{id}', [
    'as' => 'api.ad.show',
    'uses' => 'AdApiController@show'
  ]);

  $router->post('/update', [
    'as' => 'api.ad.update',
    'uses' => 'AdController@update',
    'middleware' => 'token-can:adsense.ads.update',
  ]);

  $router->post('/delete', [
    'as' => 'api.ad.delete',
    'uses' => 'AdController@delete',
    'middleware' => 'token-can:adsense.ads.destroy'
  ]);
});


$router->group(['prefix' =>'/adsense/v1'], function (Router $router) {
    require('ApiRoutes/spaceApiRoutes.php');
    require('ApiRoutes/adApiRoutes.php');

});

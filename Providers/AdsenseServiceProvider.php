<?php

namespace Modules\Adsense\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Modules\Adsense\Entities\Space;
use Modules\Adsense\Entities\Ad;
use Modules\Adsense\Entities\Stat;
use Modules\Adsense\Events\Handlers\RegisterAdsenseSidebar;
use Modules\Adsense\Presenters\AdsensePresenter;
use Modules\Adsense\Repositories\Cache\CacheSpaceDecorator;
use Modules\Adsense\Repositories\Cache\CacheAdDecorator;
use Modules\Adsense\Repositories\Cache\CacheStatDecorator;
use Modules\Adsense\Repositories\Eloquent\EloquentSpaceRepository;
use Modules\Adsense\Repositories\Eloquent\EloquentAdRepository;
use Modules\Adsense\Repositories\Eloquent\EloquentStatRepository;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Traits\CanGetSidebarClassForModule;
use Modules\Core\Traits\CanPublishConfiguration;
use Illuminate\Support\Arr;

class AdsenseServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration, CanGetSidebarClassForModule;

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(
            BuildingSidebar::class,
            $this->getSidebarClassForModule('adsense', RegisterAdsenseSidebar::class)
        );

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('ads', Arr::dot(trans('adsense::ads')));
            $event->load('space', Arr::dot(trans('adsense::space')));
            $event->load('stats', Arr::dot(trans('adsense::stat')));
            // append translations


        });


    }

    /**
     * Register all online spaces on the Pingpong/Menu package
     */
    public function boot()
    {
        $this->publishConfig('adsense', 'config');
        $this->publishConfig('adsense', 'permissions');

        $this->registerSpaces();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'adsense');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('adsense');
    }

    /**
     * Register class binding
     */
    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Adsense\Repositories\SpaceRepository',
            function () {
                $repository = new EloquentSpaceRepository(new Space());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new CacheSpaceDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Adsense\Repositories\AdRepository',
            function () {
                $repository = new EloquentAdRepository(new Ad());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new CacheAdDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Adsense\Repositories\StatRepository',
            function () {
                $repository = new EloquentStatRepository(new Stat());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new CacheStatDecorator($repository);
            }
        );

        $this->app->bind('Modules\Adsense\Presenters\AdsensePresenter');
    }

    /**
     * Register the active spaces
     */
    private function registerSpaces()
    {
        if (!$this->app['encore.isInstalled']) {
            return;
        }
    }

}

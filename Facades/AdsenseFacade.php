<?php

namespace Modules\Adsense\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Adsense\Presenters\AdsensePresenter;


class AdsenseFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AdsensePresenter::class;
    }

}

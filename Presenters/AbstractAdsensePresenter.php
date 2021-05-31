<?php

namespace Modules\Adsense\Presenters;

use Modules\Adsense\Repositories\SpaceRepository;

abstract class AbstractAdsensePresenter implements AdsensePresenterInterface
{

    /**
     * @var SpaceRepository
     */
    protected $spaceRepository;

    /**
     * SpacePresenter constructor.
     * @param SpaceRepository $spaceRepository
     */
    public function __construct(SpaceRepository $spaceRepository)
    {
        $this->spaceRepository = $spaceRepository;
    }

}

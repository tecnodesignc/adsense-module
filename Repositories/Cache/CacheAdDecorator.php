<?php
namespace Modules\Adsense\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Adsense\Repositories\AdRepository;

class CacheAdDecorator extends BaseCacheDecorator implements AdRepository
{
    /**
     * @var AdRepository
     */
    protected $repository;

    public function __construct(AdRepository $ad)
    {
        parent::__construct();
        $this->entityName = 'ads';
        $this->repository = $ad;
    }

}

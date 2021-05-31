<?php

namespace Modules\Adsense\Repositories\Cache;

use Modules\Adsense\Repositories\StatRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheStatDecorator extends BaseCacheDecorator implements StatRepository
{
    public function __construct(StatRepository $stat)
    {
        parent::__construct();
        $this->entityName = 'adsense.stats';
        $this->repository = $stat;
    }
}

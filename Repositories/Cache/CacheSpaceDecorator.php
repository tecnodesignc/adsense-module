<?php

namespace Modules\Adsense\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Adsense\Repositories\SpaceRepository;

class CacheSpaceDecorator extends BaseCacheDecorator implements SpaceRepository
{
    /**
     * @var SpaceRepository
     */
    protected $repository;

    public function __construct(SpaceRepository $space)
    {
        parent::__construct();
        $this->entityName = 'spaces';
        $this->repository = $space;
    }

    /**
     * Get all online spaces
     * @return object
     */
    public function allOnline()
    {
        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.allOnline", $this->cacheTime,
                function () {
                    return $this->repository->allOnline();
                }
            );
    }

    public function findBySystemName(string $systemName)
    {
        return $this->remember(function () use ($systemName) {
            return $this->repository->findBySystemName($systemName);
        });
    }

    public function countAll()
    {
        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.countAll", $this->cacheTime,
                function () {
                    return $this->repository->countAll();
                }
            );
    }
}

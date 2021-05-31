<?php namespace Modules\Adsense\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface SpaceRepository extends BaseRepository
{
    /**
     * Get all online spaces
     * @return object
     */
    public function allOnline();

    /**
     * @param string $systemName
     * @return Object
     */
    public function findBySystemName(string $systemName);

    /**
     * Count all records
     * @return int
     */
    public function countAll();
}

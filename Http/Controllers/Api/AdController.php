<?php

namespace Modules\Adsense\Http\Controllers\Api;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Modules\Adsense\Services\AdOrderer;
use Modules\Adsense\Repositories\AdRepository;

class AdController extends Controller
{
    /**
     * @var Repository
     */
    private $cache;
    /**
     * @var AdOrderer
     */
    private $adOrderer;
    /**
     * @var AdRepository
     */
    private $ad;

    public function __construct(AdOrderer $adOrderer, Repository $cache, AdRepository $ad)
    {
        $this->cache = $cache;
        $this->adOrderer = $adOrderer;
        $this->ad = $ad;
    }

    /**
     * Update all ads
     * @param Request $request
     */
    public function update(Request $request)
    {
        $this->cache->tags('ads')->flush();

        $this->adOrderer->handle($request->get('space'));
    }

    /**
     * Delete a ad
     * @param Request $request
     * @return mixed
     */
    public function delete(Request $request)
    {
        $ad = $this->ad->find($request->get('ad'));

        if (!$ad) {
            return Response::json(['errors' => true]);
        }

        $this->ad->destroy($ad);

        return Response::json(['errors' => false]);
    }
}

<?php

namespace Modules\Adsense\Tests;

class AdOrdererTest extends BaseAdsenseTest
{
    /**
     * @var \Modules\Adsense\Services\AdOrderer
     */
    protected $adOrderer;

    public function setUp()
    {
        parent::setUp();
        $this->adOrderer = app('Modules\Adsense\Services\AdOrderer');
    }

    /**
     * @test
     */
    public function sorts_ads()
    {
        $space = $this->createSpaceWithAds('Sorting Test Adsense', 'sorting_space', 10);

        $newOrderArray = [];
        foreach ($space->ads->shuffle() as $newOrder => $ad) {
            $newOrderArray[] = ['id' => $ad->id];
        }

        $this->adOrderer->handle(json_encode($newOrderArray));

        $reloadedSpace = $this->spaceRepository->find($space->id);
        $newOrderCheckArray = [];
        foreach ($reloadedSpace->ads as $ad) {
            $newOrderCheckArray[] = ['id' => $ad->id];
        }

        $this->assertEquals($newOrderArray, $newOrderCheckArray);
    }

}

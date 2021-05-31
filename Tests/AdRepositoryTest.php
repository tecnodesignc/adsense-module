<?php

namespace Modules\Adsense\Tests;

use Modules\Adsense\Entities\Ad;

class AdRepositoryTest extends BaseSpaceTest
{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function can_create_ad()
    {
        $numberOfAds = rand(1, 10);
        $space = $this->createSpaceWithAds('Homepage Space', 'homepage', $numberOfAds);
        $this->assertEquals($numberOfAds, count($space->ads));
    }

    /**
     * this is more of a Collection test, rather than Space
     * @test
     */
    public function can_associate_ad()
    {
        $space = $this->createSpace();

        $ad = new Ad;
        $ad->title = $this->faker->words(3);
        $ad->caption = $this->faker->words(10);

        $ad->space()->associate($space);

        $this->assertEquals($space->id, $ad->space_id);
    }

    /**
     * @test
     */
    public function can_delete_ad()
    {
        $adCount = rand(1,5);
        $space = $this->createSpaceWithAds('Homepage Space', 'homepage_space', $adCount);
        $this->assertEquals($adCount, count($space->ads));

        foreach ($space->ads as $ad) {
            $this->adRepository->destroy($ad);
        }

        $spaceRetrievedAgain = $this->spaceRepository->find($space->id);
        $this->assertEquals(0, count($spaceRetrievedAgain->ads));
    }

}

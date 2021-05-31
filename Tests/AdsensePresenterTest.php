<?php

namespace Modules\Adsense\Tests;

use Modules\Adsense\Presenters\SpacePresenter;

class AdsensePresenterTest extends BaseSpaceTest
{

    /**
     * @var AdsensePresenter
     */
    private $adsensePresenter;

    public function setUp()
    {
        parent::setUp();
        $this->adsensePresenter = app('Modules\Adsense\Presenters\AdsensePresenter');
    }

    /**
     * @test
     */
    public function renders_output_for_stored_space()
    {
        $systemName = 'homepage_space';
        $this->createSpaceWithAds('Homepage Space', $systemName, 5);
        $renderedHtml = $this->adsensePresenter->render($systemName);
        $this->assertStringStartsWith(sprintf('<div id="%s"', $systemName), $renderedHtml);
    }

    /**
     * @test
     */
    public function renders_output_for_given_space()
    {
        $systemName = 'homepage_space_instance';
        $space = $this->createSpaceWithAds('Homepage Space', $systemName, 5);
        $renderedHtml = $this->adsensePresenter->render($space);
        $this->assertStringStartsWith(sprintf('<div id="%s"', $systemName), $renderedHtml);
    }
}

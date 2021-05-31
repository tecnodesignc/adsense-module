<?php namespace Modules\Adsense\Tests;

class SpaceRepositoryTest extends BaseSpaceTest
{
    /**
     * @test
     */
    public function can_create_space()
    {
        $space = $this->createSpace('Homepage Space', 'homepage');

        $this->assertEquals(1, $this->spaceRepository->find($space->id)->count());
        $this->assertEquals($space->name, $this->spaceRepository->find($space->id)->name);
        $this->assertEquals($space->system_name, $this->spaceRepository->find($space->id)->system_name);
    }

    /**
     * @test
     */
    public function can_delete_space()
    {
        $space = $this->createSpace('Homepage Space', 'homepage');
        $this->assertEquals(1, $this->spaceRepository->find($space->id)->count());
        $this->spaceRepository->destroy($space);
        $this->assertNull($this->spaceRepository->find($space->id));
    }

}

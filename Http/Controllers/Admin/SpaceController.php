<?php

namespace Modules\Adsense\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Adsense\Entities\Space;
use Modules\Adsense\Http\Requests\CreateSpaceRequest;
use Modules\Adsense\Http\Requests\UpdateSpaceRequest;
use Modules\Adsense\Repositories\AdRepository;
use Modules\Adsense\Repositories\SpaceRepository;
use Modules\Adsense\Services\SpaceRenderer;

class SpaceController extends AdminBaseController
{
    /**
     * @var SpaceRepository
     */
    private $space;

    /**
     * @var AdRepository
     */
    private $ad;

    /**
     * @var SpaceRenderer
     */
    private $spaceRenderer;

    public function __construct(
        SpaceRepository $space,
        AdRepository $ad,
        SpaceRenderer $spaceRenderer
    )
    {
        parent::__construct();
        $this->space = $space;
        $this->ad = $ad;
        $this->spaceRenderer = $spaceRenderer;
    }

    public function index()
    {
        $spaces = $this->space->all();

        return view('adsense::admin.spaces.index')
            ->with([
                'spaces' => $spaces
            ]);
    }

    public function create()
    {
        return view('adsense::admin.spaces.create');
    }

    public function store(CreateSpaceRequest $request)
    {
        $this->space->create($request->all());

        return redirect()->route('admin.adsense.space.index')->withSuccess(trans('adsense::messages.space created'));
    }

    public function edit(Space $space)
    {
        $ads = $space->ads;
        $spaceStructure = $this->spaceRenderer->renderForSpace($space, $ads);

        return view('adsense::admin.spaces.edit')
            ->with([
                'space' => $space,
                'ads' => $spaceStructure
            ]);

    }

    public function update(Space $space, UpdateSpaceRequest $request)
    {
        $this->space->update($space, $request->all());

        return redirect()->route('admin.adsense.space.index')->withSuccess(trans('adsense::messages.space updated'));
    }

    public function destroy(Space $space)
    {
        $this->space->destroy($space);

        return redirect()->route('admin.adsense.space.index')->withSuccess(trans('adsense::messages.space deleted'));
    }
}

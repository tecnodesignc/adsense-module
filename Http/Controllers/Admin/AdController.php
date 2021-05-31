<?php

namespace Modules\Adsense\Http\Controllers\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Laracasts\Flash\Flash;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Adsense\Entities\Space;
use Modules\Adsense\Entities\Ad;
use Modules\Adsense\Http\Requests\CreateAdRequest;
use Modules\Adsense\Http\Requests\UpdateAdRequest;
use Modules\Adsense\Repositories\AdRepository;
use Modules\Media\Repositories\FileRepository;

class AdController extends AdminBaseController
{
    /**
     * @var AdRepository
     */
    private $ad;


    /**
     * @var FileRepository
     */
    private $file;

    public function __construct(AdRepository $ad,  FileRepository $file)
    {
        parent::__construct();
        $this->ad = $ad;
        $this->file = $file;
    }

    public function create(Space $space)
    {

        return view('adsense::admin.ads.create')
            ->with([
                'space' => $space,
            ]);
    }

    public function store(Space $space, CreateAdRequest $request)
    {
        $this->ad->create($this->addSpaceId($space, $request));

        return redirect()
            ->route('admin.adsense.space.edit', [$space->id])
            ->withSuccess(trans('adsense::messages.ad created'));
    }

    public function edit(Space $space, Ad $ad)
    {
        return view('adsense::admin.ads.edit')
            ->with([
                'space' => $space,
                'ad' => $ad,
                'adImage' => $this->file->findFileByZoneForEntity('adImage', $ad)
            ]);
    }

    public function update(Space $space, Ad $ad, UpdateAdRequest $request)
    {
        $this->ad->update($ad, $this->addSpaceId($space, $request));

        return redirect()
            ->route('admin.adsense.space.edit', [$space->id])
            ->withSuccess(trans('adsense::messages.ad updated'));
    }

    /**
     * @param  Space $space
     * @param  \Illuminate\Foundation\Http\FormRequest $request
     * @return array
     */
    private function addSpaceId(Space $space, FormRequest $request)
    {
        return array_merge($request->all(), ['space_id' => $space->id]);
    }
}

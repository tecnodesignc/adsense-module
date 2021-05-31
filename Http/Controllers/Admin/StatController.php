<?php

namespace Modules\Adsense\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Adsense\Entities\Stat;
use Modules\Adsense\Http\Requests\CreateStatRequest;
use Modules\Adsense\Http\Requests\UpdateStatRequest;
use Modules\Adsense\Repositories\StatRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class StatController extends AdminBaseController
{
    /**
     * @var StatRepository
     */
    private $stat;

    public function __construct(StatRepository $stat)
    {
        parent::__construct();

        $this->stat = $stat;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$stats = $this->stat->all();

        return view('adsense::admin.stats.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('adsense::admin.stats.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateStatRequest $request
     * @return Response
     */
    public function store(CreateStatRequest $request)
    {
        $this->stat->create($request->all());

        return redirect()->route('admin.adsense.stat.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('adsense::stats.title.stats')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Stat $stat
     * @return Response
     */
    public function edit(Stat $stat)
    {
        return view('adsense::admin.stats.edit', compact('stat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Stat $stat
     * @param  UpdateStatRequest $request
     * @return Response
     */
    public function update(Stat $stat, UpdateStatRequest $request)
    {
        $this->stat->update($stat, $request->all());

        return redirect()->route('admin.adsense.stat.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('adsense::stats.title.stats')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Stat $stat
     * @return Response
     */
    public function destroy(Stat $stat)
    {
        $this->stat->destroy($stat);

        return redirect()->route('admin.adsense.stat.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('adsense::stats.title.stats')]));
    }
}

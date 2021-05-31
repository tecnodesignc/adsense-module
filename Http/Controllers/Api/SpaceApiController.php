<?php

namespace Modules\Adsense\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Modules\Adsense\Repositories\SpaceRepository;
use Modules\Adsense\Transformers\SpaceTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;

class SpaceApiController extends BaseApiController
{


    /**
     * @var SpaceRepository
     */
    private $space;

    public function __construct(SpaceRepository $space)
    {
        $this->space = $space;
    }

    /**
     * GET ITEMS
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $spaces = $this->space->getItemsBy($params);

            //Response
            $response = ["data" => SpaceTransformer::collection($spaces)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($spaces)] : false;
        } catch (\Exception $e) {
            \Log::Error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    /**
     * GET A ITEM
     *
     * @param $criteria
     * @return mixed
     */
    public function show($criteria, Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $space = $this->space->getItem($criteria, $params);

            //Break if no found item
            if (!$space) throw new Exception('Item not found', 404);

            //Response
            $response = ["data" => new SpaceTransformer($space)];

        } catch (\Exception $e) {
            \Log::Error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * CREATE A ITEM
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        \DB::beginTransaction();
        try {
            $data = $request->input('attributes') ?? [];//Get data
            //Validate Request
            $this->validateRequestApi(new CreateSpaceRequest($data));

            //Create item
            $space = $this->space->create($data);

            //Response
            $response = ["data" => new SpaceTransformer($space)];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \Log::Error($e);
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    /**
     * UPDATE ITEM
     *
     * @param $criteria
     * @param Request $request
     * @return mixed
     */
    public function update($criteria, Request $request)
    {
        \DB::beginTransaction(); //DB Transaction
        try {
            //Get data
            $data = $request->input('attributes') ?? [];//Get data

            //Validate Request
            $this->validateRequestApi(new CreateSpaceRequest($data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);
            //Request to Repository
            $space = $this->space->getItem($criteria, $params);
            //Request to Repository
            $this->space->update($space, $data);

            //Response
            $response = ["data" => trans('adsense::messages.resource updated')];
            \DB::commit();//Commit to DataBase
        } catch (\Exception $e) {
            \Log::Error($e);
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    /**
     * DELETE A ITEM
     *
     * @param $criteria
     * @return mixed
     */
    public function delete($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get params
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $space = $this->space->getItem($criteria, $params);

            //call Method delete
            $this->space->destroy($space);

            //Response
            $response = ["data" => trans('adsense::messages.resource deleted')];
            \DB::commit();//Commit to Data Base
        } catch (\Exception $e) {
            \Log::Error($e);
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }
}

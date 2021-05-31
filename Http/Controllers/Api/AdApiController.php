<?php

namespace Modules\Adsense\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Adsense\Repositories\AdRepository;
use Modules\Adsense\Transformers\AdTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;

class AdApiController extends BaseApiController
{

    /**
     * @var AdRepository
     */
  private AdRepository $ad;

  public function __construct(AdRepository $space)
  {
    $this->ad = $space;
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
            $ads = $this->ad->getItemsBy($params);

            //Response
            $response = ["data" => AdTransformer::collection($ads)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($ads)] : false;
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
    public function show($criteria,Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $ad = $this->ad->getItem($criteria, $params);

            //Break if no found item
            if(!$ad) throw new Exception('Item not found',404);

            //Response
            $response = ["data" => new AdTransformer($ad)];

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
            $this->validateRequestApi(new CreateAdRequest($data));

            //Create item
            $ad = $this->ad->create($data);

            //Response
            $response = ["data" => new AdTransformer($ad)];
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
            $this->validateRequestApi(new CreateAdRequest($data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);
            //Request to Repository
            $ad = $this->ad->getItem($criteria, $params);
            //Request to Repository
            $this->ad->update($ad, $data);

            //Response
            $response = ["data" => trans('adsense::common.messages.resource updated')];
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
            $ad = $this->ad->getItem($criteria, $params);

            //call Method delete
            $this->ad->destroy($ad);

            //Response
            $response = ["data" => trans('adsense::common.messages.resource deleted')];
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

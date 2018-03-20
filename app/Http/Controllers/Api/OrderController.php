<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use Auth;
use \App\User;
use App\Category;
use App\Order;
use App\Setting;
use App\Helpers\OrderOperations;
use App\LogOrderProcess as OrderLogger;
use DB;
use Geotools;

/**
 * Handle api Clients auth
 * @author Ahmad Gamal <eng.asgamal@gmail.com>
 */
class OrderController extends ApiBaseController {

    /**
     * @SWG\Post(
     *     path="/api/auth/order",
     *     summary="Order a lawyers",
     *     tags={"Client"},
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          in="header", name="X-Api-Language", description="['ar','en'] default is 'ar'", type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="header", name="Authorization", description="Logged in User access token", required=true, type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="body",
     *          name="body",
     *          description="Request body", 
     *          required=true,
     *          @SWG\Schema(ref="#/definitions/OrderRequest"),
     *      ),
     *     @SWG\Response(response="405",description="Invalid input"),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/OrderResponses")
     *     ),
     *     @SWG\SecurityScheme(
     *         securityDefinition="X-Api-Token",
     *         type="apiKey",
     *         in="header",
     *         name="X-Api-Token"
     *    ),
     * )
     */
    public function order(Request $request) {
        $validator = Validator::make($request->all(), [
                    'categoryId' => 'required',
                    'delivery' => 'required|in:home,office',
                    'latitude' => 'required',
                    'longitude' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->getErrorJsonResponse($validator->errors()->all());
        }

        $user = Auth()->user();
        if ($user->type !== User::$CLIENT_TYPE) {
            return $this->getErrorJsonResponse([], __('api.Must be a client'));
        }

        $category = Category::find($request->categoryId);
        if (!$category || !$category->leave) {
            return $this->getErrorJsonResponse([], __('api.Wrong category id'));
        }

        $cost = intval($category->cost);
        if ($request->delivery == 'home') {
            $fees = Setting::where('setting', 'DELIVER_REQUEST_TO_HOME')->first();
            $cost += $fees ? intval($fees->value) : 0;
        }

        $requestData = $request->all();
        $requestData['cost'] = $cost;
        $requestData['client_id'] = $user->id;
        $requestData['category_id'] = $category->id;
        $requestData['created_at_timestamp'] = time();

        $id = Order::create($requestData)->id;
        $order = Order::find($id);

        $user->totalOrders = $user->totalOrders + 1;
        $user->save();
        
        $orderOperations = new OrderOperations();
        $orderOperations->logOrderProcess($order, OrderLogger::$CREATE_TYPE);
        
        // Send nearby 5K lawyers notification
        $orderOperations->notifyNearbyLawyers($order, [0, 5]);

        return $this->getSuccessJsonResponse($this->prepareOrderDetails($order));
    }

    /**
     * @SWG\Get(
     *     path="/api/auth/orderDetails",
     *     summary="List order details by id",
     *     tags={"Client"},
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          in="header", name="X-Api-Language", description="['ar','en'] default is 'ar'", type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="header", name="Authorization", description="Logged in User access token", required=true, type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="query", name="orderId", description="Client order id", required=true, type="string",
     *      ),
     *     @SWG\Response(response="405",description="Invalid input"),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/OrderResponses")
     *     ),
     *     @SWG\SecurityScheme(
     *         securityDefinition="X-Api-Token",
     *         type="apiKey",
     *         in="header",
     *         name="X-Api-Token"
     *    ),
     * )
     */
    public function orderDetails(Request $request) {
        $validator = Validator::make($request->all(), [
                    'orderId' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->getErrorJsonResponse($validator->errors()->all());
        }

        $order = Order::find($request->orderId);
        if (!$order) {
            return $this->getErrorJsonResponse([], __('api.Wrong order id'));
        }

        return $this->getSuccessJsonResponse($this->prepareOrderDetails($order));
    }

    protected function prepareOrderDetails($order) {
        return [
            'id' => $order->id,
            'status' => $order->status,
            'cost' => $order->cost,
            'delivery' => __('api.'.$order->delivery),
            'clientName' => $order->clientName,
            'representativeName' => $order->representativeName,
            'clientNationalID' => $order->clientNationalID,
            'representativeNationalID' => $order->representativeNationalID,
            'letterNumber' => $order->letterNumber,
            'letterDate' => $order->letterDate,
            'marriageDate' => $order->marriageDate,
            'marriageTime' => $order->marriageTime,
            'clientLat' => $order->latitude,
            'clientLong' => $order->longitude,
            'address' => $order->address,
            'time' => strpos($order->time, 'hour') !== false ? __('api.'.$order->time) : $order->time,
            'distance' => $order->distance,
            'category' => $this->prepareCategoryDetails($order->category),
            'lawyer' => $order->lawyer ? $this->prepareUserDetails($order->lawyer) : null,
            'client' => $order->client ? $this->prepareUserDetails($order->client) : null,
            'clientRate' => $order->clientRate,
            'isInAcceptLawyerPeriod' => $order->lock ? 0 : 1,
            'support' => $order->support,
            'accepted_at' => $order->accepted_at ? strtotime($order->accepted_at) : null,
            'closed_at' => $order->closed_at ? strtotime($order->closed_at) : null,
            'created_at' => $order->created_at_timestamp
        ];
    }

    protected function prepareCategoryDetails($category) {
        if(!$category) {
            $categoryFullName = '';
        }elseif(!$category->parent) {
            $categoryFullName = $category->getNameLocal();
        }else{
            $categoryFullName = $category->parentCategory->getNameLocal().'-'.$category->getNameLocal();
        }

        return [
            'id' => $category ? $category->id : '--',
            'name' => $categoryFullName,
            'discription' => $category ? $category->getDiscriptionLocal() : '--',
            'cost' => $category ? $category->cost : '--'
        ];
    }

    protected function prepareUserDetails($user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
            'image' => 'uploads/'.$user->image,
            'lat' => $user->latitude,
            'long' => $user->longitude
        ];
    }
    
    /**
     * @SWG\Get(
     *     path="/api/auth/order/laywersList",
     *     summary="List laywers related to order request",
     *     tags={"Client"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          in="header", name="X-Api-Language", description="['ar','en'] default is 'ar'", type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="header", name="Authorization", description="Logged in User access token", required=true, type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="query", name="orderId", description="Client order id", required=true, type="string",
     *      ),
     * 	   @SWG\Parameter(
     * 		name="page",
     * 		in="query",
     * 		required=false,
     * 		type="integer",
     * 		description="Optional Page Number",
     * 	   ),
     * 	   @SWG\Parameter(
     * 		name="limit",
     * 		in="query",
     * 		required=false,
     * 		type="integer",
     * 		description="Optional limit of results | Ignored if page is not set",
     * 	   ),
     *     @SWG\Response(response="405",description="Invalid input"),
     *     @SWG\SecurityScheme(
     *         securityDefinition="X-Api-Token",
     *         type="apiKey",
     *         in="header",
     *         name="X-Api-Token"
     *    ),
     * )
     */
    public function listOrderLawyers(Request $request) {
        $validator = Validator::make($request->all(), [
                    'orderId' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->getErrorJsonResponse($validator->errors()->all());
        }

        $order = Order::find($request->orderId);
        if (!$order) {
            return $this->getErrorJsonResponse([], __('api.Wrong order id'));
        }

        $distanceSelect = sprintf(
                "ROUND(( %d * acos( cos( radians(%s) ) " .
                " * cos( radians(`latitude`) ) " .
                " * cos( radians(`longitude`) - radians(%s) ) " .
                " + sin( radians(%s) ) * sin( radians(`latitude`) ) " .
                " ) " .
                "), 2 )" .
                "AS distance", 6371, $order->latitude, $order->longitude, $order->latitude
        );

        $query = \App\Lawyer::select(DB::raw('users.*,' . $distanceSelect))
                ->where('type', User::$LAWYER_TYPE)
                ->where('active', true)
                ->where('isOnline', true)
                ->whereIn('lawyerType', $order->getCategoryType($order->category))
                ->orderBy('distance', 'DESC');   
        
        $limit = $request->get('limit', 10);
        $query->limit($limit);

        $page = $request->get('page', 1);
        $skip = ($page - 1) * $limit;
        $query->offset($skip);
        
        $lawyers = $query->get();
        
        return $this->getSuccessJsonResponse($lawyers);
    }

    protected function calculateOrderDistance($coordA, $coordB) {
        $coordA   = Geotools::coordinate($coordA);
        $coordB   = Geotools::coordinate($coordB);
        $distance = Geotools::distance()->setFrom($coordA)->setTo($coordB);

        // $distance->flat(); // 659166.50038742 (meters)
        return round($distance->in('km')->haversine()); // 659.02190812846
    }

}

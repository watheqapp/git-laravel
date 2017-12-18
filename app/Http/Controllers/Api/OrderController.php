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
            'delivery' => $order->delivery,
            'clientName' => $order->clientName,
            'representativeName' => $order->representativeName,
            'clientNationalID' => $order->clientNationalID,
            'representativeNationalID' => $order->representativeNationalID,
            'clientLat' => $order->latitude,
            'clientLong' => $order->longitude,
            'category' => $this->prepareCategoryDetails($order->category),
            'lawyer' => $order->lawyer ? $this->prepareUserDetails($order->lawyer) : null,
            'client' => $order->client ? $this->prepareUserDetails($order->client) : null,
            'isInAcceptLawyerPeriod' => $order->lock ? 0 : 1,
            'accepted_at' => $order->accepted_at ? strtotime($order->accepted_at) : null,
            'created_at' => time($order->created_at)
        ];
    }

    protected function prepareCategoryDetails($category) {
        return [
            'id' => $category->id,
            'name' => $category->getNameLocal(),
            'discription' => $category->getDiscriptionLocal(),
            'cost' => $category->cost
        ];
    }

    protected function prepareUserDetails($user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
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
        
        $lawyers = \App\Lawyer::where('type', User::$LAWYER_TYPE)
                         ->where('active', true)
                         ->where('lawyerType', $order->getCategoryType($order->category))
                         ->get();
                
        
        return $this->getSuccessJsonResponse($lawyers);
    }

}

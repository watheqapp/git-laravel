<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\OrderController;
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
 * Handle api client orders auth
 * @author Ahmad Gamal <eng.asgamal@gmail.com>
 */
class ClientOrderController extends OrderController {

    /**
     * @SWG\GET(
     *     path="/api/auth/client/order/selectLaywer",
     *     summary="Accept client orders",
     *     tags={"Client"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          in="header", name="X-Api-Language", description="['ar','en'] default is 'ar'", type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="header", name="Authorization", description="Logged in User access token", required=true, type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="query", name="orderId", description="Order id", required=true, type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="query", name="lawyerId", description="Lawyer id", required=true, type="string",
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
    public function selectOrderLawyer(Request $request) {
        $validator = Validator::make($request->all(), [
                    'orderId' => 'required',
                    'lawyerId' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->getErrorJsonResponse($validator->errors()->all());
        }

        $user = Auth()->user();
        if ($user->type !== User::$CLIENT_TYPE) {
            return $this->getErrorJsonResponse([], __('api.Must be a client'));
        }

        $order = Order::whereId($request->orderId)
                ->where('client_id', $user->id)
                ->first();
        
        if (!$order) {
            return $this->getErrorJsonResponse([], __('api.Wrong order id'));
        }

        if ($order->status != Order::$NEW_STATUS) {
            return $this->getErrorJsonResponse([], __('api.Order accepted before'));
        }

        $lawyer = \App\Lawyer::where('id', $request->lawyerId)
                ->where('active', true)
                ->where('type', User::$LAWYER_TYPE)
                ->where('lawyerType', $order->getCategoryType($order->category))
                ->first();

        if (!$lawyer) {
            return $this->getErrorJsonResponse([], __('api.Lawyer not found'));
        }

        $order->lawyer_id = $lawyer->id;
        $order->status = Order::$PENDING_STATUS;
        $order->accepted_at = date('Y-m-d H:i:s');
        $order->save();

        $orderOperations = new OrderOperations();
        $orderOperations->logOrderProcess($order, OrderLogger::$FORCE_SELECT_LAWYER_TYPE);

        $orderOperations->sendLawyerForceAcceptNotification([$lawyer], $order);
//        $orderOperations->sendClientAcceptNotification($order);

        $order = Order::find($order->id);
        return $this->getSuccessJsonResponse($this->prepareOrderDetails($order));
    }
    
    /**
     * @SWG\GET(
     *     path="/api/auth/client/order/listNewOrders",
     *     summary="List client new orders",
     *     tags={"Client"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          in="header", name="X-Api-Language", description="['ar','en'] default is 'ar'", type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="header", name="Authorization", description="Logged in User access token", required=true, type="string",
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
    public function listNewOrders(Request $request) {
        $user = Auth()->user();
        if ($user->type !== User::$CLIENT_TYPE) {
            return $this->getErrorJsonResponse([], __('api.Must be a client'));
        }
        
        $ordersList = $this->listOrderByStatus($request, Order::$NEW_STATUS);
        
        return $this->getSuccessJsonResponse($ordersList);
    }
    
    /**
     * @SWG\GET(
     *     path="/api/auth/client/order/listPendingOrders",
     *     summary="List client pending orders",
     *     tags={"Client"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          in="header", name="X-Api-Language", description="['ar','en'] default is 'ar'", type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="header", name="Authorization", description="Logged in User access token", required=true, type="string",
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
    public function listPendingOrders(Request $request) {
        $user = Auth()->user();
        if ($user->type !== User::$CLIENT_TYPE) {
            return $this->getErrorJsonResponse([], __('api.Must be a client'));
        }
        
        $ordersList = $this->listOrderByStatus($request, Order::$PENDING_STATUS);
        
        return $this->getSuccessJsonResponse($ordersList);
    }
    
    /**
     * @SWG\GET(
     *     path="/api/auth/client/order/listClosedOrders",
     *     summary="List client closed orders",
     *     tags={"Client"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          in="header", name="X-Api-Language", description="['ar','en'] default is 'ar'", type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="header", name="Authorization", description="Logged in User access token", required=true, type="string",
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
    public function listClosedOrders(Request $request) {
        $user = Auth()->user();
        if ($user->type !== User::$CLIENT_TYPE) {
            return $this->getErrorJsonResponse([], __('api.Must be a client'));
        }
        
        $ordersList = $this->listOrderByStatus($request, Order::$CLOSED_STATUS);
        
        return $this->getSuccessJsonResponse($ordersList);
    }
    
    /**
     * @param type $request
     * @param type $status
     * @return type
     */
    private function listOrderByStatus($request, $status) {
        $user = Auth()->user();
        $query = Order::where('client_id', $user->id)
                ->where('status', $status);
        
        $limit = $request->get('limit', 10);
        if ($limit) {
            $query->limit($limit);
        }

        $page = $request->get('page', 1);
        if ($page) {
            $skip = ($page - 1) * $limit;
            $query->offset($skip);
        }
        
        $orders = $query->latest()->get();
        
        $data = [];
        foreach ($orders as $order) {
            $data[] = $this->prepareOrderDetails($order);
        }
        
        return $data;
    }

}

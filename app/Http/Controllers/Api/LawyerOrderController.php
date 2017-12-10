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
 * Handle api lawyers orders auth
 * @author Ahmad Gamal <eng.asgamal@gmail.com>
 */
class LawyerOrderController extends OrderController {

    /**
     * @SWG\Get(
     *     path="/api/auth/lawyer/order/accept",
     *     summary="Accept client orders",
     *     tags={"Lawyer"},
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
    public function acceptOrder(Request $request) {
        $validator = Validator::make($request->all(), [
                    'orderId' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->getErrorJsonResponse($validator->errors()->all());
        }

        $user = Auth()->user();
        if ($user->type !== User::$LAWYER_TYPE) {
            return $this->getErrorJsonResponse([], __('api.Must be a lawyer'));
        }

        $order = Order::find($request->orderId);
        if (!$order) {
            return $this->getErrorJsonResponse([], __('api.Wrong order id'));
        }
        
        if ($order->status != Order::$NEW_STATUS) {
            return $this->getErrorJsonResponse([], __('api.Order accepted by another lawyer'));
        }
        
        if ($order->lock) {
            return $this->getErrorJsonResponse([], __('api.Order available accept period finished'));
        }
        
        $user = Auth()->user();
        $order->lawyer_id = $user->id;
        $order->status = Order::$PENDING_STATUS;
        $order->accepted_at = date('Y-m-d H:i:s');
        $order->save();
                
        $orderOperations = new OrderOperations();
        $orderOperations->logOrderProcess($order, OrderLogger::$ACCEPT_TYPE);
                
        $orderOperations->sendClientAcceptNotification($order);
        
        $order = Order::find($order->id);
        return $this->getSuccessJsonResponse($this->prepareOrderDetails($order));
    }

}

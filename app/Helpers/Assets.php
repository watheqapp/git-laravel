<?php

namespace App\Helpers;

use App\ContactUs;
use App\LogNotification;
use App\LogOrderProcess;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Notification;
use App\User;
use App\Order;
use App\LogOrderProcess as OrderLogger;
use App\Client;
use App\Lawyer;
use App\Category;
use App\Setting;

/**
 * @author Ahmad Gamal <ahmed.gamal@ibtikar.net.sa>
 */
class Assets
{

    public static function newOrderCount()
    {
        return self::countOrdersByStatus(Order::$NEW_STATUS);
    }

    public static function pendingOrderCount()
    {
        return self::countOrdersByStatus(Order::$PENDING_STATUS);
    }

    public static function closedOrderCount()
    {
        return self::countOrdersByStatus(Order::$CLOSED_STATUS);
    }

    public static function removedOrderCount()
    {
        return self::countOrdersByStatus(Order::$REMOVED_STATUS);
    }

    public static function supportOrderCount()
    {
        return Order::where('support', true)->count();
    }

    public static function countOrdersByStatus($status)
    {
        return Order::where('status', $status)->count();
    }

    public static function countTotalOrders()
    {
        return Order::count();
    }

    public static function countTotalClients()
    {
        return User::where('type', User::$CLIENT_TYPE)->count();
    }

    public static function countTotalLawyers()
    {
        return User::where('type', User::$LAWYER_TYPE)->count();
    }

    public static function latestThreeClients()
    {
        return User::where('type', User::$CLIENT_TYPE)->take(3)->latest()->get();
    }

    public static function clientContactCount()
    {
        return ContactUs::where(['user_type' => User::$CLIENT_TYPE])->count();
    }

    public static function lawyerContactCount()
    {
        return ContactUs::where(['user_type' => User::$LAWYER_TYPE])->count();
    }

    public static function countTotalOrdersCost()
    {
        $totalCost = Order::select(DB::raw('SUM(cost) as totalCost'))
            ->first();
        return $totalCost ? $totalCost->totalCost : 0;
    }

    public static function countTotalAuthorizationCost()
    {
        $totalCost = Order::select(DB::raw('SUM(cost) as totalCost'))
            ->whereIn('category_id', Category::$authorizationCategories)
            ->first();
        return $totalCost ? $totalCost->totalCost : 0;
    }

    public static function countTotalContractCost()
    {
        $totalCost = Order::select(DB::raw('SUM(cost) as totalCost'))
            ->whereIn('category_id', Category::$contracts)
            ->first();
        return $totalCost ? $totalCost->totalCost : 0;
    }

    public static function countTotalMarriageContractsCost()
    {
        $totalCost = Order::select(DB::raw('SUM(cost) as totalCost'))
            ->whereIn('category_id', Category::$marriageContracts)
            ->first();
        return $totalCost ? $totalCost->totalCost : 0;
    }


    /**
     * Log order process from create to accept
     * @param type $order
     * @param type $type
     * @param type $lawyers
     * @param type $distance
     */
    public function logOrderProcess($order, $type, $lawyers = false, $distance = null)
    {
        $message = '';
        switch ($type) {
            case OrderLogger::$CREATE_TYPE:
                $message = __('api.order_created_log', [
                    'user' => $order->client->name
                ], 'ar');
                break;

            case OrderLogger::$ACCEPT_TYPE:
                $lawyer = $order->lawyer;
                $message = __('api.order_accepted_log', [
                    'lawyer' => $lawyer ? $lawyer->name : '--',
                    'direction' => $lawyer ? "[" . $lawyer->latitude . ',' . $lawyer->longitude . "]" : '--'
                ], 'ar');
                break;

            case OrderLogger::$CLOSED_TYPE:
                $lawyer = $order->lawyer;
                $message = __('api.order_close_log', [
                    'lawyer' => $lawyer ? $lawyer->name : '--',
                ], 'ar');
                break;

            case OrderLogger::$FORCE_SELECT_LAWYER_TYPE:
                $lawyer = $order->lawyer;
                $message = __('api.force_select_lawyer_log', [
                    'lawyer' => $lawyer ? $lawyer->name : '--',
                ], 'ar');
                break;

            case OrderLogger::$NOTIFY_LAWYER_FORCE_SELECT_TYPE:
                $lawyer = $order->lawyer;
                $message = __('api.notify_lawyer_force_select_log', [
                    'lawyer' => $lawyer ? $order->lawyer->name : '--',
                ], 'ar');
                break;

            case OrderLogger::$NOTIFY_CLIENT_ACCEPT_TYPE:
                $lawyer = $order->lawyer;
                $message = __('api.order_notify_client_accept_log', [
                    'lawyer' => $lawyer ? $order->lawyer->name : '--',
                    'client' => $order->client ? $order->client->name : '--',
                ], 'ar');
                break;

            case OrderLogger::$NOTIFY_CLIENT_CLOSE_TYPE:
                $lawyer = $order->lawyer;
                $message = __('api.order_notify_client_close_log', [
                    'lawyer' => $lawyer ? $order->lawyer->name : '--',
                    'client' => $order->client ? $order->client->name : '--',
                ], 'ar');
                break;

            case OrderLogger::$NOTIFY_CLIENT_NOT_ACCEPT_TYPE:
                $message = __('api.order_notify_client_not_accept_log', [
                    'client' => $order->client ? $order->client->name : '--',
                ], 'ar');
                break;

            case OrderLogger::$NOTIFY_LAWYER_TYPE:
                $lawyerStr = '<ul>';
                foreach ($lawyers as $lawyer) {
                    $lawyerStr .= '<li>';
                    $lawyerStr .= $lawyer->name;
                    $lawyerStr .= ' -';
                    $lawyerStr .= $lawyer->latitude;
                    $lawyerStr .= ',';
                    $lawyerStr .= $lawyer->longitude;
                    $lawyerStr .= '</li>';
                }
                $lawyerStr .= '</ul>';

                $message = __('api.order_notify_lawyer_log', [
                    'lawyers' => $lawyerStr,
                    'lawyersCount' => $lawyers ? count($lawyers) : 0,
                    'distance' => $distance ? implode(',', $distance) : '--'
                ], 'ar');
                break;
        }

        OrderLogger::create([
            'order_id' => $order->id,
            'type' => $type,
            'message' => $message
        ]);
    }

    /*
     *  find the n closest locations
     *  @author https://gist.github.com/fhferreira/9081607
     *  @param Model $query eloquent model
     *  @param float $lat latitude of the point of interest
     *  @param float $lng longitude of the point of interest
     *  @param float $max_distance distance in miles or km
     *  @param string $units miles or kilometers
     *  @param Array $fiels to return
     *  @return array
     */

    public function getNearbyLawyers($order, $distanceBetween)
    {
        $distance_select = sprintf(
            "ROUND(( %d * acos( cos( radians(%s) ) " .
            " * cos( radians(`latitude`) ) " .
            " * cos( radians(`longitude`) - radians(%s) ) " .
            " + sin( radians(%s) ) * sin( radians(`latitude`) ) " .
            " ) " .
            "), 2 )" .
            "AS distance", 6371, $order->latitude, $order->longitude, $order->latitude
        );

        $lawyers = User::select(DB::raw('users.*,' . $distance_select))
            ->having('distance', '>=', $distanceBetween[0])
            ->having('distance', '<', $distanceBetween[1])
            ->where('type', User::$LAWYER_TYPE)
            ->where('active', true)
            ->where('isOnline', false)
            ->whereIn('lawyerType', $order->getCategoryType($order->category))
            ->orderBy('distance', 'ASC')
            ->get();

//        echo '<pre>';
//    	echo $query->toSQL();
//    	echo $distance_select;
//    	echo '</pre>';	
//    	die();	
        //$queries = DB::getQueryLog();
        //$last_query = end($queries);
        //var_dump($last_query);
        //die();
        return $lawyers;
    }

    /**
     * @param type $lawyers
     * @param type $orderId
     * @return boolean
     */
    public function sendLawyerNotification($lawyers, $orderId)
    {
        if (count($lawyers) == 0)
            return false;

        $notificaiton = new Notification();

        $notificationData = [
            'title' => __('api.New order request title'),
            'content' => __('api.New order request content'),
            'type' => 'NewRequest',
            'id' => $orderId,
        ];

        return $notificaiton->sendNotification($lawyers, $notificationData);
    }


    /**
     * @param type $lawyers
     * @param type $orderId
     * @return boolean
     */
    public function sendLawyerForceAcceptNotification($lawyers, $order)
    {
        if (count($lawyers) == 0)
            return false;

        $notificaiton = new Notification();

        $notificationData = [
            'title' => __('api.Assigned order request title'),
            'content' => __('api.Assigned order request content'),
            'type' => 'AssignedRequest',
            'id' => $order->id,
        ];

        $notificaiton->sendNotification($lawyers, $notificationData);
        $this->logOrderProcess($order, OrderLogger::$NOTIFY_LAWYER_FORCE_SELECT_TYPE);
    }

    /**
     * @param object $order
     * @return type
     */
    public function sendClientNotAcceptNotification($order)
    {
        $notificaiton = new Notification();

        $notificationData = [
            'title' => __('api.No Laywer Accept order title'),
            'content' => __('api.No Laywer Accept order content'),
            'type' => 'NotAcceptedRequest',
            'id' => $order->id,
        ];

        $notificaiton->sendNotification([$order->client], $notificationData);
        $this->logOrderProcess($order, OrderLogger::$NOTIFY_CLIENT_NOT_ACCEPT_TYPE);
    }

    /**
     * @param object $order
     * @return type
     */
    public function sendClientAcceptNotification($order)
    {
        $notificaiton = new Notification();

        $notificationData = [
            'title' => __('api.Laywer Accept order title'),
            'content' => __('api.Laywer Accept order content'),
            'type' => 'AcceptedRequest',
            'id' => $order->id,
        ];

        $notificaiton->sendNotification([$order->client], $notificationData);
        $this->logOrderProcess($order, OrderLogger::$NOTIFY_CLIENT_ACCEPT_TYPE);
    }


    /**
     * @param object $order
     * @return type
     */
    public function sendClientCloseNotification($order)
    {
        $notificaiton = new Notification();

        $notificationData = [
            'title' => __('api.Laywer Close order title'),
            'content' => __('api.Laywer Close order content'),
            'type' => 'CloseRequest',
            'id' => $order->id,
        ];

        $notificaiton->sendNotification([$order->client], $notificationData);
        $this->logOrderProcess($order, OrderLogger::$NOTIFY_CLIENT_CLOSE_TYPE);
    }

    /**
     * @param type $order
     * @return boolean
     */
    public function isOrderAccepted($order)
    {
        return Order::where([
                'id' => $order->id,
                'status' => Order::$NEW_STATUS
            ])
                ->count() == 0;
    }


    public static function checkLawyerHasCredit($lawyer)
    {
        $fees = Setting::where('setting', 'ORDER_FEES_RATE')->first()->value;
        $permitTimes = Setting::where('setting', 'ORDER_ALLOWED_TIME')->first()->value;

        return $lawyer->credit > -($fees * $permitTimes);

    }

    public static function orderFeesRate()
    {
        return Setting::where('setting', 'ORDER_FEES_RATE')->first()->value;
    }

    // Backend Notitifications
    public static function latestAdminNotifications()
    {
        Carbon::setLocale('ar');
        return LogOrderProcess::whereIn('type', [
                LogOrderProcess::$CREATE_TYPE,
                LogOrderProcess::$ACCEPT_TYPE,
                LogOrderProcess::$CLOSED_TYPE,
                LogOrderProcess::$REMOVED_TYPE,
            ]
        )->take(10)->latest()->get();
    }

    public static function countNewlAdminNotifications()
    {
        return LogOrderProcess::whereIn('type', [
                LogOrderProcess::$CREATE_TYPE,
                LogOrderProcess::$ACCEPT_TYPE,
                LogOrderProcess::$CLOSED_TYPE,
                LogOrderProcess::$REMOVED_TYPE,
            ])
            ->where('isRead', false)
            ->get()
            ->count();
    }
}

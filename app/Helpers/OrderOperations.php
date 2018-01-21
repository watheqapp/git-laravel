<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Notification;
use App\User;
use App\Order;
use App\LogOrderProcess as OrderLogger;

/**
 * @author Ahmad Gamal <ahmed.gamal@ibtikar.net.sa>
 */
class OrderOperations {

    /**
     * @param object $order
     * @param Array $distanceBetween
     */
    public function notifyNearbyLawyers($order, $distanceBetween) {
        $lawyers = $this->getNearbyLawyers($order, $distanceBetween);
        if (count($lawyers) > 0) {
            $this->sendLawyerNotification($lawyers, $order->id, $order->client_id);
        }
        $this->logOrderProcess($order, OrderLogger::$NOTIFY_LAWYER_TYPE, $lawyers, $distanceBetween);
    }

    /**
     * Log order process from create to accept
     * @param type $order
     * @param type $type
     * @param type $lawyers
     * @param type $distance
     */
    public function logOrderProcess($order, $type, $lawyers = false, $distance = null) {
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

    public function getNearbyLawyers($order, $distanceBetween) {
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
                ->where('lawyerType', $order->getCategoryType($order->category))
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
    public function sendLawyerNotification($lawyers, $orderId, $clientId) {
        if (count($lawyers) == 0)
            return false;

        $notificaiton = new Notification();

        $notificationData = [
            'title' => __('api.New order request title'),
            'content' => __('api.New order request content'),
            'type' => 'NewRequest',
            'orderId' => $orderId,
            'clientId' => $clientId,
        ];
        
        return $notificaiton->sendNotification($lawyers, $notificationData);
    }
    
    
    /**
     * @param type $lawyers
     * @param type $orderId
     * @return boolean
     */
    public function sendLawyerForceAcceptNotification($lawyers, $order) {
        if (count($lawyers) == 0)
            return false;

        $notificaiton = new Notification();

        $notificationData = [
            'title' => __('api.Assigned order request title'),
            'content' => __('api.Assigned order request content'),
            'type' => 'AssignedRequest',
            'orderId' => $order->id,
            'clientId' => $order->client_id,
            ];

        $notificaiton->sendNotification($lawyers, $notificationData);
        $this->logOrderProcess($order, OrderLogger::$NOTIFY_LAWYER_FORCE_SELECT_TYPE);
    }

    /**
     * @param object $order
     * @return type
     */
    public function sendClientNotAcceptNotification($order) {
        $notificaiton = new Notification();

        $notificationData = [
            'title' => __('api.No Laywer Accept order title'),
            'content' => __('api.No Laywer Accept order content'),
            'type' => 'NotAcceptedRequest',
            'orderId' => $order->id,
        ];

        $notificaiton->sendNotification([$order->client], $notificationData);
        $this->logOrderProcess($order, OrderLogger::$NOTIFY_CLIENT_NOT_ACCEPT_TYPE);
    }

    /**
     * @param object $order
     * @return type
     */
    public function sendClientAcceptNotification($order) {
        $notificaiton = new Notification();

        $notificationData = [
            'title' => __('api.Laywer Accept order title'),
            'content' => __('api.Laywer Accept order content'),
            'type' => 'AcceptedRequest',
            'orderId' => $order->id,
            'lawyerId' => $order->lawyer_id,
        ];

        $notificaiton->sendNotification([$order->client], $notificationData);
        $this->logOrderProcess($order, OrderLogger::$NOTIFY_CLIENT_ACCEPT_TYPE);
    }

    
    /**
     * @param object $order
     * @return type
     */
    public function sendClientCloseNotification($order) {
        $notificaiton = new Notification();

        $notificationData = [
            'title' => __('api.Laywer Close order title'),
            'content' => __('api.Laywer Close order content'),
            'type' => 'CloseRequest',
            'orderId' => $order->id,
            'lawyerId' => $order->lawyer_id,
        ];

        $notificaiton->sendNotification([$order->client], $notificationData);
        $this->logOrderProcess($order, OrderLogger::$NOTIFY_CLIENT_CLOSE_TYPE);
    }

    /**
     * @param type $order
     * @return boolean
     */
    public function isOrderAccepted($order) {
        return Order::where([
                            'id' => $order->id,
                            'status' => Order::$NEW_STATUS
                        ])
                        ->count() == 0;
    }

}

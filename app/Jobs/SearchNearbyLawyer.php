<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\User;

class SearchNearbyLawyer implements ShouldQueue {

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    protected $order;
    protected $client;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order, User $client) {
        $this->order = $order;
        $this->client = $client;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $clientLat = $this->order->latitude;
        $clientLong = $this->order->longitude;
        
        $lawyers = $this->getNearbyLawyers($clientLat, $clientLong, [0, 5]);
        $this->sendLawyerNotification($lawyers);
        
        sleep(30);
        exit;
        
        if($this->isOrderAccepted($this->order)) {
            return true;
        }
        
        $lawyers = $this->getNearbyLawyers($clientLat, $clientLong, [5, 10]);
        $this->sendLawyerNotification($lawyers);
        
        sleep(30);
        
        if($this->isOrderAccepted($this->order)) {
            return true;
        }
        
        $lawyers = $this->getNearbyLawyers($clientLat, $clientLong, [10, 20]);
        $this->sendLawyerNotification($lawyers);
        
        sleep(60);
        
        if(!$this->isOrderAccepted($this->order)) {
            return $this->sendClientNotification();
        }
        
        return true;
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

    private static function getNearbyLawyers($clientLat, $clientLong, $distanceBetween) {
        $distance_select = sprintf(
                "ROUND(( %d * acos( cos( radians(%s) ) " .
                " * cos( radians(`latitude`) ) " .
                " * cos( radians(`longitude`) - radians(%s) ) " .
                " + sin( radians(%s) ) * sin( radians(`latitude`) ) " .
                " ) " .
                "), 2 )" .
                "AS distance",
                6371,
                $clientLat,
                $clientLong,
                $clientLat
        );

        $lawyers = User::select(DB::raw('users.*,' . $distance_select))
                ->having('distance', '>=', $distanceBetween[0])
                ->having('distance', '<', $distanceBetween[1])
                ->where('type', User::$LAWYER_TYPE)
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
    
    private function sendLawyerNotification($lawyers) {
        if(count($lawyers) == 0)
            return false;
        
        $notificaiton = new \App\Helpers\Notification();
        
        $notificationData = [
          'title' => __('api.New order request title'),
          'content' => __('api.New order request content'),
          'type' => 'NewRequest',
          'orderId' => $this->order->id,
          'clientId' => $this->order->client_id,
        ];
        
        return $notificaiton->sendNotification($lawyers, $notificationData);
    }
    
    private function sendClientNotification() {
        $notificaiton = new \App\Helpers\Notification();
        
        $notificationData = [
          'title' => __('api.No Laywer Accept order title'),
          'content' => __('api.No Laywer Accept order content'),
          'type' => 'NotAcceptedRequest',
          'orderId' => $this->order->id,
        ];
        
        return $notificaiton->sendNotification([$this->order->client], $notificationData);
    }
    
    private function isOrderAccepted($order) {
        return Order::where([
                'id' => $order->id,
                'status' => Order::$NEW_STATUS
                ])
                ->count() == 0;
    }

}

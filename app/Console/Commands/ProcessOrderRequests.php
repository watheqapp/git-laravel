<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Order;
use App\User;

class ProcessOrderRequests extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'requests:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process client order requests';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        while (true) {
            $this->processClientRequests();
            sleep(1);
        }
    }

    private function processClientRequests() {
        $orderOperations = new \App\Helpers\OrderOperations();

        /**
         * Notify nearby 10K (second step after 30S)
         * Get all request that
         *      - isNotifyNearby10 = false
         *      - Accepted = false
         *      - lock = false
         *      - createdAt > createdAt + 30
         * Result
         *      - Sent notification to nearby 10
         *      - Set IsNotifyNearby10 = true
         */
        $after30SOrders = Order::select('*')
                ->selectRaw('created_at_timestamp + ? AS created_at_plus30', [30])
                ->where([
                    'status' => Order::$NEW_STATUS,
                    'lock' => false,
                    'isNotifyNearby10' => false,
                ])
                ->havingRaw('created_at_plus30 < ?', [time()])
                ->get();

        if (count($after30SOrders) > 0) {
            foreach ($after30SOrders as $after30SOrder) {
                $orderOperations->notifyNearbyLawyers($after30SOrder, [5, 10]);
                $after30SOrder->isNotifyNearby10 = true;
                $after30SOrder->save();
            }
        }


        /*
         * Get all request that
         *      - isNotifyNearby10 = true
         *      - isNotifyNearby20 = false
         *      - Accepted = false
         *      - lock = false
         *      - createdAt > createdAt + 60
         * Result
         *      - Sent notification to nearby 20
         *      - Set IsNotifyNearby20 = true
         */
        $after60SOrders = Order::select('*')
                ->selectRaw('created_at_timestamp + ? AS created_at_plus60', [60])
                ->where([
                    'status' => Order::$NEW_STATUS,
                    'lock' => false,
                    'isNotifyNearby10' => true,
                    'isNotifyNearby20' => false,
                ])
                ->havingRaw('created_at_plus60 < ?', [time()])
                ->get();

        if (count($after60SOrders) > 0) {
            foreach ($after60SOrders as $after60SOrder) {
                $orderOperations->notifyNearbyLawyers($after60SOrder, [10, 20]);
                $after60SOrder->isNotifyNearby20 = true;
                $after60SOrder->save();
            }
        }

        /*
         * Get all request that
         *      - IsNotifyNearby10 = true
         *      - IsNotifyNearby20 = true
         *      - lock = false
         *      - Accepted = false
         *      - createdAt > createdAt + 120
         * Result
         *      - Sent notification to client with notAccepted
         *      - Set lock = true
         */

        $after120SOrders = Order::select('*')
                ->selectRaw('created_at_timestamp + ? AS created_at_plus120', [120])
                ->where([
                    'status' => Order::$NEW_STATUS,
                    'lock' => false,
                    'isNotifyNearby10' => true,
                    'isNotifyNearby20' => true,
                ])
                ->havingRaw('created_at_plus120 < ?', [time()])
                ->get();

        if (count($after120SOrders) > 0) {
            foreach ($after120SOrders as $after120SOrder) {
                $orderOperations->sendClientNotAcceptNotification($after120SOrder);
                $after120SOrder->lock = true;
                $after120SOrder->save();
            }
        }

        return true;
    }

}

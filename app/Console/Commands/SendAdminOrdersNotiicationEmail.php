<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Order;
use App\User;
use Mail;
use App\LogOrderProcess as OrderLogger;

class SendAdminOrdersNotiicationEmail extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order-notification-email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification email to admin after each order status change';

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
        $orderLogs = OrderLogger::whereIn('type', [
            OrderLogger::$CREATE_TYPE,
            OrderLogger::$ACCEPT_TYPE,
            OrderLogger::$CLOSED_TYPE,
            OrderLogger::$REMOVED_TYPE,
            OrderLogger::$FORCE_SELECT_LAWYER_TYPE
        ])
        ->where('isAdminNotified', false)->take(10)->get();

        foreach ($orderLogs as $orderLog) {
            $orderLog->isAdminNotified = true;
            $orderLog->save();
            Mail::send(
                [
                    'html' => 'email.admin-notification'
                ],
                [
                    'username' => 'Watheq Admin',
                    'body' => $orderLog->message,
                    'order' => $orderLog->order,
                ], function ($m) {
                    $m->from(env('MAIL_USERNAME'), env('APP_NAME'));
                    $m->to(env('ADMIN_EMAIL'), 'sir')->subject(__('backend.Change status notification'));
            });
        }
    }
}

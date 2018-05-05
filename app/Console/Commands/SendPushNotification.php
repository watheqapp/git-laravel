<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\LogNotification;
use App\User;
use App\Lawyer;

class SendPushNotification extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push-notification:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send periodic push notifications';

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
    	$pushNotifications = LogNotification::where('type', LogNotification::$NOTIFY_INFO_TYPE)
    								->where('isSend', false)
    								->get();

    	$notificationHelper = new \App\Helpers\Notification();
    	foreach ($pushNotifications as $pushNotification) {
    		$notificationData = [
	            'title' => $pushNotification->title,
	            'content' => $pushNotification->content,
	            'type' => $pushNotification->type,
	            'orderId' => null,
	            'clientId' => null,
	        ];

    		switch ($pushNotification->userType) {
    			case LogNotification::$NOTIFY_INFO_ONE_LAWYER:
    			case LogNotification::$NOTIFY_INFO_ONE_CLERK:
    			case LogNotification::$NOTIFY_INFO_ONE_USER:
    				$notificationHelper->sendDirectNotification([$pushNotification->user], $notificationData);
    				break;

    			case LogNotification::$NOTIFY_INFO_ALL_LAWYERS:
    				$users = User::where('type', User::$LAWYER_TYPE)
                     ->whereIn('lawyerType', [
                     	Lawyer::$LAWYER_AUTHORIZED_SUBTYPE,
                     	Lawyer::$LAWYER_BOTH_SUBTYPE]
                     )->get();
    				$notificationHelper->sendDirectNotification($users, $notificationData);
    				break;

    			case LogNotification::$NOTIFY_INFO_ALL_CLERKS:
    				$users = User::where('type', User::$LAWYER_TYPE)
                     ->whereIn('lawyerType', [
                     	Lawyer::$LAWYER_CLERK_SUBTYPE,
                     	Lawyer::$LAWYER_BOTH_SUBTYPE]
                     )->get();
    				$notificationHelper->sendDirectNotification($users, $notificationData);
    				break;

    			case LogNotification::$NOTIFY_INFO_ALL_USERS:
    				$users = User::where('type', User::$CLIENT_TYPE)->get();
    				$notificationHelper->sendNotification($users, $notificationData);
    				break;
    			
    		}

    		$pushNotification->isSend = true;
	    	$pushNotification->save();
    		
    	}


    }

}

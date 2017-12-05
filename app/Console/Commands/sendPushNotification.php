<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use App\Device;
    

class sendPushNotification extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pushNotification:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send new push notification';

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
        // Get push notifications messages and tokens
        $notifications = Notification::where('status', 'new')->get();
        
        if(count($notifications) == 0) {
            $this->info('No notification messages exists.');
            return true;
        }
        
        foreach ($notifications as $notification) {
            $notification->status = 'inprogress'; 
//            $notification->save();
            $tokens = $this->getNotificationTokens($notification);
            if (empty($tokens)) {
                $notification->status = 'done';
                $notification->save();
                $this->info('Empty tokens for push notification #'.$notification->id);
                continue;
            }
            
            $status = $this->sendNotification($tokens, $notification->message);
            
            $notification->status = 'done'; 
            $notification->save();
            
            $this->info('Push Notification #'.$notification->id.' sent,'.$status);
        }
        
        $this->info('Command run successfuly.');
    }

    private function getNotificationTokens($notification) {
        switch ($notification->type) {
            // all users
            case 0:
                $devices = Device::all();
                break;

            // Favourite Room users
            case 1:
                $users = $notification->room->favouriteUsers;
                $userIds = array();
                foreach ($users as $user) {
                    $userIds[] = $user->id;
                }
                $devices = Device::whereIn('user_id', $userIds)->get();
                break;

            // Following Co wokring users
            case 2:
                $users = $notification->coworking->followUsers;
                $userIds = array();
                foreach ($users as $user) {
                    $userIds[] = $user->id;
                }
                $devices = Device::whereIn('user_id', $userIds)->get();
                break;
            
            // Specific user id
            case 3:
                $user = $notification->user;
                $userIds = array($user->id);
                $devices = Device::whereIn('user_id', $userIds)->get();
                break;
        }
        
        $tokens = array();
        foreach ($devices as $device) {
            $tokens[] = $device->token;
        }
        return $tokens;
    }


    private function sendNotification($tokens, $message){
        $optionBuiler = new OptionsBuilder();
        $optionBuiler->setTimeToLive(60 * 20);
        $option = $optionBuiler->build();

        $notificationBuilder = new PayloadNotificationBuilder('مكانك');
        $notificationBuilder->setBody($message)
                ->setSound('default');
        $notification = $notificationBuilder->build();
        
//        $dataBuilder = new PayloadDataBuilder();
//        $dataBuilder->addData(['a_data' => 'my_data']);
//        $data = $dataBuilder->build();

        // You must change it to get your tokens
        try {
            $downstreamResponse = \LaravelFCM\Facades\FCM::sendTo($tokens, $option, $notification);
        } catch (Exception $ex) {
            return 'something wronge';
        }
        
        $result = 'Count: ';
        //return Array - you must remove all this tokens in your database
        $deleteTokens = $downstreamResponse->tokensToDelete();
        if(!empty($deleteTokens)) {
            Device::whereIn('token', $deleteTokens)->delete();
        }

        //return Array (key : oldToken, value : new token - you must change the token in your database )
        $modifyTokens = $downstreamResponse->tokensToModify();
        if(!empty($modifyTokens)) {
            foreach ($modifyTokens as $key => $modifyToken) {
                Device::where('token', $key)->update('token', $modifyToken);
            }
        }
        
        //return Array - you should try to resend the message to the tokens in the array
        $retryTokens = $downstreamResponse->tokensToRetry();
        if(!empty($retryTokens)) {
            $this->sendNotification($retryTokens, $message);
        }
        // return Array (key:token, value:errror) - in production you should remove from your database the tokens present in this array 
        $errorTokens = $downstreamResponse->tokensWithError();
        if(!empty($errorTokens)) {
            Device::whereIn('token', $errorTokens)->delete();
        }
        
        $result .= $downstreamResponse->numberSuccess() ? $downstreamResponse->numberSuccess().' Success' : ''; 
        $result .= $downstreamResponse->numberFailure() ? $downstreamResponse->numberFailure().' Failure' : ''; 
        $result .= $downstreamResponse->numberModification() ? $downstreamResponse->numberModification().' Modify' : ''; 
        
        return $result;
    }
}  
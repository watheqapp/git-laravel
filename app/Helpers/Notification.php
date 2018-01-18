<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use App\Device;

/**
 * @author Ahmad Gamal <ahmed.gamal@ibtikar.net.sa>
 */
class Notification {
    
    private function getUsersTokens($users) {
        $userIds = [];
        foreach ($users as $user) {
            if($user) {
                $userIds[] = $user->id;
            }
        }
        
        return Device::whereIn('user_id', $userIds)->pluck('firebaseToken')->toArray();
    }

    public function sendNotification($users, $notificationData) {
        $tokens = $this->getUsersTokens($users);
        
        if (empty($tokens)) {
            return 'Count: 0';
        }
        
        $optionBuiler = new OptionsBuilder();
        $optionBuiler->setTimeToLive(60 * 20);
        $option = $optionBuiler->build();

//        $notificationBuilder = new PayloadNotificationBuilder($notificationData['title']);
//        $notificationBuilder->setBody($notificationData['content'])
//                ->setSound('default');
//        $notification = $notificationBuilder->build($notificationData['title']);
        
        $notificationBuilder = new PayloadNotificationBuilder();
        $notification = $notificationBuilder->build();

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($notificationData);
        $data = $dataBuilder->build();

        try {
            $downstreamResponse = \LaravelFCM\Facades\FCM::sendTo($tokens, $option, $notification, $data);
        } catch (Exception $ex) {
            return 'something wronge';
        }

        $result = 'Count: ';
        //return Array - you must remove all this tokens in your database
        $deleteTokens = $downstreamResponse->tokensToDelete();
        if (!empty($deleteTokens)) {
            Device::whereIn('firebaseToken', $deleteTokens)->delete();
        }

        //return Array (key : oldToken, value : new token - you must change the token in your database )
        $modifyTokens = $downstreamResponse->tokensToModify();
        if (!empty($modifyTokens)) {
            foreach ($modifyTokens as $key => $modifyToken) {
                Device::where('firebaseToken', $key)->update('firebaseToken', $modifyToken);
            }
        }

        //return Array - you should try to resend the message to the tokens in the array
        $retryTokens = $downstreamResponse->tokensToRetry();
        if (!empty($retryTokens)) {
            $this->sendNotification($retryTokens, $notificationData);
        }
        // return Array (key:token, value:errror) - in production you should remove from your database the tokens present in this array 
        $errorTokens = $downstreamResponse->tokensWithError();
        if (!empty($errorTokens)) {
            Device::whereIn('firebaseToken', $errorTokens)->delete();
        }

        $result .= $downstreamResponse->numberSuccess() ? $downstreamResponse->numberSuccess() . ' Success' : '';
        $result .= $downstreamResponse->numberFailure() ? $downstreamResponse->numberFailure() . ' Failure' : '';
        $result .= $downstreamResponse->numberModification() ? $downstreamResponse->numberModification() . ' Modify' : '';

        return $result;
    }

}

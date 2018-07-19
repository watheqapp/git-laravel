<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Config;
use Auth;
use JWTAuth;
use App\Device;
use App\ContactUs;
use App\SMSMESSAGE;
use Validator;
use Twilio;

/**
 * @SWG\Swagger(
 *     schemes={"http","https"},
 *     basePath="/",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Watheq API's Docs",
 *         description="",
 *         termsOfService="",
 *         @SWG\Contact(
 *             email="eng.asgamal@gmail.com"
 *         ),
 *         @SWG\License(
 *             name="Private License",
 *             url="URL to the license"
 *         )
 *     ),
 *     @SWG\ExternalDocumentation(
 *         description="",
 *         url=""
 *     )
 * )
 */
class ApiBaseController extends BaseController {
    
    public function getSuccessJsonResponse($data=false) {
        $response = [
            'status' => 'success',
            'code' => 200,
            'message' => __('api.success', [], 'en'),
            'data' => $data ? $data : null
        ];
        return response()->json($response, 200, [], JSON_NUMERIC_CHECK);
    }

    public function getErrorJsonResponse(array $errors = array(), $message = 'error') {
        $response = [
            'status' => 'error',
            'code' => 405,
            'message' => !empty($errors) ? "Invalid input" : $message,
            'errors' => !empty($errors) ? $errors : null
        ];
        return response()->json($response, 200);
    }

    public function trans($str, $params = [], $lang = 'ar') {
        return __('api.' . $str, $params, $lang);
    }

    protected function dateFormater($date) {
        return $date ? $date->format('U') : '';
    }

    /**
     * Regiser device id 
     * @param Array $device
     */
    public function registerDeviceToken($device) {
        $deviceObj = Device::where('firebaseToken', $device['firebaseToken']);
        if ($deviceObj->exists()) {
            $deviceObj->delete();
        }

        Device::create($device);
    }

    function getRandomString($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $string = '';

        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return strtolower($string);
    }
    
    /**
     * @SWG\Post(
     *     path="/api/auth/contactus/create",
     *     summary="Create contact us message",
     *     tags={"General"},
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          in="header", name="X-Api-Language", description="['ar','en'] default is 'ar'", type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="header", name="Authorization", description="Logged in User access token", required=true, type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="body",
     *          name="body",
     *          description="Request body", 
     *          required=true,
     *          @SWG\Schema(ref="#/definitions/ContactUs"),
     *     ),
     *     @SWG\Response(
     *          response="405",
     *          description="Invalid input"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @SWG\SecurityScheme(
     *         securityDefinition="X-Api-Token",
     *         type="apiKey",
     *         in="header",
     *         name="X-Api-Token"
     *     ),
     * )
     */
    public function contactUs(Request $request) {
        $validator = Validator::make($request->all(), [
                    'title' => 'required|min:3|max:200',
                    'content' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->getErrorJsonResponse($validator->errors()->all());
        }

        $requestArr = $request->all();
        $client = Auth()->user();

        $requestArr['user_id'] = $client->id;
        $requestArr['user_type'] = $client->type;

        ContactUs::create($requestArr);

        return $this->getSuccessJsonResponse();
    }
    
    /**
     * @SWG\Get(
     *     path="/api/auth/notification/list",
     *     summary="List client/lawyer notifications",
     *     tags={"General"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          in="header", name="X-Api-Language", description="['ar','en'] default is 'ar'", type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="header", name="Authorization", description="Logged in User access token", required=true, type="string",
     *      ),
     *     @SWG\Response(
     *          response="405",
     *          description="Invalid input"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/ListNotificationResponses")
     *     ),
     *     @SWG\SecurityScheme(
     *         securityDefinition="X-Api-Token",
     *         type="apiKey",
     *         in="header",
     *         name="X-Api-Token"
     *     ),
     * )
     */
    public function listNotifications(Request $request) {
        $user = Auth()->user();
        
        $notifications = \App\LogNotification::where('userId', $user->id)->latest()->get();
        
        $responses = [];
        foreach ($notifications as $notification) {
            $data = new Models\ListNotificationResponses();
            $data->title = $notification->title;
            $data->content  = $notification->content;
            $data->type   = $notification->type;
            $data->orderId   = $notification->orderId;
            $data->created_at  = strtotime($notification->created_at);
            $responses[] = $data;
        }
        
        return $this->getSuccessJsonResponse($responses);
    }
    
    /**
     * @SWG\Get(
     *     path="/api/auth/social/links",
     *     summary="List social links",
     *     tags={"General"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          in="header", name="X-Api-Language", description="['ar','en'] default is 'ar'", type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="header", name="Authorization", description="Logged in User access token", required=true, type="string",
     *      ),
     *     @SWG\Response(
     *          response="405",
     *          description="Invalid input"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/ListSocialResponses")
     *     ),
     *     @SWG\SecurityScheme(
     *         securityDefinition="X-Api-Token",
     *         type="apiKey",
     *         in="header",
     *         name="X-Api-Token"
     *     ),
     * )
     */
    public function socialLinks(Request $request) {
        $responses = new \stdClass();
        
        $socials = \App\Setting::whereIn('setting', [
            'SOCIAL_FACEBOOK',
            'SOCIAL_TWITTER',
            'SOCIAL_GOOGLE'
            ])->get()->pluck('value', 'setting')->toArray();
        
        $responses->facebook = $socials['SOCIAL_FACEBOOK'];
        $responses->twitter  = $socials['SOCIAL_TWITTER'];
        $responses->google   = $socials['SOCIAL_GOOGLE'];
        
        return $this->getSuccessJsonResponse($responses);
    }


    /**
     * @SWG\Post(
     *     path="/api/user/send-login-sms",
     *     summary="Send login sms to verify phone number",
     *     tags={"User"},
     *     consumes={"application/json"},
     *     @SWG\Parameter(
     *          in="body",
     *          name="phone",
     *          description="phone", 
     *          required=true,
     *          @SWG\Schema(ref="#/definitions/SendSMSRequest"),
     *      ),
     *     @SWG\Response(response="405",description="Invalid input"),
     *     @SWG\SecurityScheme(
     *         securityDefinition="X-Api-Token",
     *         type="apiKey",
     *         in="header",
     *         name="X-Api-Token"
     *    ),
     * )
     */
    public function sendLoginSMS(Request $request) {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->getErrorJsonResponse($validator->errors()->all());
        }
        
        $phone = $request->input('phone');

        $smsMsg = SMSMESSAGE::where('phone', $phone)
                            ->where('expired', false)
                            ->where('expiredDate', '>', time())
                            ->first();

        if($smsMsg) {
            return $this->getSuccessJsonResponse(['code' => $smsMsg->code]);
        }


        $code = $this->generateAndSendPhoneCode($phone);
        
        if($code === 'failed') {
            $msg = 'Something wrong with SMS gatway';
            return $this->getErrorJsonResponse([], $msg);
        }
        
        $sms = new SMSMESSAGE();
        $sms->phone = $phone;
        $sms->code = $code;
        $sms->expiredDate = time()+300;

        $sms->save();
        return $this->getSuccessJsonResponse(['code' => $code]);
    }

    /**
     * @param Object $user
     * @return type
     */
    private function generateAndSendPhoneCode($phone) {

        $code = rand(1000, 9999);
        
        $msg = __('api.Welcome to Watheq APP, Your verification code is', ['code' => $code]);

        $result = $this->sendSMS($phone, $msg);
        
        if($result == 'failed') {
            return $result;
        }
        
        return $code;
    }

     /**
     * Send SMS TO mobily.ws
     * @param String $numbers
     * @param String $msg
     * @param Integer $MsgID
     * @param Date|0 $sentDate
     * @return String $result
     */
    function sendSMS($phone, $msg) {


        $ID = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $service = env('TWILIO_SERVICE_ID');
        $from = env('TWILIO_FROM');
        $url = 'https://api.twilio.com/2010-04-01/Accounts/' . $ID . '/Messages.json';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);

        curl_setopt($ch, CURLOPT_HTTPAUTH,CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD,$ID . ':' . $token);

        curl_setopt($ch, CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            'To=' . rawurlencode($phone) .
            // '&MessagingServiceSid=' . $service .
            '&From=' . rawurlencode($from) .
            '&Body=' . rawurlencode($msg));

        $resp = curl_exec($ch);
        curl_close($ch);




                


        // $API_KEY = env('NEXMO_API_KEY');
        // $API_SECRET = env('NEXMO_API_SECRET');
        // $sender = env('NEXMO_API_SECRET_SENDER');

        // $url = 'https://rest.nexmo.com/sms/json?' . http_build_query(
        //     [
        //       'api_key' =>  $API_KEY,
        //       'api_secret' => $API_SECRET,
        //       'to' => $number,
        //       'from' => $sender,
        //       'text' => $msg
        //     ]
        // );


        // $ch = curl_init($url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $response = curl_exec($ch);

        // $response = json_decode($response, true);
        
        
        // if ($response && isset($response['messages']) && $response['messages'][0]['status'] == "0") {
            return 'SMS message sent successfully';
        // }

        // return 'failed';

//        return $this->printStringResult(trim($result));
    }

}

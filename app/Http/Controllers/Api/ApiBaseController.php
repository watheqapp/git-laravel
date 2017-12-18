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
use Validator;

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

}

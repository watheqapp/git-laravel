<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Config;
use Auth;
use JWTAuth;
use App\Device;

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
        return response()->json($response, 200);
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

}

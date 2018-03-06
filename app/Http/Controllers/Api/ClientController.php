<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use JWTAuth;
use \App\Device;
use \App\User;
use \App\Client;

/**
 * Handle api Clients auth
 * @author Ahmad Gamal <eng.asgamal@gmail.com>
 */
class ClientController extends ApiBaseController {

    /**
     * @SWG\Post(
     *     path="/api/client/login",
     *     summary="Check Clients then register or login them",
     *     tags={"Client"},
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          in="header", name="X-Api-Language", description="['ar','en'] default is 'ar'", type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="body",
     *          name="body",
     *          description="Request body", 
     *          required=true,
     *          @SWG\Schema(ref="#/definitions/ClientLoginRequest"),
     *      ),
     *     @SWG\Response(response="405",description="Invalid input"),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/ClientLoginResponses")
     *     ),
     *     @SWG\SecurityScheme(
     *         securityDefinition="X-Api-Token",
     *         type="apiKey",
     *         in="header",
     *         name="X-Api-Token"
     *    ),
     * )
     */
    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
//                    'phone' => 'required|saudi_phone',
                    'phone' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->getErrorJsonResponse($validator->errors()->all());
        }

        $client = Client::firstOrCreate([
                    'phone' => $request->phone,
                    'type' => Client::$CLIENT_TYPE,
                    'lastLoginDate' => date('Y-m-d H:i')
        ]);

        $client = Client::find($client->id);

        return $this->getSuccessJsonResponse($client);
    }

    /**
     * @SWG\Post(
     *     path="/api/auth/client/completeProfile",
     *     summary="Complete client profile",
     *     tags={"Client"},
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
     *          @SWG\Schema(ref="#/definitions/ClientCompleteProfileRequest"),
     *      ),
     *     @SWG\Response(response="405",description="Invalid input"),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/ClientLoginResponses")
     *     ),
     *     @SWG\SecurityScheme(
     *         securityDefinition="X-Api-Token",
     *         type="apiKey",
     *         in="header",
     *         name="X-Api-Token"
     *    ),
     * )
     */
    public function completeProfile(Request $request) {
        $validator = Validator::make($request->all(), [
                    'name' => 'required|min:3|max:100',
                    'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->getErrorJsonResponse($validator->errors()->all());
        }

        $client = $this->updateUserObj($request);

        return $this->getSuccessJsonResponse($client);
    }

    /**
     * @SWG\Post(
     *     path="/api/auth/client/updateProfile",
     *     summary="Update client profile",
     *     tags={"Client"},
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
     *          @SWG\Schema(ref="#/definitions/ClientUpdateProfileRequest"),
     *      ),
     *     @SWG\Response(response="405",description="Invalid input"),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/ClientLoginResponses")
     *     ),
     *     @SWG\SecurityScheme(
     *         securityDefinition="X-Api-Token",
     *         type="apiKey",
     *         in="header",
     *         name="X-Api-Token"
     *    ),
     * )
     */
    public function updateProfile(Request $request) {
        $validator = Validator::make($request->all(), [
                    'name' => 'sometimes|min:3|max:100',
//                    'phone' => 'required|saudi_phone',
                    'phone' => 'required|numeric',
                    'email' => 'sometimes|email',
                    'language' => 'sometimes|in:ar,en',
        ]);

        if ($validator->fails()) {
            return $this->getErrorJsonResponse($validator->errors()->all());
        }

        $client = $this->updateUserObj($request);

        return $this->getSuccessJsonResponse($client);
    }

    /**
     * @param type $request
     */
    private function updateUserObj($request) {
        $client = Auth()->user();
        $client->name = $request->name ? $request->name : $client->name;
        $client->phone = $request->phone ? $request->phone : $client->phone;
        $client->email = $request->email ? $request->email : $client->email;
        $client->language = $request->language ? $request->language : $client->language;

        if ($request->has('image')) {
            $fileNameWithoutExt = 'client-' . rand(1111, 9999) . time();
            $fileName = $this->saveBase64Image($request->image, $fileNameWithoutExt);
            $oldImage = $client->image;
            if ($fileName) {
                $client->image = $fileName;
                if ($oldImage) {
                    @unlink(public_path('uploads/' . $oldImage));
                }
            }
        }

        $client->save();

        return Client::find($client->id);
    }

    private function saveBase64Image($base64Image, $fileNameWithoutExt, $availableExt = ['png', 'jpg', 'jpeg']) {
        try {
            $splited = explode(',', substr($base64Image, 5), 2);
            $mime = $splited[0];
            $data = $splited[1];

            $mime_split_without_base64 = explode(';', $mime, 2);
            $mime_split = explode('/', $mime_split_without_base64[0], 2);
            $imageName = false;
            if (count($mime_split) == 2) {
                $extension = $mime_split[1];
                if (!in_array(strtolower($extension), $availableExt)) {
                    return false;
                }
                $uploadPath = public_path() . '/uploads/';
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath);
                }
                $imageName = $fileNameWithoutExt . '.' . $extension;
                @file_put_contents($uploadPath . $imageName, base64_decode($data));
            }
            return $imageName;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * @SWG\Post(
     *     path="/api/auth/client/registerDeviceToken",
     *     summary="Register Client device token",
     *     tags={"Client"},
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
     *          @SWG\Schema(ref="#/definitions/Device"),
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
    public function registerDevice(Request $request) {
        $validator = Validator::make($request->all(), [
                    'identifier' => 'required',
                    'firebaseToken' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->getErrorJsonResponse($validator->errors()->all());
        }

        $device = $request->all();
        $client = Auth()->user();

        $device['user_id'] = $client->id;
        $device['operator'] = $request->operator;

        $this->registerDeviceToken($device);

        return $this->getSuccessJsonResponse();
    }

    /**
     * @SWG\Post(
     *     path="/api/auth/client/logout",
     *     summary="Logout client and remove device token",
     *     tags={"Client"},
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
     *          @SWG\Schema(ref="#/definitions/RemoveDevice"),
     *     ),
     *     @SWG\Response(
     *         response=405,
     *         description="Invalid input",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *     ),
     *     @SWG\SecurityScheme(
     *         securityDefinition="X-Api-Token",
     *         type="apiKey",
     *         in="header",
     *         name="X-Api-Token"
     *     ),
     * )
     */
    public function Logout(Request $request) {
        $validator = Validator::make($request->all(), [
                    'identifier' => 'required|max:190',
        ]);

        if ($validator->fails()) {
            return $this->getErrorJsonResponse($validator->errors()->all());
        }

        $user = Auth()->user();
        $requestBody = $request->body;

        JWTAuth::invalidate();

        Device::where('identifier', $requestBody['identifier'])
                ->where('user_id', $user->id)
                ->delete();

        return $this->getSuccessJsonResponse();
    }

}

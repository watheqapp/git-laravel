<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use JWTAuth;
use \App\Device;
use \App\User;
use \App\Lawyer;
use Propaganistas\LaravelPhone\PhoneNumber;

/**
 * Handle api Lawyers auth
 * @author Ahmad Gamal <eng.asgamal@gmail.com>
 */
class LawyerController extends ApiBaseController {

    /**
     * @SWG\Post(
     *     path="/api/lawyer/login",
     *     summary="Check Lawyers then register or login them",
     *     tags={"Lawyer"},
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
     *          @SWG\Schema(ref="#/definitions/LawyerLoginRequest"),
     *      ),
     *   @SWG\Response(response="405",description="Invalid input"),
     *      @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/LawyerLoginResponses")
     *     ),
     *     @SWG\SecurityScheme(
     *         securityDefinition="X-Api-Token",
     *         type="apiKey",
     *         in="header",
     *         name="X-Api-Token"
     *    ),
     * )
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
//                    'phone' => 'required|saudi_phone',
            'phone' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->getErrorJsonResponse($validator->errors()->all());
        }

        $phone = str_replace('+', '', (string)PhoneNumber::make('+' . $request->phone));

        $lawyer = Lawyer::where([
                'phone' => $phone,
                'type' => Lawyer::$LAWYER_TYPE,
            ]
        )->first();

        if ($lawyer) {
            if($lawyer->migrated) {
                $lawyer->active = true;
            }
            $lawyer->lastLoginDate = date('Y-m-d H:i');
            $lawyer->save();
        } else {
            $lawyer = Lawyer::Create([
                'phone' => $phone,
                'type' => Lawyer::$LAWYER_TYPE,
                'active' => 0,
                'lastLoginDate' => date('Y-m-d H:i')
            ]);
        }

        $lawyer = Lawyer::find($lawyer->id);
        return $this->getSuccessJsonResponse($lawyer);

    }

    /**
     * @SWG\Post(
     *     path="/api/auth/lawyer/completeProfile",
     *     summary="Complete lawyer profile",
     *     tags={"Lawyer"},
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
     *          @SWG\Schema(ref="#/definitions/LawyerCompleteProfileRequest"),
     *      ),
     *   @SWG\Response(response="405",description="Invalid input"),
     *      @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/LawyerLoginResponses")
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
                    'latitude' => 'required',
                    'longitude' => 'required'
            ]);

        if ($validator->fails()) {
            return $this->getErrorJsonResponse($validator->errors()->all());
        }

        $lawyer = $this->updateUserObj($request);

        return $this->getSuccessJsonResponse($lawyer);
    }
    
    /**
     * @SWG\Post(
     *     path="/api/auth/lawyer/completeFiles",
     *     summary="Complete lawyer files",
     *     tags={"Lawyer"},
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
     *          @SWG\Schema(ref="#/definitions/LawyerCompleteFilesRequest"),
     *      ),
     *   @SWG\Response(response="405",description="Invalid input"),
     *      @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/LawyerLoginResponses")
     *     ),
     *     @SWG\SecurityScheme(
     *         securityDefinition="X-Api-Token",
     *         type="apiKey",
     *         in="header",
     *         name="X-Api-Token"
     *    ),
     * )
     */
    public function completeFiles(Request $request) {
        $validator = Validator::make($request->all(), [
                    'lawyerType' => 'required|in:authorized,clerk',
                    'IDCardFile' => 'required',
                    'licenseFile' => 'required'
            ]);

        if ($validator->fails()) {
            return $this->getErrorJsonResponse($validator->errors()->all());
        }

        $lawyer = $this->updateUserObj($request);

        return $this->getSuccessJsonResponse($lawyer);
    }

    /**
     * @SWG\Post(
     *     path="/api/auth/lawyer/updateVisibility",
     *     summary="Update lawyer visibility 1 fot online or 0 for offline",
     *     tags={"Lawyer"},
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
     *          @SWG\Schema(ref="#/definitions/LawyerUpdateVisibilityRequest"),
     *      ),
     *   @SWG\Response(response="405",description="Invalid input"),
     *      @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/LawyerLoginResponses")
     *     ),
     *     @SWG\SecurityScheme(
     *         securityDefinition="X-Api-Token",
     *         type="apiKey",
     *         in="header",
     *         name="X-Api-Token"
     *    ),
     * )
     */
    public function updateVisibility(Request $request) {
        $validator = Validator::make($request->all(), [
            'isOnline' => 'required|in:1,0'
        ]);

        if ($validator->fails()) {
            return $this->getErrorJsonResponse($validator->errors()->all());
        }

        $lawyer = Auth()->user();

        $lawyer->isOnline = $request->isOnline;
        $lawyer->save();

        $lawyer = Lawyer::find($lawyer->id);

        return $this->getSuccessJsonResponse($lawyer);
    }

    /**
     * @SWG\Post(
     *     path="/api/auth/lawyer/updateProfile",
     *     summary="Update lawyer profile",
     *     tags={"Lawyer"},
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
     *          @SWG\Schema(ref="#/definitions/LawyerUpdateProfileRequest"),
     *      ),
     *   @SWG\Response(response="405",description="Invalid input"),
     *      @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/LawyerLoginResponses")
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
                    'latitude' => 'required',
                    'longitude' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->getErrorJsonResponse($validator->errors()->all());
        }

        $lawyer = $this->updateUserObj($request);

        return $this->getSuccessJsonResponse($lawyer);
    }

    /**
     * @param type $request
     */
    private function updateUserObj($request) {
        $lawyer = Auth()->user();

        if($request->phone) {
            $phone = str_replace('+', '', (string) PhoneNumber::make('+' . $request->phone));
        }

        $lawyer->name = $request->name ? $request->name : $lawyer->name;
        $lawyer->phone = $request->phone ? $phone : $lawyer->phone;
        $lawyer->email = $request->email ? $request->email : $lawyer->email;
        $lawyer->lawyerType = $request->lawyerType ? $request->lawyerType : $lawyer->lawyerType;
        $lawyer->language = $request->language ? $request->language : $lawyer->language;
        $lawyer->latitude = $request->latitude ? $request->latitude : $lawyer->latitude;
        $lawyer->longitude = $request->longitude ? $request->longitude : $lawyer->longitude;
        
        if ($request->has('image')) {
            $fileNameWithoutExt = 'lawyer-' . rand(1111, 9999) . time();
            $fileName = $this->saveBase64Image($request->image, $fileNameWithoutExt);
            $oldFile = $lawyer->image;
            if ($fileName) {
                $lawyer->image = $fileName;
                if ($oldFile) {
                    @unlink(public_path('uploads/' . $oldFile));
                }
            }
        }
        
        if ($request->has('IDCardFile')) {
            $fileNameWithoutExt = 'lawyer-idcard-' . rand(1111, 9999) . time();
            $fileName = $this->saveBase64Image($request->IDCardFile, $fileNameWithoutExt);
            if ($fileName) {
                $lawyer->IDCardFile = $fileName;
            }
        }
        
        if ($request->has('licenseFile')) {
            $fileNameWithoutExt = 'lawyer-license-' . rand(1111, 9999) . time();
            $fileName = $this->saveBase64Image($request->licenseFile, $fileNameWithoutExt);
            if ($fileName) {
                $lawyer->licenseFile = $fileName;
            }
        }
        
//        $lawyer->active = true;
        $lawyer->save();

        return Lawyer::find($lawyer->id);
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
     *     path="/api/auth/lawyer/registerDeviceToken",
     *     summary="Register Lawyer device token",
     *     tags={"Lawyer"},
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
     *      ),
     *      @SWG\Response(
     *          response="405",
     *          description="Invalid input"
     *      ),
     *      @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @SWG\SecurityScheme(
     *         securityDefinition="X-Api-Token",
     *         type="apiKey",
     *         in="header",
     *         name="X-Api-Token"
     *    ),
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
        $lawyer = Auth()->user();

        $device['user_id'] = $lawyer->id;
        $device['operator'] = $request->operator;

        $this->registerDeviceToken($device);

        return $this->getSuccessJsonResponse();
    }

    /**
     * @SWG\Post(
     *     path="/api/auth/lawyer/logout",
     *     summary="Logout lawyer and remove device token",
     *     tags={"Lawyer"},
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
     *      ),
     *      @SWG\Response(
     *         response=405,
     *         description="Invalid input",
     *     ),
     *      @SWG\Response(
     *         response=200,
     *         description="Success",
     *     ),
     *     @SWG\SecurityScheme(
     *         securityDefinition="X-Api-Token",
     *         type="apiKey",
     *         in="header",
     *         name="X-Api-Token"
     *    ),
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

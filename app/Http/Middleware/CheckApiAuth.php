<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use App;

class CheckApiAuth
{
    /**
     * Handle all (non authorize) APIs default tokens 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $keyName = 'X_Api_Key';
        $headers = getallheaders();
        

        $AppsKey = array();
        
        $AppsKey['android'] = env('ANDROID_API_KEY');
        $AppsKey['ios'] = env('IOS_API_KEY');
        
        if(!array_key_exists($keyName, $headers) || !in_array($headers[$keyName], $AppsKey)) {
            return response()->json([
                'code' => 403,
                'status' => 'error',
                'message' => 'Invalid API token',
                'errors' => null
            ], 200);
        }
        
        // CHECK JSON REQUEST BODY
        if($request->path() != 'api/auth/lawyer/completeFiles') {
            if($request->method() == 'POST' && empty($request->json()->all())) {
                return response()->json([
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Invalid json format',
                    'errors' => null
                ], 200);
            }

            if($request->method() == 'POST') {
                $request->request->add(['body' => json_decode($request->getContent(), true)]);
            }
        }
        
        $operatingTypes = array(
            'android' => 1,
            'ios' => 2,
        );
        
        
        // inject language in request
        $request->request->add(['language' => 'ar']);
        if(array_key_exists('X-Api-Language', $headers) && in_array($headers['X-Api-Language'], ['ar', 'en'])) {
            $request->request->add(['language' => $headers['X-Api-Language']]);
        }
        
        $operatingType = array_search($headers[$keyName], $AppsKey);

        $request->request->add(['operator' => $operatingTypes[$operatingType]]);
        
        App::setLocale($request->language);

        return $next($request);
    }
}

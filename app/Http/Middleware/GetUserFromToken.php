<?php

/*
 * This file is part of jwt-auth.
 *
 * (c) Sean Tymon <tymon148@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Middleware;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use App;

class GetUserFromToken extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if (! $token = $this->auth->setRequest($request)->getToken()) {
            return response()->json([
                'code' => 401, 
                'status' => 'error', 
                'message' => 'Invalid credentials',
                'errors' => null
                ], 200);
//            return $this->respond('tymon.jwt.absent', 'token_not_provided', 400);
        }

        try {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
            return response()->json([
                'code' => 401, 
                'status' => 'error', 
                'message' => 'token_expired',
                'errors' => null
                ], 200);
//            return $this->respond('tymon.jwt.expired', 'token_expired', $e->getStatusCode(), [$e]);
        } catch (JWTException $e) {
            return response()->json([
                'code' => 401, 
                'status' => 'error', 
                'message' => 'Invalid credentials',
                'errors' => null
                ], 200);
//            return $this->respond('tymon.jwt.invalid', 'token_invalid', $e->getStatusCode(), [$e]);
        }

        if (! $user) {
            return response()->json([
                'code' => 401, 
                'status' => 'error', 
                'message' => 'user_not_found',
                'errors' => null
                ], 401);
//            return $this->respond('tymon.jwt.user_not_found', 'user_not_found', 404);
        }

        $this->events->fire('tymon.jwt.valid', $user);
        
//        App::setLocale($user->language);

        return $next($request);
    }
}

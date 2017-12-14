<?php

namespace App\Http\Middleware;

use Closure;
use App;
use App\User;
use Illuminate\Support\Facades\Auth;

class BackendUser
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
        $userType = Auth()->user()->type;
        if(!in_array($userType, [User::$BACKEND_TYPE])) {
            return redirect('/');
        }

        return $next($request);
    }
}

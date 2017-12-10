<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use App\LogOrderProcess as OrderLog;

/**
 * Handle forontend home pages
 * @author Ahmad Gamal <eng.asgamal@gmail.com>
 */
class HomeController extends Controller {

    
    public function orderLog(Request $request) {
        $log = false;
        if($request->has('order')) {
            $log = OrderLog::oldest()->whereOrderId($request->order)->get();
        }
        return view('orderLogPage', compact('log'));
    }
}
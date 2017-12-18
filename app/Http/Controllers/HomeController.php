<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LogOrderProcess as OrderLog;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('home');
    }

    public function orderLog(Request $request) {
        $log = false;
        if ($request->has('order')) {
            $log = OrderLog::oldest()->whereOrderId($request->order)->get();
        }
        return view('orderLogPage', compact('log'));
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function terms() {
        $page = \App\StaticPage::where('page', 'terms')->first();
        return view('terms', compact('page'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function help() {
        $page = \App\StaticPage::where('page', 'help')->first();
        return view('help', compact('page'));
    }


}

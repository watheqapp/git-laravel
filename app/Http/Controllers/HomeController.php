<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LogOrderProcess as OrderLog;
use Geotools;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        echo calculateOrderDistance();
        return view('home');
    }

    private function calculateOrderDistance($coordA, $coordB) {
        $coordA   = Geotools::coordinate([48.8234055, 2.3072664]);
        $coordB   = Geotools::coordinate([43.296482, 5.36978]);
        $distance = Geotools::distance()->setFrom($coordA)->setTo($coordB);

        // $distance->flat(); // 659166.50038742 (meters)
        return $distance->in('km')->haversine(); // 659.02190812846
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function questions() {
        $page = \App\StaticPage::where('page', 'questions')->first();
        return view('questions', compact('page'));
    }


}

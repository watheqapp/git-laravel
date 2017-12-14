<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests;
use Illuminate\Http\Request;

/**
 * Handle backend operations
 * @author Ahmad Gamal <eng.asgamal@gmail.com>
 */
class BackendController extends BaseController {

    
    public function index(Request $request) {
        return view('backend.backend', []);
    }
}
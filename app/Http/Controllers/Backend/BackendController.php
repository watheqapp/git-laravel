<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Helpers\Assets;
use App\User;
use DB;
use Firebase;
/**
 * Handle backend operations
 * @author Ahmad Gamal <eng.asgamal@gmail.com>
 */
class BackendController extends BaseController {

    public $className = 'Dashboard';
    public $createTempelate = '';
    public $editTempelate = '';
    public $formAttributes = [];

    public function index(Request $request) {
        $breadcrumb = [
            'pageLable' => $this->className,
            'links' => []
        ];


        $ordersByDays = DB::table('orders')
                          ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as totalOrders'), DB::raw('SUM(cost) as totalCost'))
                          ->groupBy('date')
                          ->take(10)
                          ->latest()
                          ->get()
                          ->toArray();

        $ordersByDaysStatistics = [];
        foreach ($ordersByDays as $day) {
            $ordersByDaysStatistics[] = [date('d-m', strtotime($day->date)), $day->totalOrders];
            $costsByDaysStatistics[] = [date('d-m', strtotime($day->date)), $day->totalCost];
        }

        $ordersByDaysStatistics = json_encode($ordersByDaysStatistics);
        $costsByDaysStatistics = json_encode($costsByDaysStatistics);


        $lawyers = User::where('type', User::$LAWYER_TYPE)
                        ->where('active', false)
                        ->get();

        
        // $chat = false;
        // if($order->status != Order::$NEW_STATUS) {
        //     $chat = Firebase::get('/messages/'.$order->client->id.'/'.$order->client->id.$order->lawyer->id.$order->id,['print' => 'pretty', 'orderBy' => '"$key"', 'limitToLast' => 1]);
        //     $chat = (($chat));
        //     echo "<pre>";
        //     var_dump(($chat));
        //     exit;
        // }

        return view('backend.backend', compact('breadcrumb', 'lawyers', 'ordersByDaysStatistics', 'costsByDaysStatistics'));
    }

    public function jsonErrorResponses($msg = '') {
        return response()->json(['status' => 'error', 'message' => $msg ? __('backend.' . $msg) : __('backend.error occurred')]);
    }

    public function jsonSuccessResponses($msg = '') {
        return response()->json(['status' => 'success', 'message' => $msg ? __('backend.' . $msg) : __('backend.done successfuly')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $breadcrumb = [
            'pageLable' => 'Create '.$this->className,
            'links' => [
                ['name' => 'List '.$this->className, 'route' => route('backend.'.$this->className.'.index')],
                ['name' => 'Create '.$this->className]
            ]
        ];
        return view($this->createTempelate ? $this->createTempelate : 'backend.layouts.form.create',
                        $this->preparedCreateForm())
                        ->with(['className' => $this->className, 'breadcrumb' => $breadcrumb])
                        ->with('formAttributes', $this->formAttributes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $breadcrumb = [
            'pageLable' => 'Edit '.$this->className,
            'links' => [
                ['name' => 'List '.$this->className, 'route' => route('backend.'.$this->className.'.index')],
                ['name' => 'Edit '.$this->className]
            ]
        ];
        return view($this->editTempelate ? $this->editTempelate : 'backend.layouts.form.edit', $this->preparedEditForm($id))
                        ->with(['className' => $this->className, 'breadcrumb' => $breadcrumb])
                        ->with('formAttributes', $this->formAttributes);
    }

    public function preparedCreateForm() {
        
    }

    public function preparedEditForm($id) {
        
    }

}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Datatables;
use Session;
use JsValidator;
use App\User;

/**
 * @author Ahmad Gamal <eng.asgamal@gmail.com>
 */
class PricesController extends BackendController {

    public $listData = [
        'listNameSingle' => 'price',
    ];
    public $createTempelate = '';
    public $editTempelate = '';
    public $className = 'price';
    public $formAttributes = ['files' => false];
    protected $editValidationRules = [
        'priceItem.*' => 'required|numeric',
            'deliveryFees' => 'required|numeric'
    ];

    public function edit($id = false) {
        $breadcrumb = [
            'pageLable' => 'Edit ' . $this->className,
            'links' => [
                ['name' => 'Edit ' . $this->className]
            ]
        ];
        return view('backend.price.form', $this->preparedEditForm())
                        ->with('className', $this->className)
                        ->with('formAttributes', $this->formAttributes)
                        ->with('breadcrumb', $breadcrumb);
    }

    public function preparedEditForm($id = false) {
        $documents = \App\Category::where('leave', true)->get();
        $setting = \App\Setting::where('setting', 'DELIVER_REQUEST_TO_HOME')->first();
        $orderFeesRate = \App\Setting::where('setting', 'ORDER_FEES_RATE')->first();
        $orderAllowedTimes = \App\Setting::where('setting', 'ORDER_ALLOWED_TIME')->first();
        $validator = JsValidator::make($this->editValidationRules, [], [], '.form-horizontal');
        return compact('documents', 'setting', 'orderFeesRate', 'orderAllowedTimes', 'validator');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $this->validate($request, [
            'priceItem.*' => 'required|numeric',
            'deliveryFees' => 'required|numeric',
            'orderFeesRate' => 'required|numeric',
            'orderAllowedTimes' => 'required|numeric'
        ]);
        
        $requestData = $request->get('priceItem');
        
        foreach ($requestData as $id => $cost) {
            \App\Category::where('id', $id)->update(['cost' => $cost]);
        }
        
        \App\Setting::where('setting', 'DELIVER_REQUEST_TO_HOME')->update(['value' => $request->deliveryFees]);
        \App\Setting::where('setting', 'ORDER_FEES_RATE')->update(['value' => $request->orderFeesRate]);
        \App\Setting::where('setting', 'ORDER_ALLOWED_TIME')->update(['value' => $request->orderAllowedTimes]);

        Session::flash('success', 'Updated successfuly');
        return redirect()->route('backend.price.edit');
    }

}

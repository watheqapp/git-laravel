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
        $validator = JsValidator::make($this->editValidationRules, [], [], '.form-horizontal');
        return compact('documents', 'setting', 'validator');
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
            'deliveryFees' => 'required|numeric'
        ]);
        
        $requestData = $request->get('priceItem');
        
        foreach ($requestData as $id => $cost) {
            \App\Category::where('id', $id)->update(['cost' => $cost]);
        }
        
        \App\Setting::where('setting', 'DELIVER_REQUEST_TO_HOME')->update(['value' => $request->deliveryFees]);

        Session::flash('success', 'Updated successfuly');
        return redirect()->route('backend.price.edit');
    }

}

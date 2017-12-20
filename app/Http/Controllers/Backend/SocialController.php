<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Datatables;
use Session;
use JsValidator;
use App\Setting;

/**
 * @author Ahmad Gamal <eng.asgamal@gmail.com>
 */
class SocialController extends BackendController {

    public $listData = [
        'listNameSingle' => 'social',
    ];
    public $createTempelate = '';
    public $editTempelate = '';
    public $className = 'social';
    public $formAttributes = ['files' => false];
    protected $editValidationRules = [
        'socialItem.*' => 'required|url'
    ];

    public function edit($id = false) {
        $breadcrumb = [
            'pageLable' => 'Edit ' . $this->className,
            'links' => [
                ['name' => 'Edit ' . $this->className]
            ]
        ];
        return view('backend.social.form', $this->preparedEditForm())
                        ->with('className', $this->className)
                        ->with('formAttributes', $this->formAttributes)
                        ->with('breadcrumb', $breadcrumb);
    }

    public function preparedEditForm($id = false) {
        $documents = Setting::whereIn('setting', [
            'SOCIAL_FACEBOOK',
            'SOCIAL_TWITTER',
            'SOCIAL_GOOGLE'
        ])->get();
        $validator = JsValidator::make($this->editValidationRules, [], [], '.form-horizontal');
        return compact('documents', 'validator');
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
            'socialItem.*' => 'required|url'
        ]);
        
        $requestData = $request->get('socialItem');
        
        foreach ($requestData as $id => $url) {
            Setting::where('id', $id)->update(['value' => $url]);
        }

        Session::flash('success', 'Updated successfuly');
        return redirect()->route('backend.social.edit');
    }

}

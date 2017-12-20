<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use App\Http\Controllers\Base\BaseController;
use App\StaticPage;
use Illuminate\Http\Request;
use Session;
use JsValidator;

class PagesController extends BaseController {

    public $listData = [
        'listNameSingle' => 'pages',
    ];
    public $createTempelate = '';
    public $editTempelate = '';
    public $className = 'pages';
    public $formAttributes = ['files' => false];
    protected $editValidationRules = [
        'pagesItem.*' => 'required'
    ];

    public function edit($id = false) {
        $breadcrumb = [
            'pageLable' => 'Edit ' . $this->className,
            'links' => [
                ['name' => 'Edit ' . $this->className]
            ]
        ];
        return view('backend.pages.form', $this->preparedEditForm())
                        ->with('className', $this->className)
                        ->with('formAttributes', $this->formAttributes)
                        ->with('breadcrumb', $breadcrumb);
    }

    public function preparedEditForm($id = false) {
        $documents = StaticPage::get();
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
            'pagesItem.*' => 'required'
        ]);

        $requestData = $request->get('pagesItem');
        
        
        foreach ($requestData as $id => $content) {
            StaticPage::where('id', $id)->update(['content' => $content]);
        }

        Session::flash('success', 'Updated successfuly');
        return redirect()->route('backend.pages.edit');
    }

}

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

    public $className = 'Dashboard';
    public $createTempelate = '';
    public $editTempelate = '';
    public $formAttributes = [];

    public function index(Request $request) {
        $breadcrumb = [
            'pageLable' => $this->className,
            'links' => []
        ];
        return view('backend.backend', compact('breadcrumb'));
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

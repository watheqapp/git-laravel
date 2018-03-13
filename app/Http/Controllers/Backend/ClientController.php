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
class ClientController extends BackendController {

    public $listData = [
        'listNameSingle' => 'client',
    ];
    public $createTempelate = '';
    public $editTempelate = '';
    public $className = 'client';
    public $formAttributes = ['files' => true];
    protected $createValidationRules = [
        'name' => 'required|min:3|max:150',
        'email' => 'required|email|unique:users,email,NULL,id,type,2',
        'phone' => 'required|numeric|unique:users,phone,NULL,id,type,2',
        'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:8192',
    ];

    public function index(Request $request) {
        $breadcrumb = [
            'pageLable' => 'List client',
            'links' => [
                ['name' => 'List client']
            ]
        ];
        $this->listData = [
            'listName' => 'client_list',
            'listNameSingle' => 'client',
            'listAjaxRoute' => 'backend.client.listAjax',
        ];
        $this->listData['breadcrumb'] = $breadcrumb;
        $this->listData['columns'] = $this->dataColumns();
        $this->listData['totalCount'] = User::where(['type' => User::$CLIENT_TYPE])->count();

        return view('backend.layouts.list', $this->listData);
    }

    private function dataColumns() {
        return [
            'id',
            'image',
            'name',
            'phone',
            'created_at',
            'active',
        ];
    }

    public function listData(Request $request) {
        $items = User::select($this->dataColumns())
                ->where(['type' => User::$CLIENT_TYPE])
                ->latest();
        return Datatables::of($items)
                        ->addColumn('actions', function ($item) {
                            return '<a class="btn btn-sm green btn-outline" href="' . route('backend.client.edit', ['id' => $item->id]) . '"><i class="fa fa-paste"></i> ' . __('backend.Edit') . '</a> ' .
                                    '<a class="btn btn-sm blue btn-outline page-scroll dev-list-ajax-action" data-popup="tooltip" data-placement="bottom" data-name="(' . $item->name . ')" title="' . __('backend.' . ($item->active ? 'Deactivate' : 'Activate')) . '" href="javascript:void(0)" data-href="' . route('backend.client.toggleActive', ['id' => $item->id, 'active' => $item->active ? 0 : 1]) . '"><i class="fa fa-' . ($item->active ? "times" : "check") . '"></i> ' . __('backend.' . ($item->active ? 'Deactivate' : 'Activate')) . '</a> ' .
                                    '<a class="btn btn-sm red btn-outline dev-list-ajax-action" title="' . __('backend.Delete') . '" data-name="(' . $item->name . ')" href="javascript:void(0)" data-href="' . route('backend.client.delete', ['id' => $item->id]) . '"><i class="fa fa-trash"></i> ' . __('backend.Delete') . '</a>';
                        })
                        ->escapeColumns(['actions'])
                        ->editColumn('active', function ($item) {
                            return $item->getActivateTxt();
                        })
                        ->editColumn('image', function ($item) {
                            return '<img class="img-responsive" src="' . ($item->image ? asset('uploads/' . $item->image) : '/backend-assets/apps/img/profile.jpg') . '" />';
                        })
                        ->removeColumn('id')
                        ->make();
    }

    public function preparedEditForm($id) {
        $document = User::where(['type' => User::$CLIENT_TYPE])->findOrFail($id);
        $this->createValidationRules ['email'] = 'required|email|unique:users,email,'.$document->id.',id,type,2';
        $this->createValidationRules ['phone'] = 'required|numeric|unique:users,phone,'.$document->id.',id,type,2';
        $validator = JsValidator::make($this->createValidationRules, [], [], '.form-horizontal');
        return compact('document', 'validator');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id) {
        $client = User::where(['type' => User::$CLIENT_TYPE])->findOrFail($id);
        
        $this->createValidationRules ['email'] = 'required|email|unique:users,email,'.$client->id.',id,type,2';
        $this->createValidationRules ['phone'] = 'required|numeric|unique:users,phone,'.$client->id.',id,type,2';
       
        
        $this->validate($request, $this->createValidationRules);

        $client->name = $request->name;
        $client->phone = $request->phone;
        $client->email = $request->email;
        
        if ($request->hasFile('image')) {
            $uploadPath = public_path('/uploads/');
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = 'client-' . rand(11111, 99999) . '.' . $extension;
            $request->file('image')->move($uploadPath, $fileName);
            $client->image = $fileName;
        }
        
        $client->save();

        Session::flash('success', 'Updated successfuly');
        return redirect('backend/client/list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        $client = User::where(['type' => User::$CLIENT_TYPE])->find($id);

        if (!$client) {
            return $this->jsonErrorResponses();
        }

        $client->delete();

        return $this->jsonSuccessResponses();
    }

    /**
     * Activate/Deactivate the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function toggleActive($id, $status) {
        $client = User::where(['type' => User::$CLIENT_TYPE])->find($id);

        if (!$client) {
            return $this->jsonErrorResponses();
        }

        $status = $status ? true : false;
        $client->active = $status;
        $client->save();

        return $this->jsonSuccessResponses();
    }

    public function clientsMap(Request $request) {
        $breadcrumb = [
            'pageLable' => 'Client concentration map',
            'links' => [
                ['name' => 'Client concentration map']
            ]
        ];

        $items = User::where('type', User::$CLIENT_TYPE)
                ->where('latitude', '!=', '')
                ->latest()
                ->get();

        // $clients = [];
        // foreach ($items as $client) {
        //     $clients[] = [
        //         $client->latitude,
        //         $client->longitude
        //     ];
        // }

        // echo "<pre>";
        // print_r($clients);
        // exit;

        return view('backend.client.map', compact('items', 'breadcrumb'));
    }
}

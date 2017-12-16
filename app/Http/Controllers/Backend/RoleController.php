<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;
use DB;
use Config;
use Datatables;
use Session;
use Mail;
use JsValidator;

class RoleController extends BackendController {

    public $listData = [];
    //this will used for generating breadcrumb
    public $className = 'role';
    protected $createValidationRules = [
        'name' => 'required|min:3|max:150|unique:roles,name|min:1|max:150',
        'description' => 'required|min:10|max:500',
        'permissions' => 'required',
    ];

    public function __construct() {
        $this->listData = [
            'listName' => 'role_list',
            'listNameSingle' => 'role',
            'listAjaxRoute' => 'backend.role.listAjax',
        ];
    }

    public function index(Request $request) {
        if (Auth()->user()->hasPermission('role-role')) {
            $this->listData['addButtonRoute'] = 'backend.role.create';
        }
        $breadcrumb = [
            'pageLable' => 'List role',
            'links' => [
                ['name' => 'List role']
            ]
        ];
        $this->listData['breadcrumb'] = $breadcrumb;
        $this->listData['columns'] = $this->dataColumns();
        $this->listData['totalCount'] = Role::count();
        
        return view('backend.layouts.list', $this->listData);
    }

    private function dataColumns() {
        return [
            'id',
            'name',
            'description',
            'permissions',
        ];
    }

    public function listData(Request $request) {
        $items = Role::select([
                    'id',
                    'name',
                    'description',
                    'created_at'
                ])->latest();
        return Datatables::of($items)
                        ->addColumn('actions', function ($item) {
                            return '<a class="btn btn-sm blue btn-outline" href="' . route('backend.role.edit', ['id' => $item->id]) . '"><i class="fa fa-paste"></i> ' . __('backend.Edit') . '</a> ' .
                                    '<a class="btn btn-sm red btn-outline dev-list-ajax-action" title="' . __('backend.Delete role') . '" data-name="' . $item->nameAr . '" href="javascript:void(0)" data-href="' . route('backend.role.delete', ['id' => $item->id]) . '"><i class="fa fa-trash"></i> ' . __('backend.Delete') . '</a>';
                        })
                        ->escapeColumns(['actions'])
                        ->editColumn('name', function ($item) {
                            return str_limit($item->name, 20, '...');
                        })
                        ->editColumn('description', function ($item) {
                            return str_limit($item->description, 20, '...');
                        })
                        ->editColumn('created_at', function ($item) {
                            $permissionString = array();
                            foreach ($item->permissionObjs() as $permission) {
                                $permissionString[] = __('backend.' . $permission);
                            }
                            return implode(',', $permissionString);
                        })
                        
                        ->removeColumn('id')
                        ->make();
    }

    public function preparedCreateForm() {
        $permissions = Permission::orderBy('module')->pluck('id', 'name')->toArray();
        $modules = Permission::distinct()->pluck('module');
        $validator = JsValidator::make($this->createValidationRules, [], [], '.form-horizontal');
        return compact('permissions', 'modules', 'validator');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, $this->createValidationRules);
        $role = new Role();
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();

        foreach ($request->permissions as $key => $value) {
            $role->attachPermission($value);
        }
        Session::flash('success', 'Added successfuly');
        return redirect()->route('backend.role.index');
    }

    public function preparedEditForm($id) {
        $document = Role::findOrFail($id);
        $permissions = Permission::orderBy('module')->pluck('id', 'name')->toArray();
        $modules = Permission::distinct()->pluck('module');
        $validator = JsValidator::make([
                    'name' => 'required|min:3|max:150|unique:roles,name,' . $id . ',id',
                    'description' => 'required|min:10|max:500',
                    'permissions' => 'required',
                        ], [], [], '.form-horizontal');
        return compact('document', 'permissions', 'modules', 'validator');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|min:3|max:150|unique:roles,name,' . $id . ',id',
            'description' => 'required|min:10|max:500',
            'permissions' => 'required',
        ]);
        $role = Role::findorfail($id);
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();

        DB::table("permission_role")->where("permission_role.role_id", $id)
                ->delete();
        foreach ($request->permissions as $key => $value) {
            $role->attachPermission($value);
        }

        Session::flash('success', 'Updated successfuly');
        return redirect()->route('backend.role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $role = Role::find($id);

        if (!$role) {
            return $this->jsonErrorResponses();
        }

        // check if users has this role or not
        $usersCount = \App\User::join('role_user', 'users.id', '=', 'role_user.user_id')
                        ->where('role_user.role_id', $id)->count();

        if ($usersCount) {
            return $this->jsonErrorResponses('cant delete this role as it contain user');
        }

        Role::whereId($id)->delete();
        return $this->jsonSuccessResponses();
    }

}

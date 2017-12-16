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
    public $className='role';


    protected $createValidationRules = [
            'nameAr' => 'required|unique:roles,nameAr|min:1|max:150',
            'nameEn' => 'required|unique:roles,nameEn|min:1|max:150',
            'descriptionAr' => 'required|min:10|max:500',
            'descriptionEn' => 'required|min:10|max:500',
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
        if (Auth()->user()->hasPermission('user_create')) {
        $this->listData['addButtonRoute'] = 'backend.role.create';
        }
        $this->listData['columns'] = $this->dataColumns();
        $this->listData['totalCount'] = Role::count();
        return view('backend.list', $this->listData);
    }

    private function dataColumns() {
        return [
            'id',
            'nameAr',
            'nameEn',
            'descriptionAr',
            'descriptionEn',
            'permissions',
        ];
    }

    public function listData(Request $request) {
        $items = Role::select([
            'id',
            'nameAr',
            'nameEn',
            'descriptionAr',
            'descriptionEn',
            'created_at'

        ])->latest();
        return Datatables::of($items)
                        ->addColumn('actions', function ($item) {
                            $actions = "";
                            if (Auth()->user()->hasPermission('role-role-edit') ) {
                            $actions .= '<a class="btn btn-info" href="' . route('backend.role.edit', ['id' => $item->id]) . '"><i class="fa fa-paste"></i> ' . __('backend.Edit') . '</a> ';
                            }
                            if (Auth()->user()->hasPermission('role-role-delete')) {
                            $actions .= '<a class="btn btn-danger dev-list-ajax-action" title="' . __('backend.Delete role') . '" data-name="' . $item->nameAr . '" href="javascript:void(0)" data-href="' . route('backend.role.delete', ['id' => $item->id]) . '"><i class="fa fa-trash"></i> ' . __('backend.Delete') . '</a>';
                            }
                            return $actions;
                        })
                        ->escapeColumns(['actions'])
                        ->editColumn('created_at', function ($item) {
                            $permissionString=array();
                            foreach ($item->permissionObjs() as $permission) {
                                $permissionString[]= __('backend.'.$permission);

                            }
                            return implode(',', $permissionString);
                        })
                        ->removeColumn('id')
                        ->make();
    }


    public function preparedCreateForm() {
        $permissions= Permission::orderBy('module')->pluck('id','name')->toArray();
        $modules= Permission::distinct()->pluck('module');
        $validator = JsValidator::make($this->createValidationRules,[],[],'.form-horizontal');
        return compact('permissions','modules','validator');
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
        $role->nameAr = $request->nameAr;
        $role->descriptionAr = $request->descriptionAr;
        $role->nameEn = $request->nameEn;
        $role->descriptionEn = $request->descriptionEn;
        $role->save();

        foreach ($request->permissions as $key => $value) {
            $role->attachPermission($value);
        }
        Session::flash('success', 'Added successfuly');
        return redirect()->route('backend.role.create');

    }



    public function preparedEditForm($id) {
        $document = Role::findOrFail($id);
        $permissions = Permission::orderBy('module')->pluck('id', 'name')->toArray();
        $modules = Permission::distinct()->pluck('module');
        $validator = JsValidator::make([
                    'nameAr' => 'required|min:1|max:150|unique:roles,nameAr,' . $id . ',id',
                    'nameEn' => 'required|min:1|max:150|unique:roles,nameEn,' . $id . ',id',
                    'descriptionAr' => 'required|min:10|max:500',
                    'descriptionEn' => 'required|min:10|max:500',
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
            'nameAr' => 'required|min:1|max:150|unique:roles,nameAr,' . $id . ',id',
            'nameEn' => 'required|min:1|max:150|unique:roles,nameEn,' . $id . ',id',
            'descriptionAr' => 'required|min:10|max:500',
            'descriptionEn' => 'required|min:10|max:500',
            'permissions' => 'required',
        ]);
        $role = Role::findorfail($id);
        $role->nameAr = $request->nameAr;
        $role->descriptionAr = $request->descriptionAr;
        $role->nameEn = $request->nameEn;
        $role->descriptionEn = $request->descriptionEn;
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
        $role=  Role::find($id);

        if (!$role) {
            return $this->jsonErrorResponses();
        }
// check if users has this role or not
        $usersCount= \App\User::join('role_user', 'users.id', '=', 'role_user.user_id')
        ->where('role_user.role_id',$id)->count();

        if($usersCount){
              return $this->jsonErrorResponses('cant delete this role as it contain user');
        }
        Role::whereId($id)->delete();
        return $this->jsonSuccessResponses();

    }

}

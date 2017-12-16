<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Datatables;
use Session;
use JsValidator;
use App\Role;
use App\User;

/**
 * @author Ahmad Gamal <eng.asgamal@gmail.com>
 */
class EmployeeController extends BackendController {

    public $listData = [
        'listNameSingle' => 'employee',
    ];
    public $createTempelate = '';
    public $editTempelate = '';
    public $className = 'employee';
    public $formAttributes = ['files' => true];
    protected $createValidationRules = [
        'name' => 'required|min:3|max:150',
        'email' => 'required|email|unique:users,email,NULL,id,type,1',
        'password' => 'required|min:8|confirmed|password_validate',
        'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:8192',
    ];

    public function index(Request $request) {
        $breadcrumb = [
            'pageLable' => 'List employee',
            'links' => [
                ['name' => 'List employee']
            ]
        ];
        $this->listData = [
            'listName' => 'employee_list',
            'listNameSingle' => 'employee',
            'listAjaxRoute' => 'backend.employee.listAjax',
        ];
        $this->listData['breadcrumb'] = $breadcrumb;
        if (Auth()->user()->hasPermission('role-employee')) {
            $this->listData['addButtonRoute'] = 'backend.employee.create';
        }
        $this->listData['columns'] = $this->dataColumns();
        $this->listData['totalCount'] = User::where(['type' => User::$BACKEND_TYPE, 'admin' => false])->count();

        return view('backend.layouts.list', $this->listData);
    }

    private function dataColumns() {
        return [
            'id',
            'image',
            'name',
            'created_at',
            'active',
        ];
    }

    public function listData(Request $request) {
        $items = User::select($this->dataColumns())
                ->where(['type' => User::$BACKEND_TYPE, 'admin' => false])
                ->latest();
        return Datatables::of($items)
                        ->addColumn('actions', function ($item) {
                            return '<a class="btn btn-sm green btn-outline" href="' . route('backend.employee.edit', ['id' => $item->id]) . '"><i class="fa fa-paste"></i> ' . __('backend.Edit') . '</a> ' .
                                    '<a class="btn btn-sm blue btn-outline page-scroll dev-list-ajax-action" data-popup="tooltip" data-placement="bottom" data-name="(' . $item->name . ')" title="' . __('backend.' . ($item->active ? 'Deactivate' : 'Activate')) . '" href="javascript:void(0)" data-href="' . route('backend.employee.toggleActive', ['id' => $item->id, 'active' => $item->active ? 0 : 1]) . '"><i class="fa fa-' . ($item->active ? "times" : "check") . '"></i> ' . __('backend.' . ($item->active ? 'Deactivate' : 'Activate')) . '</a> ' .
                                    '<a class="btn btn-sm red btn-outline dev-list-ajax-action" title="' . __('backend.Delete') . '" data-name="(' . $item->name . ')" href="javascript:void(0)" data-href="' . route('backend.employee.delete', ['id' => $item->id]) . '"><i class="fa fa-trash"></i> ' . __('backend.Delete') . '</a>';
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

    public function preparedCreateForm() {
        $roles = Role::get()->pluck('name', 'id')->toArray();
        $validator = JsValidator::make($this->createValidationRules, [], [], '.form-horizontal');
        return compact('roles', 'validator', 'breadcrumb');
    }

    public function preparedEditForm($id) {
        $document = User::where(['type' => User::$BACKEND_TYPE, 'admin' => false])->findOrFail($id);
        $roles = Role::get()->pluck('name', 'id')->toArray();
        $validator = JsValidator::make([
                    'name' => 'required|min:3|max:150',
                    'email' => 'required|email|unique:users,email,NULL,id,type,1',
                    'password' => 'sometimes|min:8|confirmed|password_validate'
                        ], [], [], '.form-horizontal');
        return compact('document', 'validator', 'roles');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
        $this->validate($request, $this->createValidationRules);

        $requestData = $request->all();
        $requestData['password'] = bcrypt($request->password);
        $requestData['type'] = User::$BACKEND_TYPE;

        if ($request->hasFile('image')) {
            $uploadPath = public_path('/uploads/');
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = 'employee-' . rand(11111, 99999) . '.' . $extension;
            $request->file('image')->move($uploadPath, $fileName);
            $requestData['image'] = $fileName;
        }

        $employee = User::create($requestData);

        if (!empty($request->roles)) {
            $employee->roles()->attach($request->roles);
        }

        Session::flash('success', 'Added successfuly');
        return redirect('backend/employee/list');
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
        $employee = User::where(['type' => User::$BACKEND_TYPE, 'admin' => false])->findOrFail($id);

        $this->validate($request, $this->createValidationRules);

        $employee->name = $request->name;
        $employee->email = $request->email;

        if ($request->has('password')) {
            $employee->password = bcrypt($request->password);
        }

        if ($request->hasFile('image')) {
            $uploadPath = public_path('/uploads/');
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = 'employee-' . rand(11111, 99999) . '.' . $extension;
            $request->file('image')->move($uploadPath, $fileName);
            $employee->image = $fileName;
        }

        $employee->roles()->detach();

        if (!empty($request->roles)) {
            $employee->roles()->attach($request->roles);
        }
        
        $employee->save();

        Session::flash('success', 'Updated successfuly');
        return redirect('backend/employee/list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        $employee = User::where(['type' => User::$BACKEND_TYPE, 'admin' => false])->find($id);

        if (!$employee || $employee->admin) {
            return $this->jsonErrorResponses();
        }

        $employee->delete();

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
        $employee = User::where(['type' => User::$BACKEND_TYPE, 'admin' => false])->find($id);

        if (!$employee || $employee->admin) {
            return $this->jsonErrorResponses();
        }

        $status = $status ? true : false;
        $employee->active = $status;
        $employee->save();

        return $this->jsonSuccessResponses();
    }

    public function profile(Request $request) {
        $employee = Auth()->user();
        $validator = JsValidator::make([
                    'name' => 'required|min:3|max:150',
                    'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
                    'old_password' => 'required|old_password:' . $employee->password,
                    'password' => 'sometimes|min:8|confirmed|password_validate',
                    'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:8192',
                        ], [], [], '.form-horizontal');

        return view('backend.form.edit', compact('document', 'validator'))
                        ->with('className', 'profile')
                        ->with('formAttributes', $this->formAttributes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function profileUpdate(Request $request, $id) {
        $employee = User::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|min:3|max:150',
            'email' => 'required|email|unique:users,email,' . $employee->id . ',id,deleted_at,NULL',
            'old_password' => 'required|old_password:' . $employee->password,
            'password' => 'nullable|min:8|confirmed|password_validate',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:8192',
        ]);

        $employee->name = $request->name;
        $employee->email = $request->email;

        if ($request->has('password')) {
            $employee->password = bcrypt($request->password);
        }

        if ($request->hasFile('image')) {
            $uploadPath = public_path('/uploads/');
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = 'employee-' . rand(11111, 99999) . '.' . $extension;
            $request->file('image')->move($uploadPath, $fileName);
            $employee->image = $fileName;
        }

        $employee->save();

        Session::flash('success', 'Updated successfuly');
        return redirect('backend/profile');
    }

}

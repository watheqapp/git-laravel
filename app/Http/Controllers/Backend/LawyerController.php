<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\BackendController;
use App\Http\Requests;
use App\Lawyer;
use Illuminate\Http\Request;
use Datatables;
use Session;
use JsValidator;
use App\User;

/**
 * @author Ahmad Gamal <eng.asgamal@gmail.com>
 */
class LawyerController extends BackendController {

    public $listData = [
        'listNameSingle' => 'lawyer',
    ];
    public $createTempelate = '';
    public $editTempelate = '';
    public $className = 'lawyer';
    public $formAttributes = ['files' => true];
    protected $createValidationRules = [
        'name' => 'required|min:3|max:150',
        'email' => 'required|email|unique:users,email,NULL,id,type,2',
        'phone' => 'required|numeric|unique:users,phone,NULL,id,type,2',
        'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:8192',
    ];

    public function index(Request $request) {
        $breadcrumb = [
            'pageLable' => 'List lawyer',
            'links' => [
                ['name' => 'List lawyer']
            ]
        ];
        $this->listData = [
            'listName' => 'lawyer_list',
            'listNameSingle' => 'lawyer',
            'listAjaxRoute' => 'backend.lawyer.listAjax',
        ];
        $this->listData['breadcrumb'] = $breadcrumb;
        $this->listData['columns'] = $this->dataColumns();
        $this->listData['totalCount'] = User::where(['type' => User::$LAWYER_TYPE])->count();

        return view('backend.lawyer.list', $this->listData);
    }

    private function dataColumns() {
        return [
            'id',
            'image',
            'name',
            'phone',
            'lawyerType',
            'credit',
            'created_at',
            'lastLoginDate',
            'active',
        ];
    }

    public function listData(Request $request) {
        $items = User::select($this->dataColumns())
                ->where(['type' => User::$LAWYER_TYPE])
                ->latest();
        return Datatables::of($items)
                        ->addColumn('actions', function ($item) {
                            return 
                                '<a class="btn btn-sm yellow btn-outline" href="' . route('backend.lawyer.show', ['id' => $item->id]) . '"><i class="fa fa-eye"></i> ' . __('backend.View') . '</a> ' .
                                '<a class="btn btn-sm green btn-outline" href="' . route('backend.lawyer.edit', ['id' => $item->id]) . '"><i class="fa fa-paste"></i> ' . __('backend.Edit') . '</a> ' .
                                '<a class="btn btn-sm blue btn-outline page-scroll dev-list-ajax-action" data-popup="tooltip" data-placement="bottom" data-name="(' . $item->name . ')" title="' . __('backend.' . ($item->active ? 'Deactivate' : 'Activate')) . '" href="javascript:void(0)" data-href="' . route('backend.lawyer.toggleActive', ['id' => $item->id, 'active' => $item->active ? 0 : 1]) . '"><i class="fa fa-' . ($item->active ? "times" : "check") . '"></i> ' . __('backend.' . ($item->active ? 'Deactivate' : 'Activate')) . '</a> ' .
                                '<a class="btn btn-sm red btn-outline dev-list-ajax-action" title="' . __('backend.Delete') . '" data-name="(' . $item->name . ')" href="javascript:void(0)" data-href="' . route('backend.lawyer.delete', ['id' => $item->id]) . '"><i class="fa fa-trash"></i> ' . __('backend.Delete') . '</a>';
                        })
                        ->escapeColumns(['actions'])
                        ->editColumn('name', function ($item) {
                            $color='';
                            if($item->lawyerType == Lawyer::$LAWYER_CLERK_SUBTYPE) {
                                $color = '#F1C40F';
                            } elseif ($item->lawyerType == Lawyer::$LAWYER_AUTHORIZED_SUBTYPE){
                                $color = '#36c6d3';
                            }
                            return '<p class="td-bg" data-color="'.$color.'">'.$item->name.'</p>';
                        })
                        ->editColumn('active', function ($item) {
                            return $item->getActivateTxt();
                        })
                        ->editColumn('lastLoginDate', function ($item) {
                            $date = $item->lastLoginDate ? $item->lastLoginDate : '';
                            $color='';
                            if($item->lastLoginDate) {
                                $date = $item->lastLoginDate;
                                $color = '#ccc';
                            } else {
                                $date = __('backend.Not login yet');
                                $color = 'red';
                            }
                            return '<p class="td-bg" data-color="'.$color.'">'.$date.'</p>';
                        })
                        ->editColumn('lawyerType', function ($item) {
                            return '<span class="label label-sm label-'.($item->lawyerType == "clerk" ? 'warning' : 'success').'">'.$item->getLawyerTypeTxt()."</span>";
                        })
                        ->editColumn('image', function ($item) {
                            return '<img class="img-responsive" src="' . ($item->image ? asset('uploads/' . $item->image) : '/backend-assets/apps/img/profile.jpg') . '" />';
                        })
                        ->removeColumn('id')
//                        ->setRowClass(function ($item) {
//                            return $item->lastLoginDate == '' ? 'lawyer-notlogin' : 'lawyer-login';
//                        })
                        ->make();
    }

    public function preparedEditForm($id) {
        $document = User::where(['type' => User::$LAWYER_TYPE])->findOrFail($id);
        $this->createValidationRules ['email'] = 'required|email|unique:users,email,'.$document->id.',id,type,2';
        $this->createValidationRules ['phone'] = 'required|unique:users,phone,'.$document->id.',id,type,2';
        $this->createValidationRules ['credit'] = 'required|numeric';
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
        $lawyer = User::where(['type' => User::$LAWYER_TYPE])->findOrFail($id);
        
        $this->createValidationRules ['email'] = 'required|email|unique:users,email,'.$lawyer->id.',id,type,2';
        $this->createValidationRules ['phone'] = 'required|unique:users,phone,'.$lawyer->id.',id,type,2';
        $this->createValidationRules ['credit'] = 'required|numeric';
        
        $this->validate($request, $this->createValidationRules);

        $lawyer->name = $request->name;
        $lawyer->phone = $request->phone;
        $lawyer->email = $request->email;
        $lawyer->credit = $request->credit;

        if ($request->hasFile('image')) {
            $uploadPath = public_path('/uploads/');
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = 'lawyer-' . rand(11111, 99999) . '.' . $extension;
            $request->file('image')->move($uploadPath, $fileName);
            $lawyer->image = $fileName;
        }
        
        $lawyer->save();

        Session::flash('success', 'Updated successfuly');
        return redirect('backend/lawyer/list');
    }
    
    public function show($id) {
        $user = User::where('type', User::$LAWYER_TYPE)->findOrFail($id);
        
        $breadcrumb = [
            'pageLable' => 'Show '.$this->className,
            'links' => [
                ['name' => 'List '.$this->className, 'route' => route('backend.'.$this->className.'.index')],
                ['name' => 'Show '.$this->className]
            ]
        ];
        return view('backend.lawyer.show', compact('user', 'breadcrumb'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        $lawyer = User::where(['type' => User::$LAWYER_TYPE])->find($id);

        if (!$lawyer) {
            return $this->jsonErrorResponses();
        }

        $lawyer->delete();

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
        $lawyer = User::where(['type' => User::$LAWYER_TYPE])->find($id);

        if (!$lawyer) {
            return $this->jsonErrorResponses();
        }

        $status = $status ? true : false;
        $lawyer->active = $status;
        $lawyer->save();

        return $this->jsonSuccessResponses();
    }
}

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
        'lawyerType' => 'required',
        'phone' => 'required|numeric|unique:users,phone,NULL,id,type,2',
        'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:8192',
    ];

    public function lawyersList(Request $request) {
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
        $this->listData['totalActiveLawyer'] = User::where('type', User::$LAWYER_TYPE)
            ->where('active', true)
            ->whereIn('lawyerType', [Lawyer::$LAWYER_AUTHORIZED_SUBTYPE, Lawyer::$LAWYER_BOTH_SUBTYPE])
            ->count();
        $this->listData['totalActiveAuthorized'] = User::where('type', User::$LAWYER_TYPE)
            ->where('active', true)
            ->whereIn('lawyerType', [Lawyer::$LAWYER_CLERK_SUBTYPE, Lawyer::$LAWYER_BOTH_SUBTYPE])
            ->count();

        return view('backend.lawyer.list', $this->listData);
    }

    public function authorizedList(Request $request) {
        $breadcrumb = [
            'pageLable' => 'List authorized',
            'links' => [
                ['name' => 'List authorized']
            ]
        ];
        $this->listData = [
            'listName' => 'authorized_list',
            'listNameSingle' => 'authorized',
            'listAjaxRoute' => 'backend.authorized.listAjax',
        ];
        $this->listData['breadcrumb'] = $breadcrumb;
        $this->listData['columns'] = $this->dataColumns();
        $this->listData['totalActiveLawyer'] = User::where('type', User::$LAWYER_TYPE)
            ->where('active', true)
            ->whereIn('lawyerType', [Lawyer::$LAWYER_AUTHORIZED_SUBTYPE, Lawyer::$LAWYER_BOTH_SUBTYPE])
            ->count();
        $this->listData['totalActiveAuthorized'] = User::where('type', User::$LAWYER_TYPE)
            ->where('active', true)
            ->whereIn('lawyerType', [Lawyer::$LAWYER_CLERK_SUBTYPE, Lawyer::$LAWYER_BOTH_SUBTYPE])
            ->count();
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
            // 'created_at',
            'lastLoginDate',
            'isOnline',
            'active',
        ];
    }

    public function listLawyerData(Request $request) {
        $items = User::select($this->dataColumns())
            ->where('type', User::$LAWYER_TYPE)
            ->whereIn('lawyerType', [
                Lawyer::$LAWYER_AUTHORIZED_SUBTYPE,
                Lawyer::$LAWYER_BOTH_SUBTYPE
            ])
            ->orderBy('isOnline', 'DESC')
            ->orderBy('active', 'DESC')
            ->latest();

        return $this->listData($items);
    }

    public function listAuthorizedData(Request $request) {
        $items = User::select($this->dataColumns())
            ->where('type', User::$LAWYER_TYPE)
            ->whereIn('lawyerType', [
                Lawyer::$LAWYER_CLERK_SUBTYPE,
                Lawyer::$LAWYER_BOTH_SUBTYPE
            ])
            ->orderBy('isOnline', 'DESC')
            ->orderBy('active', 'DESC')
            ->latest();

        return $this->listData($items);
    }


    public function listData($items) {
        return Datatables::of($items)
                        ->addColumn('actions', function ($item) {
                            return 
                                '<a class="btn btn-sm yellow btn-outline" href="' . route('backend.lawyer.show', ['id' => $item->id]) . '"><i class="fa fa-eye"></i> ' . __('backend.View') . '</a> ' .
                                '<a class="btn btn-sm green btn-outline" href="' . route('backend.lawyer.edit', ['id' => $item->id]) . '"><i class="fa fa-paste"></i> ' . __('backend.Edit') . '</a> ' .
                                '<a class="btn btn-sm blue btn-outline page-scroll dev-list-ajax-action" data-popup="tooltip" data-placement="bottom" data-name="(' . $item->name . ')" title="' . __('backend.' . ($item->active ? 'Deactivate' : 'Activate')) . '" href="javascript:void(0)" data-href="' . route('backend.lawyer.toggleActive', ['id' => $item->id, 'active' => $item->active ? 0 : 1]) . '"><i class="fa fa-' . ($item->active ? "times" : "check") . '"></i> ' . __('backend.' . ($item->active ? 'Deactivate' : 'Activate')) . '</a> ' .
                                '<a class="btn btn-sm red btn-outline dev-list-ajax-action" title="' . __('backend.Delete') . '" data-name="(' . $item->name . ')" href="javascript:void(0)" data-href="' . route('backend.lawyer.delete', ['id' => $item->id]) . '"><i class="fa fa-trash"></i> ' . __('backend.Delete') . '</a>';
                        })
                        ->escapeColumns(['actions'])
//                        ->editColumn('name', function ($item) {
//                            $color='';
//                            if($item->lawyerType == Lawyer::$LAWYER_CLERK_SUBTYPE) {
//                                $color = '#F1C40F';
//                            } elseif ($item->lawyerType == Lawyer::$LAWYER_AUTHORIZED_SUBTYPE){
//                                $color = '#36c6d3';
//                            }
//                            return '<p class="td-bg" data-color="'.$color.'">'.$item->name.'</p>';
//                        })
                        ->editColumn('active', function ($item) {
                            return $item->getActivateTxt();
                        })
                        ->editColumn('isOnline', function ($item) {
                            return '<span class="label label-sm label-'.($item->isOnline ? 'success' : 'danger').'">'.__($item->isOnline ? 'backend.Available' : 'backend.Not available')."</span>";
                        })
                        ->editColumn('lastLoginDate', function ($item) {
                            return $item->lastLoginDate ? $item->lastLoginDate : '--';
//                            $color='';
//                            if($item->lastLoginDate) {
//                                $date = $item->lastLoginDate;
//                                $color = '#ccc';
//                            } else {
//                                $date = __('backend.Not login yet');
//                                $color = 'red';
//                            }
//                            return '<p class="td-bg" data-color="'.$color.'">'.$date.'</p>';
                        })
                        ->editColumn('lawyerType', function ($item) {
                            return '<span class="label label-sm label-'.($item->lawyerType == "clerk" ? 'info' : ($item->lawyerType == "authorized" ? 'success' : 'danger')).'">'.$item->getLawyerTypeTxt()."</span>";
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
        $this->createValidationRules ['email'] = 'required|email|unique:users,email,'.$document->id.',id,type,2,deleted_at,NULL';
        $this->createValidationRules ['phone'] = 'required|unique:users,phone,'.$document->id.',id,type,2,deleted_at,NULL';
        $this->createValidationRules ['credit'] = 'required|numeric';
        $validator = JsValidator::make($this->createValidationRules, [], [], '.form-horizontal');
        $lawyerTypes = Lawyer::lawyerTypesArr();
        return compact('document', 'validator', 'lawyerTypes');
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
        
        $this->createValidationRules ['email'] = 'required|email|unique:users,email,'.$lawyer->id.',id,type,2,deleted_at,NULL';
        $this->createValidationRules ['phone'] = 'required|unique:users,phone,'.$lawyer->id.',id,type,2,deleted_at,NULL';
        $this->createValidationRules ['credit'] = 'required|numeric';
        
        $this->validate($request, $this->createValidationRules);

        $lawyer->name = $request->name;
        $lawyer->phone = $request->phone;
        $lawyer->email = $request->email;
        $lawyer->credit = $request->credit;
        $lawyer->lawyerType = $request->lawyerType;

        if ($request->hasFile('image')) {
            $uploadPath = public_path('/uploads/');
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = 'lawyer-' . rand(11111, 99999) . '.' . $extension;
            $request->file('image')->move($uploadPath, $fileName);
            $lawyer->image = $fileName;
        }
        
        $lawyer->save();

        Session::flash('success', 'Updated successfuly');
        return redirect('backend/lawyer/laywers-list');
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

    public function clientsMap(Request $request) {
        $breadcrumb = [
            'pageLable' => 'Lawyer concentration map',
            'links' => [
                ['name' => 'Lawyer concentration map']
            ]
        ];

        $items = User::where('type', User::$LAWYER_TYPE)
                ->where('latitude', '!=', '')
                ->latest()
                ->get();

        // $lawyers = [];
        // foreach ($items as $lawyer) {
        //     $lawyers[] = [
        //         'latitude' => $lawyer->latitude,
        //         'longitude' => $lawyer->longitude,

        //     ];
        // }

        // echo "<pre>";
        // print_r($lawyers);
        // exit;

        return view('backend.lawyer.map', compact('items', 'breadcrumb'));
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use JsValidator;
use App\User;
use App\Lawyer;
use App\LogNotification as Notification;

/**
 * @author Ahmad Gamal <eng.asgamal@gmail.com>
 */
class PushNotificationController extends BackendController
{

    public $listData = [
        'listNameSingle' => 'pushnotification',
    ];
    public $editTempelate = '';
    public $className = 'pushnotification';
    public $formAttributes = ['files' => false];
    protected $createValidationRules = [
        'userType' => 'required',
//        'userId' => 'required',
        'title' => 'required|max:100',
        'content' => 'required|max:250',
    ];

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $breadcrumb = [
            'pageLable' => 'Create '.$this->className,
            'links' => [
                ['name' => 'Create '.$this->className]
            ]
        ];
        return view('backend.layouts.form.create',
                        $this->preparedCreateForm())
                        ->with(['className' => $this->className, 'breadcrumb' => $breadcrumb])
                        ->with('formAttributes', $this->formAttributes);
    }

    public function preparedCreateForm()
    {
        $userTypes = Notification::userTypes();

        $validator = JsValidator::make($this->createValidationRules, [], [], '.form-horizontal');
        return compact('userTypes', 'validator', 'breadcrumb');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->createValidationRules);

        $requestData = $request->all();
        $requestData['type'] = Notification::$NOTIFY_INFO_TYPE;
        $notification = Notification::create($requestData);

        Session::flash('success', 'Sent successfuly');
        return redirect('backend/push-notification/create');
    }

    public function searchUsers(Request $request)
    {
        $users = User::take(20);

        switch ($request->get('type')) {
            case 'one-lawyer':
                $users->where('type', User::$LAWYER_TYPE)
                     ->whereIn('lawyerType', [Lawyer::$LAWYER_AUTHORIZED_SUBTYPE, Lawyer::$LAWYER_BOTH_SUBTYPE]);
                break;

            case 'one-clerk':
                $users->where('type', User::$LAWYER_TYPE)
                     ->whereIn('lawyerType', [Lawyer::$LAWYER_CLERK_SUBTYPE, Lawyer::$LAWYER_BOTH_SUBTYPE]);
                break;

            case 'one-user':
                $users->where('type', User::$CLIENT_TYPE);
                break;
        }

        $users = $users->where('name', 'like', $request->get('search').'%')->get();

        $results = [];
        foreach ($users as $user) {
            $results[] = [
                'id' => $user->id,
                'text' => $user->name
            ];
        }

        return json_encode($results);
        
    }

}

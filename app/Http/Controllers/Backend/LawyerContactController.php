<?php

namespace App\Http\Controllers\Backend;

use App\ContactUs;
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
class LawyerContactController extends BackendController
{

    public $listData = [
        'listNameSingle' => 'lawyerContact',
    ];
    public $createTempelate = '';
    public $editTempelate = '';
    public $className = 'lawyerContact';

    public function index(Request $request)
    {
        $breadcrumb = [
            'pageLable' => 'List lawyer contact us messages',
            'links' => [
                ['name' => 'List lawyer contact us messages']
            ]
        ];
        $this->listData = [
            'listName' => 'lawyerContact_list',
            'listNameSingle' => 'lawyerContact',
            'listAjaxRoute' => 'backend.lawyerContact.listAjax',
        ];
        $this->listData['breadcrumb'] = $breadcrumb;
        $this->listData['columns'] = $this->dataColumns();
        $this->listData['totalCount'] = ContactUs::where(['user_type' => User::$LAWYER_TYPE])->count();

        return view('backend.layouts.list', $this->listData);
    }

    private function dataColumns()
    {
        return [
            'id',
            'title',
            'content',
            'user_id',
            'created_at',
        ];
    }

    public function listData(Request $request)
    {
        $items = ContactUs::select($this->dataColumns())
            ->where(['user_type' => User::$LAWYER_TYPE])
            ->latest();

        return Datatables::of($items)
            ->addColumn('actions', function ($item) {
                return '';
            })
            ->escapeColumns(['actions'])
            ->editColumn('user_id', function ($item) {
                return $item->user ? $item->user->name : '---';
            })
            ->removeColumn('id')
            ->make();
    }
}

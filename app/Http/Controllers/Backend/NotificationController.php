<?php

namespace App\Http\Controllers\Backend;

use App\LogOrderProcess;
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
class NotificationController extends BackendController
{

    public $listData = [
        'listNameSingle' => 'notification',
    ];
    public $createTempelate = '';
    public $editTempelate = '';
    public $className = 'notification';

    public function index(Request $request)
    {
        $breadcrumb = [
            'pageLable' => 'List notification messages',
            'links' => [
                ['name' => 'List notification messages']
            ]
        ];
        $this->listData = [
            'listName' => 'notification_list',
            'listNameSingle' => 'notification',
            'listAjaxRoute' => 'backend.notification.listAjax',
        ];
        $this->listData['breadcrumb'] = $breadcrumb;
        $this->listData['columns'] = $this->dataColumns();
        $this->listData['totalCount'] = 0;

        return view('backend.layouts.list', $this->listData);
    }

    private function dataColumns()
    {
        return [
            'message',
            'order_id',
            'created_at',
        ];
    }

    public function listData(Request $request)
    {
        $items = LogOrderProcess::select($this->dataColumns())
            ->whereIn('type', [
                LogOrderProcess::$CREATE_TYPE,
                LogOrderProcess::$ACCEPT_TYPE,
                LogOrderProcess::$CLOSED_TYPE,
                LogOrderProcess::$REMOVED_TYPE,
            ])
            ->latest();

        return Datatables::of($items)
            ->addColumn('actions', function ($item) {
                return '';
            })
            ->escapeColumns(['actions'])
            ->editColumn('order_id', function ($item) {
                return $item->order ? '<a href="'.route('backend.order.show', ['id' =>$item->order->id]).'">'.__('backend.Order number').'#'.$item->order->id.'</a>': '---';
            })
            ->removeColumn('id')
            ->make();
    }

    public function read(Request $request)
    {
        return LogOrderProcess::where('isRead', false)->update(['isRead' => true]);
    }
}

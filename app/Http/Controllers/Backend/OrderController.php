<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Datatables;
use Session;
use JsValidator;
use App\Order;
use Firebase;

/**
 * @author Ahmad Gamal <eng.asgamal@gmail.com>
 */
class OrderController extends BackendController {

    public $listData = [
        'listNameSingle' => 'order',
    ];
    public $className = 'order';

    public function newOrders(Request $request) {
        $breadcrumb = [
            'pageLable' => 'List new order',
            'links' => [
                ['name' => 'List new order']
            ]
        ];
        $this->listData = [
            'listName' => 'order_new_list',
            'listNameSingle' => 'order',
            'listAjaxRoute' => 'backend.order.newAjax',
        ];
        $this->listData['breadcrumb'] = $breadcrumb;
        $this->listData['columns'] = $this->newOrderColumns();
        $this->listData['totalCount'] = Order::where('status', Order::$NEW_STATUS)->count();

        return view('backend.layouts.list', $this->listData);
    }

    public function newOrdersData(Request $request) {
        $items = Order::select($this->newOrderColumns())
                ->where('status', Order::$NEW_STATUS)
                ->latest();
        return Datatables::of($items)
                        ->addColumn('actions', function ($item) {
                            return
                                    '<a class="btn btn-sm yellow btn-outline" href="' . route('backend.order.show', ['id' => $item->id]) . '"><i class="fa fa-eye"></i> ' . __('backend.View') . '</a> ' .
                                    '<a class="btn btn-sm red btn-outline dev-list-ajax-action" title="' . __('backend.Delete') . '" data-name="(' . __('backend.The Order') . ')" href="javascript:void(0)" data-href="' . route('backend.order.delete', ['id' => $item->id]) . '"><i class="fa fa-trash"></i> ' . __('backend.Delete') . '</a>';
                        })
                        ->editColumn('client_id', function ($item) {
                            return $item->client ? $item->client->name : '--';
                        })
                        ->editColumn('category_id', function ($item) {
                            return $item->category ? $item->category->nameAr : '--';
                        })
                        ->editColumn('cost', function ($item) {
                            return $item->cost . ' ' . __('backend.SAR');
                        })
                        ->escapeColumns(['actions'])
                        ->removeColumn('id')
                        ->make();
    }

    private function newOrderColumns() {
        return [
            'id',
            'client_id',
            'category_id',
            'cost',
            'created_at',
        ];
    }

    public function pendingOrders(Request $request) {
        $breadcrumb = [
            'pageLable' => 'List pending order',
            'links' => [
                ['name' => 'List pending order']
            ]
        ];
        $this->listData = [
            'listName' => 'order_pending_list',
            'listNameSingle' => 'order',
            'listAjaxRoute' => 'backend.order.pendingAjax',
        ];
        $this->listData['breadcrumb'] = $breadcrumb;
        $this->listData['columns'] = $this->pendingOrderColumns();
        $this->listData['totalCount'] = Order::where('status', Order::$PENDING_STATUS)->count();

        return view('backend.layouts.list', $this->listData);
    }

    public function PendingOrdersData(Request $request) {
        $items = Order::select($this->pendingOrderColumns())
                ->where('status', Order::$PENDING_STATUS)
                ->latest();
        return Datatables::of($items)
                        ->addColumn('actions', function ($item) {
                            return
                                    '<a class="btn btn-sm yellow btn-outline" href="' . route('backend.order.show', ['id' => $item->id]) . '"><i class="fa fa-eye"></i> ' . __('backend.View') . '</a> ' .
                                    '<a class="btn btn-sm red btn-outline dev-list-ajax-action" title="' . __('backend.Delete') . '" data-name="(' . __('backend.The Order') . ')" href="javascript:void(0)" data-href="' . route('backend.order.delete', ['id' => $item->id]) . '"><i class="fa fa-trash"></i> ' . __('backend.Delete') . '</a>';
                        })
                        ->editColumn('client_id', function ($item) {
                            return $item->client ? $item->client->name : '--';
                        })
                        ->editColumn('lawyer_id', function ($item) {
                            return $item->lawyer ? $item->lawyer->name : '--';
                        })
                        ->editColumn('category_id', function ($item) {
                            return $item->category ? $item->category->nameAr : '--';
                        })
                        ->editColumn('cost', function ($item) {
                            return $item->cost . ' ' . __('backend.SAR');
                        })
                        ->escapeColumns(['actions'])
                        ->removeColumn('id')
                        ->make();
    }

    private function pendingOrderColumns() {
        return [
            'id',
            'client_id',
            'lawyer_id',
            'category_id',
            'cost',
            'accepted_at',
        ];
    }

    public function closedOrders(Request $request) {
        $breadcrumb = [
            'pageLable' => 'List closed order',
            'links' => [
                ['name' => 'List closed order']
            ]
        ];
        $this->listData = [
            'listName' => 'order_closed_list',
            'listNameSingle' => 'order',
            'listAjaxRoute' => 'backend.order.closedAjax',
        ];
        $this->listData['breadcrumb'] = $breadcrumb;
        $this->listData['columns'] = $this->closedOrderColumns();
        $this->listData['totalCount'] = Order::where('status', Order::$CLOSED_STATUS)->count();

        return view('backend.layouts.list', $this->listData);
    }

    public function closedOrdersData(Request $request) {
        $items = Order::select($this->closedOrderColumns())
                ->where('status', Order::$CLOSED_STATUS)
                ->latest();
        return Datatables::of($items)
                        ->addColumn('actions', function ($item) {
                            return
                                    '<a class="btn btn-sm yellow btn-outline" href="' . route('backend.order.show', ['id' => $item->id]) . '"><i class="fa fa-eye"></i> ' . __('backend.View') . '</a> ' .
                                    '<a class="btn btn-sm red btn-outline dev-list-ajax-action" title="' . __('backend.Delete') . '" data-name="(' . __('backend.The Order') . ')" href="javascript:void(0)" data-href="' . route('backend.order.delete', ['id' => $item->id]) . '"><i class="fa fa-trash"></i> ' . __('backend.Delete') . '</a>';
                        })
                        ->editColumn('client_id', function ($item) {
                            return $item->client ? $item->client->name : '--';
                        })
                        ->editColumn('lawyer_id', function ($item) {
                            return $item->lawyer ? $item->lawyer->name : '--';
                        })
                        ->editColumn('category_id', function ($item) {
                            return $item->category ? $item->category->nameAr : '--';
                        })
                        ->editColumn('cost', function ($item) {
                            return $item->cost . ' ' . __('backend.SAR');
                        })
                        ->escapeColumns(['actions'])
                        ->removeColumn('id')
                        ->make();
    }

    private function closedOrderColumns() {
        return [
            'id',
            'client_id',
            'lawyer_id',
            'category_id',
            'cost',
            'accepted_at',
            'closed_at',
        ];
    }



    public function supportOrders(Request $request) {
        $breadcrumb = [
            'pageLable' => 'List support order',
            'links' => [
                ['name' => 'List support order']
            ]
        ];
        $this->listData = [
            'listName' => 'order_support_list',
            'listNameSingle' => 'order',
            'listAjaxRoute' => 'backend.order.supportAjax',
        ];
        $this->listData['breadcrumb'] = $breadcrumb;
        $this->listData['columns'] = $this->supportOrderColumns();
        $this->listData['totalCount'] = Order::where('support', true)->count();

        return view('backend.layouts.list', $this->listData);
    }

    public function supportOrdersData(Request $request) {
        $items = Order::select($this->closedOrderColumns())
                ->where('support', true)
                ->latest();
        return Datatables::of($items)
                        ->addColumn('actions', function ($item) {
                            return
                                    '<a class="btn btn-sm yellow btn-outline" href="' . route('backend.order.show', ['id' => $item->id]) . '"><i class="fa fa-eye"></i> ' . __('backend.View') . '</a> ' .
                                    '<a class="btn btn-sm red btn-outline dev-list-ajax-action" title="' . __('backend.Delete') . '" data-name="(' . __('backend.The Order') . ')" href="javascript:void(0)" data-href="' . route('backend.order.delete', ['id' => $item->id]) . '"><i class="fa fa-trash"></i> ' . __('backend.Delete') . '</a>';
                        })
                        ->editColumn('client_id', function ($item) {
                            return $item->client ? $item->client->name : '--';
                        })
                        ->editColumn('lawyer_id', function ($item) {
                            return $item->lawyer ? $item->lawyer->name : '--';
                        })
                        ->editColumn('category_id', function ($item) {
                            return $item->category ? $item->category->nameAr : '--';
                        })
                        ->editColumn('cost', function ($item) {
                            return $item->cost . ' ' . __('backend.SAR');
                        })
                        ->escapeColumns(['actions'])
                        ->removeColumn('id')
                        ->make();
    }

    private function supportOrderColumns() {
        return [
            'id',
            'client_id',
            'lawyer_id',
            'category_id',
            'cost',
            'accepted_at',
            'closed_at',
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        $order = Order::find($id);

        if (!$order) {
            return $this->jsonErrorResponses();
        }

        $order->delete();

        return $this->jsonSuccessResponses();
    }

    public function show($id) {
        $order = Order::findOrFail($id);

        $breadcrumb = [
            'pageLable' => 'Show ' . $this->className,
            'links' => [
                ['name' => 'List new ' . $this->className, 'route' => route('backend.' . $this->className . '.new')],
                ['name' => 'Show ' . $this->className]
            ]
        ];

        $chat = false;
        if($order->status != Order::$NEW_STATUS && $order->lawyer) {
            $chat = Firebase::get('/messages/'.$order->client->id.'/'.$order->client->id.$order->lawyer->id.$order->id,['print' => 'pretty']);
            $chat = (json_decode($chat));
            // echo "<pre>";
            // var_dump(($chat));
            // exit;
        }
        return view('backend.order.show', compact('order', 'breadcrumb', 'chat'));
    }

    public function ordersMap(Request $request) {
        $breadcrumb = [
            'pageLable' => 'Order concentration map',
            'links' => [
                ['name' => 'Order concentration map']
            ]
        ];

        $items = Order::select('*')
                ->latest()
                ->get();

        $orders = [];
        foreach ($items as $key => $item) {
            $orders[] = [
                $item->latitude,
                $item->longitude
            ];
        }
        return view('backend.order.map', compact('orders', 'breadcrumb'));
    }

}

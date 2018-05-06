<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\OrderOperations;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Requests;
use App\User;
use Illuminate\Http\Request;
use Datatables;
use Session;
use JsValidator;
use App\Order;
use Firebase;
use Geotools;
use DB;
use Validator;
use App\LogOrderProcess as OrderLogger;

/**
 * @author Ahmad Gamal <eng.asgamal@gmail.com>
 */
class OrderController extends BackendController
{

    public $listData = [
        'listNameSingle' => 'order',
    ];
    public $className = 'order';

    public $assignLawyerValidationRules = [
        'orderId' => 'required',
        'lawyerId' => 'required'
    ];

    public $changeStatusValidationRules = [
        'orderId' => 'required',
        'status' => 'required'
    ];

    public function newOrders(Request $request)
    {
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
        $this->listData['availableStatus'] = [];
        return view('backend.order.list', $this->listData);
    }

    public function newOrdersData(Request $request)
    {
        $items = Order::select($this->newOrderColumns())
            ->where('status', Order::$NEW_STATUS)
            ->latest();
        return Datatables::of($items)
            ->addColumn('actions', function ($item) {
                return
                    '<a class="btn btn-sm yellow btn-outline" href="' . route('backend.order.show', ['id' => $item->id]) . '"><i class="fa fa-eye"></i> ' . __('backend.View') . '</a> ' .
                    '<a class="btn btn-sm blue btn-outline dev-assign-lawyer-action" title="' . __('backend.Assign lawyer') . '" href="javascript:void(0)" data-href="' . route('backend.order.assignLawyerModal', ['id' => $item->id]) . '"><i class="fa fa-user"></i> ' . __('backend.Assign lawyer') . '</a>' .
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

    private function newOrderColumns()
    {
        return [
            'id',
            'client_id',
            'category_id',
            'cost',
            'created_at',
        ];
    }

    public function pendingOrders(Request $request)
    {
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

        $this->listData['availableStatus'] = [
            Order::$NEW_STATUS => __('backend.'.Order::$NEW_STATUS ),
            Order::$CLOSED_STATUS => __('backend.'.Order::$CLOSED_STATUS ),
            Order::$REMOVED_STATUS => __('backend.'.Order::$REMOVED_STATUS ),
        ];
        return view('backend.order.list', $this->listData);
    }

    public function PendingOrdersData(Request $request)
    {
        $items = Order::select($this->pendingOrderColumns())
            ->where('status', Order::$PENDING_STATUS)
            ->latest();
        return Datatables::of($items)
            ->addColumn('actions', function ($item) {
                return
                    '<a class="btn btn-sm yellow btn-outline" href="' . route('backend.order.show', ['id' => $item->id]) . '"><i class="fa fa-eye"></i> ' . __('backend.View') . '</a> ' .
                    '<a class="btn btn-sm green btn-outline dev-change-status-action" data-id="' . $item->id . '" title="' . __('backend.Change order status') . '" href="javascript:void(0)"><i class="fa fa-mm"></i> ' . __('backend.Change order status') . '</a>' .
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

    private function pendingOrderColumns()
    {
        return [
            'id',
            'client_id',
            'lawyer_id',
            'category_id',
            'cost',
            'accepted_at',
        ];
    }

    public function closedOrders(Request $request)
    {
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
        $this->listData['availableStatus'] = [
            Order::$NEW_STATUS => __('backend.'.Order::$NEW_STATUS ),
            Order::$PENDING_STATUS => __('backend.'.Order::$PENDING_STATUS ),
            Order::$REMOVED_STATUS => __('backend.'.Order::$REMOVED_STATUS ),
        ];
        return view('backend.order.list', $this->listData);
    }

    public function closedOrdersData(Request $request)
    {
        $items = Order::select($this->closedOrderColumns())
            ->where('status', Order::$CLOSED_STATUS)
            ->latest();
        return Datatables::of($items)
            ->addColumn('actions', function ($item) {
                return
                    '<a class="btn btn-sm yellow btn-outline" href="' . route('backend.order.show', ['id' => $item->id]) . '"><i class="fa fa-eye"></i> ' . __('backend.View') . '</a> ' .
                    '<a class="btn btn-sm green btn-outline dev-change-status-action" data-id="' . $item->id . '" title="' . __('backend.Change order status') . '" href="javascript:void(0)"><i class="fa fa-mm"></i> ' . __('backend.Change order status') . '</a>' .
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

    private function closedOrderColumns()
    {
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


    public function removedOrders(Request $request)
    {
        $breadcrumb = [
            'pageLable' => 'List removed order',
            'links' => [
                ['name' => 'List removed order']
            ]
        ];
        $this->listData = [
            'listName' => 'order_removed_list',
            'listNameSingle' => 'order',
            'listAjaxRoute' => 'backend.order.removedAjax',
        ];
        $this->listData['breadcrumb'] = $breadcrumb;
        $this->listData['columns'] = $this->removedOrderColumns();
        $this->listData['totalCount'] = Order::where('status', Order::$REMOVED_STATUS)->count();
        $this->listData['availableStatus'] = [
            Order::$NEW_STATUS => __('backend.'.Order::$NEW_STATUS ),
            Order::$PENDING_STATUS => __('backend.'.Order::$PENDING_STATUS ),
            Order::$CLOSED_STATUS => __('backend.'.Order::$CLOSED_STATUS ),
        ];
        return view('backend.order.list', $this->listData);
    }

    public function removedOrdersData(Request $request)
    {
        $items = Order::select($this->removedOrderColumns())
            ->where('status', Order::$REMOVED_STATUS)
            ->latest();
        return Datatables::of($items)
            ->addColumn('actions', function ($item) {
                return
                    '<a class="btn btn-sm yellow btn-outline" href="' . route('backend.order.show', ['id' => $item->id]) . '"><i class="fa fa-eye"></i> ' . __('backend.View') . '</a> ' .
                    '<a class="btn btn-sm green btn-outline dev-change-status-action" data-id="' . $item->id . '" title="' . __('backend.Change order status') . '" href="javascript:void(0)"><i class="fa fa-mm"></i> ' . __('backend.Change order status') . '</a>' .
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
            ->editColumn('removed_by', function ($item) {
                return __('api.' . $item->removed_by);
            })
            ->escapeColumns(['actions'])
            ->removeColumn('id')
            ->make();
    }

    private function removedOrderColumns()
    {
        return [
            'id',
            'client_id',
            'lawyer_id',
            'category_id',
            'cost',
            'removed_by',
            'removed_at',
        ];
    }


    public function supportOrders(Request $request)
    {
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

    public function supportOrdersData(Request $request)
    {
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

    private function supportOrderColumns()
    {
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
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return $this->jsonErrorResponses();
        }

        $order->delete();

        return $this->jsonSuccessResponses();
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);

        $breadcrumb = [
            'pageLable' => 'Show ' . $this->className,
            'links' => [
                ['name' => 'List new ' . $this->className, 'route' => route('backend.' . $this->className . '.new')],
                ['name' => 'Show ' . $this->className]
            ]
        ];

        // List lawyers by nearby distance to client lat & lng
        $distanceSelect = sprintf(
            "ROUND(( %d * acos( cos( radians(%s) ) " .
            " * cos( radians(`latitude`) ) " .
            " * cos( radians(`longitude`) - radians(%s) ) " .
            " + sin( radians(%s) ) * sin( radians(`latitude`) ) " .
            " ) " .
            "), 2 )" .
            "AS distance", 6371, $order->latitude, $order->longitude, $order->latitude
        );

        $OutLawyers = \App\Lawyer::select(DB::raw('users.*,' . $distanceSelect))
                        ->where('type', User::$LAWYER_TYPE)
                        ->having('distance', '>', 20)
                        ->having('distance', '<', 50)
                        ->where('active', true)
                        ->where('isOnline', true)
                        ->whereIn('lawyerType', $order->getCategoryType($order->category))
                        ->orderBy('distance', 'DESC')
                        ->get()
                        ->pluck('name', 'id')->toArray();

        $inLawyers = \App\OrderLawyersHistory::where('order_id', $order->id)->get();

        // return view('backend.lawyer.map', compact('items', 'breadcrumb'));

        $chat = false;
        if ($order->status != Order::$NEW_STATUS && $order->lawyer) {
            $chat = Firebase::get('/messages/' . $order->client->id . '/' . $order->client->id . $order->lawyer->id . $order->id, ['print' => 'pretty']);
            $chat = (json_decode($chat));
            // echo "<pre>";
            // var_dump(($chat));
            // exit;
        }
        return view('backend.order.show', compact('order', 'inLawyers', 'OutLawyers', 'breadcrumb', 'chat'));
    }

    public function ordersMap(Request $request)
    {
        $breadcrumb = [
            'pageLable' => 'Order concentration map',
            'links' => [
                ['name' => 'Order concentration map']
            ]
        ];

        $items = Order::select('*')
            ->latest()
            ->get();

        // $orders = [];
        // foreach ($items as $key => $item) {
        //     $orders[] = [
        //         $item->latitude,
        //         $item->longitude
        //     ];
        // }
        return view('backend.order.map', compact('items', 'breadcrumb'));
    }

    public function assignLawyerModel(Request $request, $id)
    {
        $order = Order::where('status', Order::$NEW_STATUS)
            ->where('id', $id)
            ->first();

        if (!$order) {
            return $this->jsonErrorResponses(__('Wrong order id'), 'api');
        }

        // List lawyers by nearby distance to client lat & lng
        $distanceSelect = sprintf(
            "ROUND(( %d * acos( cos( radians(%s) ) " .
            " * cos( radians(`latitude`) ) " .
            " * cos( radians(`longitude`) - radians(%s) ) " .
            " + sin( radians(%s) ) * sin( radians(`latitude`) ) " .
            " ) " .
            "), 2 )" .
            "AS distance", 6371, $order->latitude, $order->longitude, $order->latitude
        );

        $lawyers = \App\Lawyer::select(DB::raw('users.*,' . $distanceSelect))
            ->where('type', User::$LAWYER_TYPE)
            ->where('active', true)
            ->where('isOnline', true)
            ->whereIn('lawyerType', $order->getCategoryType($order->category))
            ->orderBy('distance', 'DESC')
            ->get()
            ->pluck('name', 'id')->toArray();

        $validator = JsValidator::make($this->assignLawyerValidationRules, [], [], '.form-horizontal');

        $view = view('backend.order.assignLawyerModal', compact('order', 'lawyers', 'validator'))->render();
        return $this->jsonViewResponses($view);
    }

    public function assignLawyer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            $this->assignLawyerValidationRules
        ]);

//        if ($validator->fails()) {
//            return $this->jsonErrorResponses($validator->errors()->all());
//        }

        $order = Order::whereId($request->orderId)->first();

        if (!$order) {
            return $this->jsonErrorResponses(__('Wrong order id'), 'api');
        }

        if ($order->status != Order::$NEW_STATUS) {
            return $this->jsonErrorResponses(__('Order accepted before'), 'api');
        }

        if (!$order->lock) {
            return $this->jsonErrorResponses(__('Order still in lawyer accept period'), 'api');
        }

        $lawyer = \App\Lawyer::where('id', $request->lawyerId)
            ->where('active', true)
            ->where('isOnline', true)
            ->where('type', User::$LAWYER_TYPE)
            ->whereIn('lawyerType', $order->getCategoryType($order->category))
            ->first();

        if (!$lawyer) {
            return $this->jsonErrorResponses(__('Lawyer not found'), api);
        }

        $order->lawyer_id = $lawyer->id;
        $order->status = Order::$PENDING_STATUS;
        $order->accepted_at = date('Y-m-d H:i:s');
        $order->distance = $this->calculateOrderDistance([$order->latitude, $order->longitude], [$lawyer->latitude, $lawyer->longitude]);

        $order->save();

        $lawyer->totalOrders = $lawyer->totalOrders + 1;
        $lawyer->save();

        $orderOperations = new OrderOperations();
        $orderOperations->logOrderProcess($order, OrderLogger::$FORCE_SELECT_LAWYER_TYPE);

        $orderOperations->sendLawyerForceAcceptNotification([$lawyer], $order);

        return $this->jsonSuccessResponses();
    }


    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            $this->changeStatusValidationRules
        ]);

//        if ($validator->fails()) {
//            return $this->jsonErrorResponses($validator->errors()->all());
//        }

        $order = Order::whereId($request->orderId)->first();

        if (!$order) {
            return $this->jsonErrorResponses(__('Wrong order id'), 'api');
        }

        if ($order->status == Order::$NEW_STATUS) {
            return $this->jsonErrorResponses(__('Order should not be new to change it\'s status'), 'api');
        }

        if ($order->status == Order::$NEW_STATUS) {
            return $this->jsonErrorResponses(__('Order should not be new to change it\'s status'), 'api');
        }

        $order->status = $request->status;
        if($request->status == Order::$NEW_STATUS) {
            $order->lawyer_id = null;
        }

        $order->save();

//        $orderOperations = new OrderOperations();
//        $orderOperations->logOrderProcess($order, OrderLogger::$FORCE_SELECT_LAWYER_TYPE);
//        $orderOperations->sendLawyerForceAcceptNotification([$lawyer], $order);

        return $this->jsonSuccessResponses();
    }

    protected function calculateOrderDistance($coordA, $coordB) {
        $coordA   = Geotools::coordinate($coordA);
        $coordB   = Geotools::coordinate($coordB);
        $distance = Geotools::distance()->setFrom($coordA)->setTo($coordB);

        // $distance->flat(); // 659166.50038742 (meters)
        return round($distance->in('km')->haversine()); // 659.02190812846
    }
}

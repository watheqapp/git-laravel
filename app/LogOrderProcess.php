<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogOrderProcess extends Model {

    protected $table = 'log_order_process';
    protected $fillable = [
        'order_id',
        'type',
        'message',
        'isRead',
    ];
    public static $CREATE_TYPE = 'createdOrder';
    public static $ACCEPT_TYPE = 'acceptOrder';
    public static $CLOSED_TYPE = 'closeOrder';
    public static $FORCE_SELECT_LAWYER_TYPE = 'forceSelectLawyer';
    public static $NOTIFY_LAWYER_FORCE_SELECT_TYPE = 'notifyForceSelectLawyer';
    public static $NOTIFY_LAWYER_TYPE = 'notifyLawyer';
    public static $NOTIFY_CLIENT_ACCEPT_TYPE = 'notifyClientAccept';
    public static $NOTIFY_CLIENT_CLOSE_TYPE = 'notifyClientclose';
    public static $NOTIFY_CLIENT_NOT_ACCEPT_TYPE = 'notifyClientNotAccept';

    public function order() {
        return $this->belongsTo('App\Order', 'order_id')->withTrashed();
    }

}

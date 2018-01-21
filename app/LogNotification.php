<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogNotification extends Model {

    protected $table = 'log_notification';
    protected $fillable = [
        'title',
        'content',
        'type',
        'orderId',
        'userId'
    ];
    
    public static $NOTIFY_LAWYER_FORCE_SELECT_TYPE = 'notifyForceSelectLawyer';
    public static $NOTIFY_LAWYER_TYPE = 'notifyLawyer';
    public static $NOTIFY_CLIENT_ACCEPT_TYPE = 'notifyClientAccept';
    public static $NOTIFY_CLIENT_CLOSE_TYPE = 'notifyClientclose';
    public static $NOTIFY_CLIENT_NOT_ACCEPT_TYPE = 'notifyClientNotAccept';

    public function order() {
        return $this->belongsTo('App\Order', 'orderId')->withTrashed();
    }
    
    public function user() {
        return $this->belongsTo('App\User', 'userId')->withTrashed();
    }

}

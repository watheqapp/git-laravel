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
        'userId',
        'userType',
        'isSend',
    ];
    
    public static $NOTIFY_LAWYER_FORCE_SELECT_TYPE = 'notifyForceSelectLawyer';
    public static $NOTIFY_LAWYER_TYPE = 'notifyLawyer';
    public static $NOTIFY_CLIENT_ACCEPT_TYPE = 'notifyClientAccept';
    public static $NOTIFY_CLIENT_CLOSE_TYPE = 'notifyClientclose';
    public static $NOTIFY_CLIENT_NOT_ACCEPT_TYPE = 'notifyClientNotAccept';
    public static $NOTIFY_INFO_TYPE = 'notifyInfo';

    public static $NOTIFY_INFO_ALL_LAWYERS = 'all-lawyers';
    public static $NOTIFY_INFO_ONE_LAWYER = 'one-lawyer';
    public static $NOTIFY_INFO_ALL_CLERKS = 'all-clerks';
    public static $NOTIFY_INFO_ONE_CLERK = 'one-clerk';
    public static $NOTIFY_INFO_ALL_USERS = 'all-users';
    public static $NOTIFY_INFO_ONE_USER = 'one-user';

    public function order() {
        return $this->belongsTo('App\Order', 'orderId')->withTrashed();
    }
    
    public function user() {
        return $this->belongsTo('App\User', 'userId')->withTrashed();
    }

    public static function userTypes() {
        return [
            self::$NOTIFY_INFO_ALL_LAWYERS => __('backend.'.self::$NOTIFY_INFO_ALL_LAWYERS),
            self::$NOTIFY_INFO_ONE_LAWYER => __('backend.'.self::$NOTIFY_INFO_ONE_LAWYER),
            self::$NOTIFY_INFO_ALL_CLERKS => __('backend.'.self::$NOTIFY_INFO_ALL_CLERKS),
            self::$NOTIFY_INFO_ONE_CLERK => __('backend.'.self::$NOTIFY_INFO_ONE_CLERK),
            self::$NOTIFY_INFO_ALL_USERS => __('backend.'.self::$NOTIFY_INFO_ALL_USERS),
            self::$NOTIFY_INFO_ONE_USER => __('backend.'.self::$NOTIFY_INFO_ONE_USER),
            ];
    }

    public static function oneUsersTypes() {
        return [
            self::$NOTIFY_INFO_ONE_LAWYER => __('backend.'.self::$NOTIFY_INFO_ONE_LAWYER),
            self::$NOTIFY_INFO_ONE_CLERK => __('backend.'.self::$NOTIFY_INFO_ONE_CLERK),
            self::$NOTIFY_INFO_ONE_USER => __('backend.'.self::$NOTIFY_INFO_ONE_USER),
            ];
    }

}

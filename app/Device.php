<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Device
 */
class Device extends Model
{   
    public static $DEVICE_ANDROID_TYPE = 1;
    public static $DEVICE_IOS_TYPE = 2;

    static $operatingType = array(
        'android' => 1,
        'ios' => 2,
    );
    
    protected $fillable = [
        'identifier',
        'firebaseToken',
        'operator',
        'user_id'
        ];
    
    /**
     * Get the user record associated with device.
     */
    public function userObj() {
        return $this->belongsTo('App\User', 'user_id')->withTrashed();
    }
}

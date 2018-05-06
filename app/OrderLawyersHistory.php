<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderLawyersHistory extends Model {

    protected $table = 'order_lawyers_history';
    protected $fillable = [
        'order_id',
        'lawyer_id',
        'latitude',
        'longtitude',
    ];

    public function order() {
        return $this->belongsTo('App\Order', 'order_id')->withTrashed();
    }

    public function lawyer() {
        return $this->belongsTo('App\User', 'lawyer_id')->withTrashed();
    }

}

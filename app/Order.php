<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model {

    use SoftDeletes;

    protected $table = 'orders';
    protected $fillable = [
        'client_id',
        'category_id',
        'cost',
        'delivery',
        'latitude',
        'longitude',
        'created_at_timestamp',
        'clientName',
        'representativeName',
        'nationalID'
    ];
    public static $NEW_STATUS = 'New';
    public static $PENDING_STATUS = 'Pending';
    public static $CLOSED_STATUS = 'Closed';

    public function client() {
        return $this->belongsTo('App\User', 'client_id')->withTrashed();
    }

    public function lawyer() {
        return $this->belongsTo('App\User', 'lawyer_id')->withTrashed();
    }

    public function category() {
        return $this->belongsTo('App\Category', 'category_id');
    }
    
    public function getCategoryType($category) {
        return $category->id == 13 ? Lawyer::$LAWYER_CLERK_SUBTYPE : Lawyer::$LAWYER_AUTHORIZED_SUBTYPE;
    }

}

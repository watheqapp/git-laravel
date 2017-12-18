<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ContactUs
 */
class ContactUs extends Model {
    
    public $table = 'contactus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'user_type'
    ];

    /**
     * Get users record associated to message.
     */
    public function user() {
        return $this->hasMany('App\User', 'user_id')->get();
    }

}

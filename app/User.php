<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable {

    use Notifiable;

    use SoftDeletes;
    
    public static $BACKEND_TYPE = 1;
    public static $CLIENT_TYPE = 2;
    public static $LAWYER_TYPE = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'type',
        'admin',
        'active',
        'image',
        'totalOrders'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    public function hasPermission($permissions) {
        if ($this->admin || $this->can(explode('|', $permissions))) {
            return true;
        }

        return FALSE;
    }

    public function getActivateTxt() {
        return __('backend.' . ($this->attributes['active'] ? 'Activated' : 'Deactivated'));
    }
    
    public function getLawyerTypeTxt() {
        return $this->attributes['lawyerType'] ? __('backend.' . $this->attributes['lawyerType']) : '';
    }
    
    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
    }

}

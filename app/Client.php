<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use JWTAuth;

class Client extends Authenticatable {

    use Notifiable;
    use SoftDeletes;

    public $table = 'users';
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
        'language'
    ];
    protected $appends = [
        'isCompleteProfile',
        'token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'type',
        'admin',
        'active',
        'updated_at',
        'phoneVerified',
        'deleted_at',
        'remember_token',
        'lawyerType',
        'IDCardFile',
        'licenseFile'
        'credit'
    ];
    
    
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
//    public function apply(Builder $builder, Model $model)
//    {
//        $builder->where('type', self::$CLIENT_TYPE);
//    }

    /**
     * Get the user's login complete profile.
     * @return boolean
     */
    public function getIsCompleteProfileAttribute() {
        return $this->email ? 1 : 0;
    }

    /**
     * Get the user's login token.
     * @return string
     */
    public function getTokenAttribute() {
        return 'Bearer ' . JWTAuth::fromUser($this);
    }

    /**
     * Get the user's Name.
     * @return string
     */
    public function getNameAttribute() {
        return $this->attributes['name'] ? $this->attributes['name'] : '';
    }

    /**
     * Get the user's Email.
     * @return string
     */
    public function getEmailAttribute() {
        return $this->attributes['email'] ? $this->attributes['email'] : '';
    }

    /**
     * Get the user's Image.
     * @return string
     */
    public function getImageAttribute() {
        return $this->attributes['image'] ? 'uploads/' . $this->attributes['image'] : '';
    }

    /**
     * Get the user's Created at.
     * @return integer
     */
    public function getCreatedAtAttribute() {
        return strtotime($this->attributes['created_at']);
    }

}

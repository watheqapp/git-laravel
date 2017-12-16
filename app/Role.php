<?php

namespace App;

use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends EntrustRole {

    public function permissionObjs() {
        return $this->belongsToMany('App\Permission', 'permission_role', 'role_id', 'permission_id')->pluck('name');
    }

    public function permissionIds() {
        return $this->belongsToMany('App\Permission', 'permission_role', 'role_id', 'permission_id')->pluck('id')->toArray();
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Category
 */
class Category extends Model {

    /**
     * Get the parent category record associated with Category.
     */
    public function parentCategory() {
        return $this->belongsTo('App\Category', 'parent');
    }

    /**
     * Get sub categories record associated to Category.
     */
    public function subCategories() {
        return $this->hasMany('App\Category', 'parent')->get();
    }

    public function getNameLocal() {
        return $this->attributes['name' . ucfirst(\App::getLocale())];
    }
    
    public function getDiscriptionLocal() {
        return $this->attributes['description' . ucfirst(\App::getLocale())];
    }

}

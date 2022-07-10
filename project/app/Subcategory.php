<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = ['store_id','category_id','sub_name','sub_slug','featured'];
    public $timestamps = false;

    public function childs()
    {
    	return $this->hasMany('App\Childcategory');
    }

    public function category()
    {
    	return $this->belongsTo('App\Category');
    }
    public function products()
    {
        return $this->hasMany('App\Product');
    }

}

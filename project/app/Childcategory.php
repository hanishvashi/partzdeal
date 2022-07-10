<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Childcategory extends Model
{
    protected $fillable = ['subcategory_id','store_id','child_name','child_slug','featured'];
    public $timestamps = false;

    public function subcategory()
    {
    	return $this->belongsTo('App\Subcategory');
    }
    public function products()
    {
        return $this->hasMany('App\Product');
    }
}

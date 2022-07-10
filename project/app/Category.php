<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['cat_name','store_id','cat_slug','featured','photo','short_description','parent_id','page_title','meta_keywords','meta_description'];
    public $timestamps = false;


    public function subs()
    {
    	return $this->hasMany('App\Subcategory');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }
}

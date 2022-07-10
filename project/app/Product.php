<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id','subcategory_id','store_id','sku','slug','brand_id','series_id','size_guide','name', 'photo', 'size','size_qty','size_price', 'color', 'description','cprice','pprice','stock','policy','featured','status', 'views','tags','best','top','hot','latest','big','features','colors','user_id','product_condition','ship','meta_tag','meta_description','youtube','type','file','license','license_qty','link','platform','region','licence_type','measure','min_qty','is_tier_price','tier_prices'];

    public function category()
    {
    	return $this->belongsTo('App\Category');
    }

    public function subcategory()
    {
    	return $this->belongsTo('App\Subcategory');
    }

    public function childcategory()
    {
    	return $this->belongsTo('App\Childcategory');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function galleries()
    {
        return $this->hasMany('App\Gallery');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    public function wishlists()
    {
        return $this->hasMany('App\Wishlist');
    }
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    public function clicks()
    {
        return $this->hasMany('App\ProductClick');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Wishlist extends Model
{
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
	
	public static function IsinWishlist($user_id,$product_id)
	{
		$wishlists = DB::table('wishlists')
		->select('wishlists.*')
		->where('wishlists.user_id',$user_id)->where('wishlists.product_id',$product_id)->get();
		return count($wishlists);
	}
}

<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $guard = 'user';

    protected $fillable = ['store_id','cover_photo','shop_url','name', 'photo', 'zip', 'residency','state', 'city', 'address', 'phone', 'fax', 'email','password','shop_name','owner_name','shop_number','shop_address','reg_number','shop_message','is_vendor','shop_details','f_url','g_url','t_url','l_url','f_check','g_check','t_check','l_check','shipping_cost','affilate_code'];

    protected $hidden = [
        'password'
    ];

    protected $remember_token = false;


    public function orders()
    {
        return $this->hasMany('App\Order');
    }
    public function vendororders()
    {
        return $this->hasMany('App\VendorOrder');
    }
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    public function replies()
    {
        return $this->hasMany('App\Reply');
    }
    public function subreplies()
    {
        return $this->hasMany('App\SubReply');
    }
    public function reviews()
    {
        return $this->hasMany('App\Review');
    }
    public function wishlists()
    {
        return $this->hasMany('App\Wishlist');
    }
    public function favorites()
    {
        return $this->hasMany('App\FavoriteSeller');
    }
    public function socialProviders()
    {
        return $this->hasMany(SocialProvider::class);
    }
    public function products()
    {
        return $this->hasMany('App\Product');
    }
    public function sliders()
    {
        return $this->hasMany('App\VendorSlider');
    }
    public function IsVendor(){
        if ($this->is_vendor == 2) {
           return true;
        }
        return false;
    }

    public function withdraws()
    {
        return $this->hasMany('App\Withdraw');
    }
    public function senders()
    {
        return $this->hasMany('App\Conversation','sent_user');
    }
    public function recievers()
    {
        return $this->hasMany('App\Conversation','recieved_user');
    }
    public function conversations()
    {
        return $this->hasMany('App\AdminUserConversation');
    }
    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }
    public function notivications()
    {
        return $this->hasMany('App\Notification','vendor_id');
    }
    public function subscribes()
    {
        return $this->hasMany('App\UserSubscription');
    }
}

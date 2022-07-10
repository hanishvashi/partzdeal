<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Generalsetting extends Model
{
    protected $fillable = ['mobile_logo','paypal_check','paypal_business','paypal_text','razorcheck','razorpay_sandbox_check','razorpay_sandbox_keyid','razorpay_sandbox_keysecret','razorpay_live_keyid','razorpay_live_keysecret','logo', 'favicon', 'title', 'site', 'bgimg','cimg', 'about', 'street', 'phone', 'fax', 'email', 'footer', 'bg_link','bg_title','bg_text','np','fp','pb','sk','ss','vid','vidimg','tags','sign','slider','category','sb','hv','ftp','lp','pp','lb','bs','ts','bl','ship','mmi','bi','pcheck','scheck','mcheck','bcheck','ccheck','colors','bimg','loader','count_title','count_heading','count_date','count_link','count_image','order_title','order_text','cart_success','cart_error','wish_success','wish_error','wish_remove','invalid','color_change','size_change','coupon_found','no_coupon','coupon_already','withdraw_charge','withdraw_fee','fixed_commission','percentage_commission','tax','ship_info','multiple_ship','is_talkto','talkto','subscribe_title','subscribe_text','subscribe_image','is_subscribe','is_language','reg_vendor','rtl','is_affilate','affilate_charge','compare_success','compare_error','compare_remove','guest_checkout','affilate_banner','smtp_host', 'smtp_port', 'smtp_user', 'smtp_pass', 'from_email', 'from_name','is_smtp','is_comment','footer_background','is_loader','store_id','payu_sandbox','payu_merchant_key','payu_merchant_salt'];

    public $timestamps = false;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = ['email_type', 'email_subject', 'email_body', 'status'];
    public $timestamps = false;

//    public static function BBCode($cname="",$oamount="",$aname="",$aemail="",$wtitle="",$emailbody){
//
//        $body = preg_replace("/{customer_name}/", $cname ,$emailbody);
//        $body = preg_replace("/{order_amount}/", $oamount ,$body);
//        $body = preg_replace("/{admin_name}/", $aname ,$body);
//        $body = preg_replace("/{admin_email}/", $aemail ,$body);
//        $body = preg_replace("/{website_title}/", $wtitle ,$body);
//
//        return $body;
//    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function order()
    {
    	return $this->belongsTo('App\Order');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function vendor()
    {
        return $this->belongsTo('App\User','vendor_id');
    }

    public function product()
    {
    	return $this->belongsTo('App\Product');
    }

    public function conversation()
    {
        return $this->belongsTo('App\Conversation');
    }

}

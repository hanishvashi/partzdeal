<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubReply extends Model
{
    protected $fillable = ['reply_id', 'user_id','text'];
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function reply()
    {
    	return $this->belongsTo('App\Reply');
    }
}

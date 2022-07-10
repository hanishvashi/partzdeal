<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminUserConversation extends Model
{
	public function user()
	{
	    return $this->belongsTo('App\User');
	}

	public function admin()
	{
	    return $this->belongsTo('App\Admin');
	}

	public function messages()
	{
	    return $this->hasMany('App\AdminUserMessage','conversation_id');
	}

	public function notifications()
	{
	    return $this->hasMany('App\UserNotification','conversation1_id');
	}
}

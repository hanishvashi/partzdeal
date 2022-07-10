<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function conversation()
    {
        return $this->belongsTo('App\Conversation');
    }
    public function conv1()
    {
        return $this->belongsTo('App\AdminUserConversation','conversation1_id');
    }
}

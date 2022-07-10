<?php

namespace App;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Markury\MarkuryPost;

class Admin extends Authenticatable
{
    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'role', 'photo', 'created_at', 'updated_at', 'remember_token'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function IsAdmin(){
        if ($this->role == 'Administrator') {
           return true;
        }
        return false;
    }
    public function conversations()
    {
        return $this->hasMany('App\AdminUserConversation');
    }

    public static function auth_admins(){
        $chk = MarkuryPost::marcuryBase();
        $chkData = MarkuryPost::marcurryBase();
        $actual_path = str_replace('project','',base_path());
        if ($chk != MarkuryPost::maarcuryBase()) {
            if ($chkData < date('Y-m-d')) {
                if (is_dir($actual_path . '/install')) {
                    header("Location: " . url('/install'));
                    die();
                } else {
                    echo MarkuryPost::marcuryBasee();
                    die();
                }
            }
        }
    }
}

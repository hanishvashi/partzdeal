<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorSlider extends Model
{
    protected $fillable = ['photo','user_id'];
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

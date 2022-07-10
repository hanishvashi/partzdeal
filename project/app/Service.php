<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['store_id','title','text','photo'];
    public $timestamps = false;
}

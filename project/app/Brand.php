<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['store_id','photo','url','brand_name'];
    public $timestamps = false;
    public $incrementing = true;
}

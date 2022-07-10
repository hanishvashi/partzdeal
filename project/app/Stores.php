<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    protected $table = 'stores';
    public $timestamps = true;
     protected $fillable = [
        'store_name','store_code','store_description',
    ];

}

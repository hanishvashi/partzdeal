<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $table = 'series';
    protected $primaryKey = 'id';
    protected $returnType     = 'array';
    protected $fillable = ['store_id','series_name'];
    public $timestamps = false;
}

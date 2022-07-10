<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandSeries extends Model
{
    protected $table = 'brand_series_link';
    protected $primaryKey = 'id';
    protected $returnType     = 'array';
    protected $fillable = ['brand_id','series_id'];
    public $timestamps = false;
}

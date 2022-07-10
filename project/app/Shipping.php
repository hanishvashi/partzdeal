<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipping extends Model
{
  protected $table = 'shipping_methods';
  protected $primaryKey = 'id';
  protected $returnType  = 'array';
  protected $fillable = ['store_id','status','shipping_text','shipping_percentage','shipping_price','carrier_title'];
//  public $timestamps = false;
  public $incrementing = true;
  use SoftDeletes;
  protected $dates = ['deleted_at'];
}

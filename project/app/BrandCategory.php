<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandCategory extends Model
{
  protected $table = 'brand_categories_link';
  protected $primaryKey = 'id';
  protected $returnType     = 'array';
  protected $fillable = ['brand_id','category_id'];
  public $timestamps = false;
}

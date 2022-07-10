<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class ProductCategory extends Model
{
	protected $table = 'product_categories';
    protected $fillable = ['product_id', 'category_id'];
	protected $primaryKey = 'id';
	protected $returnType     = 'array';
	protected $hidden = [

    ];
}

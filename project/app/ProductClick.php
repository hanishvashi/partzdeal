<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductClick extends Model
{
	protected $table = 'product_clicks';
	protected $fillable = ['product_id'];
	public $timestamps = false;
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}

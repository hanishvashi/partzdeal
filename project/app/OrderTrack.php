<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderTrack extends Model
{
    //

	protected $fillable = ['store_id','order_id', 'title','text'];

    public function order()
    {
        return $this->belongsTo('App\Models\Order','order_id')->withDefault(function ($data) {
			foreach($data->getFillable() as $dt){
				$data[$dt] = __('Deleted');
			}
		});
    }

}

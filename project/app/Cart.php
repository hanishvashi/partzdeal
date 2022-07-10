<?php

namespace App;
use App\Generalsetting;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    public function totalCartAmount($cartdata)
    {
      $totalcartprice = 0;
      if ($cartdata) {
          $products = $cartdata->items;
          $totalcartprice = array_sum(array_column($products, 'price'));
        }
      return $totalcartprice;
    }

    public function add($item, $id) {
        $storedItem = ['sku'=>$item->sku,'slug'=>$item->slug,'qty' => 0, 'size' => $item->size, 'color' => $item->color, 'stock' => $item->stock, 'price' => $item->cprice, 'item' => $item, 'license' => ''];
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }
        $storedItem['qty']++;
        if($item->stock != null)
        {
        $storedItem['stock']--;
        }

        if($item->size != null)
        {
        $size = explode(',', $item->size);
        $storedItem['size'] = $size[0];
        }
        if($item->color != null)
        {
        $color = explode(',', $item->color);
        $storedItem['color'] = $color[0];
        }

        $storedItem['price'] = $item->cprice * $storedItem['qty'];
        $this->items[$id] = $storedItem;
        $this->totalQty++;
        $this->totalPrice += $item->cprice;
    }

    public function adding($item, $id,$size_qty, $size_price) {
        $storedItem = ['sku'=>$item->sku,'slug'=>$item->slug,'itemprice'=>0,'qty' => 0, 'size' => $item->size, 'color' => $item->color, 'stock' => $item->stock, 'price' => $item->cprice, 'item' => $item, 'license' => ''];
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }
        $storedItem['qty']++;
        if($item->stock != null)
        {
        $storedItem['stock']--;
        }

		if(!empty($size_qty)){
        $storedItem['size_qty'] = $size_qty;
        }
        if(!empty($size_price)){
        $storedItem['size_price'] = $size_price;
        $size_cost = $size_price;
        }else{
		$size_cost = 0;
		}

		if($item->is_tier_price==1)
		{
			$tier_prices = json_decode($item->tier_prices,true);
			$itemprice = $this->FindTierPrice($storedItem['qty'],$item,$tier_prices);
			$storedItem['price'] = ($size_cost + $itemprice) * $storedItem['qty'];
			$storedItem['itemprice'] = (float)$itemprice+$size_cost;
		}else{
		$storedItem['price'] = ($size_cost + $item->cprice) * $storedItem['qty'];
		$storedItem['itemprice'] = $item->cprice+$size_cost;
		}

        $this->items[$id] = $storedItem;
        $this->totalQty++;
        $this->totalPrice += $item->cprice+$size_cost;
    }

    public function reduce($item, $id,$size_qty, $size_price) {
        $storedItem = ['sku'=>$item->sku,'slug'=>$item->slug,'itemprice'=>0,'qty' => 0, 'size' => $item->size, 'color' => $item->color, 'stock' => $item->stock, 'price' => $item->cprice, 'item' => $item, 'license' => ''];
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }
        $storedItem['qty']--;
        if($item->stock != null)
        {
        $storedItem['stock']++;
        }
		if(!empty($size_qty)){
        $storedItem['size_qty'] = $size_qty;
        }
        if(!empty($size_price)){
        $storedItem['size_price'] = $size_price;
        $size_cost = $size_price;
        }else{
		$size_cost = 0;
		}

		if($item->is_tier_price==1)
		{
		$tier_prices = json_decode($item->tier_prices,true);
		$itemprice = $this->FindTierPrice($storedItem['qty'],$item,$tier_prices);
		$storedItem['price'] = ($size_cost + $itemprice) * $storedItem['qty'];
		$storedItem['itemprice'] = (float)$itemprice+$size_cost;
		}else{
		$storedItem['price'] = ($size_cost + $item->cprice) * $storedItem['qty'];
		$storedItem['itemprice'] = $item->cprice+$size_cost;
		}


        $this->items[$id] = $storedItem;
        $this->totalQty--;
        $this->totalPrice -= $item->cprice+$size_cost;
    }

    public function addnum($item, $id, $qty, $size,$size_qty,$size_price,$size_key, $color) {
        $storedItem = ['sku'=>$item->sku,'slug'=>$item->slug,'itemprice'=>0,'qty' => 0, 'size' => $item->size, 'color' => $item->color, 'stock' => $item->stock, 'price' => $item->cprice, 'item' => $item, 'license' => ''];
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }

        $storedItem['qty'] = $storedItem['qty'] + $qty;
        if($item->stock != null)
        {
        $storedItem['stock'] -=  $qty;
        }
        if($item->size != null)
        {
        $sizes = explode(',', $item->size);
        $storedItem['size'] = $sizes[0];
        }
        if(!empty($size)){
        $storedItem['size'] = $size;
		$storedItem['size_key'] = $size_key;
        }
		// if(!empty($size_key)){

        // }
        if(!empty($item->size_qty)){
        $storedItem['size_qty'] = $size_qty;
        }
        if(!empty($size_qty)){
        $storedItem['size_qty'] = $size_qty;
        }
        if(!empty($size_price)){
        $storedItem['size_price'] = $size_price;
        $size_cost = $size_price;
        }else{
		$size_cost = 0;
		}
        if($item->color != null)
        {
        $colors = explode(',', $item->color);
        $storedItem['color'] = $colors[0];
        }
        if(!empty($color)){
        $storedItem['color'] = $color;
        }
		    $item->cprice += $size_cost;
        if($item->is_tier_price==1)
        {
        $tier_prices = json_decode($item->tier_prices,true);
        $itemprice = $this->FindTierPrice($storedItem['qty'],$item,$tier_prices);
        $storedItem['price'] = $itemprice * $storedItem['qty'];
        $storedItem['itemprice'] = (float)$itemprice;
        }else{
        $storedItem['price'] = $item->cprice * $storedItem['qty'];
        $storedItem['itemprice'] = 0;
        }

        $this->items[$id] = $storedItem;
        $this->totalQty+=$qty;
        $this->totalPrice += $item->cprice * $qty;
    }

	public function FindTierPrice($qty,$prod,$tier_prices)
	{
		$quantity = (int)$qty;
		$minqty = min(array_column($tier_prices, 'price_qty'));
		if($quantity<$minqty){
		$itemprice = $prod->cprice;
		}else{
			$tierdata = array_filter($tier_prices, function($el) use ($quantity)
			{
			return ($el['price_qty'] <= $quantity);
			});
			$tcnt = count($tierdata);
			$tierpriceinfo = $tierdata[$tcnt-1];

			if($prod->user_id != 0){
			$gs = Generalsetting::findOrFail(1);
			$itemprice = $tierpriceinfo['price'] + $gs->fixed_commission + ($tierpriceinfo['price']/100) * $gs->percentage_commission;
			}else{
			$itemprice = $tierpriceinfo['price'];
			}
		}
		return $itemprice;
	}

	public function filterPricebetween($tier_prices,$quantity)
	{

	}

    public function updateItem($item, $id,$size) {

        $this->items[$id]['size'] = $size;
    }
    public function updateLicense($id,$license) {

        $this->items[$id]['license'] = $license;
    }
    public function updateColor($item, $id,$color) {

        $this->items[$id]['color'] = $color;
    }
    public function removeItem($id) {
        $this->totalQty -= $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['price'];
        unset($this->items[$id]);
    }
}

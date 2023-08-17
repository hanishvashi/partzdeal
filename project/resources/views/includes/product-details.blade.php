<h5>{{$product->name}}</h5>
<p class="mb-2 text-muted text-uppercase small">Brand : {{$brand_name}}</p>
<p class="mb-2 text-muted text-uppercase small">Product SKU: {{$product->sku}}</p>
<p class="productDetails-reviews">
    <div class="ratings">
      <div class="empty-stars"></div>
      <div class="full-stars" style="width:{{App\Review::ratings($product->id)}}%"></div>
    </div>
  <span>{{count($product->reviews)}} {{$lang->dttl}}</span>
</p>
@php
$product_price = $product->cprice;
@endphp
<p><span class="mr-1"><strong>{{$curr->sign}}{{ number_format($product->cprice, 2) }}</strong></span></p>
<?php if(!empty($product->size)){?>
<input type="hidden" id="product_option_size" value="0"/>
<?php }else{?>
<input type="hidden" id="product_option_size" value="1"/>
<?php }?>
<?php if(!empty($product->color)){?>
<input type="hidden" id="product_option_color" value="0"/>
<?php }else{?>
<input type="hidden" id="product_option_color" value="1"/>
<?php }?>

<?php if(!empty($tier_prices)){?>
<ul class="tier-prices product-pricing">
<?php foreach($tier_prices as $key=> $tierprice){
if($product->user_id != 0){
  $group_price = $tierprice['price'] + $gs->fixed_commission + ($tierprice['price']/100) * $gs->percentage_commission ;
}else{
  $group_price = $tierprice['price'];
}
?>
<li class="tier-price tier-<?php echo $key;?>">
    @if($store_code=='partzdeal-india')
    Buy <?php echo round($tierprice['price_qty'],0);?> or more for <span class="price">{{$curr->sign}}{{ number_format($group_price, 2) }}</span> each
    @else
    Buy <?php echo round($tierprice['price_qty'],0);?> or more for <span class="price">{{$curr->sign}}{{ $group_price }}</span> each
    @endif
</li>
<?php }?>
</ul>
<?php }?>
<input type="hidden" id="product_price" value="{{$product_price}}"/>
<hr>
@php
  $stk = (string)$product->stock;
@endphp
<input type="hidden" id="pid" value="{{$product->id}}">

<div class="table-responsive">
  <table class="table table-sm table-borderless">
    <tbody>
      <tr>
        <td class="pl-0">
          <div class="productDetails-quantity">
          <p>{{$lang->cquantity}}</p>
          <input type="hidden" id="stock" value="{{$product->stock}}">
          <span class="quantity-btn" id="qsub"><i class="fa fa-minus"></i></span>
          <span id="qval">{{$product->min_qty}}</span>
          <span class="quantity-btn" id="qadd"><i class="fa fa-plus"></i></span>
          <!--<span style="padding-left: 5px; border: none; font-weight: 700; font-size: 15px;">{{ $product->measure }}</span>-->
          <span style="padding-left: 5px; border: none; font-weight: 700; font-size: 15px; width: 100px;">In Stock</span>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>
@if($stk == "0")
<a class="productDetails-addCart-btn addCart_btn d-none d-md-inline-block" style="cursor: no-drop;;">
<i class="fa fa-cart-plus"></i> <span>{{$lang->dni}}</span>
</a>
@else
<button type="button" class="productDetails-addCart-btn addCart_btn addtocartajax btn btn-light btn-md mr-1 mb-2" id="addcrt" style="cursor: pointer;">
<i class="fa fa-cart-plus"></i> <span>{{$lang->hcs}}</span>
</button>
@endif
<button type="button" data-productid="{{$product->id}}" data-productsku="{{$product->sku}}" data-productname="{{$product->name}}" class="productDetails-addCart-btn addCart_btn no-wish enqbtn btn btn-light btn-md mr-1 mb-2" data-toggle="modal" data-target="#InquiryModal"><i class="fa fa-info"></i> <span>Enquire Now</span></button>

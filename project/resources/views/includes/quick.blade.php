<div class="section-padding product-details-wrapper p-3 p-md-4" style="">
<div class="container p-0">
<div class="row">
		<div class="col-md-12 col-lg-5 mb-3 mb-lg-0">
		@if(Auth::guard('user')->check())
		<?php $user_id = Auth::guard('user')->user()->id;
		if(App\Wishlist::IsinWishlist($user_id,$product->id)==1)
		{ ?>
		<button class="removewish" id="rmwish" title="Remove from Wishlist" tabindex="-1"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
		<?php }else{ ?>
		<button class="add_to_wish" id="wish" title="{{$lang->wishlist_add}}" tabindex="-1"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
		<?php } ?>
		@else
		<button class="add_to_wish" title="{{$lang->wishlist_add}}" data-toggle="modal" data-target="#loginModal" tabindex="-1"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
		@endif
		<div class="product-review-carousel-img product-zoom" >
		<img id="imageDiv" class="img-fluid" src="{{asset('assets/images/'.$product->photo)}}" alt="Product image">
		</div>
		<div class="owl-carousel product-review-owl-carousel">
		<div class="single-product-item small-img">
		<img style="height: 80px; width: 95px;" id="iconOne" onclick="productGallery(this.id)" src="{{asset('assets/images/'.$product->photo)}}" alt="Product image">
		</div>
		@foreach($product->galleries as $gallery)
		<div class="single-product-item small-img">
		<img style="height: 80px; width: 95px;" id="icon{{$gallery->id}}" onclick="productGallery(this.id)" src="{{asset('assets/images/gallery/'.$gallery->photo)}}" alt="Product image">
		</div>
		@endforeach
		</div>
		</div>
		
		<div class="col-md-12 col-lg-7">
		@if(strlen($product->name) > 40)
		<h4 class="productDetails-header">{{$product->name}}</h4>
		@else
		<h4 class="productDetails-header">{{$product->name}}</h4>
		@endif
		<!--<h6>Product ID: {{sprintf("%'.08d", $product->id)}}</h6>-->
		@if($product->user_id != 0)

		@if(isset($product->user))
		
		@endif
		@else

		{{-- Admin Contact --}}

		@endif
		
		@if($product->youtube != null)                    
		<div class="productVideo__title">
		{{$lang->watch_video}}: <a style=" color:{{$gs->colors == null ? '#337ab7':$gs->colors}};" class="fancybox" data-fancybox="" href="{{$product->youtube}}"><i class="fa fa-play-circle"></i></a>
		</div>

		@endif
		@if($product->type == 2)
		<div class="productVideo__title">
		{{$lang->platform}}{{$product->platform}}
		</div>
		<div class="productVideo__title">
		{{$lang->region}}{{$product->region}}
		</div>
		<div class="productVideo__title">
		{{$lang->licence_type}}{{$product->licence_type}}
		</div>
		@endif
		@if($product->product_condition != 0)
		<div class="productDetails-header-info">

		<div class="product-headerInfo__title">
		{{$lang->product_condition}}: <span style="font-weight: 400;">{{ $product->product_condition == 1 ?'Used' : 'New'}}.<span>
		</div>
		</div>
		@endif
		@if($product->ship != null)
		<div class="productDetails-header-info">

		<div class="product-headerInfo__title">
		{{$lang->shipping_time}}: <span style="font-weight: 400;">{{ $product->ship}}.</span>
		</div>
		</div>
		@endif

		@php
		$stk = (string)$product->stock;
		@endphp

		@if($product->type == 0)
		@if($stk == "0")
		<p class="productDetails-status mb-0" style="color: red;">
		<i class="fa fa-times-circle-o"></i>
		<span style="font-weight: 700;">{{$lang->dni}}</span>
		</p>
		@else
		<p class="productDetails-status mb-0" style="color: green;">
		<i class="fa fa-check-square-o"></i>
		<span style="font-weight: 700;">{{$lang->sbg}}</span>
		</p>
		@endif
		@endif
		<div class="productDetails-reviews">
    		<div class="ratings">
        		<div class="empty-stars"></div>
        		<div class="full-stars" style="width:{{App\Review::ratings($product->id)}}%"></div>
    		</div>
    		<span>{{count($product->reviews)}} {{$lang->dttl}}</span>
		</div>
		@if($gs->sign == 0)
		<h4 class="productDetails-price mb-0">{{$curr->sign}}
		@if($product->user_id != 0)
		@php
		$price = $product->cprice + $gs->fixed_commission + ($product->cprice/100) * $gs->percentage_commission ;
		$product_price = $price;
		@endphp
		{{round($price * $curr->value,2)}}
		@else
		@php
		$product_price = $product->cprice;
		@endphp
		{{round($product->cprice * $curr->value,2)}}
		@endif                   

		@if($product->pprice != null)
		<span><del>{{$curr->sign}}{{round($product->pprice * $curr->value,2)}}</del></span>
		@endif
		</h4>
		<input type="hidden" id="product_price" value="{{$product_price}}"/>
		@else
		<h4 class="productDetails-price mb-0">
		@if($product->user_id != 0)
		@php
		$price = $product->cprice + $gs->fixed_commission + ($product->cprice/100) * $gs->percentage_commission ;
		@endphp
		{{round($price * $curr->value,2)}}
		@else
		@php
		$product_price = $product->cprice;
		@endphp
		{{round($product->cprice * $curr->value,2)}}
		@endif                   
		{{$curr->sign}}
		@if($product->pprice != null)
		<span><del>{{round($product->pprice * $curr->value,2)}}{{$curr->sign}}</del></span>
		@endif  
		</h4> 
		<input type="hidden" id="product_price" value="{{$product_price}}"/>					
		@endif
		
		<?php if(!empty($product->size)){?>
		<input type="hidden" id="product_option_size" value="0"/>	
		<?php }else{?>
		<input type="hidden" id="product_option_size" value="1"/>
		<?php }?>

		@if(!empty($product->size))
		<div class="product-size mb-3">
		<p class="title mb-0">{{ $lang->doo }} :</p>
		<ul class="siz-list mb-0">
		@php
		$is_first = true;
		@endphp
		@foreach($size as $key => $data1)
		<li class="{{ $is_first ? '' : '' }}">
		<span class="box">{{ $data1 }}
		<input type="hidden" class="size" value="{{ $data1 }}">
		<input type="hidden" class="size_qty" value="{{ $size_qty[$key] }}">
		<input type="hidden" class="size_key" value="{{$key}}">
		<input type="hidden" class="size_price" value="{{ round($size_price[$key] * $curr->value,2) }}">
		</span>
		</li>
		@php
		$is_first = false;
		@endphp
		@endforeach
		<li>
		</ul>
		</div>
		@endif
		
		<?php if(!empty($product->color)){?>
				   <input type="hidden" id="product_option_color" value="0"/>	
				   <?php }else{?>
				   <input type="hidden" id="product_option_color" value="1"/>
				   <?php }?>
		
		@if(!empty($product->color))
		<div class="product-color mb-2">
		<p class="title mb-0">{{ $lang->colors }} :</p>
		<ul class="color-list mb-0">
		@php
		$is_first = true;
		@endphp
		@foreach($color as $key => $data1)
		<li class="{{ $is_first ? '' : '' }}">
		<span class="box" data-color="{{ $color[$key] }}" style="background-color: {{ $color[$key] }}"></span>
		</li>
		@php
		$is_first = false;
		@endphp
		@endforeach
		</ul>
		</div>
		@endif
		<?php if(!empty($tier_prices)){?>
		<ul class="tier-prices product-pricing d-none">
		<?php foreach($tier_prices as $key=> $tierprice){
		if($product->user_id != 0){
		$group_price = $tierprice['price'] + $gs->fixed_commission + ($tierprice['price']/100) * $gs->percentage_commission ;
		}else{
		$group_price = $tierprice['price'];
		}
		?>		 		
		<li class="tier-price tier-<?php echo $key;?>">
		Buy <?php echo round($tierprice['price_qty'],0);?> or more for <span class="price">Rs <?php echo round($group_price,2);?></span> each
		</li>
		<?php }?>
		</ul>
		<?php }?>
		<div class="productDetails-quantity">
		<p>{{$lang->cquantity}}</p>
		<input type="hidden" id="stock" value="{{$product->stock}}">
		<span class="quantity-btn" id="qsub"><i class="fa fa-minus"></i></span>
		<span id="qval">{{$product->min_qty}}</span>
		<span class="quantity-btn" id="qadd"><i class="fa fa-plus"></i></span>
		<!--<span style="padding-left: 5px; border: none; font-weight: 700; font-size: 15px;">{{ $product->measure }}</span>-->
		</div>
		@if($stk == "0")
		<a class="productDetails-addCart-btn addCart_btn" style="cursor: pointer;">
		<i class="fa fa-cart-plus"></i> <span>{{$lang->dni}}</span>
		</a>
		@else
		<a class="productDetails-addCart-btn addCart_btn" id="addcrt" style="cursor: pointer;">
		<i class="fa fa-cart-plus"></i> <span>{{$lang->hcs}}</span>
		</a>
		@endif
		<input type="hidden" id="pid" value="{{$product->id}}">
		<!--@if(Auth::guard('user')->check())-->
		<!--<a style="cursor: pointer;" class="productDetails-addCart-btn addCart_btn" id="wish"><i class="fa fa-heart"></i> <span>{{$lang->wishlist_add}}</span></a>-->
		<!--@else-->
		<!--<a style="cursor: pointer;" class="productDetails-addCart-btn no-wish addCart_btn" data-toggle="modal" data-target="#loginModal"><i class="fa fa-heart"></i> <span>{{$lang->wishlist_add}}</span></a>-->
		<!--@endif-->
		</div>
		
</div>
</div>
</div>
<script type="text/javascript">
function getAmount()
{
  var total = 0;
  var value = parseFloat($('#product_price').val());
 
  total += value;
  return total;
}
    var sizes = "";
    var colors = "";
    var stock = $("#stock").val();

    $(document).on("click", "#qsub" , function(){
         var qty = $("#qval").html();
         qty--;
         if(qty < 1)
         {
         $("#qval").html("{{$product->min_qty}}");            
         }
         else{
         $("#qval").html(qty);
         }
    });
    $(document).on("click", "#qadd" , function(){
        var qty = $("#qval").html();
        if(stock != "")
        {
        var stk = parseInt(stock);
          if(qty < stk)
          {
             qty++;
             $("#qval").html(qty);               
          }

        }
        else{
         qty++;
         $("#qval").html(qty);          
        }

    });
	
	var sizes = "";
    var size_qty = "";
    var size_price = "";
    var size_key = "";
    var colors = "";
    var total = "";
    var stock = $("#stock").val();
    var keys = "";
    var values = "";
    var prices = "";

    // Product Details Product Size Active Js Code
    $(document).on('click', '.product-size .siz-list .box', function () {
        $('#qval').html('{{$product->min_qty}}');
        var parent = $(this).parent();
         size_qty = $(this).find('.size_qty').val();
         size_price = $(this).find('.size_price').val();
         size_key = $(this).find('.size_key').val();
         sizes = $(this).find('.size').val();
                $('.product-size .siz-list li').removeClass('active');
                parent.addClass('active');
         total = getAmount()+parseFloat(size_price);
         total = total.toFixed(2);
         stock = size_qty;
		 
		 $('#product_option_size').val('1');

         var pos = $('#curr_pos').val();
         var sign = "Rs. ";
		 $('.productDetails-price').html(sign+total);
    });
	
	$(document).on('click', '.product-color .color-list .box', function () {
        colors = $(this).data('color');
        var parent = $(this).parent();
            $('.product-color .color-list li').removeClass('active');
            parent.addClass('active');
			$('#product_option_color').val('1');
    });

    $(document).on("click", "#addcrt" , function(){
		var product_option_color = $('#product_option_color').val();
		var product_option_size = $('#product_option_size').val();
		if(product_option_size=='0')
		{
			$.notify("Please select product item size.","warning");
			
			return false;
		}
		if(product_option_color=='0')
		{
			$.notify("Please select product item color.","warning");
			return false;
		}
     var qty = $("#qval").html();
     var pid = $("#pid").val();
             $(".empty").html("");
                $.ajax({
                        type: "GET",
                        url:"{{URL::to('/json/addnumcart')}}",
                        data:{id:pid,qty:qty,size:sizes,size_qty:size_qty,size_price:size_price,size_key:size_key,color:colors},
						success:function(data){
						console.log(data);
                        if(data == 0)
                        {
                        $.notify("{{$gs->cart_error}}","error");
                        }
                        else{
                        $(".empty").html("");
                        $(".total").html((data[0] * {{$curr->value}}).toFixed(2));
                        $(".cart-quantity").html(data[2]);
                        var arr = $.map(data[1], function(el) {
                        return el });
                        $(".js-cart-product-template").html("");
						if(data[2]>=1)
						{
var checkoutbutton = '<a class="button" href="{{route("front.checkout")}}" title="Checkout">Checkout</a><a class="button" href="{{route("front.cart")}}" title="View Cart">View Cart</a>';
							$(".cart_text_footer_btn").html(checkoutbutton);
						}
                        for(var k in arr)
                        {
                            var x = arr[k]['item']['name'];
                            var p = x.length  > 45 ? x.substring(0,45)+'...' : x;
                            var measure = arr[k]['item']['measure'] != null ? arr[k]['item']['measure'] : "";
                            $(".js-cart-product-template").append(
                             '<div class="single-myCart">'+
            '<p class="cart-close" onclick="remove('+arr[k]['item']['id']+')"><i class="fa fa-close"></i></p>'+
                            '<div class="cart-img">'+
                    '<img src="{{ asset('assets/images/') }}/'+arr[k]['item']['photo']+'" alt="Product image">'+
                            '</div>'+
                            '<div class="cart-info">'+
        '<a href="{{url('/')}}/product/'+arr[k]['item']['id']+'/'+arr[k]['item']['name']+'" style="color: black; padding: 0 0;">'+'<h5>'+p+'</h5></a>'+
                        '<p>{{$lang->cquantity}}: '+arr[k]['qty']+' '+measure+'</p>'+
                        @if($gs->sign == 0)
                        '<p>{{$curr->sign}}'+(arr[k]['price'] * {{$curr->value}}).toFixed(2)+'</p>'+
                        @else
                        '<p>'+(arr[k]['price'] * {{$curr->value}}).toFixed(2)+'{{$curr->sign}}</p>'+
                        @endif
                        '</div>'+
                        '</div>');
                          }
                        $.notify("{{$gs->cart_success}}","success");
                        $("#qval").html("{{$product->min_qty}}");
                        }
                      }
                  }); 

    });

</script>
<script>
        $(document).on("click", "#wish" , function(){
            var pid = $("#pid").val();
            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/wish')}}",
                    data:{id:pid},
                    success:function(data){
                        if(data == 1)
                        {
                            $.notify("{{$gs->wish_success}}","success");
							setTimeout(function () {
							location.reload(true);
							}, 1000);
                        }
                        else {
                            $.notify("{{$gs->wish_error}}","error");
                        }
                      }
              }); 

            return false;
        });
		$(document).on("click", "#rmwish" , function(){
            var pid = $("#pid").val();
            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/removewish')}}",
                    data:{id:pid},
                    success:function(data){
					$.notify("{{$gs->wish_remove}}","success"); 
					setTimeout(function () {
					location.reload(true);
					}, 1000);
                      }
              });

            return false;
        });
    </script>
    <script>
        $(document).on("click", "#favorite" , function(){
          $("#favorite").hide();
            var pid = $("#fav").val();
            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/favorite')}}",
                    data:{id:pid},
                    success:function(data){
                      $('.product-headerInfo__btns').html('<a class="headerInfo__btn colored"><i class="fa fa-check"></i> {{ $lang->product_favorite }}</a>');
                      }
              }); 

        });
    </script>
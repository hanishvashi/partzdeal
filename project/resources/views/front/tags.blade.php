@extends('layouts.front')
@section('content')
@php
$i=1;
$j=1;
@endphp
   
   <div id="content" class="shopPage">

		<section id="shop_section" class="p-0 p-md-4">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <!--div class="col-12 col-md-4 col-lg-3 col-xl-2">
			
          </div-->
          <div class="col-12 col-md-12 col-lg-12 col-xl-12">
            <div class="row">
              <div class="col-12">
                <h4 class="heading_three mb-2">{{$lang->dom}} {{ucfirst($seltag)}}</h4>
                <ul class="category_list">
				@if($gs->tags != null)
				@foreach(explode(',',$gs->tags) as $tag)
				<li><a href="{{route('front.tags',$tag)}}" class=" btn btn_one <?php if($seltag==$tag){ echo 'sel_tag'; }?>">{{$tag}}</a></li>
				@endforeach
				@endif
                  <!--li><button class=" btn btn_one">Trendy</button></li>
                  <li><button class=" btn btn_one">Sports</button></li>
                  <li><button class=" btn btn_one">Movies</button></li>
                  <li><button class=" btn btn_one">Superhero</button></li>
                  <li><button class=" btn btn_one">Music</button></li-->
                </ul>
              </div>                  
            </div>
            <div class="row">     
              <div class="col-8 col-md-7 col-lg-8 col-xl-9 align-self-center">
                <h4 class="heading_three">{{ucfirst($seltag)}} <span class="small">{{$total_product}} Results</span></h4>
              </div>
              
            </div>
            <div class="row product_list">   
		    	@foreach($products as $prod)
					{{-- LOOP STARTS --}}
					{{-- If This product belongs to vendor then apply this --}}
					@if($prod->user_id != 0)

					{{-- check  If This vendor status is active --}}
					@if($prod->user_id != 2)
					@php
					$price = $prod->cprice + $gs->fixed_commission + ($prod->cprice/100) * $gs->percentage_commission ;
					@endphp

					@if(isset($max))  
					@if($price < $max)
					<div class="col-6 col-sm-4 col-md-6 col-lg-3 col-xl-3 align-self-center">
					@php
					$name = str_replace(" ","-",$prod->name);
					@endphp
					@if(Auth::guard('user')->check())
						<?php $user_id = Auth::guard('user')->user()->id;
						if(App\Wishlist::IsinWishlist($user_id,$prod->id)==1)
						{ ?>
						<button data-pid="{{$prod->id}}" class="wishlist wishicon removewish" tabindex="-1"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
						<?php }else{ ?>
						<button data-pid="{{$prod->id}}" class="wishlist wishicon add_to_wish" tabindex="-1"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
						<?php } ?>
					@else
					<button class="wishlist wishicon" data-toggle="modal" data-target="#loginModal" rel-toggle="tooltip" title="{{$lang->wishlist_add}}" tabindex="-1"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
					@endif
					<a href="{{route('front.product',['id' => $prod->id, 'slug' => $name])}}" class="product_box">
					<div class="product-img text-center">
					@if($prod->features!=null && $prod->colors!=null)
					@php
					$title = explode(',', $prod->features);
					$details = explode(',', $prod->colors);
					@endphp
					@endif
					<img src="{{asset('assets/images/'.$prod->photo)}}" alt="featured product">
					
					<input type="hidden" value="{{$prod->id}}">
					
					</div>
					
					<div class="product_content">
					<h5>{{strlen($prod->name) > 65 ? substr($prod->name,0,65)."..." : $prod->name}}</h5>
					<div class="product-review" style="display:none">
					<div class="ratings">
					<div class="empty-stars"></div>
					<div class="full-stars" style="width:{{App\Review::ratings($prod->id)}}%"></div>
					</div>
					</div>

					@if($gs->sign == 0)
					<div class="product-price">{{$curr->sign}}
					{{round($price * $curr->value,2)}}
					@if($prod->pprice != 0)
					<del class="offer-price">{{$curr->sign}}{{round($prod->pprice * $curr->value,2)}}</del>  
					@endif

					</div>
					@else
					<div class="product-price">
					{{round($price * $curr->value,2)}}
					@if($prod->pprice != 0)
					<del class="offer-price">{{$curr->sign}}{{round($prod->pprice * $curr->value,2)}}</del>  
					@endif
					{{$curr->sign}}
					</div>
					@endif
					<button type="button" data-productid="{{$prod->id}}" class="btn btn_one addcart"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><circle cx="8" cy="20" r="2"></circle><circle cx="18" cy="20" r="2"></circle><path d="M19,17H7a1,1,0,0,1-1-.78L3.2,4H2A1,1,0,0,1,2,2H4a1,1,0,0,1,1,.78L7.8,15H18.2L20,6.78a1,1,0,0,1,2,.44l-2,9A1,1,0,0,1,19,17Z"></path><path d="M16,6H14V4a1,1,0,0,0-2,0V6H10a1,1,0,0,0,0,2h2v2a1,1,0,0,0,2,0V8h2a1,1,0,0,0,0-2Z"></path></svg></button>
					<button type="button" data-toggle="modal" data-productid="{{$prod->id}}" data-target="#myModal" rel-toggle="tooltip" class="btn btn_one quick-view-btn"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M21.71,20.29,18,16.61A9,9,0,1,0,16.61,18l3.68,3.68a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29ZM4,11a7,7,0,1,1,12,4.93h0s0,0,0,0A7,7,0,0,1,4,11Z"></path><path d="M14,10H12V8a1,1,0,0,0-2,0v2H8a1,1,0,0,0,0,2h2v2a1,1,0,0,0,2,0V12h2a1,1,0,0,0,0-2Z"></path></svg></button>
					
					</div>
					</a>

					</div>
					@endif
					@else                  
					<div class="col-6 col-sm-4 col-md-6 col-lg-4 col-xl-3 align-self-center">
					@php
					$name = str_replace(" ","-",$prod->name);
					@endphp
					@if(Auth::guard('user')->check())
						<?php $user_id = Auth::guard('user')->user()->id;
						if(App\Wishlist::IsinWishlist($user_id,$prod->id)==1)
						{ ?>
						<button data-pid="{{$prod->id}}" class="wishlist wishicon removewish" tabindex="-1"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
						<?php }else{ ?>
						<button data-pid="{{$prod->id}}" class="wishlist wishicon add_to_wish" tabindex="-1"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
						<?php } ?>

					@else
					<button class="wishlist wishicon" data-toggle="modal" data-target="#loginModal" rel-toggle="tooltip" title="{{$lang->wishlist_add}}" tabindex="-1"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
					@endif
					<a href="{{route('front.product',['id' => $prod->id, 'slug' => $name])}}" class="product_box">
					<div class="product-img text-center">
					@if($prod->features!=null && $prod->colors!=null)
					@php
					$title = explode(',', $prod->features);
					$details = explode(',', $prod->colors);
					@endphp
					@endif
					<img src="{{asset('assets/images/'.$prod->photo)}}" alt="featured product">
					<input type="hidden" value="{{$prod->id}}">
				
					</div>
					<div class="product_content">
					<h5>{{strlen($prod->name) > 65 ? substr($prod->name,0,65)."..." : $prod->name}}</h5>
					<div class="product-review" style="display:none;">
					<div class="ratings">
					<div class="empty-stars"></div>
					<div class="full-stars" style="width:{{App\Review::ratings($prod->id)}}%"></div>
					</div>
					</div>

					@if($gs->sign == 0)
					<div class="product-price">{{$curr->sign}}
					{{round($price * $curr->value,2)}}
					@if($prod->pprice != 0)
					<del class="offer-price">{{$curr->sign}}{{round($prod->pprice * $curr->value,2)}}</del>  
					@endif

					</div>
					@else
					<div class="product-price">
					{{round($price * $curr->value,2)}}
					@if($prod->pprice != 0)
					<del class="offer-price">{{$curr->sign}}{{round($prod->pprice * $curr->value,2)}}</del>  
					@endif
					{{$curr->sign}}
					</div>
					@endif
					<button type="button" data-productid="{{$prod->id}}" class="btn btn_one addcart"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><circle cx="8" cy="20" r="2"></circle><circle cx="18" cy="20" r="2"></circle><path d="M19,17H7a1,1,0,0,1-1-.78L3.2,4H2A1,1,0,0,1,2,2H4a1,1,0,0,1,1,.78L7.8,15H18.2L20,6.78a1,1,0,0,1,2,.44l-2,9A1,1,0,0,1,19,17Z"></path><path d="M16,6H14V4a1,1,0,0,0-2,0V6H10a1,1,0,0,0,0,2h2v2a1,1,0,0,0,2,0V8h2a1,1,0,0,0,0-2Z"></path></svg></button>
					<button type="button" data-toggle="modal" data-productid="{{$prod->id}}" data-target="#myModal" rel-toggle="tooltip" class="btn btn_one quick-view-btn"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M21.71,20.29,18,16.61A9,9,0,1,0,16.61,18l3.68,3.68a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29ZM4,11a7,7,0,1,1,12,4.93h0s0,0,0,0A7,7,0,0,1,4,11Z"></path><path d="M14,10H12V8a1,1,0,0,0-2,0v2H8a1,1,0,0,0,0,2h2v2a1,1,0,0,0,2,0V12h2a1,1,0,0,0,0-2Z"></path></svg></button>
					</div>
					
					</a>
					
					</div>
					@endif
					@endif

					{{-- Otherwise display products created by admin --}}

					@else


					<div class="col-6 col-sm-4 col-md-6 col-lg-4 col-xl-3 align-self-center">
					@php
					$name = str_replace(" ","-",$prod->name);
					@endphp
					@if(Auth::guard('user')->check())
					<?php $user_id = Auth::guard('user')->user()->id;
					if(App\Wishlist::IsinWishlist($user_id,$prod->id)==1)
					{ ?>
					<button data-pid="{{$prod->id}}" class="wishlist wishicon removewish" tabindex="-1"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
					<?php }else{ ?>
					<button data-pid="{{$prod->id}}" class="wishlist wishicon add_to_wish" tabindex="-1"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
					<?php } ?>

					@else
					<button class="wishlist wishicon" data-toggle="modal" data-target="#loginModal" rel-toggle="tooltip" title="{{$lang->wishlist_add}}" tabindex="-1"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
					@endif
					<a href="{{route('front.product',['id' => $prod->id, 'slug' => $name])}}" class="product_box">
					<div class="product-img text-center">
					@if($prod->features!=null && $prod->colors!=null)
					@php
					$title = explode(',', $prod->features);
					$details = explode(',', $prod->colors);
					@endphp
					@endif
					<img src="{{asset('assets/images/'.$prod->photo)}}" alt="featured product">
					<input type="hidden" value="{{$prod->id}}">
					</div>
					<div class="product_content">
					<h5>{{strlen($prod->name) > 65 ? substr($prod->name,0,65)."..." : $prod->name}}</h5>
					<div class="product-review" style="display:none">
					<div class="ratings">
					<div class="empty-stars"></div>
					<div class="full-stars" style="width:{{App\Review::ratings($prod->id)}}%"></div>
					</div>
					</div>
					@if($gs->sign == 0)
					<div class="product-price">{{$curr->sign}}
					{{round($prod->cprice * $curr->value,2)}}
					@if($prod->pprice != 0)
					<del class="offer-price">{{$curr->sign}}{{round($prod->pprice * $curr->value,2)}}</del>  
					@endif

					</div>
					@else
					<div class="product-price">
					{{round($prod->cprice * $curr->value,2)}}
					@if($prod->pprice != 0)
					<del class="offer-price">{{$curr->sign}}{{round($prod->pprice * $curr->value,2)}}</del>  
					@endif
					{{$curr->sign}}
					</div>
					@endif
					<button type="button" data-productid="{{$prod->id}}" class="btn btn_one addcart"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><circle cx="8" cy="20" r="2"></circle><circle cx="18" cy="20" r="2"></circle><path d="M19,17H7a1,1,0,0,1-1-.78L3.2,4H2A1,1,0,0,1,2,2H4a1,1,0,0,1,1,.78L7.8,15H18.2L20,6.78a1,1,0,0,1,2,.44l-2,9A1,1,0,0,1,19,17Z"></path><path d="M16,6H14V4a1,1,0,0,0-2,0V6H10a1,1,0,0,0,0,2h2v2a1,1,0,0,0,2,0V8h2a1,1,0,0,0,0-2Z"></path></svg></button>
					<button type="button" data-toggle="modal" data-productid="{{$prod->id}}" data-target="#myModal" rel-toggle="tooltip" class="btn btn_one quick-view-btn"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M21.71,20.29,18,16.61A9,9,0,1,0,16.61,18l3.68,3.68a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29ZM4,11a7,7,0,1,1,12,4.93h0s0,0,0,0A7,7,0,0,1,4,11Z"></path><path d="M14,10H12V8a1,1,0,0,0-2,0v2H8a1,1,0,0,0,0,2h2v2a1,1,0,0,0,2,0V12h2a1,1,0,0,0,0-2Z"></path></svg></button>
					</div>
					
					</a>
					</div>

					@endif
					{{-- LOOP ENDS --}}
				@endforeach
            </div>
            
            @if(isset($min) || isset($max))
			<div class="row">
    			<div class="col-md-12 text-center"> 
    			    {!! $products->appends(['min' => $min, 'max' => $max])->links() !!}               
    			</div>
			</div>
			@else
			<div class="row">
    			<div class="col-md-12 text-center"> 
    			    {!! $products->links() !!}               
    			</div>
			</div>
			@endif
          </div>
        </div>
      </div>
    </section>



	</div>
    <!-- Ending of product search area -->
@endsection

@section('scripts')
<script type="text/javascript">
	$(document).on("click", ".add_to_wish" , function(){
            var pid = $(this).data("pid"); //$("#pid").val();
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
	$('.removewish').click(function(){
			var pid = $(this).data("pid");
			
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

@endsection
@extends('layouts.front')

@section('content')

@php

$i=1;

$j=1;

@endphp





    <!-- Starting of product category area -->

	

	<div id="content" class="artistPage">

<section id="artist" class="">
<div class="container-fluid">
<div class="row justify-content-center">
<div class="col-12 p-3 text-center mb-0">
<div class="artistBox">
<div class="artist_coverImg">
<img class="d-block w-100" src="{{ $vendor->cover_photo ? asset('assets/images/'.$vendor->cover_photo):asset('assets/website/images/cover_artist.jpg')}}" alt="First slide">
</div>
<div class="artistContent">
<div class="artist_img">
<img src="{{ $vendor->photo ? asset('assets/images/'.$vendor->photo):asset('assets/website/images/artist.jpg')}}" alt="First slide">                  
</div>
<a href="#" class="btn btn_one share_btn"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.602 3.082a1 1 0 011.082.188l8 7.5a1 1 0 010 1.46l-8 7.5A1 1 0 0112 19v-3.635c-2.6.066-4.3.402-5.578 1.074-1.4.736-2.424 1.945-3.54 4.033A1 1 0 011 20.001c0-4.858 1.646-8.03 4.079-9.957C7.16 8.394 9.707 7.742 12 7.602V4a1 1 0 01.602-.918zM14 6.308v2.263a1 1 0 01-1 1c-2.271 0-4.769.526-6.679 2.04-1.24.982-2.296 2.433-2.867 4.574a8.2 8.2 0 012.038-1.517c1.88-.988 4.254-1.315 7.508-1.315a1 1 0 011 1v2.339l5.538-5.192L14 6.308z" fill="currentColor"></path></svg>Share</a>
<h4 class="heading_two">{{$vendor->shop_name}}</h4>
<ul class="artistDetail_list mt-1">
<li>Joined <?php $date=date_create($vendor->created_at); echo date_format($date,"F Y"); ?></li>
<li>{{$total_product}} designs</li>
<li><a href="#">View artist profile</a></li>
</ul>
</div> 
</div>
</div>
</div>
</div>
</section>

		<section id="shop_section" class="padding_tb20">

      <div class="container-fluid">

        <div class="row justify-content-center">

          <div class="col-12 col-md-4 col-lg-3 col-xl-2">

            <!--<h4 class="heading_three mb-4">{{$lang->doa}}</h4>-->

			@include('includes.catalog')

          </div>

          <div class="col-12 col-md-8 col-lg-9 col-xl-10">


            <div class="row">     

              <div class="col-8 col-md-7 col-lg-8 col-xl-9 align-self-center">

                <h4 class="heading_three">Stickers <span class="small">{{$total_product}} Results</span></h4>

              </div>

              <div class="col-4 col-md-5 col-lg-4 col-xl-3 align-self-center text-right">

					<select id="sortby" class="custom-select">

					@if($sort == "new")

					<option value="new" selected>{{$lang->doe}}</option>

					@else

					<option value="new">{{$lang->doe}}</option>

					@endif

					@if($sort == "old")

					<option value="old" selected>{{$lang->dor}}</option>

					@else

					<option value="old">{{$lang->dor}}</option>

					@endif

					@if($sort == "low")

					<option value="low" selected>{{$lang->dopr}}</option>

					@else

					<option value="low">{{$lang->dopr}}</option>

					@endif

					@if($sort == "high")

					<option value="high" selected>{{$lang->doc}}</option>

					@else

					<option value="high">{{$lang->doc}}</option>

					@endif

					</select>

              </div>

            </div>

            <div class="row product_list">   

		    	@foreach($vprods as $prod)

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

					@if(Auth::guard('user')->check())

					<span data-productid="{{$prod->id}}" class="wishlist hovertip uwish" rel-toggle="tooltip" title="{{$lang->wishlist_add}}"><i class="fa fa-heart"></i>

					<span class="wish-number">{{App\Wishlist::where('product_id','=',$prod->id)->get()->count() }}</span>

					</span>

					<button tabindex="-1"><i class="fa fa-heart-o" aria-hidden="true"></i></button>

					@else

					<span class="wishlist hovertip no-wish" data-toggle="modal" data-target="#loginModal" rel-toggle="tooltip" title="{{$lang->wishlist_add}}"><i class="fa fa-heart"></i>

					<span class="wish-number">{{App\Wishlist::where('product_id','=',$prod->id)->get()->count() }}</span>

					</span>

					<button tabindex="-1"><i class="fa fa-heart-o" aria-hidden="true"></i></button>

					@endif

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

					<button type="button" data-toggle="modal" data-productid="{{$prod->id}}" data-target="#myModal" rel-toggle="tooltip" class="btn btn_one wish-listt"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M21.71,20.29,18,16.61A9,9,0,1,0,16.61,18l3.68,3.68a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29ZM4,11a7,7,0,1,1,12,4.93h0s0,0,0,0A7,7,0,0,1,4,11Z"></path><path d="M14,10H12V8a1,1,0,0,0-2,0v2H8a1,1,0,0,0,0,2h2v2a1,1,0,0,0,2,0V12h2a1,1,0,0,0,0-2Z"></path></svg></button>

					

					</div>

					</a>



					</div>

					@endif

					@else                  

					<div class="col-6 col-sm-4 col-md-6 col-lg-4 col-xl-3 align-self-center">

					@php

					$name = str_replace(" ","-",$prod->name);

					@endphp

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

					

					@if(Auth::guard('user')->check())

					<span class="wishlist hovertip uwish" rel-toggle="tooltip" title="{{$lang->wishlist_add}}"><i class="fa fa-heart"></i>

					<span class="wish-number">{{App\Wishlist::where('product_id','=',$prod->id)->get()->count() }}</span>

					</span>

					<button tabindex="-1"><i class="fa fa-heart-o" aria-hidden="true"></i></button>

					@else

					<span class="wishlist hovertip no-wish" data-toggle="modal" data-target="#loginModal" rel-toggle="tooltip" title="{{$lang->wishlist_add}}"><i class="fa fa-heart"></i>

					<span class="wish-number">{{App\Wishlist::where('product_id','=',$prod->id)->get()->count() }}</span>

					</span>

					<button tabindex="-1"><i class="fa fa-heart-o" aria-hidden="true"></i></button>

					@endif

				

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

					<button type="button" data-toggle="modal" data-productid="{{$prod->id}}" data-target="#myModal" rel-toggle="tooltip" class="btn btn_one wish-listt"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M21.71,20.29,18,16.61A9,9,0,1,0,16.61,18l3.68,3.68a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29ZM4,11a7,7,0,1,1,12,4.93h0s0,0,0,0A7,7,0,0,1,4,11Z"></path><path d="M14,10H12V8a1,1,0,0,0-2,0v2H8a1,1,0,0,0,0,2h2v2a1,1,0,0,0,2,0V12h2a1,1,0,0,0,0-2Z"></path></svg></button>

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

					@if(Auth::guard('user')->check())

					<span class="wishlist hovertip uwish" rel-toggle="tooltip" title="{{$lang->wishlist_add}}"><i class="fa fa-heart"></i>

					<span class="wish-number">{{App\Wishlist::where('product_id','=',$prod->id)->get()->count() }}</span>

					</span>

					<button tabindex="-1"><i class="fa fa-heart-o" aria-hidden="true"></i></button>

					@else

					<span class="wishlist hovertip no-wish" data-toggle="modal" data-target="#loginModal" rel-toggle="tooltip" title="{{$lang->wishlist_add}}"><i class="fa fa-heart"></i>

					<span class="wish-number">{{App\Wishlist::where('product_id','=',$prod->id)->get()->count() }}</span>

					</span>

					<button tabindex="-1"><i class="fa fa-heart-o" aria-hidden="true"></i></button>

					@endif

					







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

					<button type="button" data-toggle="modal" data-productid="{{$prod->id}}" data-target="#myModal" rel-toggle="tooltip" class="btn btn_one wish-listt"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M21.71,20.29,18,16.61A9,9,0,1,0,16.61,18l3.68,3.68a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29ZM4,11a7,7,0,1,1,12,4.93h0s0,0,0,0A7,7,0,0,1,4,11Z"></path><path d="M14,10H12V8a1,1,0,0,0-2,0v2H8a1,1,0,0,0,0,2h2v2a1,1,0,0,0,2,0V12h2a1,1,0,0,0,0-2Z"></path></svg></button>

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

    			    {!! $vprods->appends(['min' => $min, 'max' => $max])->links() !!}               

    			</div>

			</div>

			@else

			<div class="row">

    			<div class="col-md-12 text-center"> 

    			    {!! $vprods->links() !!}               

    			</div>

			</div>

			@endif

          </div>

        </div>

      </div>

    </section>







    



	</div>

	

	

    <!-- Ending of product category area -->

@endsection



@section('scripts')

<script type="text/javascript">

        $("#sortby").change(function () {

        var sort = $("#sortby").val();

        window.location = "{{url('/artist')}}/{{$vendor->shop_url}}/"+sort;

    });

</script>





<script type="text/javascript">

            $("#ex2").slider({});

        $("#ex2").on("slide", function(slideRange) {

            var totals = slideRange.value;

            var value = totals.toString().split(',');

            $("#price-min").val(value[0]);

            $("#price-max").val(value[1]);

        });

</script>





@endsection
<section id="home_products" class="">
  <div class="container">

	<div class="row">
      <div class="col-12 align-self-center">
        <h2 class="heading_two">Top Rated Parts</h2>
      </div>
    </div>

    <div class="row product_list">

      <div class="col-12">

         <div class="explore_slider slider owl-carousel">
		@foreach($tproducts as $fprod)
		@php
		$name = str_replace(" ","-",$fprod->name);
		@endphp

          <div class="slide">


					<div class="card">
					<div class="card-body">
          <a href="{{route('front.page',['slug' => $fprod->slug])}}">
          <div class="card-img-actions"> <img src="{{asset('assets/images/'.$store_code.'/products/thumb_'.$fprod->photo)}}" class="card-img img-fluid" alt=""> </div>
          </a>
          <input type="hidden" value="{{$fprod->id}}">
					</div>
					<div class="card-body bg-light text-center">
					<div class="mb-2">
					<h6 class="font-weight-semibold mb-2"> <a href="{{route('front.page',['slug' => $fprod->slug])}}" class="text-default mb-2" data-abc="true">{{strlen($fprod->name) > 65 ? substr($fprod->name,0,65)."..." : $fprod->name}}</a> </h6>
					</div>
					@if($gs->sign == 0)
					<h4 class="mb-0 font-weight-semibold pricetxt">{{$curr->sign}}{{ number_format($fprod->cprice, 2) }}
					@if($fprod->pprice != 0)
					<del class="offer-price">{{$curr->sign}}{{round($fprod->pprice * $curr->value,2)}}</del>
					@endif
					</h4>
					@else
					<h4 class="mb-0 font-weight-semibold">
					{{round($fprod->cprice * $curr->value,2)}}
					@if($fprod->pprice != 0)
					<del class="offer-price">{{$curr->sign}}{{round($fprod->pprice * $curr->value,2)}}</del>
					@endif
					{{$curr->sign}}
					</h4>
					@endif

				@if($fprod->is_tier_price == 1)
				@php
				$tier_prices = json_decode($fprod->tier_prices,true);
				$total_t_prices = count($tier_prices);
				$lowestprice = min(array_column($tier_prices, 'price'));
				@endphp
					<div class="text-muted mb-3">As Low As: {{$curr->sign}}{{ number_format($lowestprice, 2) }}</div>
				@endif
        <div class="row nomargin">
        <div class="col-lg-6"><button type="button"  data-productid="{{$fprod->id}}" class="btn bg-cart addajaxcart btn160widht"><i class="fa fa-cart-plus mr-2"></i> Add to cart</button></div>
        <div class="col-lg-6"><button type="button"  data-productid="{{$fprod->id}}" data-productsku="{{$fprod->sku}}" data-productname="{{$fprod->name}}" class="btn bg-cart btn160widht enqbtn" data-toggle="modal" data-target="#InquiryModal"><i class="fa fa-info"></i> Enquire Now</button></div>
        </div>
        	</div>
					</div>

          </div>
		  @endforeach

        </div>
      </div>
    </div>
  </div>
</section>

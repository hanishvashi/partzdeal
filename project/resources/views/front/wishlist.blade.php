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
                <h4 class="heading_three mb-2">My Wishlists</h4>

              </div>
            </div>
            <div class="row">
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
          <div id="product_items_grid" class="row product_list">
		    	@foreach($wproducts as $prod)
					{{-- LOOP STARTS --}}
					<div class="col-6 col-sm-4 col-md-6 col-lg-4 col-xl-3 align-self-center">
					@php
					$name = str_replace(" ","-",$prod->name);
					@endphp
					@if(Auth::guard('user')->check())
					<button class="removewish" tabindex="-1"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
					@else
					<button class="removewish" tabindex="-1"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
					@endif

					<div class="card">
					<div class="card-body">
					<a href="{{route('front.page',['slug' => $prod->slug])}}">
					<div class="card-img-actions"> <img src="{{asset('assets/images/products/thumb_'.$prod->photo)}}" class="card-img img-fluid" alt=""> </div>
					</a>
					<input type="hidden" value="{{$prod->id}}">
					</div>
					<div class="card-body bg-light text-center">
					<div class="mb-2">
					<h6 class="font-weight-semibold mb-2"> <a href="{{route('front.page',['slug' => $prod->slug])}}" class="text-default mb-2" data-abc="true">{{strlen($prod->name) > 65 ? substr($prod->name,0,65)."..." : $prod->name}}</a> </h6>
					</div>
					@if($gs->sign == 0)
					<h4 class="mb-0 font-weight-semibold pricetxt">{{$curr->sign}}{{ number_format($prod->cprice, 2) }}
					@if($prod->pprice != 0)
					<del class="offer-price">{{$curr->sign}}{{round($prod->pprice * $curr->value,2)}}</del>
					@endif
					</h4>
					@else
					<h4 class="mb-0 font-weight-semibold">
					{{round($prod->cprice * $curr->value,2)}}
					@if($prod->pprice != 0)
					<del class="offer-price">{{$curr->sign}}{{round($prod->pprice * $curr->value,2)}}</del>
					@endif
					{{$curr->sign}}
					</h4>
					@endif

					@if($prod->is_tier_price == 1)
					@php
					$tier_prices = json_decode($prod->tier_prices,true);
					$total_t_prices = count($tier_prices);
					$lowestprice = min(array_column($tier_prices, 'price'));
					@endphp
					<div class="text-muted mb-3">As Low As: {{$curr->sign}}{{ number_format($lowestprice, 2) }}</div>
					@endif
					<button type="button"  data-productid="{{$prod->id}}" class="btn bg-cart addajaxcart"><i class="fa fa-cart-plus mr-2"></i> Add to cart</button>
					</div>
					</div>
					</div>
					{{-- LOOP ENDS --}}
				@endforeach
            </div>

            @if(isset($min) || isset($max))
			<div class="row">
    			<div class="col-md-12 text-center">
    			    {!! $wproducts->appends(['min' => $min, 'max' => $max])->links() !!}
    			</div>
			</div>
			@else
			<div class="row">
    			<div class="col-md-12 text-center">
    			    {!! $wproducts->links() !!}
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
            $("#ex2").slider({});
        $("#ex2").on("slide", function(slideRange) {
            var totals = slideRange.value;
            var value = totals.toString().split(',');
            $("#price-min").val(value[0]);
            $("#price-max").val(value[1]);
        });
</script>

<script type="text/javascript">
        $("#sortby").change(function () {
        var sort = $("#sortby").val();
        window.location = "{{url('/user/wishlists')}}/"+sort;
    });
</script>

<script type="text/javascript">
    $('.removewish').click(function(){
        $(this).parent().hide();
            var pid = $(this).parent().find('input[type=hidden]').val();
            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/removewish')}}",
                    data:{id:pid},
                    success:function(data){
        $.notify("{{$gs->wish_remove}}","success");
                      }
              });
        return false;
    });
</script>
@endsection

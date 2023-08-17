@extends('layouts.front')

@section('styles')

<style type="text/css">

	    .root.root--in-iframe {
      background: #4682b447 !important;
    }
</style>

@endsection



@section('content')

	<!-- Check Out Area Start -->
	<section class="checkout_page">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="checkout-area mb-0 pb-0">
						<div class="checkout-process">
							<ul class="nav"  role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="pills-step1-tab" data-toggle="pill" href="#pills-step1" role="tab" aria-controls="pills-step1" aria-selected="true">
									<span>1</span> Address
									<i class="fa fa-address-card"></i>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link disabled" id="pills-step2-tab" data-toggle="pill" href="#pills-step2" role="tab" aria-controls="pills-step2" aria-selected="false" >
										<span>2</span> Orders
										<i class="fa fa-shopping-cart"></i>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link disabled" id="pills-step3-tab" data-toggle="pill" href="#pills-step3" role="tab" aria-controls="pills-step3" aria-selected="false">
											<span>3</span> Payment
											<i class="fa fa-credit-card"></i>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>


				<div class="col-lg-8">




		<form id="" action="" method="POST" class="checkoutform">

			@include('includes.form-success')
			@include('includes.form-error')

			{{ csrf_field() }}

					<div class="checkout-area">
						<div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade show active" id="pills-step1" role="tabpanel" aria-labelledby="pills-step1-tab">
								<div class="content-box">

									<div class="content">
										<div class="personal-info">
											<h5 class="title">Personal Information :</h5>

  @if(!Auth::guard('user')->check())
		<div class="row">
		<div class="col-lg-4 mt-3">
		<input class="styled-checkbox" id="open-pass-guest" type="radio" checked value="guest" name="pass_check">
		<label for="open-pass-guest">Checkout as guest</label>
		</div>
		<div class="col-lg-4 mt-3">
		<input class="styled-checkbox" id="open-pass-login" type="radio" value="login" name="pass_check">
		<label for="open-pass-login">Login</label>
		</div>
		<div class="col-lg-4 mt-3">
		<input class="styled-checkbox" id="open-pass-signup" type="radio" value="signup" name="pass_check">
		<label for="open-pass-signup">Create an account</label>
		</div>
		</div>
@include('includes.ajax-login-form')

@include('includes.ajax-signup-form')
	@endif
	</div>
										<div class=" firstinfodetails billing-address">
											<h5 class="title">Billing Details</h5>
											<div class="row">
												<div class="col-lg-6 d-none">
													<select class="form-control" id="shipop" name="shipping" required="">
														<option value="shipto">Billing Address</option>
													</select>
												</div>

												<div class="col-lg-6 d-none" id="shipshow">
													<select class="form-control nice" name="pickup_location">
														@foreach($pickups as $pickup)
														<option value="{{$pickup->location}}">{{$pickup->location}}</option>
														@endforeach
													</select>
												</div>

												<div class="col-lg-6">
													<input class="form-control" type="text" name="name"
														placeholder="Full Name" required=""
														value="{{ Auth::guard('user')->check() ? Auth::guard('user')->user()->name : '' }}">
												</div>
												<div class="col-lg-6">
													<input class="form-control" type="text" onkeypress="return isNumberKey(event)" name="phone"
														placeholder="Phone Number" required=""
														value="{{ Auth::guard('user')->check() ? Auth::guard('user')->user()->phone : '' }}">
												</div>
												<div class="col-lg-6">
													<input class="form-control" type="email" name="email"
														placeholder="Email Address" required=""
														value="{{ Auth::guard('user')->check() ? Auth::guard('user')->user()->email : '' }}">
												</div>
												<div class="col-lg-12">
													<input class="form-control" type="text" name="address"
														placeholder="Address" required=""
														value="{{ Auth::guard('user')->check() ? Auth::guard('user')->user()->address : '' }}">
												</div>
												<div class="col-lg-6 mb-3">
													<select class="form-control" id="customer_country" name="customer_country" required="">
														@include('includes.countries')
													</select>
												</div>
												<div class="col-lg-6">
													<select class="form-control" name="customer_state" id="customer_state" required="">
														<option value="">Select State</option>
													</select>
												</div>
												<div class="col-lg-6">
													<input class="form-control" type="text" name="city"
														placeholder="City" required=""
														value="{{ Auth::guard('user')->check() ? Auth::guard('user')->user()->city : '' }}">
												</div>
												<div class="col-lg-6">
													<input class="form-control" type="text" name="zip"
														placeholder="Postal Code" required=""
														value="{{ Auth::guard('user')->check() ? Auth::guard('user')->user()->zip : '' }}">
												</div>
											</div>
										</div>
										<div class="firstinfodetails row {{ $digital == 1 ? 'd-none' : '' }}">
											<div class="col-lg-12 mt-3">
													<input class="styled-checkbox" id="ship-diff-address" type="checkbox" value="value1" >
													<label for="ship-diff-address">Ship to a Different Address?</label>
											</div>
										</div>
										<div class="ship-diff-addres-area d-none">
												<h5 class="title">Shipping Details</h5>
											<div class="row">
												<div class="col-lg-6">
													<input class="form-control ship_input" type="text" name="shipping_name"
														id="shippingFull_name" placeholder="Full Name">
														<input type="hidden" name="shipping_email" value="">
												</div>
												<div class="col-lg-6">
													<input onkeypress="return isNumberKey(event)" class="form-control ship_input" type="text" name="shipping_phone"
														id="shipingPhone_number" placeholder="Phone number">
												</div>
											</div>
											<div class="row">
												<div class="col-lg-12">
													<input class="form-control ship_input" type="text" name="shipping_address"
														id="shipping_address" placeholder="Address">
												</div>
											</div>
											<div class="row mb-3">
												<div class="col-lg-6">
													<select class="form-control ship_input" id="shipping_country" name="shipping_country">
														@include('includes.countries')
													</select>
												</div>
												<div class="col-lg-6">
													<select class="form-control" name="shipping_state" id="shipping_state" >
														<option value="">Select State</option>
													</select>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-6">
													<input class="form-control ship_input" type="text" name="shipping_city"
														id="shipping_city" placeholder="City">
												</div>
												<div class="col-lg-6">
													<input class="form-control ship_input" type="text" name="shipping_zip"
														id="shippingPostal_code" placeholder="Postal Code">
												</div>

											</div>

										</div>
										<div class="firstinfodetails order-note mt-3">
											<div class="row">
												<div class="col-lg-12">
												<input type="text" id="Order_Note" class="form-control" name="order_notes" placeholder="Order Notes">
												</div>
											</div>
										</div>
										<div class=" firstinfodetails row">
											<div class="col-lg-12  mt-3">
												<div class="bottom-area paystack-area-btn">
													<button type="submit"  class="button">Continue</button>
												</div>
											</div>
										</div>

									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="pills-step2" role="tabpanel" aria-labelledby="pills-step2-tab">
								<div class="content-box">
									<div class="content">

										<div class="order-area">
											@foreach($products as $product)
											<div class="order-item">
												<div class="product-img">
													<div class="d-flex">
														<img src=" {{ asset('assets/images/'.$store_code.'/products/'.$product['item']['photo']) }}"
															height="80" width="80" class="p-1">

													</div>
												</div>
												<div class="product-content">
													<p class="name"><a
															href="{{route('front.page',['slug' => $product['item']['slug']])}}"
															target="_blank">{{ $product['item']['name'] }}</a></p>
													<div class="unit-price">
														<h5 class="label">Price : </h5>
														<p>{{$curr->sign}}{{ number_format($product['itemprice'],2) }}</p>
													</div>

													@if(!empty($product['keys']))

													@foreach( array_combine(explode(',', $product['keys']), explode(',', $product['values']))  as $key => $value)

														<div class="quantity">
															<h5 class="label">{{ ucwords(str_replace('_', ' ', $key))  }} : </h5>
															<span class="qttotal">{{ $value }} </span>
														</div>
													@endforeach

													@endif
													<div class="quantity">
														<h5 class="label">Qty : </h5>
														<span class="qttotal">{{ $product['qty'] }} </span>
													</div>
													<div class="total-price">
														<h5 class="label">Total Price : </h5>
														<p>{{$curr->sign}}{{ number_format($product['price'],2) }}
														</p>
													</div>
												</div>
											</div>


											@endforeach

										</div>



										<div class="row">
											<div class="col-lg-12 mt-3">
												<div class="bottom-area">
													<a href="javascript:;" id="step1-btn"  class="button mr-3">Back</a>
													<a href="javascript:;" id="step3-btn"  class="button">Continue</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="pills-step3" role="tabpanel" aria-labelledby="pills-step3-tab">
								<div class="content-box">
									<div class="content">

			<div class="submit-loader">
				<img src="{{asset('assets/images/loading_large.gif')}}" alt="">
			</div>
											<div class="billing-info-area {{ $digital == 1 ? 'd-none' : '' }}">
															<h4 class="title">
																Billing Details
															</h4>
													<ul class="info-list">
														<li>
															<p id="shipping_user"></p>
														</li>
														<li>
															<p id="shipping_location"></p>
														</li>
														<li>
															<p id="shipping_phone"></p>
														</li>
														<li>
															<p id="shipping_email"></p>
														</li>
													</ul>
											</div>
											<?php if ($store_code=='partzdeal-india') {?>
												@include('load.payment-india')
											<?php }elseif($store_code=='partzdeal-australia'){?>
												@include('load.payment-australia')
											<?php }elseif($store_code=='partzdeal-usa'){?>
												@include('load.payment-usa')
											<?php }else{?>
												@include('load.payment-usa')
											<?php }?>

										<div class="row">
												<div class="col-lg-12 mt-3">
													<div class="bottom-area">

															<a href="javascript:;" id="step2-btn" class="button mr-3">Back</a>
															<button type="submit" id="final-btn" class="button">Submit</button>
													</div>

												</div>
											</div>
									</div>
								</div>
							</div>
						</div>
					</div>


                            <input type="hidden" id="shipping-cost" name="shipping_cost" value="0">
                            <input type="hidden" id="packing-cost" name="packing_cost" value="0">
                            <input type="hidden" name="dp" value="{{$digital}}">
                            <input type="hidden" name="tax" value="{{$gs->tax}}">
                            <input type="hidden" name="totalQty" value="{{$totalQty}}">

                            <input type="hidden" name="vendor_shipping_id" value="{{ $vendor_shipping_id }}">
                            <input type="hidden" name="vendor_packing_id" value="{{ $vendor_packing_id }}">


							@if(Session::has('coupon_total'))
                            	<input type="hidden" name="total" id="grandtotal" value="{{ $totalPrice }}">
                            	<input type="hidden" id="tgrandtotal" value="{{ $totalPrice }}">
							@elseif(Session::has('coupon_total1'))
								<input type="hidden" name="total" id="grandtotal" value="{{ preg_replace("/[^0-9,.]/", "", Session::get('coupon_total1') ) }}">
								<input type="hidden" id="tgrandtotal" value="{{ preg_replace("/[^0-9,.]/", "", Session::get('coupon_total1') ) }}">
							@else
                            	<input type="hidden" name="total" id="grandtotal" value="{{round($totalPrice * $curr->value,2)}}">
                            	<input type="hidden" id="tgrandtotal" value="{{round($totalPrice * $curr->value,2)}}">
							@endif


													<input type="hidden" name="shipping_method" id="shipping_method" value="">
                            <input type="hidden" name="coupon_code" id="coupon_code" value="{{ Session::has('coupon_code') ? Session::get('coupon_code') : '' }}">
                            <input type="hidden" name="coupon_discount" id="coupon_discount" value="{{ Session::has('coupon') ? Session::get('coupon') : '' }}">
                            <input type="hidden" name="coupon_id" id="coupon_id" value="{{ Session::has('coupon') ? Session::get('coupon_id') : '' }}">
                            <input type="hidden" name="user_id" id="user_id" value="{{ Auth::guard('user')->check() ? Auth::guard('user')->user()->id : '' }}">



</form>

				</div>

				@if(Session::has('cart'))
				<div class="col-lg-4">
					<div class="right-area">
						<div class="order-box">
						<h4 class="title">PRICE DETAILS</h4>
						<ul class="order-list">
							<li>
							<p>Total Cost</p>
							<P>
								<b
								class="cart-total">{{$curr->sign}}{{ Session::has('cart') ? number_format($totalPrice,2) : '0.00' }}</b>
							</P>
							</li>

							@if($gs->tax != 0)
							<li>
							<p>Tax</p>
							<P><b> {{$gs->tax}}% </b></P>
							</li>
							@endif




							@if(Session::has('coupon'))
							<li class="discount-bar">
							<p>
								{{ $lang->lang145 }} <span class="dpercent">{{ Session::get('coupon_percentage') == 0 ? '' : '('.Session::get('coupon_percentage').')' }}</span>
							</p>
							<P>
								@if($gs->currency_format == 0)
									<b id="discount">{{ $curr->sign }}{{ Session::get('coupon') }}</b>
								@else
									<b id="discount">{{ Session::get('coupon') }}{{ $curr->sign }}</b>
								@endif
							</P>
							</li>


												@else


							<li class="discount-bar d-none">
							<p>
								{{ $lang->lang145 }} <span class="dpercent"></span>
							</p>
							<P>
								<b id="discount">{{ $curr->sign }}{{ Session::get('coupon') }}</b>
							</P>
							</li>
								@endif
						</ul>

		            <div class="total-price">
		              <p>Total</p>
		              <p>
						@if(Session::has('coupon_total'))
							@if($gs->currency_format == 0)
								<span id="total-cost">{{ $curr->sign }}{{ $totalPrice }}</span>
							@else
								<span id="total-cost">{{ $totalPrice }}{{ $curr->sign }}</span>
							@endif

						@elseif(Session::has('coupon_total1'))
							<span id="total-cost">{{ $curr->sign }}{{ Session::get('coupon_total1') }}</span>
							@else
							<span id="total-cost">{{ $curr->sign }}{{ number_format($totalPrice,2) }}</span>
						@endif

		              </p>
		            </div>


						<div class="cupon-box">

							<div id="coupon-link">
							<img src="{{ asset('assets/front/images/tag.png') }}">
							Have a promotion code?
							</div>

						    <form id="check-coupon-form" class="coupon">
						        <input type="text" placeholder="Coupon Code" id="code" required="" autocomplete="off">
						        <button type="submit">Apply</button>
						    </form>


						</div>

						@if($digital == 0)

						{{-- Shipping Method Area Start --}}
						<?php if ($store_code=='partzdeal-india') {?>
							@include('load.india-shipping-method')
						<?php }elseif($store_code=='partzdeal-australia'){?>
							@include('load.aus-shipping-method')
						<?php }elseif($store_code=='partzdeal-usa'){?>
							@include('load.usa-shipping-method')
						<?php }elseif($store_code=='partzdeal-global'){ ?>
						    @include('load.usa-shipping-method')
						<?php } else{?>
							@include('load.india-shipping-method')
						<?php }?>
						{{-- Shipping Method Area End --}}



						{{-- Final Price Area Start--}}
						<div class="final-price">
							<span>Final Price :</span>
						@if(Session::has('coupon_total'))
							@if($gs->currency_format == 0)
								<span id="final-cost">{{ $curr->sign }}{{ number_format($totalPrice,2) }}</span>
							@else
								<span id="final-cost">{{ number_format($totalPrice,2) }}{{ $curr->sign }}</span>
							@endif

						@elseif(Session::has('coupon_total1'))
							<span id="final-cost">{{ $curr->sign }}{{ Session::get('coupon_total1') }}</span>
							@else
							<span id="final-cost">{{ $curr->sign }}{{ number_format($totalPrice,2) }}</span>
						@endif

						</div>
						{{-- Final Price Area End --}}

						@endif

{{-- 						<a href="{{ route('front.checkout') }}" class="order-btn mt-4">
							{{ $lang->lang135 }}
						</a> --}}
						</div>
					</div>
				</div>
				@endif
			</div>
		</div>
	</section>
		<!-- Check Out Area End-->

@if(isset($checked))



@endif

@endsection

@section('scripts')



<script type="text/javascript">
$(function () {
$("#customer_country").change();
$("#shipping_country").change();
});
	 
function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
$('#coupon-link').on('click', function(){
        $("#coupon-form,#check-coupon-form").toggle();
    });
	$('a.payment:first').addClass('active');
	$('.checkoutform').prop('action',$('a.payment:first').data('form'));
	$($('a.payment:first').attr('href')).load($('a.payment:first').data('href'));


		var show = $('a.payment:first').data('show');
		if(show != 'no') {
			$('.pay-area').removeClass('d-none');
		}
		else {
			$('.pay-area').addClass('d-none');
		}
	$($('a.payment:first').attr('href')).addClass('active').addClass('show');

	$('.submit-loader').hide();
</script>


<script type="text/javascript">

var coup = 0;
var pos = 0;

@if(isset($checked))

	$('#comment-log-reg1').modal('show');

@endif

var mship = $('.shipping').length > 0 ? $('.shipping').first().val() : 0;
var mpack = $('.packing').length > 0 ? $('.packing').first().val() : 0;

var shipping_method = $('.shipping').data('title');
mship = parseFloat(mship);
mpack = parseFloat(mpack);

$('#shipping-cost').val(mship);
$('#packing-cost').val(mpack);
var ftotal = parseFloat($('#grandtotal').val()) + mship + mpack;
ftotal = parseFloat(ftotal);
      if(ftotal % 1 != 0)
      {
        ftotal = ftotal.toFixed(2);
      }
		if(pos == 0){
			$('#final-cost').html('{{ $curr->sign }}'+ftotal+'.00')
		}
		else{
			$('#final-cost').html(ftotal+'{{ $curr->sign }}')
		}

$('#grandtotal').val(ftotal);
$('#shipping_method').val(shipping_method);

$('#shipop').on('change',function(){

	var val = $(this).val();
	if(val == 'pickup'){
		$('#shipshow').removeClass('d-none');
		$("#ship-diff-address").parent().addClass('d-none');
        $('.ship-diff-addres-area').addClass('d-none');
        $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',false);
	}
	else{
		$('#shipshow').addClass('d-none');
		$("#ship-diff-address").parent().removeClass('d-none');
        $('.ship-diff-addres-area').removeClass('d-none');
        $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',true);
	}

});


$('.shipping').on('click',function(){
	mship = $(this).val();
var shipping_method = $(this).data('title');
$('#shipping-cost').val(mship);
var ttotal = parseFloat($('#tgrandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
ttotal = parseFloat(ttotal);
      if(ttotal % 1 != 0)
      {
        ttotal = ttotal.toFixed(2);
      }
		if(pos == 0){
			$('#final-cost').html('{{ $curr->sign }}'+ttotal+'.00');
		}
		else{
			$('#final-cost').html(ttotal+'{{ $curr->sign }}');
		}

$('#grandtotal').val(ttotal);
$('#shipping_method').val(shipping_method);

})

$('.packing').on('click',function(){
	mpack = $(this).val();
$('#packing-cost').val(mpack);
var ttotal = parseFloat($('#tgrandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
ttotal = parseFloat(ttotal);
      if(ttotal % 1 != 0)
      {
        ttotal = ttotal.toFixed(2);
      }

		if(pos == 0){
			$('#final-cost').html('{{ $curr->sign }}'+ttotal);
		}
		else{
			$('#final-cost').html(ttotal+'{{ $curr->sign }}');
		}


$('#grandtotal').val(ttotal);

})

    $("#check-coupon-form").on('submit', function () {
        var val = $("#code").val();
        var total = $("#grandtotal").val();
        var ship = 0;
            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/coupon')}}",
                    data:{code:val, total:total, shipping_cost:ship},
                    success:function(data){
                        if(data == 0)
                        {
													$.notify("{{$gs->no_coupon}}","error");
													$("#code").val("");
                        }
                        else if(data == 2)
                        {
													$.notify("{{$gs->coupon_already}}","error");
													$("#code").val("");
                        }
                        else
                        {
													$("#coupon_code").val(data[1]);
                          $("#coupon_id").val(data[3]);
                          $("#coupon_discount").val(data[2]);
                          $("#discount").show("slow");
                          $("#ds").html(data[2]);
                          $("#ftotal").show("slow");
                          $("#sign").html(data[4]);
                          var x = $("#shipop").val();
                          var y = data[0];
                          $("#ft").html(y.toFixed(2));
                          $("#grandtotal").val(y);
                          $.notify("{{$gs->coupon_found}}","success");
                          $("#code").val("");
                          $("#coupon-click1").hide();
                          $("#coupon-click2").show();
                            $("#check-coupon-form").toggle();
                            $(".discount-bar").removeClass('d-none');

							if(pos == 0){
								$('#total-cost').html('{{ $curr->sign }}'+data[0]);
								$('#discount').html('{{ $curr->sign }}'+data[2]);
							}
							else{
								$('#total-cost').html(data[0]+'{{ $curr->sign }}');
								$('#discount').html(data[2]+'{{ $curr->sign }}');
							}
								$('#grandtotal').val(data[0]);
								$('#tgrandtotal').val(data[0]);
								$('#coupon_code').val(data[1]);
								$('#coupon_discount').val(data[2]);
								if(data[4] != 0){
								$('.dpercent').html('('+data[4]+')');
								}
								else{
								$('.dpercent').html('');
								}


var ttotal = parseFloat($('#grandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
ttotal = parseFloat(ttotal);
      if(ttotal % 1 != 0)
      {
        ttotal = ttotal.toFixed(2);
      }

		if(pos == 0){
			$('#final-cost').html('{{ $curr->sign }}'+ttotal)
		}
		else{
			$('#final-cost').html(ttotal+'{{ $curr->sign }}')
		}

                        //	toastr.success(lang.coupon_found);
                            $("#code").val("");
                        }
                      }
              });
              return false;
    });

// Password Checking

$("input[type=radio][name=pass_check]").on( "change", function() {
	if(this.value=='guest')
	{
		$('.signup_form').addClass('d-none');
		$('.login_form').addClass('d-none');
		$(".firstinfodetails").show();
		$('.set-account-pass').addClass('d-none');
		$('.set-account-pass input').prop('required',false);
		$('#personal-email').prop('required',false);
		$('#personal-name').prop('required',false);
	}else if(this.value=='login')
	{
		$('.signup_form').addClass('d-none');
			$('.login_form').removeClass('d-none');
		$(".firstinfodetails").hide();
		$('.set-account-pass').addClass('d-none');
		$('.set-account-pass input').prop('required',false);
		$('#personal-email').prop('required',false);
		$('#personal-name').prop('required',false);
	}else if(this.value=='signup'){
$('.signup_form').removeClass('d-none');
			$('.login_form').addClass('d-none');
		$(".firstinfodetails").hide();
		$('.set-account-pass').removeClass('d-none');
		$('.set-account-pass input').prop('required',true);
		$('#personal-email').prop('required',true);
		$('#personal-name').prop('required',true);
	}

});
function isEmpty(str){
		return !str.replace(/\s+/, '').length;
}
$(document).on("click", "#customer_login" , function(){
	var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	var user_email_address = $("#user_email_address").val();
	var user_password = $("#user_password").val();
	 if(isEmpty(user_email_address) || isEmpty(user_password))
	 {
		 $.notify("Please enter email address and password","error");
	 }else if(!regex.test(user_email_address))
	 {
		 $.notify("Invalid email address","error");
	 }
	 else
	 {
			 $.ajax({
							 type: "GET",
							 url:"{{URL::to('/user/loginajax')}}",
							 data:{user_email_address:user_email_address,user_password:user_password},
							 success:function(result){
								 console.log(result);
									 if(result.status==false)
									 {
										 $.notify(result.message,"error");
									 }else{
											$.notify(result.message,"success");
											location.reload();
									 }
								 }
				 });
	 }
});

$(document).on("click", "#customer_Signup" , function(){
	var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	var user_email_address = $("#personal-email").val();
	var user_password = $("#personal-pass").val();
	var user_confirm_password = $("#personal-pass-confirm").val();
	var personalname = $("#personal-name").val();
	 if(isEmpty(user_email_address) || isEmpty(user_password) || isEmpty(user_confirm_password) || isEmpty(personalname))
	 {
		 $.notify("Please fill all fields","error");
	 }else if(!regex.test(user_email_address))
	 {
		 $.notify("Invalid email address","error");
	 }else if(user_password !== user_confirm_password)
	 {
		 $.notify("Confirm Password Doesn't Match.","error");
	 }
	 else
	 {
			 $.ajax({
							 type: "GET",
							 url:"{{URL::to('/user/registerajax')}}",
							 data:{personal_email:user_email_address,personal_pass:user_password,personal_confirm:user_confirm_password,personal_name:personalname},
							 success:function(result){
								 console.log(result);
									 if(result.status==false)
									 {
										 $.notify(result.message,"error");
									 }else{
											$.notify(result.message,"success");
											location.reload();
									 }
								 }
				 });
	 }
});

// Password Checking Ends


// Shipping Address Checking

		$("#ship-diff-address").on( "change", function() {
            if(this.checked){
             $('.ship-diff-addres-area').removeClass('d-none');
             $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',true);
            }
            else{
             $('.ship-diff-addres-area').addClass('d-none');
             $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',false);
            }

        });


// Shipping Address Checking Ends


</script>


<script type="text/javascript">

var ck = 0;

	$('.checkoutform').on('submit',function(e){
		if(ck == 0) {
			e.preventDefault();
		$('#pills-step2-tab').removeClass('disabled');
		$('#pills-step2-tab').click();

	}else {
		$('#preloader').show();
	}
	$('#pills-step1-tab').addClass('active');
	});

	$('#step1-btn').on('click',function(){
		$('#pills-step1-tab').removeClass('active');
		$('#pills-step2-tab').removeClass('active');
		$('#pills-step3-tab').removeClass('active');
		$('#pills-step2-tab').addClass('disabled');
		$('#pills-step3-tab').addClass('disabled');

		$('#pills-step1-tab').click();

	});

// Step 2 btn DONE

	$('#step2-btn').on('click',function(){
		$('#pills-step3-tab').removeClass('active');
		$('#pills-step1-tab').removeClass('active');
		$('#pills-step2-tab').removeClass('active');
		$('#pills-step3-tab').addClass('disabled');
		$('#pills-step2-tab').click();
		$('#pills-step1-tab').addClass('active');

	});

	$('#step3-btn').on('click',function(){
	 	if($('a.payment:first').data('val') == 'paystack'){
			$('.checkoutform').prop('id','step1-form');
		}
		else {
			$('.checkoutform').prop('id','');
		}
		$('#pills-step3-tab').removeClass('disabled');
		$('#pills-step3-tab').click();

		var shipping_user  = !$('input[name="shipping_name"]').val() ? $('input[name="name"]').val() : $('input[name="shipping_name"]').val();
		var shipping_location  = !$('input[name="shipping_address"]').val() ? $('input[name="address"]').val() : $('input[name="shipping_address"]').val();
		var shipping_zipcode  = !$('input[name="shipping_zip"]').val() ? $('input[name="zip"]').val() : $('input[name="shipping_zip"]').val();
		var shipping_city  = !$('input[name="shipping_city"]').val() ? $('input[name="city"]').val() : $('input[name="shipping_city"]').val();
		var shipping_state  = !$('#shipping_state').val() ? $('#customer_state').val() : $('#shipping_state').val();
		var shipping_country  = !$('#shipping_country').val() ? $('#customer_country').val() : $('#shipping_country').val();
		var shipping_phone = !$('input[name="shipping_phone"]').val() ? $('input[name="phone"]').val() : $('input[name="shipping_phone"]').val();
		var shipping_email= !$('input[name="shipping_email"]').val() ? $('input[name="email"]').val() : $('input[name="shipping_email"]').val();

		$('#shipping_user').html('<i class="fa fa-user"></i>'+shipping_user);
		$('#shipping_location').html('<i class="fa fa-map-marker"></i>'+shipping_location+', '+shipping_city+' '+shipping_zipcode+', '+shipping_state+' '+shipping_country);
		$('#shipping_phone').html('<i class="fa fa-phone"></i>'+shipping_phone);
		$('#shipping_email').html('<i class="fa fa-envelope"></i>'+shipping_email);

		$('#pills-step1-tab').addClass('active');
		$('#pills-step2-tab').addClass('active');
	});

	$('#final-btn').on('click',function(){
		ck = 1;
	})


	$('.payment').on('click',function(){

      //$('.submit-loader').show();
		if($(this).data('val') == 'paystack'){
			$('.checkoutform').prop('id','step1-form');
		}
		else {
			$('.checkoutform').prop('id','');
		}
		$('.checkoutform').prop('action',$(this).data('form'));
		$('.pay-area #v-pills-tabContent .tab-pane.fade').not($(this).attr('href')).html('');
		var show = $(this).data('show');
		if(show != 'no') {
			$('.pay-area').removeClass('d-none');
		}
		else {
			$('.pay-area').addClass('d-none');
		}
		$($(this).attr('href')).load($(this).data('href'), function() {
            $('.submit-loader').hide();
        });


	})


        $(document).on('submit','#step1-form',function(){
        	$('#preloader').hide();
            var val = $('#sub').val();
            var total = $('#grandtotal').val();
			total = Math.round(total);
                if(val == 0)
                {
                var handler = PaystackPop.setup({
                  key: '{{$gs->paystack_key}}',
                  email: $('input[name=email]').val(),
                  amount: total * 100,
                  currency: "{{$curr->name}}",
                  ref: ''+Math.floor((Math.random() * 1000000000) + 1),
                  callback: function(response){
                    $('#ref_id').val(response.reference);
                    $('#sub').val('1');
                    $('#final-btn').click();
                  },
                  onClose: function(){
                  	window.location.reload();

                  }
                });
                handler.openIframe();
                    return false;
                }
                else {
                	$('#preloader').show();
                    return true;
                }
        });

			$('#customer_country').on('change', function() {
				var country_name = this.value;
						$("#quick-details").html('');
								$.ajax({
												type: "GET",
												url:"{{URL::to('/ajax-get-states/')}}",
												data:{cname:country_name},
												success:function(response){
														$("#customer_state").html(response);
														}

													});
						return false;
				});
				$('#shipping_country').on('change', function() {
					var country_name = this.value;
							$("#quick-details").html('');
									$.ajax({
													type: "GET",
													url:"{{URL::to('/ajax-get-states/')}}",
													data:{cname:country_name},
													success:function(response){
															$("#shipping_state").html(response);
															}

														});
							return false;
					});


</script>





@endsection

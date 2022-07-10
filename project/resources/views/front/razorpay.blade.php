@extends('layouts.front')
@section('content')
<style>
.razorpay-payment-button{
  display: none;
}
</style>
<div class="section-padding product-checkOut-wrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
				 <h1 class="signIn-title">Proceed for Payment</h1>
         <h2 class="signIn-title">Please do not refresh or back the page</h2>
				</div>
			</div>

			<div class="row justify-content-center">

                 <div class="col-12 col-md-8 col-lg-6 text-center">

                     <div class="card">
<form action="{{route('razorpay.verifypayment')}}" method="POST">
{{csrf_field()}}
  <script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key="{{ $paymentdata['key'] }}"
	data-amount="{{ $paymentdata['amount'] }}"
    data-currency="INR"
    data-name="<?php echo $paymentdata['name']?>"
    data-name="{{ $paymentdata['name'] }}"
	data-description="{{ $paymentdata['description'] }}"
    data-prefill.name="{{ $paymentdata['prefill']['name'] }}"
    data-prefill.email="{{ $paymentdata['prefill']['email'] }}"
    data-prefill.contact="{{ $paymentdata['prefill']['contact'] }}"
    data-notes.shopping_order_id="<?php echo $item_number;?>"
    data-order_id="{{ $paymentdata['razorpay_order_id'] }}"
  >
  </script>
  <!-- Any extra fields to be submitted with the form but not sent to Razorpay -->
  <input type="hidden" name="order_number" value="<?php echo $item_number;?>">
  <input type="hidden" name="order_id" value="<?php echo $order_id;?>">
  <input type="hidden" name="coupon_id" value="<?php echo $coupon_id;?>">
</form>

<a href="{{route('front.checkout')}}" class="update-shopping-btn">Go to checkout</a>

</div></div></div>

		</div>
</div>

@endsection
@section('scripts')
<script>
jQuery(document).ready(function($)
{

jQuery('.razorpay-payment-button').click();
});
</script>

@endsection

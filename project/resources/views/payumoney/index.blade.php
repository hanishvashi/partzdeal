@extends('layouts.front')
@section('content')
<div class="section-padding product-shoppingCart-wrapper pb-0">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <div class="view-cart-title">
          <!--<a style="color:black;" href="{{route('front.index')}}">{{ucfirst(strtolower($lang->home))}}</a>-->
          <!--<i class="fa fa-angle-right"></i>-->
          <!--<a style="color:black;" href="{{route('front.cart')}}">{{ucfirst(strtolower($lang->fht))}}</a>-->
          <h4>Your Payment</h4>
        </div>
      </div>
      <div class="col-md-12 col-sm-12">
        <form action="{{$action}}" method="post" id="payuForm" name="payuForm"><br />
            <input type="hidden" name="key" value="{{$MERCHANT_KEY}}" /><br />
            <input type="hidden" name="hash" value="{{$hash}}"/><br />
            <input type="hidden" name="txnid" value="{{$txnid}}" /><br />
            <input type="hidden" name="amount" value="{{$total_amount}}" /><br />
            <input type="hidden" name="firstname" id="firstname" value="{{$full_name}}" /><br />
            <input type="hidden" name="email" id="email" value="{{$user_email}}" /><br />
            <input type="hidden" name="productinfo" value="{{$item_name}}"><br />
            <input type="hidden" name="surl" value="{{$surl}}" /><br />
            <input type="hidden" name="furl" value="{{$furl}}" /><br />
            <input type="hidden" name="service_provider" value="payu_paisa"  />
            <input type="hidden" name="udf1" value="{{$order_id}}" />
            <?php
            if(!$hash) { ?>
                <input type="submit" value="Submit" />
            <?php } ?>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
           payuForm.submit();
    }
    document.getElementById("payuForm").submit();
  </script>
@endsection

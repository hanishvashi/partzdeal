<div class="payment-information">
  <h4 class="title">Payment Info</h4>
  <div class="row">

    <div class="col-lg-12">
      <div class="nav flex-column"  role="tablist" aria-orientation="vertical">
          @if($totalPrice<=5000)
        <a class="nav-link payment" data-val="" data-show="no" data-form="{{route('payu.submit')}}" data-href="{{ route('front.load.payment',['slug1' => 'payu','slug2' => 0]) }}" id="v-pills-tab1-tab" data-toggle="pill" href="#v-pills-tab1" role="tab" aria-controls="v-pills-tab1" aria-selected="true">
        <div class="icon"><span class="radio"></span></div>
        <p>PayuMoney <small></small></p>
        </a>
        {{--
        <a class="nav-link payment" data-val="" data-show="no" data-form="{{route('cash.submit')}}" data-href="{{ route('front.load.payment',['slug1' => 'cod','slug2' => 0]) }}" id="v-pills-tab2-tab" data-toggle="pill" href="#v-pills-tab2" role="tab" aria-controls="v-pills-tab2" aria-selected="true">
        <div class="icon"><span class="radio"></span></div>
        <p>Cash on Delivery <small></small></p>
        </a> --}}
          @else
          <a class="nav-link payment" data-val="" data-show="no" data-form="{{route('payu.submit')}}" data-href="{{ route('front.load.payment',['slug1' => 'payu','slug2' => 0]) }}" id="v-pills-tab1-tab" data-toggle="pill" href="#v-pills-tab1" role="tab" aria-controls="v-pills-tab1" aria-selected="true">
          <div class="icon"><span class="radio"></span></div>
          <p>PayuMoney <small></small></p>
          </a>
          @endif
      </div>
    </div>

  </div>
</div>

<div class="payment-information">
  <h4 class="title">Payment Info</h4>
  <div class="row">
    <div class="col-lg-12">
      <div class="nav flex-column"  role="tablist" aria-orientation="vertical">
      @if($gs->paypal_check == 1)
        <a class="nav-link payment" data-val="" data-show="no" data-form="{{route('paypal.submit')}}" data-href="{{ route('front.load.payment',['slug1' => 'paypal','slug2' => 0]) }}" id="v-pills-tab1-tab" data-toggle="pill" href="#v-pills-tab1" role="tab" aria-controls="v-pills-tab1" aria-selected="true">
        <div class="icon"><span class="radio"></span></div>
        <p>PayPal Express@if($gs->paypal_text != null)<small>{{ $gs->paypal_text }}</small>@endif</p>
        </a>
      @endif
      </div>
    </div>

    <div class="col-lg-12">
      <div class="pay-area d-none">
      <div class="tab-content" id="v-pills-tabContent">
        @if($gs->paypal_check == 1)
        <div class="tab-pane fade" id="v-pills-tab1" role="tabpanel" aria-labelledby="v-pills-tab1-tab">
        </div>
        @endif
    @if($digital == 0)
      @foreach($gateways as $gt)
        <div class="tab-pane fade" id="v-pills-tab{{ $gt->id }}" role="tabpanel" aria-labelledby="v-pills-tab{{ $gt->id }}-tab">
        </div>
      @endforeach
    @endif
    </div>
      </div>
    </div>
  </div>
</div>

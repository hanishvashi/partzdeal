<div class="packeging-area">
    <h4 class="title">Shipping Methods</h4>
  @foreach($shipping_data as $data)
  <?php if($data->carrier_title=='Standard'){
    $fixedShipping	= $data->shipping_price;
    $shippingPer = $data->shipping_percentage;
      if($totalPrice<300){
        $shippingCharge = $fixedShipping;
      $shippingChargeInEuro = $shippingCharge;
      }else{
      //add shipping price as free for order above 300
      $shippingChargeInEuro = 0;
      }

    ?>
    <div class="radio-design">
        <input type="radio" class="shipping" data-id="{{ $data->id }}" data-title="{{ $data->carrier_title }}" id="free-shepping-{{ $data->id }}" name="shipping" value="{{ round($shippingChargeInEuro * $curr->value,2) }}" {{ ($loop->first) ? 'checked' : '' }}>
        <span class="checkmark"></span>
        <label for="free-shepping-{{ $data->id }}">
            {{ $data->carrier_title }}
            @if($shippingChargeInEuro != 0)
            + {{ $curr->sign }}{{ round($shippingChargeInEuro * $curr->value,2) }}
            @else
            {{ $curr->sign }}{{ round($shippingChargeInEuro * $curr->value,2) }}
            @endif
            <small>{{ $data->shipping_text }}</small>
        </label>
    </div>
  <?php }elseif($data->carrier_title=='Priority'){
    $fixedShipping	= $data->shipping_price;
    $shippingPer = $data->shipping_percentage;
      if($totalPrice<50){
      $shippingCharge = ceil(($totalPrice*$shippingPer)/100);
      if($shippingCharge < $fixedShipping) {
      $shippingCharge = $fixedShipping;
       }
      $shippingChargeInEuro = $shippingCharge;
      }else{
        $shippingCharge = ceil(($totalPrice*$shippingPer)/100);
        //add shipping price as free for order above 50
        $shippingChargeInEuro = $shippingCharge;
      }
    ?>
    <div class="radio-design">
        <input type="radio" data-id="{{ $data->id }}" class="shipping" id="free-shepping-{{ $data->id }}" data-title="{{ $data->carrier_title }}" name="shipping" value="{{ round($shippingChargeInEuro * $curr->value,2) }}" {{ ($loop->first) ? 'checked' : '' }}>
        <span class="checkmark"></span>
        <label for="free-shepping-{{ $data->id }}">
            {{ $data->carrier_title }}
            @if($shippingChargeInEuro != 0)
            + {{ $curr->sign }}{{ round($shippingChargeInEuro * $curr->value,2) }}
            @else
            {{ $curr->sign }}{{ round($shippingChargeInEuro * $curr->value,2) }}
            @endif
            <small>{{ $data->shipping_text }}</small>
        </label>
    </div>
  <?php }?>

  @endforeach

</div>

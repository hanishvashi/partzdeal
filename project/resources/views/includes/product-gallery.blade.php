<div class="slider slider-for-mainphoto">
<figure class="view overlay rounded z-depth-1 main-img">
<div class="gal-item" data-src="{{filter_var($product->photo, FILTER_VALIDATE_URL) ?$product->photo:asset('assets/images/'.$store_code.'/products/'.$product->photo)}}">
<img class="img-fluid z-depth-1" src="{{filter_var($product->photo, FILTER_VALIDATE_URL) ?$product->photo:asset('assets/images/'.$store_code.'/products/'.$product->photo)}}" />
</div>
</figure>
<?php
if(!$product->galleries->isEmpty())
{
?>
@foreach($product->galleries as $gal)
<figure class="view overlay rounded z-depth-1 main-img">
<div class="gal-item" data-src="{{filter_var($gal->photo, FILTER_VALIDATE_URL) ?$gal->photo:asset('assets/images/'.$store_code.'/products/gallery/'.$gal->photo)}}">
<img class="img-fluid" src="{{filter_var($gal->photo, FILTER_VALIDATE_URL) ?$gal->photo:asset('assets/images/'.$store_code.'/products/gallery/'.$gal->photo)}}" />
</div>
</figure>
@endforeach
<?php }?>

</div>

<div class="slider slider-nav-smallphoto">
<div class="sm-gal-item">
<a href="javascript:void(0)">
<img class="" width="80" src="{{filter_var($product->photo, FILTER_VALIDATE_URL) ?$product->photo:asset('assets/images/'.$store_code.'/products/'.$product->photo)}}" title="The description goes here">
</a>
</div>
<?php
if(!$product->galleries->isEmpty())
{
?>
@foreach($product->galleries as $gal)
<div class="sm-gal-item">
<a href="javascript:void(0)">
<img width="80" src="{{asset('assets/images/'.$store_code.'/products/gallery/'.$gal->photo)}}" title="The description goes here">
</a>
</div>
@endforeach
<?php }?>
</div>

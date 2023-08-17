@if($gs->slider == 1)
    <!--  Starting of homepage carousel area   -->
<section id="home_silder" class="d-none">
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
@php
$i=1;
@endphp
<!-- Indicators -->
<!--<ol class="carousel-indicators">-->
<!--<li data-target="#bootstrap-touch-slider" data-slide-to="0" class="active"></li>-->
<!--@foreach($sliders as $sld)-->
<!--<li data-target="#bootstrap-touch-slider" data-slide-to="{{$i++}}" class=""></li>-->
<!--@endforeach-->
<!--</ol>-->
<!-- Wrapper For Slides -->
<div class="carousel-inner">
<div class="carousel-item active">
<img class="carousel_img d-block w-100" src="{{asset('assets/images/'.$sls->photo)}}" alt="First slide">
</div>


@foreach($sliders as $slider)
<div class="carousel-item">
<img class="carousel_img d-block w-100" src="{{asset('assets/images/'.$slider->photo)}}" alt="First slide">
</div>
@endforeach
<!-- End of Slide -->
</div><!-- End of Wrapper For Slides -->
</div>
</section>
    <!--  Ending of homepage carousel area   -->
@endif

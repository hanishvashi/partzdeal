@extends('layouts.front')
@section('title'){{$gs->title}} @endsection
@section('meta_description')
<meta name="description" content="{{$gs->title}}">
@endsection
@section('meta_tag')
<meta name="keywords" content="{{ $seo->meta_keys }}">
@endsection

@section('content')
    <style type="text/css">
        @media only screen and (max-width: 767px) {
            @php
                $title_size = $sls->title_size*.5;
                $desc_size = $sls->desc_size*.5;

                if ($desc_size <12){
                    $desc_size = 12;
                }

                if ($title_size <12){
                    $title_size = 12;
                }
            @endphp

            .slider-title-style{{$sls->id}} {
                font-size: {{$title_size}}px !important;
            }

            .slider-text-style{{$sls->id}} {
                font-size: {{$desc_size}}px !important;
            }
        @php
            foreach ($sliders as $slider){
                $title_size = $slider->title_size*.5;
                $desc_size = $slider->desc_size*.5;

                if ($desc_size <12){
                    $desc_size = 12;
                }

                if ($title_size <12){
                    $title_size = 12;
                }

                echo "
                .slider-title-style".$slider->id."{
                    font-size:".$title_size."px!important;
                }

                .slider-text-style".$slider->id."{
                    font-size:".$desc_size."px!important;
                }
                ";
            }
        @endphp
}
        @media only screen and (min-width: 768px) and (max-width: 991px) {

            .slider-title-style{{$sls->id}} {
                font-size: {{$sls->title_size*.7}}px !important;
            }

            .slider-text-style{{$sls->id}} {
                font-size: {{$sls->desc_size*.7}}px !important;
            }

        @php
            foreach ($sliders as $slider){
                $title_size = $slider->title_size*.7;
                $desc_size = $slider->desc_size*.7;
                echo "
                .slider-title-style".$slider->id."{
                    font-size:".$title_size."px!important;
                }

                .slider-text-style".$slider->id."{
                    font-size:".$desc_size."px!important;
                }
                ";
            }
        @endphp
}

        @media only screen and (min-width: 992px) {
            .slider-title-style{{$sls->id}} {
                font-size: {{$sls->title_size}}px !important;
            }
            .slider-text-style{{$sls->id}} {
                font-size: {{$sls->desc_size}}px !important;
            }
            @php
                foreach ($sliders as $slider){
                    echo "
                    .slider-title-style".$slider->id."{
                        font-size:".$slider->title_size."px!important;
                    }
                    .slider-text-style".$slider->id."{
                        font-size:".$slider->desc_size."px!important;
                    }
                    ";
                }
            @endphp
        }
    </style>
<div id="content">

<section class="padding_tb20">
            <div class="container-fluid">
            <div class="row">
             <div class="col-12 col-md-4 col-lg-3 col-xl-3">
                @include('includes.home-brand-filter')
              	@include('includes.home-catalog')
              </div>

                <div class="col-12 col-md-8 col-lg-9 col-xl-9">
                  @include('includes.banner-slider')
                	@include('front.extraindex')
                </div>

              </div>




    <!--section id="extraData">

    </section-->
</div>
</section>
</div>
@endsection

@section('scripts')



    <script type="text/javascript">

        $(document).ready(function(){

          $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      });

       $(".product_slider").owlCarousel({
                items: 3,
                autoplay: true,
                margin: 30,
                loop: true,
                dots: true,
                nav: true,

                navText: ["<button type='button' data-role='none' class='slick-prev slick-arrow' aria-label='Previous' role='button' style=''>Previous</button>", "<button type='button' data-role='none' class='slick-next slick-arrow' aria-label='Next' role='button' style=''>Next</button>"],
                smartSpeed: 800,
                responsive : {
                  0 : {
              		items: 1,
              		},
                  420 : {
              		items: 2,
              		},
              		768 : {
              		items: 3,
              		},
              		992 : {
              		items: 3
              		},
              		1200 : {
              		items: 3
              		}
                }
            });

    		$(".explore_slider").owlCarousel({
    		items: 3,
    		autoplay: true,
    		margin: 30,
    		loop: true,
    		dots: true,
    		nav: true,

    		navText: ["<button type='button' data-role='none' class='slick-prev slick-arrow' aria-label='Previous' role='button' style=''>Previous</button>", "<button type='button' data-role='none' class='slick-next slick-arrow' aria-label='Next' role='button' style=''>Next</button>"],
    		smartSpeed: 800,
    		responsive : {
    		0 : {
    		items: 1,
    		},
        420 : {
    		items: 2,
    		},
    		768 : {
    		items: 3,
    		},
    		992 : {
    		items: 3
    		},
    		1200 : {
    		items: 3
    		}
    		}
    		});

    		$(".fan_slider").owlCarousel({
    		items: 4,
    		/*autoplay: true,*/
    		margin: 30,
    		loop: true,
    		dots: true,
    		nav: true,

    		navText: ["<button type='button' data-role='none' class='slick-prev slick-arrow' aria-label='Previous' role='button' style=''>Previous</button>", "<button type='button' data-role='none' class='slick-next slick-arrow' aria-label='Next' role='button' style=''>Next</button>"],
    		smartSpeed: 800,
    		responsive : {
    		0 : {
    		items: 1,
    		},
    		768 : {
    		items: 2,
    		},
    		992 : {
    		items: 3
    		},
    		1200 : {
    		items: 4
    		}
    		}
    		});

    });

    </script>

@endsection

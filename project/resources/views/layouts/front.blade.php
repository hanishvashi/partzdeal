<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Partzdeal">
    <!--title>{{$gs->title}}</title-->
    <title>@yield('title')</title>
    @yield('meta_description')
    @yield('meta_tag')
    <!-- Font Awesome CSS -->
<!--style type="text/css">
    @import url('https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Rubik:300,400,500,700,900');
</style-->
<link href="https://fonts.googleapis.com/css2?family=Metrophobic&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="{{asset('assets/front/css/bootstrap-slider.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/front/css/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/front/css/owl.theme.default.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/website/css/style.css')}}">

<link rel="stylesheet" href="{{asset('assets/website/css/mobile-menu.css')}}">
<link rel="stylesheet" href="{{asset('assets/website/css/mmenu-light.css')}}">
<link rel="stylesheet" href="{{asset('assets/website/slick/slick.css')}}">
<link rel="stylesheet" href="{{asset('assets/website/css/animate.css')}}">
<link rel="stylesheet" href="{{asset('assets/website/lightbox/css/lightgallery.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/website/css/custom.css')}}">
<link rel="stylesheet" href="{{asset('assets/website/css/product-slider.css')}}">
<link rel="stylesheet" href="{{asset('assets/website/css/checkout.css')}}">
<link href="https://fonts.googleapis.com/css2?family=Questrial&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<!--link rel="stylesheet" href="{{asset('assets/front/css/all.css')}}"-->
<link rel="icon" type="image/png" href="{{asset('assets/images/'.$gs->favicon)}}">

    @include('styles.design')

    @yield('styles')

    <style type="text/css">
        .home-service-wrapper {
            box-shadow: 0 0 5px #fff;
        }
    </style>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-ZRG7YBWE21"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-ZRG7YBWE21');
</script>
</head>
<body id="sidebar-cart-curtain">
  <div id="cartoverlay" class=""><div class="ajaxloadermodal"></div></div>
    <!--  Starting of header area   -->
    <header class="header_area">
		<div class="top_bar d-none d-lg-block">
    		<div class="container-fluid">
    		<div class="row">
          <div class="col-sm-6 text-left">
<h6>Email us on : <a href="mailto:support@partzdeal.com">support@partzdeal.com</a></h6>
          </div>
    		<div class="col-sm-6 text-right">
    		<ul class="top_links m-0 p-0">

    		@if(Auth::guard('user')->check())
				<?php
				$userinfo = Auth::guard('user')->user();
				?>
				<li id="myaccountdrop" class="nav-item p-0">
				<button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false"><span class="fa fa-user"></span></button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item" href="{{route('customer-profile')}}">My Account</a>
				<a class="dropdown-item" href="{{route('customer-reset')}}">{{$lang->reset}}</a>
				<a class="dropdown-item" href="{{route('customer-orders')}}">My Orders</a>
				<a class="dropdown-item" href="{{route('user-logout')}}">Logout</a>
				</ul>
				</li>
    		@else
    		<li><a style="cursor: pointer;" data-toggle="modal" data-target="#loginModal">Login</a></li>
    		<li><a style="cursor: pointer;" data-toggle="modal" data-target="#signInModal">Signup</a></li>
    		@endif
    		</ul>
    		</div>
    		</div>
    		</div>
		</div>

        <div class="container-fluid">
            <div class="row">
      			<div class="col-12">
        			<div class="row pl-3 pr-3 pt-2 pb-1 d-none d-lg-flex">
            			<div class="col-3 col-md-2 col-lg-3 text-center align-self-center">
                			<a class="navbar-brand text-uppercase m-0" href="{{route('front.index')}}">
                			<!-- <img src="assets/images/logo.png" class="logo_main" alt="logo"> -->
                			<!-- <span>Learn<br><small>Form Online</small></span>   -->
                			<img src="{{asset('assets/images/'.$gs->logo)}}" alt="Logo" class="logo_main"> <!--span>Sticker<br>Wale</span-->
                			</a>

            			</div><!-- /.navbar-header -->
            			<div class="col-7 col-md-8 col-lg-7 align-self-center">
							@include('includes.autocomplete')
            			</div>
            			<div class="col-2 col-md-2 col-lg-2 pl-0 pl-xl-3 align-self-center">
                			<ul class="cart_header m-0 p-0 text-center">
                    			<li>
                    			@if(Auth::guard('user')->check())
                    			<a href="{{route('user-wishlists')}}" title="{{$lang->wishlists}}">
                    			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12,22a1.42,1.42,0,0,1-.91-.34L11,21.59,2.13,12.42C.52,10.77,0,9.72,0,8.09A6.17,6.17,0,0,1,1,4.72,5.88,5.88,0,0,1,3.65,2.47,5.74,5.74,0,0,1,7.1,2.12a5.9,5.9,0,0,1,3,1.68L12,5.72,13.86,3.8a5.9,5.9,0,0,1,3-1.68,5.75,5.75,0,0,1,3.45.35A5.88,5.88,0,0,1,23,4.72a6.17,6.17,0,0,1,1,3.37c0,1.6-.54,2.7-2.15,4.36l-8.94,9.21A1.43,1.43,0,0,1,12,22ZM5.93,4a3.65,3.65,0,0,0-1.49.31,3.91,3.91,0,0,0-1.77,1.5A4.14,4.14,0,0,0,2,8.09c0,1,.24,1.58,1.56,2.93L12,19.74l8.42-8.68C21.77,9.66,22,9,22,8.09a4.2,4.2,0,0,0-.67-2.29,4,4,0,0,0-1.77-1.49,3.7,3.7,0,0,0-2.25-.23,3.8,3.8,0,0,0-2,1.11h0L12,8.59,8.7,5.19a3.8,3.8,0,0,0-2-1.11A3.92,3.92,0,0,0,5.93,4Z"></path></svg>
                    			</a>
                    			@else
                    			<a style="cursor: pointer;" data-toggle="modal" class="no-wish" data-target="#loginModal" title="Wishlist">
                    			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12,22a1.42,1.42,0,0,1-.91-.34L11,21.59,2.13,12.42C.52,10.77,0,9.72,0,8.09A6.17,6.17,0,0,1,1,4.72,5.88,5.88,0,0,1,3.65,2.47,5.74,5.74,0,0,1,7.1,2.12a5.9,5.9,0,0,1,3,1.68L12,5.72,13.86,3.8a5.9,5.9,0,0,1,3-1.68,5.75,5.75,0,0,1,3.45.35A5.88,5.88,0,0,1,23,4.72a6.17,6.17,0,0,1,1,3.37c0,1.6-.54,2.7-2.15,4.36l-8.94,9.21A1.43,1.43,0,0,1,12,22ZM5.93,4a3.65,3.65,0,0,0-1.49.31,3.91,3.91,0,0,0-1.77,1.5A4.14,4.14,0,0,0,2,8.09c0,1,.24,1.58,1.56,2.93L12,19.74l8.42-8.68C21.77,9.66,22,9,22,8.09a4.2,4.2,0,0,0-.67-2.29,4,4,0,0,0-1.77-1.49,3.7,3.7,0,0,0-2.25-.23,3.8,3.8,0,0,0-2,1.11h0L12,8.59,8.7,5.19a3.8,3.8,0,0,0-2-1.11A3.92,3.92,0,0,0,5.93,4Z"></path></svg>
                    			</a>
                    			@endif
                    			</li>
                    			<li>
                    			<a class="js-toggle-cart" href="#" title="Cart">
                    			<span class="cart-quantity" id="cart-count">{{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }}</span>
                    			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><circle cx="7" cy="20" r="2"></circle><circle cx="17" cy="20" r="2"></circle><path d="M18,17H6a1,1,0,0,1-1-.79L2.19,3H1A1,1,0,0,1,1,1H3a1,1,0,0,1,1,.79L6.81,15H17.18l1.6-8H5A1,1,0,0,1,4,6c0-.55-.55-1,0-1H20a1,1,0,0,1,.77.37A1,1,0,0,1,21,6.2l-2,10A1,1,0,0,1,18,17Z"></path></svg>
                    			</a>
                    			</li>
                			</ul>
            			</div>
        			</div>



                @include('includes.cart-sidebar')

				@include('includes.header-menu')

                </div>
            </div>
        </div>


        <div class="header-support-part">
            <div class="header-middle-area">

            </div>
        </div>
    </header>

            @php
            $i=1;
            $j=1;
            @endphp

    <!--  Ending of header area   -->
        @yield('content')

<footer class="">
    <section class="footer-top main-footer style-two style-three">
    <div class="container">
    <div class="row">
    <div class="col-12 col-sm-6 col-md-3 mb-4 mb-md-0">
    <h4 class="footer_heading">ABOUT PARTZDEAL</h4>
    <ul class="footer_menu">
    <li><a href="{{route('front.page',['slug'=>'about-us'])}}">About Us</a></li>
    <!--li><a href="#">Auto Parts Enquiry</a></li-->
    <!--li><a href="{{route('front.contact')}}">Support</a></li-->
    </ul>
    </div>
    <div class="col-12 col-sm-6 col-md-3 mb-4 mb-md-0">
    <h4 class="footer_heading">OUR POLICY</h4>
    <ul class="footer_menu">
    <!--li><a href="{{route('front.page',['slug'=>'privacy-policy'])}}">Privacy Policy</a></li-->
    <li><a href="{{route('front.page',['slug'=>'disclaimer'])}}">Disclaimer</a></li>
    <li><a href="{{route('front.page',['slug'=>'shipping-policy'])}}">Shipping Policy</a></li>
    <li><a href="{{route('front.page',['slug'=>'return-and-exchange-policy'])}}">Return & Exchange Policy</a></li>
    </ul>
    </div>
    <div class="col-12 col-sm-6 col-md-3 mb-4 mb-sm-0">
    <h4 class="footer_heading">NEED HELP?</h4>
    <ul class="footer_menu">
    <!--li><a href="{{route('front.page',['slug'=>'terms-condition'])}}">Terms & Conditions</a></li-->
    <li><a href="{{route('front.contact')}}">Contact Us</a></li>
    <!--li><a href="{{route('front.faq')}}">Faq</a></li-->
    </ul>
    </div>
    <div class="col-12 col-sm-6 col-md-3 mb-0">
    <h4 class="footer_heading">Social</h4>
    <ul class="footer_menu">
    @if($sl->i_status == 1)
    <li><a target="_blank" href="{{$sl->instagram}}"><img src="{{asset('assets/website/images/icon/icon-instagram.svg')}}" class="img-fluid"> Instagram</a></li>
    @endif
    @if($sl->f_status == 1)
    <li><a target="_blank" href="{{$sl->facebook}}"><img src="{{asset('assets/website/images/icon/icon-facebook.svg')}}" class="img-fluid"> Facebook</a></li>
    @endif
    @if($sl->t_status == 1)
    <li><a target="_blank" href="{{$sl->twiter}}"><img src="{{asset('assets/website/images/icon/icon-twitter.svg')}}" class="img-fluid"> Twitter</a></li>
    @endif
    @if($sl->tg_status == 1)
    <li><a target="_blank" href="{{$sl->telegram}}"><img src="{{asset('assets/website/images/icon/icon-tumbler.svg')}}" class="img-fluid"> Tumblr</a></li>
    @endif
    <li><a href="#"><img src="{{asset('assets/website/images/icon/icon-pint.svg')}}" class="img-fluid"> Pinterest</a></li>
    </ul>
    </div>
    </div>
    </div>
    </div>
    </section>

    <section class="footer-middle">
    <div class="container">
    <div class="row">
    <div class="col-sm-6">
    <p>
    <a href="{{route('front.index')}}">
    <img src="{{asset('assets/images/'.$gs->logo)}}" class="logo_main footerlogo">
    </a>
    </p>
    </div>
    <div class="col-sm-6">
      @include('includes.newsletter')
    </div>
    </div>
    </div>
    </section>
    <section class="footer-bottom">
    <div class="container">
    <div class="row">
    <div class="col-12 text-left text-md-center">
    <ul class="footer_menu mb-0 p-0">
    <li><a href="#"><img src="{{asset('assets/website/images/icon/visa.svg')}}" class="img-fluid" alt="logo"></a></li>
    <li><a href="#"><img src="{{asset('assets/website/images/icon/master.svg')}}" class="img-fluid" alt="logo"></a></li>
    <li><a href="#"><img src="{{asset('assets/website/images/icon/american.svg')}}" class="img-fluid" alt="logo"></a></li>
    <li><a href="#"><img src="{{asset('assets/website/images/icon/paypal.svg')}}" class="img-fluid" alt="logo"></a></li>
    </ul>

    <p class="copywrite_txt"><a href="#">© Partzdeal. All Rights Reserved</a></p>
    </div>
    </div>
    </div>
    </section>
</footer>

    <!-- Ending of footer area -->



    <!-- Starting of Product View Modal -->

@include('includes.auth-modal-popup')


@if(isset($checked))
    <!-- Starting of Product View Modal -->
<div class="modal fade" id="checkoutModal"  data-keyboard="false" data-backdrop="static" role="dialog">
<div class="modal-dialog modal-dialog-centered" style="transition: .5s;" role="document">
	<!-- Modal content-->
	<div class="modal-content">
	<div class="modal-header">
	<a href="{{ url()->previous() }}" class="close">&times;</a>
	</div>
	<div class="modal-body">
	<div class="login-area text-center">
	<h1 class="heading_one mt-0 mb-3">Log In</h1>
	<p class="form-text mb-4">if you don't have an account? <strong><a href="signInModal" data-dismiss="modal" data-toggle="modal" data-target="#signInModal">Sign Up</a></strong></p>
	<div class="login-form signin-form">
	<form class="mloginform" action="{{route('user-login-submit')}}" method="POST">
	{{csrf_field()}}
	<div class="form-group {{$lang->rtl == 1 ? 'text-right' : ''}}">
	<input type="email" name="email" class="form-control" id="login_email1" placeholder="{{$lang->doeml}}" required>
	</div>
	<div class="form-group {{$lang->rtl == 1 ? 'text-right' : ''}}">
	<input type="password" name="password" class="form-control" id="login_pwd1" placeholder="{{$lang->sup}}" required>
	</div>
	<div class="form-row">
	<div class="col-12 col-md-6 text-center text-md-left">
	<div class="form-check mb-3">
	<input class="form-check-input" type="checkbox">
	<label class="form-check-label">Remember me</label>
	</div>
	</div>
	<div class="col-12 col-md-6 text-center text-md-right">
	<p class="form-text mb-3"><a href="{{route('user-forgot')}}">Lost Password?</a></p>
	</div>
	</div>
	<input type="hidden" name="wish" value="1">
	<button type="submit" class="btn btn_submit">{{$lang->sie}}</button>
	</form>
	<p class="form-text small mb-0">This site is protected by reCAPTCHA and the Google Privacy Policy and Terms of Services apply.</p>

	</div>
	</div>
	</div>
	</div>
	</div>
</div>
@endif

<!-- jQuary Library -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script>
<!--script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script-->
<script src="{{asset('assets/website/slick/slick.js')}}"></script>
<script src="{{asset('assets/front/js/notify.js')}}"></script>
<script src="{{asset('assets/front/js/bootstrap-slider.min.js')}}"></script>
<script src="{{asset('assets/front/js/owl.carousel.min.js')}}"></script>

<script src="{{asset('assets/website/lightbox/js/lightgallery-all.min.js')}}"></script>
<script src="{{asset('assets/website/lightbox/js/jquery.mousewheel.min.js')}}"></script>
<script src="{{asset('assets/website/js/main.js')}}"></script>
<script src="{{asset('assets/website/js/custom.js')}}"></script>
<script src="{{asset('assets/website/js/mmenu-light.js')}}"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<!--script src="{{asset('assets/website/js/main.js')}}"></script-->
<!--script src="{{asset('assets/front/js/all.js')}}"></script-->

    {!! $seo->google_analytics !!}

                                    @if(Session::has('subscribe'))
                                    <script type="text/javascript">
                                        $.notify("{{ Session::get('subscribe') }}","success");

                                    </script>
                                    @endif
                                    @foreach($errors->all() as $error)
                                    <script type="text/javascript">
                                        $.notify("{{$error}}","error");

                                    </script>
                                    @endforeach

 <script type="text/javascript">
 function isEmpty(str){
    return !str.replace(/\s+/, '').length;
}
     $("#prod_name").keyup(function() {
        var search = $(this).val();
		if( isEmpty(search) ) {
            $(".autocomplete").hide();
			$("#myInputautocomplete-list").html("");
        }
        else {
            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/suggest')}}",
                    data:{search:search},
                    success:function(data){
						console.log(data);
                        if(!$.isEmptyObject(data))
                        {
                        $(".autocomplete").show();
                        $("#myInputautocomplete-list").html("");
                        var arr = $.map(data, function(el) {
                        return el });
                            for(var k in arr)
                            {
                                var x = arr[k]['name'];
                                var p = x.length  > 80 ? x.substring(0,80)+'...' : x;
                                $("#myInputautocomplete-list").append('<div class="docname"><a href="{{url('/')}}/'+arr[k]['slug']+'.html'+'"><div class="search-content"><p>'+p+'</p></div></a></div>');
                            }
                        }
                        else{
                            $(".autocomplete").hide();
                        }
                        }
                  })

        }
     });
 </script>

<script type="text/javascript">
     $("#mobile_prod_name").keyup(function() {
        var search = $(this).val();
        if( isEmpty(search) ) {
            $(".autocomplete").hide();
			 $("#MobilemyInputautocomplete-list").html("");
        }
        else {
            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/suggest')}}",
                    data:{search:search},
                    success:function(data){
						console.log(data);
                        if(!$.isEmptyObject(data))
                        {
                        $(".autocomplete").show();
                        $("#MobilemyInputautocomplete-list").html("");
                        var arr = $.map(data, function(el) {
                        return el });
                            for(var k in arr)
                            {
                                var x = arr[k]['name'];
                                var p = x.length  > 50 ? x.substring(0,50)+'...' : x;
                                $("#MobilemyInputautocomplete-list").append('<div class="docname"><a href="{{url('/')}}/'+arr[k]['slug']+'.html'+'"><div class="search-content"><p>'+p+'</p></div></a></div>');
                            }
                        }
                        else{
                            $(".autocomplete").hide();
                        }
                        }
                  })

        }
     });
 </script>

<script type="text/javascript">
    function remove(id) {
      $('.ajaxloadermodal').show();
        $("#del"+id).hide();
            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/removecart')}}",
                    data:{id:id},
                    success:function(data){
                        $(".empty").html("");
                        $(".total").html("{{$curr->sign}}"+(data[0] * {{$curr->value}}).toFixed(2));
                        $("#final-cost").html("{{$curr->sign}}"+(data[0] * {{$curr->value}}).toFixed(2));
                        $("#total-cost").html("{{$curr->sign}}"+(data[0] * {{$curr->value}}).toFixed(2));
                        $(".cart-total").html("{{$curr->sign}}"+(data[0] * {{$curr->value}}).toFixed(2));
                        $("#tgrandtotal").val((data[0] * {{$curr->value}}).toFixed(2));
                        $("#grandtotal").val((data[0] * {{$curr->value}}).toFixed(2));
                        $(".cart-quantity").html(data[2]);
                        $(".js-cart-product-template").html("");
                        if(data[1] == null)
                        {
                            $(".total").html("0.00");
                            $(".cart-quantity").html("0");
                            $(".empty").html("{{$lang->h}}");
							              $(".cart_text_footer_btn").html("");
                            location.reload();
                        }

                        var arr = $.map(data[1], function(el) {
                        return el });
                        for(var k in arr)
                        {
                            var x = arr[k]['item']['name'];
                            var p = x.length  > 45 ? x.substring(0,45)+'...' : x;
                            var measure = arr[k]['item']['measure'] != null ? arr[k]['item']['measure'] : "";
                            $(".js-cart-product-template").append(
                            '<div class="single-myCart">'+
            '<p class="cart-close" onclick="remove('+arr[k]['item']['id']+')"><i class="fa fa-trash"></i></p>'+
                            '<div class="cart-img">'+
                    '<img src="{{ asset('assets/images/'.$store_code.'/products/') }}/thumb_'+arr[k]['item']['photo']+'" alt="Product image">'+
                            '</div>'+
                            '<div class="cart-info">'+
        '<a href="{{url('/')}}/'+arr[k]['item']['slug']+'.html" style="color: black; padding: 0 0;">'+'<h6>'+p+'</h6></a>'+
        '<div class="productDetails-quantity"><p>{{$lang->cquantity}}: <span class="quantity-btn side_reducing"><i class="fa fa-minus"></i></span>'+
        '<span id="cqt'+arr[k]['item']['id']+'">'+arr[k]['qty']+'</span><input type="hidden" value="'+arr[k]['item']['id']+'"><input type="hidden" class="itemid" value="'+arr[k]['item']['id']+'">'+
        '<input type="hidden" class="size_qty" value=""/><input type="hidden" class="size_price" value=""/><input type="hidden" class="size_key" value=""/><input type="hidden" class="size" value=""/>'+
        '<input type="hidden" id="stock'+arr[k]['item']['id']+'" value=""><span class="quantity-btn side_adding"><i class="fa fa-plus"></i></span></p></div>'+
                        @if($gs->sign == 0)
                        '<p class="total_item_amount">{{$curr->sign}}<span id="prct'+arr[k]['item']['id']+'">'+(arr[k]['price'] * {{$curr->value}}).toFixed(2)+'</span></p>'+
                        @else
                        '<p class="total_item_amount"><span id="prct'+arr[k]['item']['id']+'">'+(arr[k]['price'] * {{$curr->value}}).toFixed(2)+'</span>{{$curr->sign}}</p>'+
                        @endif
                        '</div>'+
                        '</div>');
                        }
$('.ajaxloadermodal').hide();
                      }
              });

    }
</script>

    <script>
    $(document).on("click", ".removecart" , function(e){
        $(".addToMycart").show();
    });
    </script>
    <script>
    var size = "";
    var colorss = "";
     $(document).on("click", ".addajaxcart" , function(){
        var qty = 1
        if(qty < 1)
        {
            $.notify("{{$gs->invalid}}","error");
        }
        else
        {
          $('.ajaxloadermodal').show();
        var pid = $(this).data("productid");
        $(".empty").html("");
            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/addnumcart')}}",
                    data:{id:pid,qty:qty,size:size,size_qty:"",size_price:"",size_key:"",color:colorss},
                    success:function(data){
                        if(data == 0)
                        {
                        $.notify("{{$gs->cart_error}}","error");
                        }
                        else{
                        $(".empty").html("");
                        $(".total").html("{{$curr->sign}}"+(data[0] * {{$curr->value}}).toFixed(2));
                        $(".cart-quantity").html(data[2]);
                        var arr = $.map(data[1], function(el) {
                        return el });
                        $(".js-cart-product-template").html("");
						if(data[2]>=1)
						{
              $(".cart_text_footer_btn").html("");
var checkoutbutton = '<a class="button" href="{{route("front.checkout")}}" title="Checkout">Checkout</a><a class="button ml-4" href="{{route("front.cart")}}" title="View Cart">View Cart</a>';
							$(".cart_text_footer_btn").html(checkoutbutton);
							$(".cart__empty").hide();
						}else{
						    $(".cart__empty").show();
						}
                        for(var k in arr)
                        {
                            var x = arr[k]['item']['name'];
                            var p = x.length  > 45 ? x.substring(0,45)+'...' : x;
                            var measure = arr[k]['item']['measure'] != null ? arr[k]['item']['measure'] : "";
                            $(".js-cart-product-template").append(
                             '<div class="single-myCart">'+
            '<p class="cart-close" onclick="remove('+arr[k]['item']['id']+')"><i class="fa fa-trash"></i></p>'+
                            '<div class="cart-img">'+
                    '<img src="{{ asset('assets/images/'.$store_code.'/products/') }}/thumb_'+arr[k]['item']['photo']+'" alt="Product image">'+
                            '</div>'+
                            '<div class="cart-info">'+
        '<a href="{{url('/')}}/'+arr[k]['item']['slug']+'.html" style="color: black; padding: 0 0;">'+'<h5>'+p+'</h5></a>'+
        '<div class="productDetails-quantity"><p>{{$lang->cquantity}}: <span class="quantity-btn side_reducing"><i class="fa fa-minus"></i></span>'+
        '<span id="cqt'+arr[k]['item']['id']+'">'+arr[k]['qty']+'</span><input type="hidden" value="'+arr[k]['item']['id']+'"><input type="hidden" class="itemid" value="'+arr[k]['item']['id']+'">'+
        '<input type="hidden" class="size_qty" value=""/><input type="hidden" class="size_price" value=""/><input type="hidden" class="size_key" value=""/><input type="hidden" class="size" value=""/>'+
        '<input type="hidden" id="stock'+arr[k]['item']['id']+'" value=""><span class="quantity-btn side_adding"><i class="fa fa-plus"></i></span></p></div>'+
                        //'<p>{{$lang->cquantity}}: '+arr[k]['qty']+' '+measure+'</p>'+
                        @if($gs->sign == 0)
                        '<p class="total_item_amount">{{$curr->sign}}<span id="prct'+arr[k]['item']['id']+'">'+(arr[k]['price'] * {{$curr->value}}).toFixed(2)+'</span></p>'+
                        @else
                        '<p class="total_item_amount"><span id="prct'+arr[k]['item']['id']+'">'+(arr[k]['price'] * {{$curr->value}}).toFixed(2)+'</span>{{$curr->sign}}</p>'+
                        @endif
                        '</div>'+
                        '</div>');
                          }
                        $.notify("{{$gs->cart_success}}","success");
                        }
                          $('.ajaxloadermodal').hide();
                      }
              });
        }
     });
    </script>
    <script>
        $(document).on("click", ".lwish" , function(){
            var pid = $(this).parent().find('input[type=hidden]').val();
            window.location = "{{url('user/wishlist/product/')}}/"+pid;
            return false;
        });
    </script>

    <script>
        $(document).on("click", ".uwish" , function(){
            //var pid = $(this).parent().find('input[type=hidden]').val();
			var pid = $(this).data("productid");
            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/wish')}}",
                    data:{id:pid},
                    success:function(data){
                        if(data == 1)
                        {
                            $.notify("{{$gs->wish_success}}","success");
                        }
                        else {
                            $.notify("{{$gs->wish_error}}","error");
                        }
                      }
              });

            return false;
        });
    </script>

    <script>
        $(document).on("click", ".no-wish" , function(){
        return false;
        });
    </script>

    <script type="text/javascript">
    	jQuery('#brandSelector').change(function() {
      jQuery('.ajaxloadermodal').show();
    	var brandId = jQuery(this).val();
        var current_category_id = jQuery("#current_category_id").val();
var token = jQuery(this).find('input[name=_token]').val();
    	jQuery.ajax({
    			type: "POST",
    			url: "{{URL::to('/sidebarsearch/findseries')}}",
    			data: { "bid": brandId, "_token": "{{ csrf_token() }}" },
    			success: function(resp) {
                    //console.log(resp);
    				jQuery('#seriesSelector').html(resp);
    				jQuery('.ajaxloadermodal').hide();
    			}
    		});

        //jQuery('#cat-loader').css("display", "block");
        console.log(current_category_id);
        jQuery.ajax({
      			type: "POST",
      			url: "{{URL::to('/sidebarsearch/findcategories')}}",
      			data: { "bid": brandId, "current_category_id":current_category_id,"_token": "{{ csrf_token() }}" },
      			success: function(resp) {
                    console.log(resp);
      				jQuery('#categoriesSelector').html(resp);
      				jQuery('.ajaxloadermodal').hide();
      			}
      		});

        });

        jQuery('#categoriesSelector').change(function() {
        jQuery('.ajaxloadermodal').show();
        var cat_id = jQuery(this).val();
        jQuery.ajax({
      			type: "GET",
      			url: "{{URL::to('/sidebarsearch/findsubcategories')}}",
      			data: { cat_id: cat_id },
      			success: function(resp) {
              console.log(resp);
      				jQuery('#subcategoriesSelector').html(resp);
      				jQuery('.ajaxloadermodal').hide();
      			}
      		});
        });

    </script>

    <script>
    $(document).on("click", "#product_email" , function(){
        $(".modal-backdrop, .modal.vendor").css('background-color','rgba(0,0,0,0)');
    });
    </script>
	@if(session('message')==='f')
		<script type="text/javascript">
		$(window).on('load', function() {
		$('#loginModal').modal('show');
		});
		</script>
	@endif
    <script type="text/javascript">

        $(document).ready(function(){

          $(document).on("click", ".enqbtn" , function(){
              grecaptcha.reset();
            var productid = $(this).data("productid");
            var productsku = $(this).data("productsku");
            var productname = $(this).data("productname");
            $("#enq_product_id").val(productid);
            $("#enq_product_sku").val(productsku);
            $("#enq_product_name").val(productname);
            });

            $("#minquiryform").submit(function(e) {
             e.preventDefault();

             var form = $(this);
              var url = form.attr('action');
             /* Submit form data using ajax*/
             $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(),
                success: function(response){
                   console.log(response);
                   if(response.status==true)
                   {
                     var alertmessage = '<div class="alert alert-success" role="alert">'+response.message+'</div>';
                     $("#inqresmessage").html(alertmessage);
                   }else{
                     var alertmessage = '<div class="alert alert-danger" role="alert">'+response.message+'</div>';
                     $("#inqresmessage").html(alertmessage);
                   }
                }});
             });

        	$(function () {
				$('[data-toggle="tooltip"]').tooltip()
			});



        $('.fan_slider').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            arrows: true,
            dots: false,
            pauseOnHover: false,
            responsive: [{
                breakpoint: 992,
                settings: {
                    slidesToShow: 3
                }
            }, {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            }, {
                breakpoint: 420,
                settings: {
                    slidesToShow: 1
                }
            }]
        });

		});
    </script>

    <script type="text/javascript">
          $(document).on("click", ".side_adding" , function(){
            var pid =  $(this).parent().find('input[type=hidden]').val();
            var stck = $("#stock"+pid).val();
            var qty = $("#cqt"+pid).html();
    		var itemid = $(this).parent().parent().find('.itemid').val();
    		var size_qty = $(this).parent().parent().find('.size_qty').val();
            var size_price = $(this).parent().parent().find('.size_price').val();
    		var size_key = $(this).parent().parent().find('.size_key').val();
            if(stck != "")
            {
              var stk = parseInt(stck);
              if(qty <= stk)
              {
              qty++;
              $("#cqt"+pid).html(qty);
              }
            }
            else{
             qty++;
             $("#cqt"+pid).html(qty);
            }
                $.ajax({
                        type: "GET",
                        url:"{{URL::to('/json/addbyone')}}",
                        data:{id:pid,itemid:itemid,size_qty:size_qty,size_price:size_price},
                        success:function(data){
                            if(data == 0)
                            {
                            }
                            else
                            {
    							console.log(data);
                            $(".total").html("{{$curr->sign}}"+(data[0] * {{$curr->value}}).toFixed(2));
                            $("#final-cost").html("{{$curr->sign}}"+(data[0] * {{$curr->value}}).toFixed(2));
                            $("#total-cost").html("{{$curr->sign}}"+(data[0] * {{$curr->value}}).toFixed(2));
                            $(".cart-total").html("{{$curr->sign}}"+(data[0] * {{$curr->value}}).toFixed(2));
                            $("#tgrandtotal").val((data[0] * {{$curr->value}}).toFixed(2));
                            $("#grandtotal").val((data[0] * {{$curr->value}}).toFixed(2));
                            $(".cart-quantity").html(data[3]);
                            $("#cqty"+pid).val("1");
                            $("#prc"+pid).html((data[2] * {{$curr->value}}).toFixed(2));
                            $("#prct"+pid).html((data[2] * {{$curr->value}}).toFixed(2));
                            $("#qty"+pid).html(data[1]);
                            $("#cqt"+pid).html(data[1]);
    						$("#itemprc"+pid).html(data[4]);
                            }
                          }
                  });
           });

          $(document).on("click", ".side_reducing" , function(){
            var id =  $(this).parent().find('input[type=hidden]').val();
            var stck = $("#stock"+id).val();
            var qty = $("#cqt"+id).html();
            qty--;
    		var itemid = $(this).parent().parent().find('.itemid').val();
    		var size_qty = $(this).parent().parent().find('.size_qty').val();
            var size_price = $(this).parent().parent().find('.size_price').val();
    		var size_key = $(this).parent().parent().find('.size_key').val();
            if(qty < 1)
             {
             $("#cqt"+id).html("1");
             }
             else{
             $("#cqt"+id).html(qty);
                $.ajax({
                        type: "GET",
                        url:"{{URL::to('/json/reducebyone')}}",
                        data:{id:id,itemid:itemid,size_qty:size_qty,size_price:size_price},
                        success:function(data){
                            $(".total").html((data[0] * {{$curr->value}}).toFixed(2));
                            $("#final-cost").html("{{$curr->sign}}"+(data[0] * {{$curr->value}}).toFixed(2));
                            $("#total-cost").html("{{$curr->sign}}"+(data[0] * {{$curr->value}}).toFixed(2));
                            $(".cart-total").html("{{$curr->sign}}"+(data[0] * {{$curr->value}}).toFixed(2));
                            $("#tgrandtotal").val((data[0] * {{$curr->value}}).toFixed(2));
                            $("#grandtotal").val((data[0] * {{$curr->value}}).toFixed(2));
                            $(".cart-quantity").html(data[3]);
                            $("#cqty"+id).val("1");
                            $("#prc"+id).html((data[2] * {{$curr->value}}).toFixed(2));
                            $("#prct"+id).html((data[2] * {{$curr->value}}).toFixed(2));
                            $("#cqt"+id).html(data[1]);
                            $("#qty"+id).html(data[1]);
    						$("#itemprc"+id).html(data[4]);
                          }
                  });
             }
           });
    </script>


    @if($gs->is_talkto == 1)
        <!--Start of Tawk.to Script-->
        {!! $gs->talkto !!}
        <!--End of Tawk.to Script-->
    @endif

    @yield('scripts')
<button type="button" class="scroll-top"><i class="fa fa-angle-up" aria-hidden="true"></i></button>
</body>
</html>

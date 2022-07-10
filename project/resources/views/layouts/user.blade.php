<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="{{$seo->meta_keys}}">
    <meta name="author" content="GeniusOcean">

    <title>{{$gs->title}}</title>
    <link href="{{asset('assets/user/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/user/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/user/css/themify-icon.css')}}" rel="stylesheet">
    <link href="{{asset('assets/user/css/perfect-scrollbar.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/user/css/bootstrap-colorpicker.css')}}" rel="stylesheet">
    <link href="{{asset('assets/user/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/user/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/user/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/user/css/responsive.css')}}" rel="stylesheet">
	<link href="{{asset('assets/admin/select2/dist/css/select2.min.css')}}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{asset('assets/images/'.$gs->favicon)}}">
        <style type="text/css">
        .form-control {
        box-shadow: inset 0px 0px 0px rgba(0,0,0,.075);
        }
        .vendor-btn {
            display: inline-block !important;
            background-color: #00b16a !important;
            color: #ffffff !important;
            padding: 8px 25px !important;
            border-radius: 30px !important;
            margin-right: 20px !important;
            cursor: pointer;
            font-weight: 500 !important;
            transition: all 0.3s;
        }
        #sidebar-menu ul li a.vendor-btn:hover {
            background-color: #333333 !important;
        }
        </style>
    @include('styles.admin-design')
    @yield('styles')
</head>
<body>
<div class="dashboard-wrapper">
    <div class="left-side">
        <!-- Starting of Dashboard Sidebar menu area -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-right">
                    <button type="button" id="sidebarCollapse" class="navbar-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </nav>

        <div class="dashboard-sidebar-area">
            <img src="{{asset('assets/images/'.$gs->bimg)}}" alt="">
            <div class="sidebar-menu-body">
                <nav id="sidebar-menu">
                    <ul class="list-unstyled profile">
                        <li class="active">
                            <div class="row">
                                @if($lang->rtl == 1)

                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                    <a dir="rtl">{{ Auth::guard('user')->user()->name}}<span>{{$lang->customer}}</span></span></a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            @if(Auth::guard('user')->user()->is_provider == 1)
                                    <img src="{{ Auth::guard('user')->user()->photo ? Auth::guard('user')->user()->photo:asset('assets/images/noimage.png')}}" alt="profile image">
                                    @else
                                    <img src="{{ Auth::guard('user')->user()->photo ? asset('assets/images/'.Auth::guard('user')->user()->photo):asset('assets/images/noimage.png') }}" alt="profile image">
                            @endif
                                </div>
                                @else
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            @if(Auth::guard('user')->user()->is_provider == 1)
                                    <img src="{{ Auth::guard('user')->user()->photo ? Auth::guard('user')->user()->photo:asset('assets/images/noimage.png')}}" alt="profile image">
                                    @else
                                    <img src="{{ Auth::guard('user')->user()->photo ? asset('assets/images/'.Auth::guard('user')->user()->photo):asset('assets/images/noimage.png') }}" alt="profile image">
                                    @endif
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                    <a>{{ Auth::guard('user')->user()->name}}<span>{{$lang->customer}}</span></span></a>
                                </div>
                                @endif
                            </div>
                        </li>
                    </ul>
                    <ul class="list-unstyled components">
                        <li>
                            <a href="{{route('front.index')}}" target="_blank"><i class="fa fa-eye"></i>{{$lang->view_website}}</a>
                        </li>
                        <li>
                            <a href="{{route('user-dashboard')}}"><i class="fa fa-home"></i>{{$lang->dashboard}}</a>
                        </li>


              @if(Auth::guard('user')->user()->IsVendor())
                        <li>
                            <a href="{{route('user-prod-index')}}"><i class="fa fa-fw fa-shopping-cart"></i>My Products</a>
                        </li>
                        <li>
                            <a href="{{route('vendor-order-index')}}"><i class="fa fa-fw fa-money"></i>My Inquries</a>
                        </li>

                        <li>
                        <a href="#generalSettings" data-toggle="collapse" aria-expanded="false"><i class="fa fa-fw fa-cogs"></i> {{$lang->settings}}</a>
                            <ul class="collapse list-unstyled submenu" id="generalSettings">
                                <li><a href="{{route('user-shop-desc')}}"><i class="fa fa-angle-{{$lang->rtl == 1 ? 'left':'right'}}"></i> {{$lang->shop_description}}</a></li>
                                <li><a href="{{route('user-social-index')}}"><i class="fa fa-angle-{{$lang->rtl == 1 ? 'left':'right'}}"></i> {{$lang->social_link}}</a></li>
                            </ul>
                        </li>
                @endif


                    </ul>
                </nav>
            </div>
        </div>
        <!-- Ending of Dashboard Sidebar menu area -->
    </div>
    @yield('content')
</div>

@if($lang->rtl == 1)
<style type="text/css">
#sidebar-menu ul.profile a {text-align: right;}
    ul.profile li.active img {
        margin-left: -10px;
    }
.components a[aria-expanded="false"]::before, a[aria-expanded="true"]::before {
    right: auto;
    left: 20px;
    }
#sidebar-menu ul li a {
    text-align: right;
    direction: rtl;
}
#sidebar-menu ul li a i.fa {margin-right: 0;margin-left: 5px;}
</style>
@endif
<script src="{{asset('assets/user/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/user/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/user/js/perfect-scrollbar.jquery.min.js')}}"></script>
<script src="{{asset('assets/user/js/jquery.canvasjs.min.js')}}"></script>
<script src="{{asset('assets/user/js/bootstrap-colorpicker.js')}}"></script>
<script src="{{asset('assets/user/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/user/js/dataTables.bootstrap.js')}}"></script>
<script src="{{asset('assets/user/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/user/js/notify.js')}}"></script>
<script src="{{asset('assets/user/js/main.js')}}"></script>
<script src="{{asset('assets/user/js/user-main.js')}}"></script>
<script src="{{asset('assets/admin/select2/dist/js/select2.min.js')}}"></script>

<script type="text/javascript">
        $(document).on("click", ".email2" , function(){
        $(".modal-backdrop, .modal.vendor").css('background-color','rgba(0,0,0,0)');
    });
$(document).ready(function(){
    setInterval(function(){
            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/conv/notf')}}",
                    success:function(data){
                        $("#notf_conv").html(data);
                      }
              });
    }, 5000);
});
            $(document).on("click", "#conv_notf" , function(){
                $("#notf_conv").html('0');
                $('.profile-notifi-content').load('{{URL::to('conv/notf')}}');
            });
            $(document).on("click", "#conv_clear" , function(){

            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/conv/notf/clear')}}"
              });
            });
</script>
@yield('scripts')
</body>
</html>

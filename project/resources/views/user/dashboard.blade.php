@extends('layouts.user')
@section('content')      


        <div class="right-side">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!-- Starting of Dashboard header items area -->
                        <div class="panel panel-default admin">
                            <div class="panel-heading admin-title">
                                <div class="product__header" style="border-bottom: none;">
                                        <div class="row reorder-xs">
                                            <div class="col-lg-8 col-md-5 col-sm-5 col-xs-12">
                                                <div class="product-header-title">
                                                    <h2 style="font-size: 25px;">{{$lang->user_dashboard}}</h2>
                                                </div>
                                            </div>
                                              @include('includes.user-notification')
                                        </div>   
                                    </div></div>
                            <div class="panel-body dashboard-body">
                                <div class="dashboard-header-area">
                                    <div class="row">
                                        @include('includes.form-success')
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                            <a href="{{route('user-wishlist')}}" class="title-stats title-red">
                                                <div class="icon"><i class="fa fa-heart fa-5x"></i></div>
                                                <div class="number">{{count($wishes)}}</div>
                                                <h4>{{$lang->favorite_product}}</h4>
                                                <span class="title-view-btn">{{$lang->view_all}}</span>
                                            </a>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                            <a href="{{route('user-orders')}}" class="title-stats title-cyan">
                                                <div class="icon"><i class="fa fa-truck fa-5x"></i></div>
                                                <div class="number">{{$process}}</div>
                                                <h4>{{$lang->order_processing}}</h4>
                                                <span class="title-view-btn">{{$lang->view_all}}</span>
                                            </a>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                            <a href="{{route('user-orders')}}" class="title-stats title-green">
                                                <div class="icon"><i class="fa fa-check fa-5x"></i></div>
                                                <div class="number">{{$complete}}</div>
                                                <h4>{{$lang->order_completed}}</h4>
                                                <span class="title-view-btn">{{$lang->view_all}}</span>
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <a class="title-stats title-indigo">
                                                <div class="icon"><i class="fa fa-money fa-5x"></i></div>
                                                <div style="font-size: 38px; font-weight: 600;">{{$currency_sign->sign}} <span>{{number_format($user->affilate_income * $currency_sign->value,2)}}</span></div>
                                                <h4>{{$lang->affilate_bonus}}</h4>
                                            </a>
                                        </div>
              @if(Auth::guard('user')->user()->IsVendor()) 
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                            <a class="title-stats title-orange">
                                                <div class="icon"><i class="fa fa-check fa-5x"></i></div>
                                                <div style="font-size: 38px; font-weight: 600;">{{$currency_sign->sign}} <span>{{number_format($user->current_balance * $currency_sign->value,2)}}</span></div>
                                                <h4>{{$lang->current_balance}}</h4>
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                            <a class="title-stats title-purple">
                                                <div class="icon"><i class="fa fa-user fa-5x"></i></div>
                                                <div class="number">{{ App\VendorOrder::where('user_id','=',$user->id)->sum('qty') }}</div>
                                                <h4>{{$lang->item_sold}}</h4>
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                            <a  class="title-stats title-blue">
                                                <div class="icon"><i class="fa fa-at fa-5x"></i></div>
                                                <div style="font-size: 38px; font-weight: 600;">{{$currency_sign->sign}} {{ number_format(App\VendorOrder::where('user_id','=',$user->id)->sum('price')  * $currency_sign->value,2) }}</div>
                                                <h4>{{$lang->total_earning}}</h4>
            @endif

                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Ending of Dashboard header items area -->


                    </div>
                </div>
            </div>
        </div>

@endsection
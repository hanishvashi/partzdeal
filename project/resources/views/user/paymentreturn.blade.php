@extends('layouts.front')
@section('title')
{{$gs->title}} - Payment Successful
@endsection
@section('meta_description')
<meta name="description" content="{{$gs->title}}">
@endsection
@section('meta_tag')
<meta name="keywords" content="{{ $seo->meta_tag }}">
@endsection
@section('content')

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row" id="main">
                <div class="container">
                    <div class="col-md-12 text-center">
                        <h2>Congratulation {{Auth::guard('user')->user()->name}}!</h2>(<a href="{{route('user.profile')}}">Edit My Profile</a>)<hr>
                        <h3 style="color:green">Your Payment Completed Successfully.</h3>
                        <a href="{{route('user.dashboard')}}" class="btn btn-success">Back To Dashboard</a>
                    </div>


                </div>
            </div>
        </div>
    </div>

@endsection
@extends('layouts.front')

@section('title'){{$gs->title}} - Contact @endsection
@section('meta_description')
<meta name="description" content="{{$gs->title}}">
@endsection
@section('meta_tag')
<meta name="keywords" content="{{ $seo->meta_tag }}">
@endsection
@section('content')

<div class="section-padding login-area-wrapper">
           <div class="container-fluid">
               <div class="row">
                 <div class="col-12 col-md-4 col-lg-3 col-xl-3">
                    @include('includes.home-brand-filter')
                  	@include('includes.home-catalog')
                  </div>
                   <div class="col-12 col-md-8 col-lg-9 col-xl-9">
                    <div class="row">
                    <div class="col-sm-6">    
                      <div class="login-area">
                           <h2 class="signIn-title text-center">{{$lang->contact}}</h2>
                           <hr>

                           @include('includes.form-success')
                           @include('includes.form-error')
                           <div class="login-form">
                             <form action="{{route('front.contact.submit')}}" method="POST">
                                 {{csrf_field()}}
                                 <div class="form-group {{$lang->rtl == 1 ? 'text-right' : ''}}">
                                     <input class="form-control" name="name" placeholder="{{$lang->con}}" required="" type="text">
                                 </div>
                                 <div class="form-group {{$lang->rtl == 1 ? 'text-right' : ''}}">
                                     <input class="form-control" name="phone" placeholder="{{$lang->cop}}" required="" type="tel">
                                 </div>
                                 <div class="form-group {{$lang->rtl == 1 ? 'text-right' : ''}}">
                                     <input class="form-control" name="email" placeholder="{{$lang->coe}}" required="" type="email">
                                 </div>
                                 <div class="form-group {{$lang->rtl == 1 ? 'text-right' : ''}}">
                                   <textarea class="form-control" name="comment" id="comment" placeholder="{{$lang->cor}}" cols="30" rows="10" style="resize: vertical;" required=""></textarea>
                                   </div>

                                     <div class="form-group {{$lang->rtl == 1 ? 'text-right' : ''}}">
                                         @if($lang->rtl == 1)
                                         <div class="col-md-2 col-md-offset-6 col-sm-2 col-sm-offset-4 col-xs-2 col-xs-offset-4">
                                             <span style="cursor: pointer; float: right;" class="refresh_code"><i class="fa fa-refresh fa-2x" style="margin-top: 10px;"></i></span>
                                         </div>
                                         <div class="col-md-4 col-sm-6 col-xs-6">
                                             <img id="codeimg" src="{{url('assets/images')}}/capcha_code.png">
                                         </div>
                                         @else
                                         <div class="col-md-4 col-sm-6 col-xs-6">
                                             <img id="codeimg" src="{{url('assets/images')}}/capcha_code.png">
                                         </div>
                                         <div class="col-md-2 col-sm-2 col-xs-2">
                                             <span style="cursor: pointer;" class="refresh_code"><i class="fa fa-refresh fa-2x" style="margin-top: 10px;"></i></span>
                                         </div>
                                         @endif
                                     </div>

                                     <div class="form-group {{$lang->rtl == 1 ? 'text-right' : ''}}">
                                             <input class="form-control" name="codes" placeholder="{{$lang->enter_code}}" required="" type="text">
                                     </div>
                                     <div class="form-group">
                                       <input type="hidden" name="to" value="{{ $ps->contact_email }}">
                                         <button type="submit" value="{{$lang->sm}}" class="btn btn_submit">{{$lang->sm}}</button>
                                     </div>


                             </form>
                           </div>

                       </div>
                    </div>  
                    <div class="col-sm-6"> 
                    <p style="font-size: 18px;">Partzdeal.com</p>
                    <address style="font-size: 18px;"><strong>Address:</strong><br>D-18, Transport Nagar,<br> Jaipur - 302003, Rajasthan<br> <strong>Phone no:</strong><br> <a href="tel:01414010541">0141-4010541</a><br> <a href="tel:09001252000">+91-9001252000</a></address>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3557.820903284202!2d75.84350491504487!3d26.909178483129182!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396db6db015abb7f%3A0x26fddb188af1748a!2sShri%20Mahalaxmi%20Autoparts%20Pvt%20Ltd!5e0!3m2!1sen!2sin!4v1666706480611!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>     
                    </div>
                       
                   </div>
               </div>
           </div>
       </div>



@endsection


@section('scripts')
    <script>
        $('.refresh_code').click(function () {
            $.get('{{url('contact/refresh_code')}}', function(data, status){
                $('#codeimg').attr("src","{{url('assets/images')}}/capcha_code.png?time="+ Math.random());
            });
        })
    </script>
@stop

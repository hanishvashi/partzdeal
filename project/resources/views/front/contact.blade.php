@extends('layouts.front')


@section('content')

<div class="section-padding login-area-wrapper">
           <div class="container-fluid">
               <div class="row">
                 <div class="col-12 col-md-4 col-lg-3 col-xl-3">
                    @include('includes.home-brand-filter')
                  	@include('includes.home-catalog')
                  </div>
                   <div class="col-12 col-md-8 col-lg-9 col-xl-9">
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
                                   <textarea class="form-control" name="text" id="comment" placeholder="{{$lang->cor}}" cols="30" rows="10" style="resize: vertical;" required=""></textarea>
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

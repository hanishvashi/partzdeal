@extends('layouts.front')
@section('content')

    <div class="section-padding">
        <div class="container-fluid">
            <div class="row">
              <div class="col-12 col-md-4 col-lg-3 col-xl-3">
                 @include('includes.home-brand-filter')
               	@include('includes.home-catalog')
               </div>
                <div class="col-12 col-md-8 col-lg-9 col-xl-9">
                {!! $page->text !!}
                </div>
           </div>
       </div>
   </div>

@endsection

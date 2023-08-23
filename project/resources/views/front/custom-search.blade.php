@extends('layouts.front')
@section('title')
{{$gs->title}} - Custom Search
@endsection
@section('content')
    
<div id="content">

<section class="padding_tb20">
            <div class="container-fluid">
            <div class="row">
             <div class="col-12 col-md-4 col-lg-3 col-xl-3">
                @include('includes.home-brand-filter')
              	@include('includes.home-catalog')
              </div>

                <div class="col-12 col-md-8 col-lg-9 col-xl-9">
                @if($total_product>0)
                  <div id="product_items_grid" class="row product_list">
                  {{-- LOOP STARTS --}}
                 
                  {{-- display products created by admin --}}
                  @include('includes.product-grid-items')
                  {{-- LOOP ENDS --}}
                  </div>
                  @else
						      <h3 class="text-center">No items found</h3>
						      @endif
                </div>

              </div>




    <!--section id="extraData">

    </section-->
</div>
</section>
</div>
@endsection

@section('scripts')


@endsection

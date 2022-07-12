@extends('layouts.front')
@section('content')
@php
$i=1;
$j=1;
@endphp


    <!-- Starting of product category area -->
	<div id="content" class="shopPage">

		<section id="shop_section" class="p-4">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12 col-md-4 col-lg-3 col-xl-3">
						@include('includes.brand-filter')
          </div>

					<input type="hidden" id="filter_category_id" name="category_id" value="{{$filterdata['select_category']}}">
          <input type="hidden" id="fiter_brand_id" name="brand_id" value="{{$filterdata['manufacturer']}}">
          <input type="hidden" id="fiter_brand_id" name="series_id" value="{{$filterdata['select_series']}}">
          <div class="col-12 col-md-8 col-lg-9 col-xl-9">
            <div class="row">

              <div class="col-12 col-sm-5 col-lg-4 col-xl-3 align-self-center text-right">
					<select onchange="AdvanceSearchfilter();" id="sortby" class="custom-select">
					@if($sort == "new")
					<option value="new" selected>{{$lang->doe}}</option>
					@else
					<option value="new">{{$lang->doe}}</option>
					@endif
					@if($sort == "old")
					<option value="old" selected>{{$lang->dor}}</option>
					@else
					<option value="old">{{$lang->dor}}</option>
					@endif
					@if($sort == "low")
					<option value="low" selected>{{$lang->dopr}}</option>
					@else
					<option value="low">{{$lang->dopr}}</option>
					@endif
					@if($sort == "high")
					<option value="high" selected>{{$lang->doc}}</option>
					@else
					<option value="high">{{$lang->doc}}</option>
					@endif
					</select>
              </div>
            </div>
            <div id="product_items_grid" class="row product_list">
							{{-- LOOP STARTS --}}
							{{-- display products created by admin --}}
							@include('includes.product-grid-items')
							{{-- LOOP ENDS --}}
            </div>
						<div class="ajax-load text-center"><!-- Place at bottom of page --></div>
          </div>
        </div>
      </div>
    </section>


	</div>


    <!-- Ending of product category area -->
@endsection

@section('scripts')

<script type="text/javascript">
            $("#ex2").slider({});
        $("#ex2").on("slide", function(slideRange) {
            var totals = slideRange.value;
            var value = totals.toString().split(',');
            $("#price-min").val(value[0]);
            $("#price-max").val(value[1]);
        });
</script>

<script type="text/javascript">
  /*var page = 0;
	jQuery(window).scroll(function() {
		var st = jQuery(window).scrollTop();
      if(350 + jQuery(window).scrollTop() + jQuery(window).height() >= jQuery(document).height()) {
          page++;
          loadMoreData(page);
      }

  });*/


  function loadMoreData(page){
		var manufacturer = $("#brandSelector").val();
		//var series_id = $("#seriesSelector").val();
		var category_id = $("#categoriesSelector").val();
		var sortby = $("#sortby").val();
		var sub_category_id = $("#subcategoriesSelector").val();
    jQuery.ajax({
              url:"{{URL::to('/json/brandfilterproductajax')}}",
              type: "POST",
              data: { "_token": "{{ csrf_token() }}",sortby:sortby,page:page,manufacturer:manufacturer,select_category:category_id,select_sub_category:sub_category_id, ajax: 'ajax'},
              beforeSend: function()
              {
								jQuery('.ajaxloadermodal').show();
              }
            })
          .done(function(data)
          {
            if( isEmpty(data) ) {
              jQuery(".ajax-load").show();
              jQuery('.ajax-load').html("No more items found");
            jQuery('.ajaxloadermodal').hide();
              return;
              }
						//	console.log(data);
             jQuery('.ajaxloadermodal').hide();
              jQuery("#product_items_grid").html(data);
          })
          .fail(function(jqXHR, ajaxOptions, thrownError)
          {
            alert('server not responding...');
          });
  }
    function isEmpty(str){
    return !str.replace(/\s+/, '').length;
}

function AdvanceSearchfilter()
{
	//var manufacturer = $("#manufacturer").val();
	var manufacturer = $("#brandSelector").val();
	var category_id = $("#categoriesSelector").val();
	var sub_category_id = $("#subcategoriesSelector").val();
	var sortby = $("#sortby").val();
var page = 1;
	jQuery.ajax({
						url:"{{URL::to('/json/brandfilterproductajax')}}",
						type: "POST",
						data: { "_token": "{{ csrf_token() }}",sortby:sortby,page:page,manufacturer:manufacturer,select_category:category_id,select_sub_category:sub_category_id, ajax: 'ajax'},
						beforeSend: function()
						{
							jQuery('.ajaxloadermodal').show();
						}
					})
				.done(function(data)
				{
					if( isEmpty(data) ) {
						jQuery(".ajax-load").show();
						jQuery('.ajax-load').html("No more items found");
					jQuery('.ajaxloadermodal').hide();
						return;
						}
						//console.log(data);
					 jQuery('.ajaxloadermodal').hide();
						jQuery("#product_items_grid").html(data);
				})
				.fail(function(jqXHR, ajaxOptions, thrownError)
				{
					alert('server not responding...');
				});
}
</script>


@endsection

@extends('layouts.front')
<?php if(isset($subcat)){
$catinfo = $subcat;
}else{
$catinfo = $cat;
}?>
@section('title')
{{$gs->title}} - {{$catinfo->cat_name}}
@endsection
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
						@include('includes.catalog')
          </div>
					
					<!--input type="hidden" id="category_id" name="category_id" value="<?php //echo $catinfo->id;?>"-->
          <div class="col-12 col-md-8 col-lg-9 col-xl-9">
            <div class="row">
              <div class="col-8 col-sm-7 col-lg-8 col-xl-9 align-self-center">
                <h4 class="heading_three">{{$catinfo->cat_name}} <span class="d-none small">{{$total_product}} Results</span></h4>
								<p class="d-none">{{$catinfo->short_description}}</p>
							</div>
              <div class="col-12 col-sm-5 col-lg-4 col-xl-3 align-self-center text-right">
					<select onchange="CatalogSearchfilter();" id="sortby" class="custom-select">
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
						@if($total_product>0)
            <div id="product_items_grid" class="row product_list">
							{{-- LOOP STARTS --}}
							{{-- display products created by admin --}}
							@include('includes.product-grid-items')
							{{-- LOOP ENDS --}}
            </div>

						@else
						<h3 class="text-center">Product Coming Soon</h3>
						@endif
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
	$(document).on("click", ".add_to_wish" , function(){
            var pid = $(this).data("pid"); //$("#pid").val();
            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/wish')}}",
                    data:{id:pid},
                    success:function(data){
                        if(data == 1)
                        {
                            $.notify("{{$gs->wish_success}}","success");
							/*setTimeout(function () {
							location.reload(true);
						}, 1000);*/
                        }
                        else {
                            $.notify("{{$gs->wish_error}}","error");
                        }
                      }
              });

            return false;
        });
	$('.removewish').click(function(){
			var pid = $(this).data("pid");

            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/removewish')}}",
                    data:{id:pid},
                    success:function(data){
        $.notify("{{$gs->wish_remove}}","success");
				setTimeout(function () {
				location.reload(true);
				}, 1000);
                      }
              });
        return false;
    });
</script>


<script type="text/javascript">
            $("#ex2").slider({});
        $("#ex2").on("slide", function(slideRange) {
            var totals = slideRange.value;
            var value = totals.toString().split(',');
            $("#price-min").val(value[0]);
            $("#price-max").val(value[1]);
        });
</script>

</script>


<script type="text/javascript">
  //var page = 0;
  /*jQuery(window).scroll(function() {
		var st = jQuery(window).scrollTop();

      if(jQuery(window).scrollTop() + jQuery(window).height() >= jQuery(document).height()) {
          page++;
          //loadMoreData(page);
      }

  });*/


  function loadMoreData(page){
    var category_id = $("#categoriesSelector").val();
    var brand_id = $("#brandSelector").val();
    var series_id = $("#seriesSelector").val();
    var subcategory_id = $("#subcategoriesSelector").val();
		var sortby = $("#sortby").val();
		var pricemin =   $("#price-min").val();
		var pricemax = $("#price-max").val();
    jQuery.ajax({
              url:"{{URL::to('/json/subcategoryfilterproductajax')}}",
              type: "POST",
              data: { "_token": "{{ csrf_token() }}",pricemin:pricemin,pricemax:pricemax,sortby:sortby,page:page, category_id:category_id,brand_id:brand_id,subcategory_id:subcategory_id,series_id:series_id, ajax: 'ajax'},
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
    function isEmpty(str){
    return !str.replace(/\s+/, '').length;
}

function CatalogSearchfilter()
{
  var category_id = $("#categoriesSelector").val();
		var sortby = $("#sortby").val();
		var pricemin =   $("#price-min").val();
		var pricemax = $("#price-max").val();
    var brand_id = $("#brandSelector").val();
    var series_id = $("#seriesSelector").val();
    var subcategory_id = $("#subcategoriesSelector").val();
		jQuery.ajax({
              url:"{{URL::to('/json/subcategoryfilterproductajax')}}",
              type: "POST",
              data: { "_token": "{{ csrf_token() }}",pricemin:pricemin,pricemax:pricemax,sortby:sortby,page:1, category_id:category_id,brand_id:brand_id,subcategory_id:subcategory_id,series_id:series_id, ajax: 'ajax'},
              beforeSend: function()
              {
								jQuery('.ajaxloadermodal').show();
              }
            })
          .done(function(data)
          {
            if( isEmpty(data) ) {
              jQuery(".ajax-load").show();
              jQuery('.ajax-load').html("No items found");
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

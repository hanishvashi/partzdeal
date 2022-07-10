<div class="product-filter-option">
<h4 class="heading_three mb-4 pb-2 pt-2 pr-2 pl-2">Brands</h4>
<div class="brnad-side-filter">
<ul style="direction: ltr;">
@php
$x=0;
@endphp
@foreach($brands as $brandrow )
<li>
<a class="home_brand_sel" data-brandid="{{$brandrow->id}}" href="javascript:void(0)">{{$brandrow->brand_name}}</a>
</li>
@endforeach
</ul>
<form style="display:none;" class="advance_search" action="{{route('advance-search-form')}}" method="POST">
{{csrf_field()}}
<div class="row justify-content-center ">
<div class="col-12">
<input type="hidden" name="manufacturer" id="manufacturer" value="">
</div>
<input type="hidden" name="page" value="1" />
<div class="col-12">
<label for="select_series">Select Series</label>
<select id="seriesSelector" name="select_series" class="form-control">
<option value="">Select Series</option>
</select>
</div>
<div class="col-12">
<label for="select_category">Select Category</label>
<select id="categoriesSelector" name="select_category" class="form-control">
<option value="">Select Category</option>
</select>
</div>
<div class="col-12">
<label for="select_sub_category">Select Sub Category</label>
<select id="subcategoriesSelector" name="select_sub_category" class="form-control">
<option value="">Select Sub Category</option>
</select>
</div>
</div>
<div class="row justify-content-center">
<div class="col-12">
<button type="submit" class="home_brand_btn btn_submit btn btn-warning float-right">Search</button>
</div>
</div>
</form>
</div>
</div>

<div class="product-filter-option">
<!--<h2 class="filter-title">{{$lang->doci}}</h2>-->
<h4 class="heading_three mb-4 pb-2 pt-2 pr-2 pl-2">{{$lang->doa}}</h4>
<ul style="direction: ltr;">
@php
$x=0;
@endphp
@foreach($categories as $ctgry )
<li>
@if(count($ctgry['childcategories']) > 0)
<span href="#filter{{++$x}}" aria-expanded="false" data-toggle="collapse">
&nbsp;<i class="fa fa-plus"></i><i class="fa fa-minus"></i>&nbsp;&nbsp;&nbsp;
@else

@endif
</span>
<a href="{{route('front.page',['slug' => $ctgry['cat_slug']])}}">{{$ctgry['cat_name']}}</a>
@if(count($ctgry['childcategories']) > 0)
<ul id="filter{{$x}}" class="collapse">
@foreach($ctgry['childcategories'] as $subctgry)
<li>
<a href="{{route('front.subcategory',['slug1'=>$ctgry['cat_slug'],'slug2'=>$subctgry['cat_slug']])}}">{{$subctgry['cat_name']}}</a>
</li>
@endforeach
</ul>
@endif
</li>
@endforeach
</ul>

<!--<h2 class="filter-title">{{$lang->dosp}}</h2>-->
<h4 class="heading_three mt-4 mt-md-5 mb-4 pb-2 pt-2 pr-2 pl-2">{{$lang->dosp}}</h4>
<form action="{{route('front.page',['slug' => $ctgry['cat_slug']])}}" method="GET">


<div class="form-group padding-bottom-10">
<input style="direction: ltr;" id="ex2" type="text" class="form-control" value="" data-slider-min="<?php echo $prices['minprice'];?>" data-slider-max="<?php echo $prices['maxprice'];?>" data-slider-step="5" data-slider-value="[{{ isset($min) ? $min:$prices['minprice']}},{{ isset($max) ? $max:$prices['maxprice']}}]"/>
</div>
<div class="form-group price_box">
<input style="direction: ltr;" type="text" id="price-min" name="min" class="price-input" value="{{ isset($min) ? $min:$prices['minprice']}}">
<i class="fa fa-minus"></i>
<input style="direction: ltr;" type="text" id="price-max" name="max" class="price-input" value="{{ isset($max) ? $max:$prices['maxprice']}}">
<input style="direction: ltr;" onclick="CatalogSearchfilter();" type="button" class="price-search-btn" value="{{$lang->don}}">
</div>
</form>





</div>

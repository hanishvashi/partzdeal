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

<div class="product-filter-option">
<!--<h2 class="filter-title">{{$lang->doci}}</h2>-->
<h4 class="heading_three mb-4 pb-2 pt-2 pr-2 pl-2">Search Filter</h4>
<div class="brnad-side-filter">
  <ul style="direction: ltr; display:none;">
  @php
  $x=0;
  @endphp
  @foreach($brands as $brandrow )
  <li class="<?php if($filterdata['manufacturer']==$brandrow->id){ echo 'brand_selected'; }?>">
  <a class="home_brand_sel" data-brandid="{{$brandrow->id}}" href="javascript:void(0)">{{$brandrow->brand_name}}</a>
  </li>
  @endforeach
  </ul>
<form style="" method="post" action="{{route('ajax-brand-filter')}}">
{{csrf_field()}}
<div class="row justify-content-center">
  <input type="hidden" name="manufacturer" id="manufacturer" value="<?php echo $filterdata['manufacturer'];?>">
  <div class="col-12">
  <label for="brandSelector">Select Brand</label>
  <select id="brandSelector" name="select_brand" class="form-control">
<option value="">Select Brand</option>
  @foreach($brands as $brandrow)
  <option <?php if($filterdata['manufacturer']==$brandrow->id){ echo 'selected'; }?> value="{{$brandrow->id}}">{{$brandrow->brand_name}}</option>
  @endforeach
  </select>
  </div>
  <div class="col-12">
  <label for="seriesSelector">Select Series</label>
  <select id="seriesSelector" name="select_series" class="form-control">
  <option value="">Select Series</option>
  <?php if(!empty($allseries)){ foreach($allseries as $series){?>
  <option <?php if($filterdata['select_category']==$series->id){ echo 'selected'; }?> value="<?php echo $series->id;?>"><?php echo $series->series_name;?></option>
  <?php }}?>
  </select>
  </div>
  <div class="col-12">
  <label for="categoriesSelector">Select Category</label>
  <select id="categoriesSelector" name="select_category" class="form-control">
  <option value="">Select Category</option>
  <?php if(!empty($allcategories)){ foreach($allcategories as $category){?>
  <option <?php if($filterdata['select_category']==$category->id){ echo 'selected'; }?> value="<?php echo $category->id;?>"><?php echo $category->cat_name;?></option>
  <?php }}?>
  </select>
  </div>
  <div class="col-12">
  <label for="subcategoriesSelector">Select Sub Category</label>
  <select id="subcategoriesSelector" name="select_sub_category" class="form-control">
  <option value="">Select Sub Category</option>
  <?php if(!empty($subcategories)){ foreach($subcategories as $subcategory){?>
  <option <?php if($filterdata['select_sub_category']==$subcategory->id){ echo 'selected'; }?> value="<?php echo $subcategory->id;?>"><?php echo $subcategory->cat_name;?></option>
  <?php }}?>
  </select>
  </div>
    </div>
<div class="row justify-content-center">
<div class="col-6">
<button type="button" class="btn btn-warning float-left home_brand_btn">Reset</button>
</div>
<div class="col-6">
<button type="button" onclick="AdvanceSearchfilter();" class="btn btn-warning float-right home_brand_btn">Search</button>
</div>
</div>
</form>
</div>
</div>
{{--
@include('includes.home-catalog')
--}}
<div class="product-filter-option">
<!--<h2 class="filter-title">{{$lang->doci}}</h2>-->
<h4 class="heading_three mb-4 pb-2 pt-2 pr-2 pl-2">Categories</h4>
<ul style="direction: ltr;">
@php
$x=0;
@endphp
@foreach($categories as $ctgry )
<li>
@if(count($ctgry['childcategories']) > 0)
<span style="display:none" href="#filter{{++$x}}" aria-expanded="false" data-toggle="collapse">
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
</div>

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

</li>
@endforeach
</ul>
</div>

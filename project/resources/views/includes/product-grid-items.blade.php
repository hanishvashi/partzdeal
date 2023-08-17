@foreach($cats as $prod)
{{-- LOOP STARTS --}}
{{-- Otherwise display products created by admin --}}
@php
$name = str_replace(" ","-",$prod->name);
@endphp
<div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4 align-self-center mt-2">

<div class="card">
<div class="card-body">
<a href="{{route('front.page',['slug' => $prod->slug])}}">
<div class="card-img-actions"> <img src="{{asset('assets/images/'.$store_code.'/products/thumb_'.$prod->photo)}}" class="card-img img-fluid" alt=""> </div>
</a>
<input type="hidden" value="{{$prod->id}}">
</div>
<div class="card-body bg-light text-center">
<div class="mb-2">
<h6 class="font-weight-semibold mb-2"> <a href="{{route('front.page',['slug' => $prod->slug])}}" class="text-default mb-2" data-abc="true">{{strlen($prod->name) > 65 ? substr($prod->name,0,65)."..." : $prod->name}}</a> </h6>
</div>
@if($gs->sign == 0)
<h4 class="mb-0 font-weight-semibold pricetxt">{{$curr->sign}}{{ number_format($prod->cprice, 2) }}
@if($prod->pprice != 0)
<del class="offer-price">{{$curr->sign}}{{round($prod->pprice * $curr->value,2)}}</del>
@endif
</h4>
@else
<h4 class="mb-0 font-weight-semibold">
{{round($prod->cprice * $curr->value,2)}}
@if($prod->pprice != 0)
<del class="offer-price">{{$curr->sign}}{{round($prod->pprice * $curr->value,2)}}</del>
@endif
{{$curr->sign}}
</h4>
@endif

@if($prod->is_tier_price == 1)
@php
$tier_prices = json_decode($prod->tier_prices,true);
$total_t_prices = count($tier_prices);
$lowestprice = min(array_column($tier_prices, 'price'));
@endphp
    @if($store_code=='partzdeal-india')
<div class="text-muted mb-3">As Low As: {{$curr->sign}}{{ number_format($lowestprice, 2) }}</div>
    @else
<div class="text-muted mb-3">As Low As: {{$curr->sign}}{{ $lowestprice }}</div>    
    @endif    
@endif
<div class="row nomargin">
<div class="col-lg-6"><button type="button"  data-productid="{{$prod->id}}" class="btn bg-cart addajaxcart btn160widht"><i class="fa fa-cart-plus"></i> Add to cart</button></div>
<div class="col-lg-6"><button type="button"  data-productid="{{$prod->id}}" data-productsku="{{$prod->sku}}" data-productname="{{$prod->name}}" class="btn bg-cart btn160widht enqbtn" data-toggle="modal" data-target="#InquiryModal"><i class="fa fa-info"></i> Enquire Now</button></div>
</div>
</div>
</div>
</div>
{{-- LOOP ENDS --}}
@endforeach
<div class="col-12">
<ul class="pagination justify-content-center">
<li class="page-item">
<?php if($page==1){ ?>
<a class="page-link" href="javascript:void(0)" aria-label="Previous">
<span aria-hidden="true">&laquo;</span>
<span class="sr-only">Previous</span>
</a>
<?php } else{ ?>
<a class="page-link pagelinknext" onclick="loadMoreData('<?php echo $page-1; ?>')" href="javascript:void(0)" data-pageid="<?php echo $page-1; ?>" aria-label="Previous">
<span aria-hidden="true">&laquo;</span>
<span class="sr-only">Previous</span>
</a>
<?php }?>
</li>
<?php
$range = 3;
$initial_num = $page - $range;
$condition_limit_num = ($page + $range)  + 1;
//$total/$items+1
$recordsPerPage = $limit;
$total_pages = ceil($total_product / $recordsPerPage);
for ($i=$initial_num; $i <$condition_limit_num; $i++) {
if (($i > 0) && ($i <= $total_pages)) {
?>
<li class="page-item <?php if($page == $i){echo 'active';} ?>">
<a href="javascript:void(0)" onclick="loadMoreData('<?php echo $i; ?>')" data-pageid="<?php echo $i; ?>" class="page-link pagelinka"><?php echo $i; ?></a>
</li>
<?php }

} ?>
<li class="page-item">
<?php if($page+1 <= $total_product/$limit+1 ){ ?>
<a class="page-link pagelinknext" onclick="loadMoreData('<?php echo $page+1; ?>')" data-pageid="<?php echo $page+1; ?>" href="javascript:void(0)" aria-label="Next">
<span aria-hidden="true">&raquo;</span>
<span class="sr-only">Next</span>
</a>
<?php }else{?>
<a class="page-link" href="javascript:void(0)" aria-label="Next">
<span aria-hidden="true">&raquo;</span>
<span class="sr-only">Next</span>
</a>
<?php }?>
</li>
</ul>
</div>

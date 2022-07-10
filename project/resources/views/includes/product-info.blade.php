<div class="col-md-7 col-lg-6 p-3 description_column">
    <div id="sticky-anchor"></div>
    <div id="sidebar" class="inner_detail">
      @if(strlen($product->name) > 40)
        <h3 class="productDetails-header">{{$product->name}}</h3>
      @else
      <h3 class="productDetails-header mb-3">{{$product->name}}</h3>
      @endif
      @if(!empty($brand_name))
      <h6 class="mb-1">Brand : {{$brand_name}}</h6>
      @endif
      <h6 class="mb-1">Product SKU: {{$product->sku}}</h6>
        @if($product->user_id != 0)

          @if(isset($product->user))
        <div class="productDetails-header-info">

        <div class="product-headerInfo__title">
          {{$lang->shop_name}}: <a style=" color:{{$gs->colors == null ? '#337ab7':$gs->colors}};" href="{{route('front.vendor',str_replace(' ', '-',($product->user->shop_url)))}}">{{$product->user->shop_name}}</a>
        </div>
        </div>
@endif
@else

{{-- Admin Contact --}}
        @endif
          @if($product->ship != null)
    <div class="productDetails-header-info">
        <div class="product-headerInfo__title">
          {{$lang->shipping_time}}: <span style="font-weight: 400;">{{ $product->ship}}.</span>
        </div>
    </div>
                  @endif

          @php
            $stk = (string)$product->stock;
          @endphp


        <p class="productDetails-reviews">
            <div class="ratings">
              <div class="empty-stars"></div>
              <div class="full-stars" style="width:{{App\Review::ratings($product->id)}}%"></div>
            </div>
          <span>{{count($product->reviews)}} {{$lang->dttl}}</span>
        </p>
        @if($gs->sign == 0)
        <h3 class="productDetails-price d-none d-md-block">
        @php
        $product_price = $product->cprice;
        @endphp
        {{$curr->sign}}<span class="pricetxts">{{ number_format($product->cprice, 2) }}</span>

        @if($product->pprice != null)
         <span><del>{{$curr->sign}}{{round($product->pprice * $curr->value,2)}}</del></span>
        @endif
       </h3>
<input type="hidden" id="product_price" value="{{$product_price}}"/>
       @else
       <h3 class="productDetails-price">

@php
$product_price = $product->cprice;
@endphp
          {{$curr->sign}}<span class="pricetxts">{{ number_format($product->cprice, 2) }}</span>
{{$curr->sign}}
        @if($product->pprice != null)
         <span><del>{{round($product->pprice * $curr->value,2)}}{{$curr->sign}}</del></span>
        @endif
        </h3>
<input type="hidden" id="product_price" value="{{$product_price}}"/>
       @endif

<?php if(!empty($product->size)){?>
<input type="hidden" id="product_option_size" value="0"/>
<?php }else{?>
<input type="hidden" id="product_option_size" value="1"/>
<?php }?>

        @if(!empty($product->size))
<div class="product-size">
<p class="title">{{ $lang->doo }} :</p>
<ul class="siz-list">
@php
$is_first = true;
@endphp
@foreach($size as $key => $data1)
<li class="{{ $is_first ? '' : '' }}">
<span class="box">{{ $data1 }}
<input type="hidden" class="size" value="{{ $data1 }}">
<input type="hidden" class="size_qty" value="{{ $size_qty[$key] }}">
<input type="hidden" class="size_key" value="{{$key}}">
<input type="hidden" class="size_price" value="{{ round($size_price[$key] * $curr->value,2) }}">
</span>
</li>
@php
$is_first = false;
@endphp
@endforeach
<li>
</ul>
</div>
@endif

<?php if(!empty($product->color)){?>
<input type="hidden" id="product_option_color" value="0"/>
<?php }else{?>
<input type="hidden" id="product_option_color" value="1"/>
<?php }?>

          @if(!empty($product->color))
<div class="product-color">
<p class="title">{{ $lang->colors }} :</p>
<ul class="color-list">
@php
$is_first = true;
@endphp
@foreach($color as $key => $data1)
<li class="{{ $is_first ? '' : '' }}">
<span class="box" data-color="{{ $color[$key] }}" style="background-color: {{ $color[$key] }}"></span>
</li>
@php
$is_first = false;
@endphp
@endforeach
</ul>
</div>
@endif
<?php if(!empty($tier_prices)){?>
<ul class="tier-prices product-pricing">
<?php foreach($tier_prices as $key=> $tierprice){
if($product->user_id != 0){
  $group_price = $tierprice['price'] + $gs->fixed_commission + ($tierprice['price']/100) * $gs->percentage_commission ;
}else{
  $group_price = $tierprice['price'];
}
?>
<li class="tier-price tier-<?php echo $key;?>">
Buy <?php echo round($tierprice['price_qty'],0);?> or more for <span class="price">{{$curr->sign}}{{ number_format($group_price, 2) }}</span> each
</li>
<?php }?>
</ul>
<?php }?>
        <div class="productDetails-quantity">
          <p>{{$lang->cquantity}}</p>
          <input type="hidden" id="stock" value="{{$product->stock}}">
          <span class="quantity-btn" id="qsub"><i class="fa fa-minus"></i></span>
          <span id="qval">{{$product->min_qty}}</span>
          <span class="quantity-btn" id="qadd"><i class="fa fa-plus"></i></span>
          <!--<span style="padding-left: 5px; border: none; font-weight: 700; font-size: 15px;">{{ $product->measure }}</span>-->
          <span style="padding-left: 5px; border: none; font-weight: 700; font-size: 15px; width: 100px;">In Stock</span>
        </div>

        @if($stk == "0")
        <a class="productDetails-addCart-btn addCart_btn d-none d-md-inline-block" style="cursor: no-drop;;">
          <i class="fa fa-cart-plus"></i> <span>{{$lang->dni}}</span>
        </a>
        @else
        <a class="productDetails-addCart-btn addCart_btn addtocartajax d-none d-md-inline-block" id="addcrt" style="cursor: pointer;">
          <i class="fa fa-cart-plus"></i> <span>{{$lang->hcs}}</span>
        </a>
        @endif
          <input type="hidden" id="pid" value="{{$product->id}}">
@if($product->size_guide != null)
<div class="col-12 p-0 mt-3 d-none d-md-block">
<a href="#sizeguideModel" data-toggle="modal" data-target="#sizeguideModel">Size Guide</a>
</div>
@endif





    <a style="cursor: pointer;" data-productid="{{$product->id}}" data-productsku="{{$product->sku}}" data-productname="{{$product->name}}" class="productDetails-addCart-btn addCart_btn no-wish enqbtn" data-toggle="modal" data-target="#InquiryModal"><span>Enquire Now</span></a>


        <div class="custom-tab d-none d-lg-block">
        <div class="row m-0 pb-1">
            <div class="col-12">
                <h2 class="heading_three mb-4">{{$lang->ddesc}}</h2>
                @if(strlen($product->description) > 70)
                    <p {!! $lang->rtl == 1 ? 'dir="rtl"' : ''!!}>{!! $product->description !!}</p>
                @else
                    <p {!! $lang->rtl == 1 ? 'dir="rtl"' : ''!!}>{!! $product->description !!}</p>
                 @endif
            </div>

            <div class="col-12">
                @if(Auth::guard('user')->check())

                    @if(Auth::guard('user')->user()->orders()->count() > 0)
                    <h1 class="heading_three mb-4">{{$lang->fpr}}</h1>
                    <hr>
                    @include('includes.form-success')
                    <div class="product-reviews">
                        <div class="review-star">
                          <div class='starrr' id='star1'></div>
                            <div>
                                <span class='your-choice-was' style='display: none;'>
                                  {{$lang->dofpl}}: <span class='choice'></span>.
                                </span>
                            </div>
                        </div>
                    </div>
                    <form class="product-review-form" action="{{route('front.review.submit')}}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{Auth::guard('user')->user()->id}}">
                        <input type="hidden" name="rating" id="rate" value="5">
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <div class="form-group">
                            <textarea name="review" id="" rows="5" placeholder="{{$lang->suf}}" class="form-control" style="resize: vertical;" required></textarea>
                        </div>
                        <div class="form-group text-center">
                            <input name="btn" type="submit" class="btn-review" value="Submit Review">
                        </div>
                    </form>
                    @else
                    <h3 class="heading_three mb-3">{{ $lang->product_review }}.</h3>
                    @endif
                    <hr>
                      <h1 class="heading_three mb-3">{{$lang->dttl}}: </h1>
                    <hr>
                    @forelse($product->reviews as $review)
                        <div class="review-rating-description">
                            <div class="row">
                              <div class="col-md-3 col-sm-3">
                                <p>{{$review->user->name}}</p>
                                <p class="product-reviews">
                                  <div class="ratings">
                                    <div class="empty-stars"></div>
                                    <div class="full-stars" style="width:{{$review->rating*20}}%"></div>
                                  </div>
                                </p>
                                <p>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $review->review_date)->diffForHumans()}}</p>
                              </div>
                              <div class="col-md-9 col-sm-9">
                                <p>{{$review->review}}</p>
                              </div>
                            </div>
                        </div>
                        @empty
                        <div class="row">
                            <div class="col-md-12">
                                <h4>{{$lang->md}}</h4>
                            </div>
                        </div>
                        @endforelse

                    @else

                        <h2 class="heading_three mb-4">{{$lang->dttl}}</h2>
                        @forelse($product->reviews as $review)
                        <div class="review-rating-description">
                            <div class="row">
                              <div class="col-12 col-md-3">
                                <p>{{$review->user->name}}</p>
                                <p class="product-reviews">
                                  <div class="ratings">
                                    <div class="empty-stars"></div>
                                    <div class="full-stars" style="width:{{$review->rating*20}}%"></div>
                                  </div>
                              </p>
                                <p>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $review->review_date)->diffForHumans()}}</p>
                              </div>
                              <div class="col-12 col-md-9">
                                <p>{{$review->review}}</p>
                              </div>
                            </div>
                        </div>
                        @empty
                        <div class="row">
                            <div class="col-md-12">
                                <h4>{{$lang->md}}</h4>
                            </div>
                        </div>
                    @endforelse
                @endif
            </div>

        </div>
    </div>
        </div>
    </div>

@extends('layouts.product')
@section('styles')
    <style type="text/css">
.replay-btn, .replay-btn-edit, .replay-btn-delete, .replay-btn-edit1, .replay-btn-delete1, .replay-btn-edit2, .replay-btn-delete2, .subreplay-btn, .view-replay-btn {
    color: {{$gs->colors == null ? 'gray' : $gs->colors}};
    font-weight: 700;
    }
    #comments .reply {
    padding-left: 52px;
    }
    @if($lang->rtl == 1)
    #comments .reply {
    padding-left: 0;
    padding-right: 52px;
    }
    .single-blog-comments-wrap.replay {margin-left: 0; margin-right: 40px;}
    @endif
    </style>
@endsection
@section('content')
@php
$i=1;
$j=1;
@endphp
    <!--  Starting of product description area   -->
    <div class="section-padding product-details-wrapper" style="padding-top: 20px; padding-bottom: 15px;">
      <div class="container">
                    <div class="breadcrumb-box" style="margin-bottom: 15px;">
                        <a href="{{route('front.index')}}">{{ucfirst(strtolower($lang->home))}}</a>
                        <a href="{{route('front.category',$product->category->cat_slug)}}">{{$product->category->cat_name}}</a>
                        @if(!empty($product->subcategory))
                        <a href="{{route('front.subcategory',$product->subcategory->sub_slug)}}">{{$product->subcategory->sub_name}}</a>
                        @endif
                        @if(!empty($product->childcategory))
                        <a href="{{route('front.childcategory',$product->childcategory->child_slug)}}">{{$product->childcategory->child_name}}</a>
                        @endif
                        <a href="{{route('front.product',['id1' => $product->id , 'id2' => $product->name])}}">{{$product->name}}</a>
            </div>

            @if($lang->rtl == 1)

{{-- if rtl display right to left --}}
        <div class="row">
                <div class="col-md-7 col-sm-7 col-xs-12"  dir="rtl">
                  @if(strlen($product->name) > 40)
                    <h3 class="productDetails-header">{{$product->name}}</h3>
                  @else
                  <h3 class="productDetails-header">{{$product->name}}</h3>
                  @endif
                  <h6>Product ID: {{sprintf("%'.08d", $product->id)}}</h6>
                    @if($product->user_id != 0)

                      @if(isset($product->user))
                    <div class="productDetails-header-info">

                    <div class="product-headerInfo__title">
              {{$lang->shop_name}}: <a style=" color:{{$gs->colors == null ? '#337ab7':$gs->colors}};" href="{{route('front.vendor',str_replace(' ', '-',($product->user->shop_name)))}}">{{$product->user->shop_name}}</a>
            </div>
                                     @if(Auth::guard('user')->check())
          <div class="product-headerInfo__btns">
            @if( Auth::guard('user')->user()->favorites()->where('vendor_id','=',$product->user->id)->get()->count() > 0)
              <a class="headerInfo__btn colored"><i class="fa fa-check"></i> {{ $lang->product_favorite }}</a>
              @if(isset($vendor))
              <a id="product_email" data-toggle="modal" data-target="#emailModal" style="cursor: pointer;" class="headerInfo__btn colored"><i class="fa fa-comments"></i> {{ $lang->contact_seller}}</a>
              @endif
            @else
            <a style="cursor: pointer;" id="favorite" class="headerInfo__btn">
              <input type="hidden" id="fav" value="{{$product->user->id}}">
              <i class="fa fa-plus"></i> {{$lang->add_seller}}
            </a>
            @endif
            
            </div>
                                            @else
          <div class="product-headerInfo__btns">
            <a style="cursor: pointer;" class="headerInfo__btn no-wish" data-toggle="modal" data-target="#loginModal"><i class="fa fa-plus"></i> {{$lang->add_seller}}</a>
            </div>
          <div class="product-headerInfo__btns">
            <a style="cursor: pointer;" class="headerInfo__btn no-wish" data-toggle="modal" data-target="#loginModal"><i class="fa fa-comments"></i> {{$lang->contact_seller}}</a>
          </div>
                                            @endif


          </div>
          @endif

          @else

          {{-- Admin Contact --}}
                  
                    <div class="productDetails-header-info">
                      @if(Auth::guard('user')->check())
                        <a style="cursor: pointer;" class="headerInfo__btn no-wish" data-toggle="modal" data-target="#emailModal1"><i class="fa fa-comments"></i> {{$lang->contact_seller}}</a>
                      @else
                      <div class="product-headerInfo__btns">
                        <a style="cursor: pointer;" class="headerInfo__btn no-wish" data-toggle="modal" data-target="#loginModal"><i class="fa fa-comments"></i> {{$lang->contact_seller}}</a>
                      </div>
                      @endif
                    </div>



                    @endif
                      @if($product->youtube != null)                    
<div class="productVideo__title">
  <div class="text-right" dir="ltr">
            {{$lang->watch_video}}: <a style="color: {{$gs->colors == null ? '#337ab7':$gs->colors}};" class="fancybox" data-fancybox="" href="{{$product->youtube}}"><i class="fa fa-play-circle"></i></a>
          </div>
  </div>
          @endif

                      @if($product->type == 2)
                          <div class="productVideo__title">
                              {{$lang->platform}}{{$product->platform}}
                          </div>
                          <div class="productVideo__title">
                              {{$lang->region}}{{$product->region}}
                          </div>
                          <div class="productVideo__title">
                              {{$lang->licence_type}}{{$product->licence_type}}
                          </div>
                      @endif


                      @if($product->product_condition != 0)
           <div class="productDetails-header-info">

                    <div class="product-headerInfo__title" dir="ltr">
              {{$lang->product_condition}}: <span style="font-weight: 400;">{{ $product->product_condition == 1 ?'Used' : 'New'}}.<span>
            </div>
          </div>
                      @endif
                      @if($product->ship != null)
           <div class="productDetails-header-info">

                    <div class="product-headerInfo__title" dir="ltr">
              {{$lang->shipping_time}}: <span style="font-weight: 400;">{{ $product->ship}}.</span>
            </div>
          </div>
                      @endif
                      
                      @php
                        $stk = (string)$product->stock;
                      @endphp

@if($product->type == 0)
                      @if($stk == "0")
                    <p class="productDetails-status" style="color: red;">
                      <i class="fa fa-times-circle-o"></i>
                      <span>{{$lang->dni}}</span>
                    </p>
                      @else
                    <p class="productDetails-status" style="color: green;">
                      <i class="fa fa-check-square-o"></i>
                      <span>{{$lang->sbg}}</span>
                    </p>
                      @endif
@endif
                    <p class="productDetails-reviews">
                        <div class="ratings" dir="ltr">
                          <div class="empty-stars"></div>
                          <div class="full-stars" style="width:{{App\Review::ratings($product->id)}}%"></div>
                        </div>
                      <span>{{count($product->reviews)}} {{$lang->dttl}}</span>
                    </p>
                    @if($gs->sign == 0)
                    <h1 class="productDetails-price text-right" dir="ltr">{{$curr->sign}}
                    @if($product->user_id != 0)
                      @php
                      $price = $product->cprice + $gs->fixed_commission + ($product->cprice/100) * $gs->percentage_commission ;
                      @endphp
                      {{round($price * $curr->value,2)}}
                    @else
                      {{round($product->cprice * $curr->value,2)}}
                    @endif                   

                    @if($product->pprice != null)
                     <span><del>{{$curr->sign}}{{round($product->pprice * $curr->value,2)}}</del></span>
                    @endif
                   </h1>
                   @else
                   <h1 class="productDetails-price">
                    @if($product->user_id != 0)
                      @php
                      $price = $product->cprice + $gs->fixed_commission + ($product->cprice/100) * $gs->percentage_commission ;
                      @endphp
                      {{round($price * $curr->value,2)}}
                    @else
                      {{round($product->cprice * $curr->value,2)}}
                    @endif                   
{{$curr->sign}}
                    @if($product->pprice != null)
                     <span><del>{{round($product->pprice * $curr->value,2)}}{{$curr->sign}}</del></span>
                    @endif  
                    </h1>                 
                   @endif
                      @if($product->size != null)
                    <div class="productDetails-size">
                      <p>{{$lang->doo}}</p>
                      @foreach($size as $sz)
                      <span class="psize">{{$sz}}</span>
                      @endforeach
                    </div>
                      @endif
                      @if($product->color != null)
                    <div class="productDetails-color">
                      <p>{{$lang->colors}}</p>
                      @foreach($color as $cl)
                      <span class="pcolor" style="background: {{$cl}};">{{$cl}}</span>
                      @endforeach
                    </div>
                    @endif
                    <div class="productDetails-quantity">
                      <p>{{$lang->cquantity}}</p>
                      <input type="hidden" id="stock" value="{{$product->stock}}">
                      <span class="quantity-btn" id="qsub"><i class="fa fa-minus"></i></span>
                      <span id="qval">1</span>
                      <span class="quantity-btn" id="qadd"><i class="fa fa-plus"></i></span>
                    <span style="padding-left: 5px; border: none; font-weight: 700; font-size: 15px;">{{ $product->measure }}</span>
                    </div>
                    @if($stk == "0")
                    <a class="productDetails-addCart-btn" style="cursor: no-drop;;">
                      <i class="fa fa-cart-plus"></i> <span>{{$lang->dni}}</span>
                    </a>
                    @else
                    <a class="productDetails-addCart-btn" id="addcrt" style="cursor: pointer;">
                      <i class="fa fa-cart-plus"></i> <span>{{$lang->hcs}}</span>
                    </a>
                    @endif
                      <input type="hidden" id="pid" value="{{$product->id}}">
                                @if(Auth::guard('user')->check())
                                    <a style="cursor: pointer;" class="productDetails-addCart-btn" id="wish"><i class="fa fa-heart"></i> <span>{{$lang->wishlist_add}}</span></a>
                                @else
      <a style="cursor: pointer;" class="productDetails-addCart-btn no-wish"    data-toggle="modal" data-target="#loginModal"><i class="fa fa-heart"></i> <span>{{$lang->wishlist_add}}</span></a>
                                @endif
                        <div class="social-sharing a2a_kit a2a_kit_size_32">
                            <a class="facebook a2a_button_facebook" href=""><i class="fa fa-facebook"></i> Share </a>
                            <a class="twitter a2a_button_twitter" href=""><i class="fa fa-twitter"></i> Tweet</a>
                            <a class="pinterest a2a_button_google_plus" href=""><i class="fa fa-pinterest"></i> Pinterest</a>
                            <a class="a2a_dd" href="https://www.addtoany.com/share" style="position: absolute; background-color: rgb(1, 102, 255); "></a>
                        </div>
                            <script async src="https://static.addtoany.com/menu/page.js"></script>
                </div>
                <div class="col-md-5 col-sm-5 col-xs-12">
                  <div class="product-review-carousel-img product-zoom" style="cursor: zoom-in;">
                    <img id="imageDiv" src="{{asset('assets/images/'.$product->photo)}}" alt="Product image">
                  </div>
                  <div class="owl-carousel product-review-owl-carousel">
                    <div class="single-product-item small-img">
                      <img style="height: 80px; width: 95px;" id="iconOne" onclick="productGallery(this.id)" src="{{asset('assets/images/'.$product->photo)}}" alt="Product image">
                    </div>
                    @foreach($product->galleries as $gallery)
                    <div class="single-product-item small-img">
                      <img style="height: 80px; width: 95px;" id="icon{{$gallery->id}}" onclick="productGallery(this.id)" src="{{asset('assets/images/gallery/'.$gallery->photo)}}" alt="Product image">
                    </div>
                    @endforeach
                  </div>

                </div>
              </div>
            @else
{{-- Else Display the regular way --}}
        <div class="row">
                <div class="col-md-5 col-sm-5 col-xs-12">
                  <div class="product-review-carousel-img product-zoom" style="cursor: zoom-in;">
                    <img id="imageDiv" src="{{asset('assets/images/'.$product->photo)}}" alt="Product image">
                  </div>
                  <div class="owl-carousel product-review-owl-carousel">
                    <div class="single-product-item small-img">
                      <img style="height: 80px; width: 95px;" id="iconOne" onclick="productGallery(this.id)" src="{{asset('assets/images/'.$product->photo)}}" alt="Product image">
                    </div>
                    @foreach($product->galleries as $gallery)
                    <div class="single-product-item small-img">
                      <img style="height: 80px; width: 95px;" id="icon{{$gallery->id}}" onclick="productGallery(this.id)" src="{{asset('assets/images/gallery/'.$gallery->photo)}}" alt="Product image">
                    </div>
                    @endforeach
                  </div>

                </div>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  @if(strlen($product->name) > 40)
                    <h3 class="productDetails-header">{{$product->name}}</h3>
                  @else
                  <h3 class="productDetails-header">{{$product->name}}</h3>
                  @endif
                  <h6>Product ID: {{sprintf("%'.08d", $product->id)}}</h6>
                    @if($product->user_id != 0)

                      @if(isset($product->user))
                    <div class="productDetails-header-info">

                    <div class="product-headerInfo__title">
              {{$lang->shop_name}}: <a style=" color:{{$gs->colors == null ? '#337ab7':$gs->colors}};" href="{{route('front.vendor',str_replace(' ', '-',($product->user->shop_name)))}}">{{$product->user->shop_name}}</a>
            </div>
                                     @if(Auth::guard('user')->check())
          <div class="product-headerInfo__btns">
            @if( Auth::guard('user')->user()->favorites()->where('vendor_id','=',$product->user->id)->get()->count() > 0)
              <a class="headerInfo__btn colored"><i class="fa fa-check"></i> {{ $lang->product_favorite }}</a>
              @if(isset($vendor))
              <a id="product_email" data-toggle="modal" data-target="#emailModal" style="cursor: pointer;" class="headerInfo__btn colored"><i class="fa fa-comments"></i> {{ $lang->contact_seller}}</a>
              @endif
            @else
            <a style="cursor: pointer;" id="favorite" class="headerInfo__btn">
              <input type="hidden" id="fav" value="{{$product->user->id}}">
              <i class="fa fa-plus"></i> {{ $lang->add_seller }}
            </a>
            @endif
            
            </div>
                                            @else
          <div class="product-headerInfo__btns">
            <a style="cursor: pointer;" class="headerInfo__btn no-wish" data-toggle="modal" data-target="#loginModal"><i class="fa fa-plus"></i> {{$lang->add_seller}}</a>
            </div>
          <div class="product-headerInfo__btns">
            <a style="cursor: pointer;" class="headerInfo__btn no-wish" data-toggle="modal" data-target="#loginModal"><i class="fa fa-comments"></i> {{$lang->contact_seller}}</a>
          </div>
                                            @endif


          </div>
          @endif
          @else

          {{-- Admin Contact --}}


                    <div class="productDetails-header-info">
                      @if(Auth::guard('user')->check())
                        <a style="cursor: pointer;" class="headerInfo__btn no-wish" data-toggle="modal" data-target="#emailModal1"><i class="fa fa-comments"></i> {{$lang->contact_seller}}</a>
                      @else
                      <div class="product-headerInfo__btns">
                        <a style="cursor: pointer;" class="headerInfo__btn no-wish" data-toggle="modal" data-target="#emailModal1"><i class="fa fa-comments"></i> {{$lang->contact_seller}}</a>
                      </div>
                      @endif
                    </div>

                    @endif
                      @if($product->youtube != null)                    
<div class="productVideo__title">
            {{$lang->watch_video}}: <a style=" color:{{$gs->colors == null ? '#337ab7':$gs->colors}};" class="fancybox" data-fancybox="" href="{{$product->youtube}}"><i class="fa fa-play-circle"></i></a>
          </div>

          @endif
                      @if($product->type == 2)
                          <div class="productVideo__title">
                              {{$lang->platform}}{{$product->platform}}
                          </div>
                          <div class="productVideo__title">
                              {{$lang->region}}{{$product->region}}
                          </div>
                          <div class="productVideo__title">
                              {{$lang->licence_type}}{{$product->licence_type}}
                          </div>
                      @endif
                      @if($product->product_condition != 0)
           <div class="productDetails-header-info">

                    <div class="product-headerInfo__title">
              {{$lang->product_condition}}: <span style="font-weight: 400;">{{ $product->product_condition == 1 ?'Used' : 'New'}}.<span>
            </div>
          </div>
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

@if($product->type == 0)
                      @if($stk == "0")
                    <p class="productDetails-status" style="color: red;">
                      <i class="fa fa-times-circle-o"></i>
                      <span style="font-weight: 700;">{{$lang->dni}}</span>
                    </p>
                      @else
                    <p class="productDetails-status" style="color: green;">
                      <i class="fa fa-check-square-o"></i>
                      <span style="font-weight: 700;">{{$lang->sbg}}</span>
                    </p>
                      @endif
@endif
                    <p class="productDetails-reviews">
                        <div class="ratings">
                          <div class="empty-stars"></div>
                          <div class="full-stars" style="width:{{App\Review::ratings($product->id)}}%"></div>
                        </div>
                      <span>{{count($product->reviews)}} {{$lang->dttl}}</span>
                    </p>
                    @if($gs->sign == 0)
                    <h1 class="productDetails-price">{{$curr->sign}}
                    @if($product->user_id != 0)
                      @php
                      $price = $product->cprice + $gs->fixed_commission + ($product->cprice/100) * $gs->percentage_commission ;
                      @endphp
                      {{round($price * $curr->value,2)}}
                    @else
                      {{round($product->cprice * $curr->value,2)}}
                    @endif                   

                    @if($product->pprice != null)
                     <span><del>{{$curr->sign}}{{round($product->pprice * $curr->value,2)}}</del></span>
                    @endif
                   </h1>
                   @else
                   <h1 class="productDetails-price">
                    @if($product->user_id != 0)
                      @php
                      $price = $product->cprice + $gs->fixed_commission + ($product->cprice/100) * $gs->percentage_commission ;
                      @endphp
                      {{round($price * $curr->value,2)}}
                    @else
                      {{round($product->cprice * $curr->value,2)}}
                    @endif                   
{{$curr->sign}}
                    @if($product->pprice != null)
                     <span><del>{{round($product->pprice * $curr->value,2)}}{{$curr->sign}}</del></span>
                    @endif  
                    </h1>                 
                   @endif
                      @if($product->size != null)
                    <div class="productDetails-size">
                      <p>{{$lang->doo}}</p>
                      @foreach($size as $sz)
                      <span class="psize">{{$sz}}</span>
                      @endforeach
                    </div>
                      @endif
                      @if($product->color != null)
                    <div class="productDetails-color">
                      <p>{{$lang->colors}}</p>
                      @foreach($color as $cl)
                      <span class="pcolor" style="background: {{$cl}};">{{$cl}}</span>
                      @endforeach
                    </div>
                    @endif
                    <div class="productDetails-quantity">
                      <p>{{$lang->cquantity}}</p>
                      <input type="hidden" id="stock" value="{{$product->stock}}">
                      <span class="quantity-btn" id="qsub"><i class="fa fa-minus"></i></span>
                      <span id="qval">1</span>
                      <span class="quantity-btn" id="qadd"><i class="fa fa-plus"></i></span>
                    <span style="padding-left: 5px; border: none; font-weight: 700; font-size: 15px;">{{ $product->measure }}</span>
                    </div>
                    @if($stk == "0")
                    <a class="productDetails-addCart-btn" style="cursor: no-drop;;">
                      <i class="fa fa-cart-plus"></i> <span>{{$lang->dni}}</span>
                    </a>
                    @else
                    <a class="productDetails-addCart-btn" id="addcrt" style="cursor: pointer;">
                      <i class="fa fa-cart-plus"></i> <span>{{$lang->hcs}}</span>
                    </a>
                    @endif
                      <input type="hidden" id="pid" value="{{$product->id}}">
                                @if(Auth::guard('user')->check())
                                    <a style="cursor: pointer;" class="productDetails-addCart-btn" id="wish"><i class="fa fa-heart"></i> <span>{{$lang->wishlist_add}}</span></a>
                                @else
      <a style="cursor: pointer;" class="productDetails-addCart-btn no-wish"    data-toggle="modal" data-target="#loginModal"><i class="fa fa-heart"></i> <span>{{$lang->wishlist_add}}</span></a>
                                @endif
                        <div class="social-sharing a2a_kit a2a_kit_size_32">
                            <a class="facebook a2a_button_facebook" href=""><i class="fa fa-facebook"></i> Share </a>
                            <a class="twitter a2a_button_twitter" href=""><i class="fa fa-twitter"></i> Tweet</a>
                            <a class="pinterest a2a_button_google_plus" href=""><i class="fa fa-pinterest"></i> Pinterest</a>
                            <a class="a2a_dd" href="https://www.addtoany.com/share" style="position: absolute; background-color: rgb(1, 102, 255); "></a>
                        </div>
                            <script async src="https://static.addtoany.com/menu/page.js"></script>
                </div>
              </div>

            @endif


      </div>
    </div>
    <!--  Ending of product description area   -->

    <!--  Starting of product detail tab area   -->
    <div class="container">
      <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="custom-tab">
                 <div class="row">
                     <div class="col-md-3">
                         <ul class="tab-list">
                              <li class="active"><a data-toggle="tab" href="#overview-tab-1">{{$lang->ddesc}}</a></li>
                              <li><a data-toggle="tab" href="#pricing-tab-2">{{$lang->ppr}}</a></li>
                              <li dir="ltr"><a data-toggle="tab" href="#location-tab-3">{{$lang->dttl}}({{count($product->reviews)}})</a></li>
                          </ul>
                     </div>
                     
                     <div class="col-md-9">
                         <div class="tab-content">
              @if(strlen($product->description) > 70)

                              <div id="overview-tab-1" class="tab-pane active fade in">
                                  <p {!! $lang->rtl == 1 ? 'dir="rtl"' : ''!!}>{!! $product->description !!}</p>
                              </div>

            @else
                              <div id="overview-tab-1" class="tab-pane active fade in">
                                  <p {!! $lang->rtl == 1 ? 'dir="rtl"' : ''!!}>{!! $product->description !!}</p>
                              </div>  

            @endif

              @if(strlen($product->policy) > 70)
                              <div id="pricing-tab-2" class="tab-pane fade">
                                  <p {!! $lang->rtl == 1 ? 'dir="rtl"' : ''!!}>{!! $product->policy !!}</p>
                              </div>
            @else
                              <div id="pricing-tab-2" class="ttab-pane fade">
                                  <p {!! $lang->rtl == 1 ? 'dir="rtl"' : ''!!}>{!! $product->policy !!}</p>
                              </div>  

            @endif

                              <div id="location-tab-3" class="tab-pane fade">
                                  <div>
                                      @if(Auth::guard('user')->check())

                                      @if(Auth::guard('user')->user()->orders()->count() > 0)
                                    <h1>{{$lang->fpr}}</h1>
                                    <hr>
                                      @include('includes.form-success')
                                    <p class="product-reviews">
                                        <div class="review-star">
                                          <div class='starrr' id='star1'></div>
                                            <div>
                                                <span class='your-choice-was' style='display: none;'>
                                                  {{$lang->dofpl}}: <span class='choice'></span>.
                                                </span>
                                            </div>
                                        </div>
                                    </p>
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
                                    <h3>{{ $lang->product_review }}.</h3>
                                    @endif
                                    <hr>
                                      <h1>{{$lang->dttl}}: </h1>
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
                                    <hr>

                                    @else


        <div class="col-lg-12 pt-50">
          <div class="blog-comments-area product">
            <hr>
            <h3 class="text-center"><a style="cursor: pointer; background-color: {{$gs->colors == null ? '#007bff':$gs->colors}}; border-color: {{$gs->colors == null ? '#007bff':$gs->colors}}; padding: 8px 12px;"  class="no-wish btn btn-primary" data-toggle="modal" data-target="#loginModal">{{$lang->comment_login}}</a> {{ $lang->to_review }} </h3>
            <hr>
          </div>
        </div>
                                    <hr>
                                      <h1>{{$lang->dttl}}: </h1>
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
                                    <hr>
      </div>
    </div>
                                    @endif

                                  </div>
                              </div>
                          </div>
                     </div>
                 </div>  
              </div>
          </div>
      </div>
    </div>
    <!--  Ending of product detail tab area   -->

<br>

@include('includes.comment-replies')

  <!--  Starting of product detail carousel area   -->
  <div class="section-padding productDetails-carousel-wrap">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-title">
            <h2>{{$lang->amf}}</h2>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="owl-carousel featured-carousel">
            @foreach($product->category->products()->where('status','=',1)->get() as $prod)
                                {{-- LOOP STARTS --}}
                                {{-- If This product belongs to vendor then apply this --}}
                                @if($prod->user_id != 0)

                                {{-- check  If This vendor status is active --}}
                                @if($prod->user->is_vendor == 2)
                                      @php
                                          $name = str_replace(" ","-",$prod->name);
                                      @endphp
                        <a href="{{route('front.product',['id' => $prod->id, 'slug' => $name])}}" class="single-product-area text-center">
                          <div class="product-image-area">
                                            @if($prod->features!=null && $prod->colors!=null)
                                            @php
                                            $title = explode(',', $prod->features);
                                            $details = explode(',', $prod->colors);
                                            @endphp
                                            <div class="featured-tag" style="width: 100%;">
                                              @foreach(array_combine($title,$details) as $ttl => $dtl)
                                              <style type="text/css">
                                                span#d{{$j++}}:after {
                                                    border-left: 10px solid {{$dtl}};
                                                }
                                              </style>
                                              <span id="d{{$i++}}" style="background: {{$dtl}}">{{$ttl}}</span>
                                              @endforeach
                                            </div>
                                            @endif
                            <img src="{{asset('assets/images/'.$prod->photo)}}" alt="featured product">
                            @if($prod->youtube != null)
                            <div class="product-hover-top">
                              <span class="fancybox" data-fancybox href="{{$prod->youtube}}"><i class="fa fa-play-circle"></i></span>
                            </div>
                            @endif

                            <div class="gallery-overlay"></div>
<div class="gallery-border"></div>
<div class="product-hover-area">
                    <input type="hidden" value="{{$prod->id}}">
                    @if(Auth::guard('user')->check())
                      <span class="wishlist hovertip uwish" rel-toggle="tooltip" title="{{$lang->wishlist_add}}"><i class="fa fa-heart"></i>
                                <span class="wish-number">{{App\Wishlist::where('product_id','=',$prod->id)->get()->count() }}</span>
                              </span>
                    @else
                      <span class="wishlist hovertip no-wish" data-toggle="modal" data-target="#loginModal" rel-toggle="tooltip" title="{{$lang->wishlist_add}}"><i class="fa fa-heart"></i>
                                <span class="wish-number">{{App\Wishlist::where('product_id','=',$prod->id)->get()->count() }}</span>
                              </span>
                    @endif
                    <span class="wish-list hovertip wish-listt" data-toggle="modal" data-target="#myModal" rel-toggle="tooltip" title="{{$lang->quick_view}}"><i class="fa fa-eye"></i>
                              </span>
                              <span class="hovertip addcart" rel-toggle="tooltip" title="{{$lang->hcs}}"><i class="fa fa-cart-plus"></i>
                              </span>
                              <span class="hovertip compare" rel-toggle="tooltip" title="{{$lang->compare}}"><i class="fa fa-exchange"></i>
                              </span>
                            </div>



                          </div>
                          <div class="product-description text-center">
                            <div class="product-name">{{strlen($prod->name) > 65 ? substr($prod->name,0,65)."..." : $prod->name}}</div>
                            <div class="product-review">
                                                  <div class="ratings">
                                                      <div class="empty-stars"></div>
                                                      <div class="full-stars" style="width:{{App\Review::ratings($prod->id)}}%"></div>
                                                  </div>
                            </div>
                      @php
                      $price = $prod->cprice + $gs->fixed_commission + ($prod->cprice/100) * $gs->percentage_commission ;
                      @endphp
                                    @if($gs->sign == 0)
                                        <div class="product-price">{{$curr->sign}}
                      {{round($price * $curr->value,2)}}
                    <del class="offer-price">{{$curr->sign}}{{round($prod->pprice * $curr->value,2)}}</del>  

                                        </div>
                                    @else
                                        <div class="product-price">
                      {{round($price * $curr->value,2)}}
                    <del class="offer-price">{{$curr->sign}}{{round($prod->pprice * $curr->value,2)}}</del>  
{{$curr->sign}}
                                        </div>
                                    @endif
                          </div>
                        </a>
                            @endif

                                {{-- Otherwise display products created by admin --}}

                                @else

                                      @php
                                          $name = str_replace(" ","-",$prod->name);
                                      @endphp
                        <a href="{{route('front.product',['id' => $prod->id, 'slug' => $name])}}" class="single-product-area text-center">
                          <div class="product-image-area">
                                            @if($prod->features!=null && $prod->colors!=null)
                                            @php
                                            $title = explode(',', $prod->features);
                                            $details = explode(',', $prod->colors);
                                            @endphp
                                            <div class="featured-tag" style="width: 100%;">
                                              @foreach(array_combine($title,$details) as $ttl => $dtl)
                                              <style type="text/css">
                                                span#d{{$j++}}:after {
                                                    border-left: 10px solid {{$dtl}};
                                                }
                                              </style>
                                              <span id="d{{$i++}}" style="background: {{$dtl}}">{{$ttl}}</span>
                                              @endforeach
                                            </div>
                                            @endif
                            <img src="{{asset('assets/images/'.$prod->photo)}}" alt="featured product">
                            @if($prod->youtube != null)
                            <div class="product-hover-top">
                              <span class="fancybox" data-fancybox href="{{$prod->youtube}}"><i class="fa fa-play-circle"></i></span>
                            </div>
                            @endif

                            <div class="gallery-overlay"></div>
<div class="gallery-border"></div>
<div class="product-hover-area">
                    <input type="hidden" value="{{$prod->id}}">
                    @if(Auth::guard('user')->check())
                      <span class="wishlist hovertip uwish" rel-toggle="tooltip" title="{{$lang->wishlist_add}}"><i class="fa fa-heart"></i>
                                <span class="wish-number">{{App\Wishlist::where('product_id','=',$prod->id)->get()->count() }}</span>
                              </span>
                    @else
                      <span class="wishlist hovertip no-wish" data-toggle="modal" data-target="#loginModal" rel-toggle="tooltip" title="{{$lang->wishlist_add}}"><i class="fa fa-heart"></i>
                                <span class="wish-number">{{App\Wishlist::where('product_id','=',$prod->id)->get()->count() }}</span>
                              </span>
                    @endif
                    <span class="wish-list hovertip wish-listt" data-toggle="modal" data-target="#myModal" rel-toggle="tooltip" title="{{$lang->quick_view}}"><i class="fa fa-eye"></i>
                              </span>
                              <span class="hovertip addcart" rel-toggle="tooltip" title="{{$lang->hcs}}"><i class="fa fa-cart-plus"></i>
                              </span>
                              <span class="hovertip compare" rel-toggle="tooltip" title="{{$lang->compare}}"><i class="fa fa-exchange"></i>
                              </span>
                            </div>



                          </div>
                          <div class="product-description text-center">
                            <div class="product-name">{{strlen($prod->name) > 65 ? substr($prod->name,0,65)."..." : $prod->name}}</div>
                            <div class="product-review">
                                                  <div class="ratings">
                                                      <div class="empty-stars"></div>
                                                      <div class="full-stars" style="width:{{App\Review::ratings($prod->id)}}%"></div>
                                                  </div>
                            </div>
                                    @if($gs->sign == 0)
                                        <div class="product-price">{{$curr->sign}}
                      {{round($prod->cprice * $curr->value,2)}}
                    <del class="offer-price">{{$curr->sign}}{{round($prod->pprice * $curr->value,2)}}</del>  

                                        </div>
                                    @else
                                        <div class="product-price">
                      {{round($prod->cprice * $curr->value,2)}}
                    <del class="offer-price">{{$curr->sign}}{{round($prod->pprice * $curr->value,2)}}</del>  
{{$curr->sign}}
                                        </div>
                                    @endif
                          </div>
                        </a>
                            @endif
                                {{-- LOOP ENDS --}}
            @endforeach
            </div>
        </div>
      </div>
    </div>
  </div>
  <!--  Ending of product detail carousel area   -->



@endsection

@section('scripts')

<style type="text/css">
 img#imageDiv {
    height: 460px;
    width: 460px;
  }
@media only screen and (max-width: 768px) { 

 img#imageDiv {
    height: 280px;
    width: 280px;
  }
   
    }
@media only screen and (max-width: 767px) { 
  .product-review-carousel-img
  {
    max-width: 300px;
    margin: 30px auto;
  }
 img#imageDiv {
    height: 300px;
    width: 300px;
  }
   
    }
</style>
<script type="text/javascript">

  function productGallery(file){
    var image = $("#"+file).attr('src');
    $('#imageDiv').attr('src',image);
    $('.zoomImg').attr('src',image);
  }


    // var size = $(this).html();
    // $('#size').val(size);

    $('#star1').starrr({
        rating: 5,
        change: function(e, value){
            if (value) {
                $('.your-choice-was').show();
                $('.choice').text(value);
                $('#rate').val(value);
            } else {
                $('.your-choice-was').hide();
            }
        }
    });

</script>

<script type="text/javascript">
    var sizes = "";
    var colors = "";
    var stock = $("#stock").val();

    $(document).on("click", ".psize" , function(){
     $('.psize').removeClass('pselected-size');
     $(this).addClass('pselected-size');
     sizes = $(this).html();
  });

    $(document).on("click", ".pcolor" , function(){
     $('.pcolor').removeClass('pselected-color');
     $(this).addClass('pselected-color');
     colors = $(this).html();
  });

    $(document).on("click", "#qsub" , function(){
         var qty = $("#qval").html();
         qty--;
         if(qty < 1)
         {
         $("#qval").html("1");            
         }
         else{
         $("#qval").html(qty);
         }
    });
    $(document).on("click", "#qadd" , function(){
        var qty = $("#qval").html();
        if(stock != "")
        {
        var stk = parseInt(stock);
          if(qty < stk)
          {
             qty++;
             $("#qval").html(qty);               
          }

        }
        else{
         qty++;
         $("#qval").html(qty);          
        }

    });

    $(document).on("click", "#addcrt" , function(){
     var qty = $("#qval").html();
     var pid = $("#pid").val();
             $(".empty").html("");
                $.ajax({
                        type: "GET",
                        url:"{{URL::to('/json/addnumcart')}}",
                        data:{id:pid,qty:qty,size:sizes,color:colors},
                    success:function(data){
                        if(data == 0)
                        {
                        $.notify("{{$gs->cart_error}}","error");
                        }
                        else{
                        $(".empty").html("");
                        $(".total").html((data[0] * {{$curr->value}}).toFixed(2));
                        $(".cart-quantity").html(data[2]);
                        var arr = $.map(data[1], function(el) {
                        return el });
                        $(".cart").html("");
                        for(var k in arr)
                        {
                            var x = arr[k]['item']['name'];
                            var p = x.length  > 45 ? x.substring(0,45)+'...' : x;
                            var measure = arr[k]['item']['measure'] != null ? arr[k]['item']['measure'] : "";
                            $(".cart").append(
                             '<div class="single-myCart">'+
            '<p class="cart-close" onclick="remove('+arr[k]['item']['id']+')"><i class="fa fa-close"></i></p>'+
                            '<div class="cart-img">'+
                    '<img src="{{ asset('assets/images/') }}/'+arr[k]['item']['photo']+'" alt="Product image">'+
                            '</div>'+
                            '<div class="cart-info">'+
        '<a href="{{url('/')}}/product/'+arr[k]['item']['id']+'/'+arr[k]['item']['name']+'" style="color: black; padding: 0 0;">'+'<h5>'+p+'</h5></a>'+
                        '<p>{{$lang->cquantity}}: '+arr[k]['qty']+' '+measure+'</p>'+
                        @if($gs->sign == 0)
                        '<p>{{$curr->sign}}'+(arr[k]['price'] * {{$curr->value}}).toFixed(2)+'</p>'+
                        @else
                        '<p>'+(arr[k]['price'] * {{$curr->value}}).toFixed(2)+'{{$curr->sign}}</p>'+
                        @endif
                        '</div>'+
                        '</div>');
                          }
                        $.notify("{{$gs->cart_success}}","success");
                        $("#qval").html("1");
                        }
                      }
                  }); 

    });

</script>


    <script>
        $(document).on("click", "#wish" , function(){
            var pid = $("#pid").val();
            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/wish')}}",
                    data:{id:pid},
                    success:function(data){
                        if(data == 1)
                        {
                            $.notify("{{$gs->wish_success}}","success");
                        }
                        else {
                            $.notify("{{$gs->wish_error}}","error");
                        }
                      }
              }); 

            return false;
        });
    </script>
    <script>
        $(document).on("click", "#favorite" , function(){
          $("#favorite").hide();
            var pid = $("#fav").val();
            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/favorite')}}",
                    data:{id:pid},
                    success:function(data){
                      $('.product-headerInfo__btns').html('<a class="headerInfo__btn colored"><i class="fa fa-check"></i> {{ $lang->product_favorite }}</a>');
                      }
              }); 

        });
    </script>



<script type="text/javascript">
//*****************************COMMENT******************************  
        $("#cmnt").submit(function(){
          var uid = $("#user_id").val();
          var pid = $("#product_id").val();
          var cmnt = $("#txtcmnt").val();
          $("#txtcmnt").prop('disabled', true);
          $('.btn blog-btn comments').prop('disabled', true);
     $.ajax({
            type: 'post',
            url: "{{URL::to('json/comment')}}",
            data: {
                '_token': $('input[name=_token]').val(),
                'uid'   : uid,
                'pid'   : pid,
                'cmnt'  : cmnt
                  },
            success: function(data) {
              $("#comments").prepend(
                    '<div id="comment'+data[3]+'">'+
                        '<div class="row single-blog-comments-wrap">'+
                            '<div class="col-lg-12">'+
                              '<h4><a class="comments-title">'+data[0]+'</a></h4>'+
                                '<div class="comments-reply-area">'+data[1]+'</div>'+
                                 '<p id="cmntttl'+data[3]+'">'+data[2]+'</p>'+
                                '<div class="replay-form">'+
                    '<p class="text-right"><input type="hidden" value="'+data[3]+'"><button class="replay-btn">{{$lang->reply_button}} <i class="fa fa-reply-all"></i></button><button class="replay-btn-edit">{{$lang->edit_button}} <i class="fa fa-edit"></i></button><button class="replay-btn-delete">{{$lang->remove}} <i class="fa fa-trash"></i></button>'+
                    '</p>'+'<form action="" method="POST" class="comment-edit">'+
                                      '{{csrf_field()}}'+
                                '<input type="hidden" name="comment_id" value="'+data[3]+'">'+
                                      '<div class="form-group">'+
                            '<textarea rows="2" id="editcmnt'+data[3]+'" name="text" class="form-control"'+ 
                            'placeholder="{{$lang->edit_comment}}" style="resize: vertical;" required=""></textarea>'+
                                      '</div>'+
                                      '<div class="form-group">'+
                    '<button type="submit" class="btn btn-no-border hvr-shutter-out-horizontal">{{$lang->update_comment}}</button>&nbsp;'+
                        '<button type="button" class="btn btn-no-border hvr-shutter-out-horizontal cancel">{{$lang->cancel_edit}}</button>'+
                                      '</div>'+
                                    '</form>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                      '</div>');
                    $("#comment"+data[3]).append('<div id="replies'+data[3]+'" style="display: none;"></div>');
                     $("#replies"+data[3]).append('<div class="rapper" style="display: none;"></div>');
                     $("#replies"+data[3]).append('<form action="" method="POST" class="reply" style="display: none;">'+
                      '{{csrf_field()}}'+
                      '<input type="hidden" name="comment_id" id="comment_id'+data[3]+'" value="'+data[3]+'">'+
                      '<input type="hidden" name="user_id" id="user_id'+data[4]+'" value="'+data[4]+'">'+
                        '<div class="form-group">'+
                          '<textarea rows="2" name="text" id="txtcmnt'+data[3]+'" class="form-control"'+ 'placeholder="{{$lang->write_reply}}" required="" style="resize: vertical;"></textarea>'+
                        '</div>'+
                      '<div class="form-group">'+
                        '<button type="submit" class="btn btn-no-border hvr-shutter-out-horizontal">{{$lang->reply_button}}</button>'+
                      '</div>'+'</form>');                      
                      
                      



                    
                      //-----------Replay button details-----------
            if (data[5] > 1){
              $("#cmnt-text").html("{{ $lang->comments }}(<span id='cmnt_count'>"+ data[5]+"</span>)");
            }
            else{
              $("#cmnt-text").html("{{ $lang->comment }} (<span id='cmnt_count'>"+ data[5]+"</span>)");              
            }
        $("#txtcmnt").prop('disabled', false);
        $("#txtcmnt").val("");
        $('.btn blog-btn comments').prop('disabled', false);
            }
        });          
          return false;
        });
//*****************************COMMENT ENDS******************************  
</script>

<script type="text/javascript">

//***************************** REPLY TOGGLE******************************
          $(document).on("click", ".replay-form p button.view-replay-btn" , function(){
          var id = $(this).parent().next().find('input[name=comment_id]').val();
          $("#replies"+id+" .rapper").show();
          $("#replies"+id).show();
          });

          $(document).on("click", ".replay-form p button.replay-btn, .replay-form p button.subreplay-btn" , function(){
          var id = $(this).parent().find('input[type=hidden]').val();
          $("#replies"+id).show();
          $("#replies"+id).find('.reply').show();
          $("#replies"+id).find('.reply textarea').focus();
          });
//*****************************REPLY******************************  
          $(document).on("submit", ".reply" , function(){
          var uid = $(this).find('input[name=user_id]').val();
          var cid = $(this).find('input[name=comment_id]').val();
          var rpl = $(this).find('textarea').val();
          $(this).find('textarea').prop('disabled', true);
          $('.btn btn-no-border hvr-shutter-out-horizontal').prop('disabled', true);
     $.ajax({
            type: 'post',
            url: "{{URL::to('json/reply')}}",
            data: {
                '_token': $('input[name=_token]').val(),
                'uid'   : uid,
                'cid'   : cid,
                'rpl'  : rpl
                  },
            success: function(data) {
              $("#replies"+cid).prepend('<div id="reply'+data[3]+'">'+
                        '<div class="row single-blog-comments-wrap replay">'+
                            '<div class="col-lg-12">'+
                              '<h4><a class="comments-title">'+data[0]+'</a></h4>'+
                                '<div class="comments-reply-area">'+data[1]+'</div>'+
                                 '<p id="rplttl'+data[3]+'">'+data[2]+'</p>'+
                                '<div class="replay-form">'+
                    '<p class="text-right"><input type="hidden" value="'+cid+'"><button class="subreplay-btn">{{$lang->reply_button}} <i class="fa fa-reply-all"></i></button><button class="replay-btn-edit1">{{$lang->edit_button}} <i class="fa fa-edit"></i></button><button class="replay-btn-delete1">{{$lang->remove}} <i class="fa fa-trash"></i></button></p>'+
                                    '<form action="" method="POST" class="reply-edit">'+
                                      '{{csrf_field()}}'+
                                  '<input type="hidden" name="reply_id" value="'+data[3]+'">'+
                                      '<div class="form-group">'+
                                    '<textarea rows="2" id="editrpl'+data[3]+'" name="text" class="form-control"'+ 'placeholder="{{$lang->edit_reply}}"  style="resize: vertical;" required=""></textarea>'+
                                      '</div>'+
                                      '<div class="form-group">'+
                                      '<button type="submit" class="btn btn-no-border hvr-shutter-out-horizontal">'+'{{$lang->update_comment}}</button>&nbsp;'+
                                      '<button type="button" class="btn btn-no-border hvr-shutter-out-horizontal cancel">{{$lang->cancel_edit}}</button>'+
                                      '</div>'+
                                    '</form>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '</div>');
                      //-----------REPLY button details-----------
        $("#txtcmnt"+cid).prop('disabled', false);
        $("#txtcmnt"+cid).val("");
        $('.btn btn-no-border hvr-shutter-out-horizontal').prop('disabled', false);
            }
        });          
          return false;
        });
//*****************************REPLY ENDS******************************  

</script>

<script type="text/javascript">

  $(document).on("click", ".replay-btn-edit" , function(){
          var id = $(this).parent().find('input[type=hidden]').val();
          var txt = $("#cmntttl"+id).html(); 
          $(this).parent().parent().parent().find('.comment-edit textarea').val(txt);
          $(this).parent().parent().parent().find('.comment-edit').toggle();
  });
  $(document).on("click", ".cancel" , function(){
          $(this).parent().parent().hide();
  });
  //*****************************SUB REPLY******************************  
          $(document).on("submit", ".comment-edit" , function(){
          var cid = $(this).find('input[name=comment_id]').val();
          var text = $(this).find('textarea').val();
           $(this).find('textarea').prop('disabled', true);
          $('.hvr-shutter-out-horizontal').prop('disabled', true);
     $.ajax({
            type: 'post',
            url: "{{URL::to('json/comment/edit')}}",
            data: {
                '_token': $('input[name=_token]').val(),
                'cid'   : cid,
                'text'  : text
                  },
            success: function(data) {
        $("#cmntttl"+cid).html(data);
        $("#editcmnt"+cid).prop('disabled', false);
        $("#editcmnt"+cid).val("");
        $('.hvr-shutter-out-horizontal').prop('disabled', false);
            }
        });          
          return false;
        });

</script>

<script type="text/javascript">
  $(document).on("click", ".replay-btn-delete" , function(){
              var id = $(this).parent().next().find('input[name=comment_id]').val();
              $("#comment"+id).hide();
              var count = parseInt($("#cmnt_count").html());
              count--;
              if(count <= 1)
              {
              $("#cmnt-text").html("COMMENT (<span id='cmnt_count'>"+ count+"</span>)");
              }
              else
              {
              $("#cmnt-text").html("COMMENTS (<span id='cmnt_count'>"+ count+"</span>)");
              }
     $.ajax({
            type: 'get',
            url: "{{URL::to('json/comment/delete')}}",
            data: {'id': id}
        }); 
  });
</script>


<script type="text/javascript">
  $(document).on("click", ".replay-btn-edit1" , function(){
          var id = $(this).parent().parent().parent().find('.reply-edit input[name=reply_id]').val();
          var txt = $("#rplttl"+id).html(); 
          $(this).parent().parent().parent().find('.reply-edit textarea').val(txt);
          $(this).parent().parent().parent().find('.reply-edit').toggle();
          var txt = $("#cmntttl"+id).html(); 
  });

  //*****************************SUB REPLY******************************  
          $(document).on("submit", ".reply-edit" , function(){
          var cid = $(this).find('input[name=reply_id]').val();
          var text = $(this).find('textarea').val();
           $(this).find('textarea').prop('disabled', true);
          $('.hvr-shutter-out-horizontal').prop('disabled', true);
     $.ajax({
            type: 'post',
            url: "{{URL::to('json/reply/edit')}}",
            data: {
                '_token': $('input[name=_token]').val(),
                'cid'   : cid,
                'text'  : text
                  },
            success: function(data) {
        $("#rplttl"+cid).html(data);
        $("#editrpl"+cid).prop('disabled', false);
        $("#editrpl"+cid).val("");
        $('.hvr-shutter-out-horizontal').prop('disabled', false);
            }
        });          
          return false;
        });

</script>

<script type="text/javascript">
  $(document).on("click", ".replay-btn-delete1" , function(){
              var id = $(this).parent().next().find('input[name=reply_id]').val();
              $("#reply"+id).hide();
     $.ajax({
            type: 'get',
            url: "{{URL::to('json/reply/delete')}}",
            data: {'id': id}
        }); 
  });
</script>


@endsection
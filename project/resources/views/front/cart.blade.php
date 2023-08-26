@extends('layouts.front')
@section('title'){{$gs->title}} - Cart @endsection
@section('meta_description')
<meta name="description" content="{{$gs->title}}">
@endsection
@section('meta_tag')
<meta name="keywords" content="{{ $seo->meta_tag }}">
@endsection
@section('content')

<!-- Starting of ViewCart area -->
    <div class="section-padding product-shoppingCart-wrapper pb-0">
        <div class="container">
            <div class="row">
              <div class="col-lg-12 text-center">
                <div class="view-cart-title">
                  <!--<a style="color:black;" href="{{route('front.index')}}">{{ucfirst(strtolower($lang->home))}}</a>-->
                  <!--<i class="fa fa-angle-right"></i>-->
                  <!--<a style="color:black;" href="{{route('front.cart')}}">{{ucfirst(strtolower($lang->fht))}}</a>-->
                  <h4>Your shopping cart</h4>
                </div>
              </div>
                <div class="col-md-12 col-sm-12">
                @include('includes.form-success')
                  <div class="table-responsive pb-0 ">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>{{$lang->cimage}}</th>
                          <th>{{$lang->cproduct}}</th>
                          <th>{{$lang->cquantity}}</th>
                          <th>{{$lang->cupice}}</th>
                          <!--<th>{{$lang->cst}}</th>-->
                          <th><!--{{$lang->cremove}}--></th>
                        </tr>
                      </thead>
                      <tbody>

                            @if(Session::has('cart'))
                            @foreach($products as $product)
                        <tr id="del{{$product['item']['id']}}">
                            <td><img src="{{ asset('assets/images/'.$store_code.'/products/thumb_'.$product['item']['photo']) }}" class="img-fluid cart_img" alt="table image"></td>

                            <td>
                              <p class="product-name-header"><strong><a href="{{route('front.page',['slug' => $product['item']['slug']])}}">{{$product['item']['name']}}</a></strong></p>
                              @if($product['item']['size'] != null)
							  <p>Size: <span class="ml-2">{{$product['size']}}</span></p>
							  @endif
							  @if($product['item']['color'] != null)
							  <p>Color: <span class="ml-2 optclrbg" style="background: {{$product['color']}};">&nbsp;</span></p>
							  @endif
							  <!--<p class="table-product-review">-->
                                <!--<div class="ratings">-->
                                <!--    <div class="empty-stars"></div>-->
                                <!--    <div class="full-stars" style="width:{{App\Review::ratings($product['item']['id'])}}%"></div>-->
                                <!--</div>-->
                                @php
                                $prod =App\Product::findOrFail($product['item']['id']);

                                @endphp
                                <!--<span>({{count($prod->reviews)}} {{$lang->dttl}})</span>-->
                              <!--</p>-->
                            </td>

                            <td>
                              <div class="productDetails-quantity">
                                <!--<p>{{$lang->cquantity}}</p>-->
                                <span class="quantity-btn reducing"><i class="fa fa-minus"></i></span>
                                <span id="qty{{$product['item']['id']}}">{{ $product['qty'] }}</span>
                                <input type="hidden" value="{{$product['item']['id']}}">
            					<input type="hidden" class="itemid" value="{{$product['item']['id']}}">
            					@if($product['item']['size'] != null)
            					<input type="hidden" class="size_qty" value="{{$product['size_qty']}}">
            					<input type="hidden" class="size_price" value="{{$product['size_price']}}">
            					<input type="hidden" class="size_key" value="{{$product['size_key']}}">
            					<input type="hidden" class="size" value="{{$product['size']}}">
            					@else
            					<input type="hidden" class="size_qty" value=""/>
            					<input type="hidden" class="size_price" value=""/>
            					<input type="hidden" class="size_key" value=""/>
            					<input type="hidden" class="size" value=""/>
            					@endif
                                <span class="quantity-btn adding"><i class="fa fa-plus"></i></span>
                                {{-- <span style="padding-left: 5px; border: none; font-weight: 700; font-size: 12px;">{{ $product['item']['measure'] }}</span> --}}
                              </div>
                            </td>
                            <td>
                              @if($gs->sign == 0)
								@if($product['itemprice']==0)
                              {{$curr->sign}}<span id="itemprc{{$product['item']['id']}}">{{ number_format($product['item']['cprice'], 2) }}</span>
								@else
							  {{$curr->sign}}<span id="itemprc{{$product['item']['id']}}">{{ number_format($product['itemprice'], 2) }}</span>
								@endif
                              @else
								@if($product['itemprice']==0)
								<span id="itemprc{{$product['item']['id']}}">{{ number_format($product['item']['cprice'], 2) }}</span> {{$curr->sign}}
								@else
								<span id="itemprc{{$product['item']['id']}}">{{ number_format($product['itemprice'], 2) }}</span>{{$curr->sign}}
								@endif
                              @endif

                            </td>
                            <!--<td>-->
                            <!--  @if($gs->sign == 0)-->
                            <!--  {{$curr->sign}}<span id="prc{{$product['item']['id']}}">{{ round($product['price'] * $curr->value, 2) }}</span>-->
                            <!--  @else-->
                            <!--  <span id="prc{{$product['item']['id']}}">{{ round($product['price'] * $curr->value, 2) }}</span>{{$curr->sign}}-->
                            <!--  @endif-->
                            <!--</td>-->

                            <td><i class="fa fa-trash-o" aria-hidden="true" style="cursor: pointer;" onclick="remove({{$product['item']['id']}})"></i></td>
                            <input type="hidden" id="stock{{$product['item']['id']}}" value="{{$product['stock']}}">
                        </tr>
                            @endforeach
                            @else
                            <tr>
                              <td colspan="5"><h2 class="text-center pt-5 pb-5">{{$lang->h}}</h2></td>
                            </tr>
                            @endif
                      </tbody>
                      <tfoot>
                      @if(Session::has('cart'))
                        <tr>
                          <td colspan="5" class="text-right">
                          <h5 class="d-inline-block m-0 mr-2">{{$lang->vt}}: </h5>
                          <h5 class="d-inline-block m-0">
                            @if($gs->sign == 0)
                            <span class="total" id="grandtotal">{{$curr->sign}}{{number_format($totalPrice, 2)}}</span>
                            @else
                            <span class="total" id="grandtotal">{{number_format($totalPrice, 2)}}</span>{{$curr->sign}}
                            @endif
                          </h5>
                          </td>
                        </tr>
                      @endif
                        <tr>
                          <td colspan="5" class="text-right">
                            <a href="{{route('front.index')}}" class="shopping-btn">{{$lang->ccs}}</a>
                            <a href="{{route('front.checkout')}}" class="update-shopping-btn">{{$lang->cpc}}</a>
                          </td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Ending of ViewCart area -->

    @endsection

@section('scripts')
<script type="text/javascript">
      $(document).on("click", ".adding" , function(){
        var pid =  $(this).parent().find('input[type=hidden]').val();
        var stck = $("#stock"+pid).val();
        var qty = $("#qty"+pid).html();
		var itemid = $(this).parent().parent().find('.itemid').val();
		var size_qty = $(this).parent().parent().find('.size_qty').val();
        var size_price = $(this).parent().parent().find('.size_price').val();
		var size_key = $(this).parent().parent().find('.size_key').val();
        if(stck != "")
        {
          var stk = parseInt(stck);
          if(qty <= stk)
          {
          qty++;
          $("#qty"+pid).html(qty);
          }
        }
        else{
         qty++;
         $("#qty"+pid).html(qty);
        }
            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/addbyone')}}",
                    data:{id:pid,itemid:itemid,size_qty:size_qty,size_price:size_price},
                    success:function(data){
                        if(data == 0)
                        {
                        }
                        else
                        {
							console.log(data);
                        $(".total").html("{{$curr->sign}}"+(data[0] * {{$curr->value}}).toFixed(2));
                        $(".cart-quantity").html(data[3]);
                        $("#cqty"+pid).val("1");
                        $("#prc"+pid).html((data[2] * {{$curr->value}}).toFixed(2));
                        $("#prct"+pid).html((data[2] * {{$curr->value}}).toFixed(2));
                        $("#cqt"+pid).html(data[1]);
                        $("#qty"+pid).html(data[1]);
						$("#itemprc"+pid).html(data[4]);
                        }
                      }
              });
       });

      $(document).on("click", ".reducing" , function(){
        var id =  $(this).parent().find('input[type=hidden]').val();
        var stck = $("#stock"+id).val();
        var qty = $("#qty"+id).html();
        qty--;
		var itemid = $(this).parent().parent().find('.itemid').val();
		var size_qty = $(this).parent().parent().find('.size_qty').val();
        var size_price = $(this).parent().parent().find('.size_price').val();
		var size_key = $(this).parent().parent().find('.size_key').val();
        if(qty < 1)
         {
         $("#qty"+id).html("1");
         }
         else{
         $("#qty"+id).html(qty);
            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/reducebyone')}}",
                    data:{id:id,itemid:itemid,size_qty:size_qty,size_price:size_price},
                    success:function(data){
                        $(".total").html((data[0] * {{$curr->value}}).toFixed(2));
                        $(".cart-quantity").html(data[3]);
                        $("#cqty"+id).val("1");
                        $("#prc"+id).html((data[2] * {{$curr->value}}).toFixed(2));
                        $("#prct"+id).html((data[2] * {{$curr->value}}).toFixed(2));
                        $("#cqt"+id).html(data[1]);
                        $("#qty"+id).html(data[1]);
						$("#itemprc"+id).html(data[4]);
                      }
              });
         }
       });
</script>

<script type="text/javascript">
       $(document).on("click", ".delcart" , function(){
        $(this).parent().parent().hide();
       });
</script>





@endsection

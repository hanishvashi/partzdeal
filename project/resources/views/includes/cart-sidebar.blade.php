<aside id="sidebar-cart" class="sidecart js-cart">
                <div class="cart__header">
                <h1 class="cart__title">Shopping cart</h1>
                <p class="cart__text">
                <a class="button_close button--light js-toggle-cart" href="#" title="Close cart">
                <svg fill="" stroke="" viewBox="0 0 750 830" xmlns="http://www.w3.org/2000/svg"><path d="M750 733.6c0 26.3-9.4 49.5-28.2 69.5-18.8 16.3-41.4 24.4-67.7 24.4-26.3 0-49.5-8.1-69.5-24.4L374.1 558.8 163.5 805c-20.1 16.3-43.2 24.4-69.5 24.4-26.3 0-48.9-8.1-67.7-24.4C8.8 783.8 0 760 0 733.6c0-26.3 8.8-48.9 26.3-67.7l219.9-250L26.3 164.1C8.8 144 0 120.8 0 94.5c0-26.3 8.8-48.9 26.3-67.7C45.1 9.3 67.7.5 94 .5c26.3 0 49.5 8.8 69.5 26.3L374 269.3 584.5 26.8C603.3 9.3 626.5.5 654 .5c27.6 0 50.1 8.8 67.7 26.3 18.8 18.8 28.2 41.4 28.2 67.7 0 26.3-9.4 49.5-28.2 69.5L501.9 415.9l219.9 250c18.8 18.8 28.2 41.4 28.2 67.7z" fill-rule="evenodd"></path></svg>
                </a>
                </p>
                </div>
            			<div class="cart__products js-cart-products">
            			<p <?php if(Session::has('cart')){ echo "style='display:none;'"; }?> class="cart__empty js-cart-empty">
            			Add a product to your cart
            			</p>
                  @php
                  $totalcartprice = 0;
                  @endphp
            			<div class="cart__product js-cart-product-template">
            			@if(Session::has('cart'))
                  @php
                  $totalcartprice = array_sum(array_column(Session::get('cart')->items, 'price'));
                  @endphp
            			@foreach(Session::get('cart')->items as $product)
            			<div class="single-myCart">
            			<p class="cart-close" onclick="remove({{$product['item']['id']}})"><i class="fa fa-trash"></i></p>
            			<div class="cart-img">
            			<img src="{{ asset('assets/images/'.$store_code.'/products/thumb_'.$product['item']['photo']) }}" alt="Product image">
            			</div>
            			<div class="cart-info">
            			<a href="{{route('front.page',['slug' => $product['item']['slug']])}}" style="color: black; padding: 0 0;"><h6>{{strlen($product['item']['name']) > 45 ? substr($product['item']['name'],0,45).'...' : $product['item']['name']}}</h6></a>
                  <div class="productDetails-quantity">
                  <p>{{$lang->cquantity}}: <span class="quantity-btn side_reducing"><i class="fa fa-minus"></i></span>
                  <span id="cqt{{$product['item']['id']}}">{{$product['qty']}}</span>
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
              <input type="hidden" id="stock{{$product['item']['id']}}" value="{{$product['stock']}}">
<span class="quantity-btn side_adding"><i class="fa fa-plus"></i></span>
                    <!--span>{{ $product['item']['measure'] }}</span-->
                  </p>
                  </div>
            			<p class="total_item_amount">
            			@if($gs->sign == 0)
            			{{$curr->sign}}<span id="prct{{$product['item']['id']}}">{{number_format($product['price'],2) }}</span>
            			@else
            			<span id="prct{{$product['item']['id']}}">{{number_format($product['price'], 2) }}</span>{{$curr->sign}}
            			@endif
            			</p>
            			</div>
            			</div>
            			@endforeach
            			@endif
            			</div>
            			</div>
            			<div class="cart__footer">
            			<!--<h5 class="empty">{{ Session::has('cart') ? '' :$lang->h }}</h5>-->
            			<!--<hr/>-->
            			<h4 class="text-left">{{$lang->vt}}
            			@if($gs->sign == 0)
            			<span class="total">{{$curr->sign}}{{ Session::has('cart') ? number_format($totalcartprice , 2) : '0.00' }}</span>
            			@else
            			<span class="total">{{ Session::has('cart') ? number_format($totalcartprice , 2) : '0.00' }}</span>{{$curr->sign}}
            			@endif
            			</h4>
            			<div class="cart__text cart_text_footer_btn">@if(Session::has('cart'))<hr/><a class="button" href="{{route('front.checkout')}}" title="Checkout">Checkout</a><a class="button ml-4" href="{{route('front.cart')}}" title="View Cart">View Cart</a>
            			@endif</div>
            			</div>
        			</aside>
<div class="lightboxcart js-lightbox js-toggle-cart"></div>

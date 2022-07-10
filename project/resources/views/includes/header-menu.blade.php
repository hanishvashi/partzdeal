<div class="row">
                    <div class="col-12 p-0">
                        <div class="navbar-default">
                            <div class="nav-menu-4">
                                <!-- Collect the nav links, forms, and other content for toggling -->
                                <nav class="navbar-menu navbar navbar-expand-lg p-0">
                					<div class="menu_btn">
                					<a href="#mobilemenuContent"><span></span></a>
                					</div>
                					<a data-target="#mySearchModal" data-toggle="modal" href="#mySearchModal" class="search_btn d-inline-block d-lg-none"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11 20c-5 0-9-4-9-9s4-9 9-9 9 4 9 9-4 9-9 9zm0-16c-3.9 0-7 3.1-7 7s3.1 7 7 7 7-3.1 7-7-3.1-7-7-7z"></path><path d="M21 22c-.3 0-.5-.1-.7-.3L16 17.4c-.4-.4-.4-1 0-1.4s1-.4 1.4 0l4.3 4.3c.4.4.4 1 0 1.4-.2.2-.4.3-.7.3z"></path></svg></a>

                                    <a class="navbar-brand width230 p-0 d-inline-block d-lg-none ml-auto mr-auto" href="{{route('front.index')}}">
                                        <img src="{{asset('assets/images/'.$gs->mobile_logo)}}" alt="Logo" class="logo_main">
                                    </a>
<ul class="cart_header m-0 p-0 d-block d-lg-none">
<li>
@if(Auth::guard('user')->check())
<a href="{{route('user-wishlists')}}" title="Wishlist">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12,22a1.42,1.42,0,0,1-.91-.34L11,21.59,2.13,12.42C.52,10.77,0,9.72,0,8.09A6.17,6.17,0,0,1,1,4.72,5.88,5.88,0,0,1,3.65,2.47,5.74,5.74,0,0,1,7.1,2.12a5.9,5.9,0,0,1,3,1.68L12,5.72,13.86,3.8a5.9,5.9,0,0,1,3-1.68,5.75,5.75,0,0,1,3.45.35A5.88,5.88,0,0,1,23,4.72a6.17,6.17,0,0,1,1,3.37c0,1.6-.54,2.7-2.15,4.36l-8.94,9.21A1.43,1.43,0,0,1,12,22ZM5.93,4a3.65,3.65,0,0,0-1.49.31,3.91,3.91,0,0,0-1.77,1.5A4.14,4.14,0,0,0,2,8.09c0,1,.24,1.58,1.56,2.93L12,19.74l8.42-8.68C21.77,9.66,22,9,22,8.09a4.2,4.2,0,0,0-.67-2.29,4,4,0,0,0-1.77-1.49,3.7,3.7,0,0,0-2.25-.23,3.8,3.8,0,0,0-2,1.11h0L12,8.59,8.7,5.19a3.8,3.8,0,0,0-2-1.11A3.92,3.92,0,0,0,5.93,4Z"></path></svg>
</a>
@else
<a href="#loginModal" data-toggle="modal" data-target="#loginModal" title="Wishlist">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12,22a1.42,1.42,0,0,1-.91-.34L11,21.59,2.13,12.42C.52,10.77,0,9.72,0,8.09A6.17,6.17,0,0,1,1,4.72,5.88,5.88,0,0,1,3.65,2.47,5.74,5.74,0,0,1,7.1,2.12a5.9,5.9,0,0,1,3,1.68L12,5.72,13.86,3.8a5.9,5.9,0,0,1,3-1.68,5.75,5.75,0,0,1,3.45.35A5.88,5.88,0,0,1,23,4.72a6.17,6.17,0,0,1,1,3.37c0,1.6-.54,2.7-2.15,4.36l-8.94,9.21A1.43,1.43,0,0,1,12,22ZM5.93,4a3.65,3.65,0,0,0-1.49.31,3.91,3.91,0,0,0-1.77,1.5A4.14,4.14,0,0,0,2,8.09c0,1,.24,1.58,1.56,2.93L12,19.74l8.42-8.68C21.77,9.66,22,9,22,8.09a4.2,4.2,0,0,0-.67-2.29,4,4,0,0,0-1.77-1.49,3.7,3.7,0,0,0-2.25-.23,3.8,3.8,0,0,0-2,1.11h0L12,8.59,8.7,5.19a3.8,3.8,0,0,0-2-1.11A3.92,3.92,0,0,0,5.93,4Z"></path></svg>
</a>
@endif
</li>
<li>
<a href="{{route('front.cart')}}" data-toggle="tooltip" data-placement="bottom" title="View Cart">
<span class="cart-quantity" id="cart-count">{{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }}</span>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><circle cx="7" cy="20" r="2"></circle><circle cx="17" cy="20" r="2"></circle><path d="M18,17H6a1,1,0,0,1-1-.79L2.19,3H1A1,1,0,0,1,1,1H3a1,1,0,0,1,1,.79L6.81,15H17.18l1.6-8H5A1,1,0,0,1,4,6c0-.55-.55-1,0-1H20a1,1,0,0,1,.77.37A1,1,0,0,1,21,6.2l-2,10A1,1,0,0,1,18,17Z"></path></svg>
</a>
</li>
</ul>
<div class="collapse navbar-collapse justify-content-center desktopmenu" id="navbarSupportedContent">
<ul class="navbar-nav">
<li class="nav-item">
<a class="nav-link" href="{{route('front.index')}}">Home<span class="sr-only">(current)</span></a>
</li>
<li class="nav-item">
<a class="nav-link" href="{{route('front.page',['slug'=>'about-us'])}}">About Us<span class="sr-only">(current)</span></a>
</li>
<li class="nav-item">
<a class="nav-link" href="{{route('front.page',['slug'=>'disclaimer'])}}">Disclaimer<span class="sr-only">(current)</span></a>
</li>
<li class="nav-item">
<a class="nav-link" href="{{route('front.page',['slug'=>'terms-condition'])}}">Terms & Conditions<span class="sr-only">(current)</span></a>
</li>
<li class="nav-item">
<a class="nav-link" href="{{route('front.contact')}}">Contact Us<span class="sr-only">(current)</span></a>
</li>

</ul>
</div>
                					<div class="mobilemenu" id="mobilemenuContent">
                                        <ul>
										<li><span>Account</span>
											@if(Auth::guard('user')->check())
											<?php
											$userinfo = Auth::guard('user')->user();
											if($userinfo['is_vendor']==2){
											?>
											<ul>
											<li><a href="{{route('user-dashboard')}}">Dashboard</a></li>
											<li><a href="{{route('user-profile')}}">My Account</a></li>
											<li><a href="{{route('user-orders')}}">My Orders</a></li>
											<li><a href="{{route('user-logout')}}">Logout</a></li>
											</ul>
											<?php }else{?>
											<ul>
											<li><a href="{{route('customer-profile')}}">My Account</a></li>
											<li><a href="{{route('customer-reset')}}">{{$lang->reset}}</a></li>
											<li><a href="{{route('customer-orders')}}">My Orders</a></li>
											<li><a href="{{route('user-logout')}}">Logout</a></li>
											</ul>
											<?php }?>
											@else
											<ul>
<li><a style="cursor: pointer;" class="custlogin" data-toggle="modal" data-target="#loginModal">Login</a></li>
<li><a class="custsignup" style="cursor: pointer;" data-toggle="modal" data-target="#signInModal">Signup</a></li>
											</ul>
											@endif
											</li>
                		<li class="Selected"><a href="{{route('front.index')}}">Home</a></li>
                    <li class="Selected"><a href="{{route('front.page',['slug'=>'about-us'])}}">About Us</a></li>
                    <li class="Selected"><a href="{{route('front.page',['slug'=>'disclaimer'])}}">Disclaimer</a></li>
                    <li class="Selected"><a href="{{route('front.page',['slug'=>'terms-condition'])}}">Terms & Conditions</a></li>
                    <li class="Selected"><a href="{{route('front.contact')}}">Contact Us</a></li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

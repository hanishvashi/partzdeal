<!---------------------------------------------------------->
<!-----------------------LOGIN MODAL------------------------>
<!---------------------------------------------------------->

<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal-Title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="transition: .5s;" role="document">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="login-area text-center">
                    <h1 class="heading_one mt-0 mb-3">Log In</h1>
					@include('includes.form-success')
                    <p class="form-text mb-4">if you don't have an account? <strong><a data-dismiss="modal" href="#signInModal" data-toggle="modal" data-target="#signInModal">Sign Up</a></strong></p>
                    <div class="login-form signin-form">
                        <form class="mloginform" action="{{route('user-login-submit')}}" method="POST">
                            {{csrf_field()}}
                            <div class="form-group {{$lang->rtl == 1 ? 'text-right' : ''}}">
                                <input type="email" name="email" class="form-control" id="login_email1" placeholder="{{$lang->doeml}}" required>
                            </div>
                            <div class="form-group {{$lang->rtl == 1 ? 'text-right' : ''}}">
                                <input type="password" name="password" class="form-control" id="login_pwd1" placeholder="{{$lang->sup}}" required>
                            </div>
                            <div class="form-row">
                                <div class="col-12 col-md-6 text-center text-md-left">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox">
                                        <label class="form-check-label">Remember me</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 text-center text-md-right">
                                    <p class="form-text mb-3"><a href="{{route('user-forgot')}}">Lost Password?</a></p>
                                </div>
                            </div>
                            <input type="hidden" name="wish" value="1">
                            <button type="submit" class="btn btn_submit">{{$lang->sie}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!---------------------------------------------------------->
<!-----------------------SIGNIN MODAL----------------------->
<!---------------------------------------------------------->

<div class="modal fade" id="signInModal" tabindex="-1" role="dialog" aria-labelledby="signInModal-Title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="transition: .5s;" role="document">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('includes.form-error')
                <div class="login-area signup-area text-center">
                    <h1 class="heading_one mt-0 mb-3">Sign Up</h1>
                    <div class="login-form signup-form">
                        <form class="mloginform" action="{{route('user-register-submit')}}" method="POST">
                            {{csrf_field()}}
                            <div class="form-group {{$lang->rtl == 1 ? 'text-right' : ''}}">
                                <input type="email" name="email" class="form-control" id="reg_email1" placeholder="{{$lang->doeml}}" required>
                            </div>
                            <div class="form-group {{$lang->rtl == 1 ? 'text-right' : ''}}">
                                <input type="text" name="name" class="form-control" id="reg_name1" placeholder="{{$lang->fname}}"required>
                            </div>
                            <div class="form-group {{$lang->rtl == 1 ? 'text-right' : ''}}">
                                <input type="password" name="password" class="form-control" id="reg_password1" placeholder="{{$lang->sup}}" required>
                            </div>
							<div class="form-group {{$lang->rtl == 1 ? 'text-right' : ''}}">
                                <input type="password" name="password_confirmation" class="form-control" id="reg_password_confirmation" placeholder="{{$lang->sup}}" required>
                            </div>
                            <div class="form-group {{$lang->rtl == 1 ? 'text-right' : ''}}">
                                <div class="form-check mb-3 text-left">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Email me special offers and news.</label>
                                </div>
                            </div>
                            <div clsss="form-group"><div class="g-recaptcha" data-sitekey="6LdbGOMUAAAAAMur04xif6mNpWdw0GI2NCBZw8kx"></div></div>
                            <input type="hidden" name="wish" value="1">
                            <button type="submit" class="btn btn_submit">{{$lang->spe}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Starting of Product View Modal -->
<div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog modal-lg">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div id="quick-details"></div>
</div>
</div>
</div>
  <!-- Ending of Product View Modal -->

<div class="modal fade" id="mySearchModal" role="dialog">
<div class="modal-dialog modal-lg">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<form id="searchForm" class="search-form" action="" method="GET">
<div class="input-group has-search">
	<input type="text" id="mobile_prod_name" name="search" class="form-control" placeholder="Search designs and products">
</div>
<div class="autocomplete" style="display:none;">
	<div id="MobilemyInputautocomplete-list" class="autocomplete-items">
	</div>
</div>
</form>
</div>
</div>
</div>
</div>

<div class="modal fade" id="InquiryModal" tabindex="-1" role="dialog" aria-labelledby="overview-tab-1-Title" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" style="transition: .5s;" role="document">
<!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="login-area text-center">
                <h1 class="heading_one mt-0 mb-3">Product Enquiry</h1>
                <div id="inqresmessage"></div>
                <div class="login-form signin-form">
                    <form id="minquiryform" role="form" action="{{route('inquire-product')}}" method="POST">
                        {{csrf_field()}}
                        <div class="form-group {{$lang->rtl == 1 ? 'text-right' : ''}}">
                            <input type="text" name="your_name" class="form-control" id="your_name" placeholder="Your Name" required>
                        </div>
                        <div class="form-group {{$lang->rtl == 1 ? 'text-right' : ''}}">
                            <input type="email" name="your_email" class="form-control" id="your_email" placeholder="{{$lang->doeml}}" required>
                        </div>
                        <div class="form-group {{$lang->rtl == 1 ? 'text-right' : ''}}">
                            <input type="tel" name="your_phone" class="form-control" id="your_phone" placeholder="Your Phone" required>
                        </div>
                        <div class="form-group {{$lang->rtl == 1 ? 'text-right' : ''}}">
                            <textarea name="message" placeholder="Comment" id="message" class="form-control" required></textarea>
                        </div>
                        <div clsss="form-group"><div class="g-recaptcha" data-sitekey="6LdbGOMUAAAAAMur04xif6mNpWdw0GI2NCBZw8kx"></div></div>

                        <input type="hidden" id="enq_product_id" name="product_id" value="">
                        <input type="hidden" id="enq_product_sku" name="product_sku" value="">
                        <input type="hidden" id="enq_product_name" name="product_name" value="">
                        <button type="submit" class="btn btn_submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

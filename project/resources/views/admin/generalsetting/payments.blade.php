@extends('layouts.admin')

@section('content')
<div class="right-side">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!-- Starting of Dashboard Office Address -->
                        <div class="section-padding add-product-1">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="add-product-box">
                                    <div class="product__header"  style="border-bottom: none;">
                                        <div class="row reorder-xs">
                                            <div class="col-lg-6 col-md-5 col-sm-5 col-xs-12">
                                                <div class="product-header-title">
                                                    <h2>Payment Informations</h2>
                                                    <p>Dashboard <i class="fa fa-angle-right" style="margin: 0 2px;"></i> Payment Settings <i class="fa fa-angle-right" style="margin: 0 2px;"></i> Payment Informations
                                                </div>
                                            </div>
                                              @include('includes.notification')
                                        </div>
                                    </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-gs-paymentsup')}}" method="POST">
                                          @include('includes.form-error')
                                          @include('includes.form-success')
                                          {{csrf_field()}}
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="disable/enable_about_page">Guest Checkout:</label>
                                            <div class="col-sm-3" style="margin-top: 6px;">
                                                        <span class="dropdown">
                                            <button id="Vendor" class="btn btn-{{$gs->guest_checkout == 1 ? 'primary':'danger'}} product-btn dropdown-toggle btn-xs" type="button" data-toggle="dropdown" style="font-size: 14px;">{{$gs->guest_checkout == 1 ? 'Activated':'Deactivated'}}
                                                <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="{{route('admin-gs-guest',1)}}">Active</a></li>
                                                            <li><a href="{{route('admin-gs-guest',0)}}">Deactive</a></li>
                                                        </ul>
                                                        </span>
                                            </div>
                                          </div>

                        <div class="form-group">
                        <label class="control-label col-sm-4" for="paypal_type">{{ __('Paypal') }}</label>
                        <div class="col-sm-6">
                        <span class="dropdown">
                        <button id="paypal_type" class="btn btn-{{$gs->paypal_check == 1 ? 'primary':'danger'}} product-btn dropdown-toggle btn-xs" type="button" data-toggle="dropdown" style="font-size: 14px;">{{$gs->paypal_check == 1 ? 'Activated':'Deactivated'}}
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                        <li><a href="{{route('admin-gs-paypal',1)}}">Active</a></li>
                        <li><a href="{{route('admin-gs-paypal',0)}}">Deactive</a></li>
                        </ul>
                        </span>
                        </div>
                        </div>


                        <div class="form-group">
                          <label class="control-label col-sm-4" for="paypal_text">{{ __('Paypal Email') }}</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" placeholder="{{ __('Paypal Email') }}" name="paypal_business" value="{{ $gs->paypal_business }}" required="">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-sm-4" for="paypal_text">Paypal Text *</label>
                          <div class="col-sm-6">
                            <textarea class="form-control" name="paypal_text" id="paypal_text" placeholder="{{ __('Paypal Text') }}">{{ $gs->paypal_text }}</textarea>
                          </div>
                        </div>
<hr>       
                <div class="form-group">
                <label class="control-label col-sm-4" for="payu_merchant_key">{{ __('Payu Merchant Key') }}</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" placeholder="{{ __('Payu Merchant Key') }}" name="payu_merchant_key" value="{{ $gs->payu_merchant_key }}" required="">
                </div>
                </div>
                
                <div class="form-group">
                <label class="control-label col-sm-4" for="payu_merchant_salt">{{ __('Payu Merchant Salt') }}</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" placeholder="{{ __('Payu Merchant Salt') }}" name="payu_merchant_salt" value="{{ $gs->payu_merchant_salt }}" required="">
                </div>
                </div>
                
                <div class="form-group">
                <label class="control-label col-sm-4" for="payu_sandbox">{{ __('Payu Payment Mode') }}</label>
                <div class="col-sm-6">
                    <select class="form-control" name="payu_sandbox">
                        <option value="0" {{$gs->payu_sandbox == 0 ? 'selected':''}}>Live</option>
                        <option value="1" {{$gs->payu_sandbox == 1 ? 'selected':''}}>Sandbox</option>
                    </select>
                </div>
                </div>
<hr>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="website_title">Currency Format *</label>
                                            <div class="col-sm-6">
                                              <select id="website_title" class="form-control" name="sign">
                                                <option value="0" {{$data->sign == 0 ? 'selected':''}}>Before Price</option>
                                                <option value="1" {{$data->sign == 1 ? 'selected':''}}>After Price</option>
                                              </select>
                                            </div>
                                          </div>
                                          <div class="form-group" style="display:none;">
                                            <label class="control-label col-sm-4" for="phone9">Withdraw Fee *<span>Withdraw Fee(Withdraw Amount + Withdraw Fee)</span></label>
                                            <div class="col-sm-6">
                                              <input name="withdraw_fee" id="phone9" class="form-control" placeholder="Withdraw Fee" type="text" value="{{$data->withdraw_fee}}" required="">
                                            </div>
                                          </div>
                                          <div class="form-group" style="display:none;">
                                            <label class="control-label col-sm-4" for="phone4">Withdraw Charge(%) *<span>Withdraw Charge(Withdraw Amount + Withdraw Charge(%))</span></label>
                                            <div class="col-sm-6">
                                              <input name="withdraw_charge" id="phone4" class="form-control" placeholder="Withdraw Charge" type="text" value="{{$data->withdraw_charge}}" required="">
                                            </div>
                                          </div>
                                          <div class="form-group" style="display:none;">
                                            <label class="control-label col-sm-4" for="phone5">Fixed Commission *<span>Fixed Commission Charge(Product Price + Commission)</span></label>
                                            <div class="col-sm-6">
                                              <input name="fixed_commission" id="phone5" class="form-control" placeholder="Fixed Commission" type="text" value="{{$data->fixed_commission}}" required="">
                                            </div>
                                          </div>
                                          <div class="form-group" style="display:none;">
                                            <label class="control-label col-sm-4" for="phone6">Percentage Commission(%) *<span>Percentage Commission Charge(Product Price + Commission(%))</span></label>
                                            <div class="col-sm-6">
                                              <input name="percentage_commission" id="phone6" class="form-control" placeholder="Percentage Commission" type="text" value="{{$data->percentage_commission}}" required="">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="phone7">Tax(%) *<span>Tax Fee(Product Price + Tax(%))</span></label>
                                            <div class="col-sm-6">
                                              <input name="tax" id="phone7" class="form-control" placeholder="Tax" type="text" value="{{$data->tax}}" required="">
                                            </div>
                                          </div>
                                        <div class="form-group" style="display:none;">
                                            <label class="control-label col-sm-4" for="disable/enable_about_page">Multiple Shipping *</label>
                                            <div class="col-sm-3">
                                                <label class="switch">
                                                  <input type="checkbox" name="multiple_ship" value="1" {{$data->multiple_ship==1?"checked":""}}>
                                                  <span class="slider round"></span>
                                                </label>
                                            </div>
                                          </div>
                                          <div class="form-group" style="display:none;">
                                            <label class="control-label col-sm-4" for="phone8">Shipping Cost *<span>(Total Amount + Shipping Cost)</span></label>
                                            <div class="col-sm-6">
                                              <input name="ship" id="phone8" class="form-control" placeholder="Shipping Cost" type="text" value="{{$data->ship}}" required="">
                                            </div>
                                          </div>
                                        <div class="form-group" style="display:none;">
                                            <label class="control-label col-sm-4" for="disable/enable_about_page">Shipping Information For Vendor *</label>
                                            <div class="col-sm-3">
                                                <label class="switch">
                                                  <input type="checkbox" name="ship_info" value="1" {{$data->ship_info==1?"checked":""}}>
                                                  <span class="slider round"></span>
                                                </label>
                                            </div>
                                          </div>
                                            <hr>
                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!-- Ending of Dashboard Office Address -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{asset('assets/admin/js/nicEdit.js')}}"></script>
<script type="text/javascript">
//<![CDATA[
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
  //]]>
</script>
@endsection

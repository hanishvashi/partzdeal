@extends('layouts.admin')

@section('content')

<div class="right-side">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!-- Starting of Dashboard area -->
                        <div class="section-padding add-product-1">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="add-product-box">
                                    <div class="product__header"  style="border-bottom: none;">
                                        <div class="row reorder-xs">
                                            <div class="col-lg-6 col-md-5 col-sm-5 col-xs-12">
                                                <div class="product-header-title">
                                                    <h2>Update Shipping <a href="{{ route('admin-shipping-index') }}" style="padding: 5px 12px;" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> Back</a></h2>
                                                    <p>Dashboard <i class="fa fa-angle-right" style="margin: 0 2px;"></i> Home Page Settings <i class="fa fa-angle-right" style="margin: 0 2px;"></i> Shipping <i class="fa fa-angle-right" style="margin: 0 2px;"></i> Update
                                                </div>
                                            </div>
                                              @include('includes.notification')
                                        </div>
                                    </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-shipping-update',$ad->id)}}" method="POST" enctype="multipart/form-data">
                                          @include('includes.form-error')
                                          @include('includes.form-success')
                                          {{csrf_field()}}



                                          <div class="form-group">
                                              <label class="control-label col-sm-4" for="carrier_title">Carrier Title *</label>
                                              <div class="col-sm-6">
                                                  <input class="form-control" name="carrier_title" id="carrier_title" placeholder="Carrier Title" value="{{$ad->carrier_title}}" type="text" required>
                                              </div>
                                          </div>

                                          <div class="form-group">
                                              <label class="control-label col-sm-4" for="shipping_price">Shipping Price *</label>
                                              <div class="col-sm-6">
                                                  <input class="form-control" name="shipping_price" id="shipping_price" placeholder="Carrier Title" value="{{$ad->shipping_price}}" type="number" min="0" required>
                                              </div>
                                          </div>

                                          <div class="form-group">
                                              <label class="control-label col-sm-4" for="shipping_percentage">Shipping Percentage *</label>
                                              <div class="col-sm-6">
                                                  <input class="form-control" name="shipping_percentage" id="shipping_percentage" placeholder="Carrier Title" value="{{$ad->shipping_percentage}}" type="number" min="0" required>
                                              </div>
                                          </div>

                                          <div class="form-group">
                                              <label class="control-label col-sm-4" for="status">Status *</label>
                                              <div class="col-sm-6">
                                                  <select class="form-control" name="status" id="status">
                                                    <option value="">Select Status</option>
                                                    <option <?php if($ad->status==1){ echo 'selected'; }?> value="1">Enabled</option>
                                                    <option <?php if($ad->status==0){ echo 'selected'; }?> value="0">Disabled</option>
                                                  </select>
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
                    <!-- Ending of Dashboard area -->
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')


@endsection

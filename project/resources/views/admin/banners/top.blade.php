@extends('layouts.admin')

@section('styles')

<style type="text/css">
    .nav-tabs a[aria-expanded="false"]::before, a[aria-expanded="true"]::before {
        content: '';
    }
</style>

@endsection

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
                                                    <h2>Top Banners</h2>
                                                    <p>Dashboard <i class="fa fa-angle-right" style="margin: 0 2px;"></i> Home Page Settings <i class="fa fa-angle-right" style="margin: 0 2px;"></i> Top Banners
                                                </div>
                                            </div>
                                              @include('includes.notification')
                                        </div>   
                                    </div>
                                    <hr>
<div class="container">
                                          @include('includes.form-error')
                                          @include('includes.form-success')
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li class="active">
          <a href="#home" role="tab" data-toggle="tab"> Banner 1</a>
      </li>
      <li><a href="#profile" role="tab" data-toggle="tab"> Banner 2</a>
      </li>
      <li><a href="#messages" role="tab" data-toggle="tab"> Banner 3</a>
      </li>
      <li><a href="#settings" role="tab" data-toggle="tab"> Banner 4</a>
      </li>
    </ul>
    
    <!-- Tab panes -->
    <div class="tab-content">
      <div class="tab-pane fade active in" id="home">
 <form class="form-horizontal" action="{{route('admin-banner-topup')}}" method="POST" enctype="multipart/form-data">
                                        {{csrf_field()}}
										
										<div class="form-group">
                                            <label class="control-label col-sm-4" for="t1t">Banner Title *</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" name="top1t" id="t1t" placeholder="Banner Title" required="" value="{{$ad->top1t}}" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="t1">Banner URL *</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" name="top1l" id="t1" placeholder="https://www.google.com" required="" value="{{$ad->top1l}}" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_current_photo">Banner Image*</label>
                                            <div class="col-sm-6">
                                                <img src="{{ $ad->top1 ? asset('assets/images/'.$ad->top1):'http://fulldubai.com/SiteImages/noimage.png'}}" alt="Photo" id="adminimg">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_profile_photo">Select Image</label>
                                            <div class="col-sm-6">
                                                <input type="file" id="uploadFile" class="hidden" name="top1" value="">
                                                <button type="button" id="uploadTrigger" onclick="uploadclick()" class="form-control"><i class="fa fa-download"></i> Choose Image</button>
                                                <p class="text-center">Prefered Size: (360x610) or Square Sized Image</p>
                                            </div>
                                        </div>

                                      
                                        <hr>
                                        <div class="add-product-footer">
                                            <button name="addProduct_btn" type="submit" class="btn add-product_btn">Submit</button>
                                        </div>
                                    </form>
      </div>
      <div class="tab-pane fade" id="profile">
 <form class="form-horizontal" action="{{route('admin-banner-topup')}}" method="POST" enctype="multipart/form-data">
                                        {{csrf_field()}}
										<div class="form-group">
                                            <label class="control-label col-sm-4" for="t2t">Banner Title *</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" name="top2t" id="t2t" placeholder="Banner Title" required="" value="{{$ad->top2t}}" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="t2">Banner URL *</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" name="top2l" id="t2" placeholder="https://www.google.com" required="" value="{{$ad->top2l}}" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_current_photo">Banner Image*</label>
                                            <div class="col-sm-6">
                                                <img src="{{ $ad->top2 ? asset('assets/images/'.$ad->top2):'http://fulldubai.com/SiteImages/noimage.png'}}" alt="Photo" id="adminimg1">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_profile_photo">Select Image</label>
                                            <div class="col-sm-6">
                                                <input type="file" id="uploadFile1" class="hidden" name="top2" value="">
                                                <button type="button" id="uploadTrigger1" onclick="uploadclick1()" class="form-control"><i class="fa fa-download"></i> Choose Image</button>
                                                <p class="text-center">Prefered Size: (360x300) or Square Sized Image</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="add-product-footer">
                                            <button name="addProduct_btn" type="submit" class="btn add-product_btn">Submit</button>
                                        </div>
                                    </form>
      </div>
      <div class="tab-pane fade" id="messages">
 <form class="form-horizontal" action="{{route('admin-banner-topup')}}" method="POST" enctype="multipart/form-data">
                                        {{csrf_field()}}
										<div class="form-group">
                                            <label class="control-label col-sm-4" for="t3t">Banner Title *</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" name="top3t" id="t3t" placeholder="Banner Title" required="" value="{{$ad->top3t}}" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="t3">Banner URL *</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" name="top3l" id="t3" placeholder="https://www.google.com" required="" value="{{$ad->top3l}}" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_current_photo">Banner Image*</label>
                                            <div class="col-sm-6">
                                                <img src="{{ $ad->top3 ? asset('assets/images/'.$ad->top3):'http://fulldubai.com/SiteImages/noimage.png'}}" alt="Photo" id="adminimg2">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_profile_photo">Select Image</label>
                                            <div class="col-sm-6">
                                                <input type="file" id="uploadFile2" class="hidden" name="top3" value="">
                                                <button type="button" id="uploadTrigger2" onclick="uploadclick2()" class="form-control"><i class="fa fa-download"></i> Choose Image</button>
                                                <p class="text-center">Prefered Size: (360x300) or Square Sized Image</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="add-product-footer">
                                            <button name="addProduct_btn" type="submit" class="btn add-product_btn">Submit</button>
                                        </div>
                                    </form>
      </div>
      <div class="tab-pane fade" id="settings">
 <form class="form-horizontal" action="{{route('admin-banner-topup')}}" method="POST" enctype="multipart/form-data">
                                        {{csrf_field()}}
										<div class="form-group">
                                            <label class="control-label col-sm-4" for="t4">Banner Title *</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" name="top4t" id="t4t" placeholder="Banner Title" required="" value="{{$ad->top4t}}" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="t4">Banner URL *</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" name="top4l" id="t4" placeholder="https://www.google.com" required="" value="{{$ad->top4l}}" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_current_photo">Banner Image*</label>
                                            <div class="col-sm-6">
                                                <img src="{{ $ad->top4 ? asset('assets/images/'.$ad->top4):'http://fulldubai.com/SiteImages/noimage.png'}}" alt="Photo" id="adminimg3">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_profile_photo">Select Image</label>
                                            <div class="col-sm-6">
                                                <input type="file" id="uploadFile3" class="hidden" name="top4" value="">
                                                <button type="button" id="uploadTrigger3" onclick="uploadclick3()" class="form-control"><i class="fa fa-download"></i> Choose Image</button>
                                                <p class="text-center">Prefered Size: (750x280) or Square Sized Image</p>
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


    <script type="text/javascript">

        function uploadclick(){
            $("#uploadFile").click();
            $("#uploadFile").change(function(event) {
                readURL(this);
                $("#uploadTrigger").html($("#uploadFile").val());
            });

        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#adminimg').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function uploadclick1(){
            $("#uploadFile1").click();
            $("#uploadFile1").change(function(event) {
                readURL1(this);
                $("#uploadTrigger1").html($("#uploadFile1").val());
            });

        }

        function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#adminimg1').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function uploadclick2(){
            $("#uploadFile2").click();
            $("#uploadFile2").change(function(event) {
                readURL2(this);
                $("#uploadTrigger2").html($("#uploadFile2").val());
            });

        }

        function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#adminimg2').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        function uploadclick3(){
            $("#uploadFile3").click();
            $("#uploadFile3").change(function(event) {
                readURL3(this);
                $("#uploadTrigger3").html($("#uploadFile3").val());
            });

        }

        function readURL3(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#adminimg3').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

@endsection


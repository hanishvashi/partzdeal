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
                                                    <h2>Add Category <a href="{{ route('admin-stores') }}" style="padding: 5px 12px;" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> Back</a></h2>
                                                    <p>Dashboard <i class="fa fa-angle-right" style="margin: 0 2px;"></i> Manage Store <i class="fa fa-angle-right" style="margin: 0 2px;"></i> Main Store <i class="fa fa-angle-right" style="margin: 0 2px;"></i> Add
                                                </div>
                                            </div>
                                              @include('includes.notification')
                                        </div>
                                    </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-store-store')}}" method="POST" enctype="multipart/form-data">
                                          @include('includes.form-error')
                                          @include('includes.form-success')
                                          {{csrf_field()}}
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="store_name">Name* <span>(In Any Language)</span></label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="store_name" id="store_name" placeholder="Enter Store name" required="" type="text" >
                                            </div>
                                          </div>


                                <div class="form-group">
                                <label class="control-label col-sm-4" for="store_description">Store Info</label>
                                <div class="col-sm-6">
                                <textarea class="form-control" name="store_description" id="store_description"></textarea>
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

<script type="text/javascript">

  function uploadclick(){
    $("#uploadFile").click();
    $("#uploadFile").change(function(event) {
          readURL(this);
        $("#uploadTrigger").html($("#uploadFile").val());
    });
}


  function readURL(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#adminimg').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
}

</script>

@endsection

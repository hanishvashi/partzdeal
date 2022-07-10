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
                                                    <h2>Add Category <a href="{{ route('admin-cat-index') }}" style="padding: 5px 12px;" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> Back</a></h2>
                                                    <p>Dashboard <i class="fa fa-angle-right" style="margin: 0 2px;"></i> Manage Category <i class="fa fa-angle-right" style="margin: 0 2px;"></i> Main Category <i class="fa fa-angle-right" style="margin: 0 2px;"></i> Add
                                                </div>
                                            </div>
                                              @include('includes.notification')
                                        </div>
                                    </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-cat-store')}}" method="POST" enctype="multipart/form-data">
                                          @include('includes.form-error')
                                          @include('includes.form-success')
                                          {{csrf_field()}}

										  <div class="form-group">
                                            <label class="control-label col-sm-4" for="parent_id">Parent Category <span>(Leave blank if already parent)</span></label>
                                            <div class="col-sm-6">
                                            <select class="form-control" id="parent_id" name="parent_id">
											<option value="0" >Select Parent Category</option>
                                              @foreach($cats as $cat)
                                                  <option value="{{$cat->id}}" >{{$cat->cat_name}}</option>
                                              @endforeach
                                              </select>
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_display_name">Name* <span>(In Any Language)</span></label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="cat_name" id="blood_group_display_name" placeholder="Enter Category name" required="" type="text" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">Slug* <span>(In English)</span></label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="cat_slug" id="blood_group_slug" placeholder="Enter Category Slug" required="" type="text" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="current_photo">Current Image*</label>
                                            <div class="col-sm-6">
                                             <img width="130px" height="90px" id="adminimg" src="" alt="No Image Added!">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="profile_photo">Add Image *</label>
                                            <div class="col-sm-6">
                                    <input type="file" id="uploadFile" class="hidden" name="photo" value="">
                                              <button type="button" id="uploadTrigger" onclick="uploadclick()" class="form-control"><i class="fa fa-download"></i> Add Category Image</button>
                                            </div>
                                          </div>
										  <div class="form-group">
                                            <label class="control-label col-sm-4" for="short_description">Short Description</label>
                                            <div class="col-sm-6">
                                             <textarea class="form-control" name="short_description" id="short_description"></textarea>
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="page_title">Page Title</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="page_title" id="page_title" placeholder="Page Title" required="" type="text" >
                                            </div>
                                          </div>

                  <div class="form-group">
                  <label class="control-label col-sm-4" for="meta_keywords">Meta Keywords</label>
                  <div class="col-sm-6">
                  <textarea placeholder="Meta Keywords" class="form-control" name="meta_keywords" id="meta_keywords"></textarea>
                  </div>
                  </div>

                  <div class="form-group">
                  <label class="control-label col-sm-4" for="meta_description">Meta Description</label>
                  <div class="col-sm-6">
                  <textarea placeholder="Meta Description" class="form-control" name="meta_description" id="meta_description"></textarea>
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

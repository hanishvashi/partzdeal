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
                                                    <h2>Update Category <a href="{{ route('admin-cat-index') }}" style="padding: 5px 12px;" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> Back</a></h2>
                                                    <p>Dashboard <i class="fa fa-angle-right" style="margin: 0 2px;"></i> Manage Category <i class="fa fa-angle-right" style="margin: 0 2px;"></i>  Main Category <i class="fa fa-angle-right" style="margin: 0 2px;"></i> Update
                                                </div>
                                            </div>
                                              @include('includes.notification')
                                        </div>
                                    </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-cat-update',$cat->id)}}" method="POST" enctype="multipart/form-data">
                                            {{csrf_field()}}
                                          @include('includes.form-error')
                                          @include('includes.form-success')

										  <div class="form-group">
                                            <label class="control-label col-sm-4" for="parent_id">Parent Category <span>(Leave blank if already parent)</span></label>
                                            <div class="col-sm-6">
                                            <select class="form-control" id="parent_id" name="parent_id">
											<option value="0" >Select Parent Category</option>
                                              @foreach($cats as $catrow)
                                                  <option <?php if($catrow->id==$cat->parent_id){ echo 'selected'; }?> value="{{$catrow->id}}" >{{$catrow->cat_name}}</option>
                                              @endforeach
                                              </select>
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_blood_group_display_name"> Name* <span>(In Any Language)</span></label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="cat_name" id="edit_blood_group_display_name" placeholder="Enter Category Name" required="" type="text" value="{{$cat->cat_name}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_blood_group_slug">Slug* <span>(In English)</span></label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="cat_slug" id="edit_blood_group_slug" placeholder="Enter Category Slug" required="" type="text" value="{{$cat->cat_slug}}" >
                                            </div>
                                          </div>


                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="current_photo">Current Photo*</label>
                                            <div class="col-sm-6">
                                              <img width="130px" height="90px" id="adminimg" src="{{ $cat->photo ? asset('assets/images/'.$cat->photo):'http://fulldubai.com/SiteImages/noimage.png'}}" alt="" id="adminimg">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="profile_photo">Edit Photo *</label>
                                            <div class="col-sm-6">
                                    <input type="file" id="uploadFile" class="hidden" name="photo" value="">
                                              <button type="button" id="uploadTrigger" onclick="uploadclick()" class="form-control"><i class="fa fa-download"></i> Edit Category Photo</button>
                                            </div>
                                          </div>

										  <div class="form-group">
                                            <label class="control-label col-sm-4" for="short_description">Short Description</label>
                                            <div class="col-sm-6">
                                             <textarea class="form-control" name="short_description" id="short_description">{{$cat->short_description}}</textarea>
                                            </div>
                                          </div>

      <div class="form-group">
      <label class="control-label col-sm-4" for="page_title">Page Title</label>
      <div class="col-sm-6">
      <input class="form-control" value="{{$cat->page_title}}" name="page_title" id="page_title" placeholder="Page Title" required="" type="text" >
      </div>
      </div>

      <div class="form-group">
      <label class="control-label col-sm-4" for="meta_keywords">Meta Keywords</label>
      <div class="col-sm-6">
      <textarea placeholder="Meta Keywords" class="form-control" name="meta_keywords" id="meta_keywords">{{$cat->meta_keywords}}</textarea>
      </div>
      </div>

      <div class="form-group">
      <label class="control-label col-sm-4" for="meta_description">Meta Description</label>
      <div class="col-sm-6">
      <textarea placeholder="Meta Description" class="form-control" name="meta_description" id="meta_description">{{$cat->meta_description}}</textarea>
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


    function readURL(input) {
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

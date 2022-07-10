@extends('layouts.admin')

@section('content')
<div class="right-side">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!-- Starting of Dashboard data-table area -->
                        <div class="section-padding add-product-1">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                  <div class="add-product-box">
                                    <div class="product__header">
                                        <div class="row reorder-xs">
                                            <div class="col-lg-6 col-md-5 col-sm-5 col-xs-12">
                                                <div class="product-header-title">
                                                    <h2>All Products</h2>
                                                    <p>Dashboard <i class="fa fa-angle-right" style="margin: 0 2px;"></i> Products <i class="fa fa-angle-right" style="margin: 0 2px;"></i> All Products</p>
                                                </div>
                                            </div>
                                              @include('includes.notification')
                                        </div>
                                    </div>
                  <div>
                                          @include('includes.form-error')
                                          @include('includes.form-success')



                                      <div class="row">
                                        <div class="col-sm-12">
                                    <div class="table-responsive">
                                      <table id="ajax-product-table_wrapper" class="table table-striped table-hover products dt-responsive" cellspacing="0" width="100%">
                                              <thead>
                                                  <tr>
                                                    <th style="width: 150px;">Product Title</th>
                                                    <th style="width: 150px;">SKU</th>
                                                    <th style="width: 200px;">Price</th>

                                                    <th style="width: 130px;">Status</th>
                                                    <th style="width: 370px;">Actions</th></tr>
                                              </thead>

                                              <tbody>

                                                </tbody>
                                          </table>
                                        </div>
                                        </div>
                                      </div>
                       </div>
                    </div>
                                  </div>
                              </div>
                        </div>
                    </div>
                    <!-- Ending of Dashboard data-table area -->
                </div>
            </div>
        </div>

    <div class="modal fade" id="feature" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center" id="myModalLabel">Confirm Delete</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">You are about to delete this Product. Everything will be deleted under this Product.</p>
                    <p class="text-center">Do you want to proceed?</p>
                </div>
                <div class="modal-footer" style="text-align: center;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok">Delete</a>
                </div>
            </div>
        </div>
    </div>
<div id="myModal" class="modal fade gallery" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Image Gallery</h4>
      </div>
      <div class="modal-body">
        <div class="gallery-btn-area text-center">
          <form  method="POST" enctype="multipart/form-data" id="form-gallery">
            {{ csrf_field() }}
            <input style="display: none;" type="file" accept="image/*" id="gallery" name="gallery[]" multiple/>
          <input type="hidden" name="product_id" value="" id="pid">
          </form>
            <a style="cursor: pointer;" class="btn btn-info gallery-btn mr-5" id="prod_gallery"><i class="fa fa-download"></i> Upload Images</a>
            <a style="cursor: pointer; background: #009432;" class="btn btn-info gallery-btn mr-5" data-dismiss="modal"><i class="fa fa-check" ></i> Done</a>
            <p style="font-size: 11px;">You can upload multiple images.</p>
        </div>

        <div class="gallery-wrap">
                <div class="row">
                </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){

      // DataTable
      $('#ajax-product-table_wrapper').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{route('products.getProducts')}}",
         "pageLength": 20,
         columns: [
            { data: 'name' },
            { data: 'sku' },
            { data: 'cprice' },
            { data: 'statusbutton',orderable: false },
            { data: 'actionbutton',orderable: false },
         ]
      });

    });
    </script>
    <script type="text/javascript">

        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    $(document).on("click", ".feature" , function(){
        var max = '';
        var pid = $(this).parent().find('input[type=hidden]').val();
        $("#feature .modal-content").html('');
            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/feature')}}",
                    data:{id:pid},
                    success:function(data){
                      data[0] = data[0] == 1 ? "checked":"";
                      data[1] = data[1] == 1 ? "checked":"";
                      data[2] = data[2] == 1 ? "checked":"";
                      data[3] = data[3] == 1 ? "checked":"";
                      data[4] = data[4] == 1 ? "checked":"";
                      data[5] = data[5] == 1 ? "checked":"";
                        $("#feature .modal-content").append(''+
        '<form class="form-horizontal" action="{{url('/')}}/admin/product/feature/'+data[6]+'" method="POST">'+
        '{{csrf_field()}}'+
            '<div class="modal-header">'+
              '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'+
                '<h4 class="modal-title text-center" id="myModalLabel2">Product Title:'+data[7]+'</h4>'+
                '</div>'+
                '<div class="modal-body">'+
                  '<div class="form-group">'+
                     '<label class="control-label" for="check1"></label>'+
                        '<div class="col-sm-9 col-sm-offset-3">'+
                           '<div class="btn btn-default checkbox1">'+
                              '<input type="checkbox" id="check1" name="featured" value="1" '+data[0]+'>'+
                                '<label for="check1">Add Product to {{$lang->bg}}</label>'+
                                  '</div>'+
                                  '</div>'+
                                  '</div>'+
                                  '<div class="form-group">'+
                                '<label class="control-label" for="check2"></label>'+
                                '<div class="col-sm-9 col-sm-offset-3">'+
                                    '<div class="btn btn-default checkbox1">'+
                                    '<input type="checkbox" id="chec2" name="best" value="1" '+data[1]+'>'+
                                    '<label for="chec2">Add Product to {{$lang->lm}}</label>'+
                                  '</div>'+
                                  '</div>'+
                                 '</div>'+
                              '<div class="form-group">'+
                              '<label class="control-label" for="check3"></label>'+
                                '<div class="col-sm-9 col-sm-offset-3">'+
                                  '<div class="btn btn-default checkbox1">'+
                                    '<input type="checkbox" id="chec3" name="top" value="1" '+data[2]+'>'+
                                      '<label for="chec3">Add Product to {{$lang->rds}}</label>'+
                                        '</div>'+
                                        '</div>'+
                                        '</div>'+
                                      '<div class="form-group">'+
                                        '<label class="control-label" for="check4"></label>'+
                                          '<div class="col-sm-9 col-sm-offset-3">'+
                                            '<div class="btn btn-default checkbox1">'+
                                              '<input type="checkbox" id="check4" name="hot" value="1" '+data[3]+'>'+
                                                '<label for="check4">Add Product to {{$lang->hot_sale}}</label>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="form-group">'+
                                              '<label class="control-label" for="check5"></label>'+
                                                '<div class="col-sm-9 col-sm-offset-3">'+
                                                  '<div class="btn btn-default checkbox1">'+
                                                    '<input type="checkbox" id="check5" name="latest" value="1" '+data[4]+'>'+
                                        '<label for="check5">Add Product to {{$lang->latest_special}}</label>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="form-group">'+
                                                '<label class="control-label" for="check6"></label>'+
                                                '<div class="col-sm-9 col-sm-offset-3">'+
                                                  '<div class="btn btn-default checkbox1">'+
                                                    '<input type="checkbox" id="check6" name="big" value="1" '+data[5]+'>'+
                                                '<label for="check6">Add Product to {{$lang->big_sale}}</label>'+
                                                  '</div>'+
                                                '</div>'+
                                            '</div>'+
                '</div>'+
                '<div class="modal-footer" style="text-align: center;">'+
                  '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>'+
                  '<button type="submit" class="btn btn-primary btn-ok">Update</button>'+'</div>'+
                  '</form>'
                  );
              }
            });
    });
$( document ).ready(function() {
        $(".add-button").append('<div class="col-sm-4 add-product-btn text-right">'+
          '<a href="{{route('admin-prod-create')}}" class="add-newProduct-btn">'+
          '<i class="fa fa-plus"></i> Add New Product</a>'+
          '</div>');
});
    $(document).on("click", ".view-gallery" , function(){
        var pid = $(this).parent().find('input[type=hidden]').val();
        $('#pid').val(pid);
        $('.gallery-wrap .row').html('');
            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/gallery')}}",
                    data:{id:pid},
                    success:function(data){
                      if(data[0] == 0)
                      {
      $('.gallery-wrap .row').html('<h3 class="text-center">No Images Found.</h3>');
     }

                      else {

                          var arr = $.map(data[1], function(el) {
                          return el });
                          for(var k in arr)
                          {
        $('.gallery-wrap .row').append('<div class="col-sm-4">'+
                                  '<div class="gallery__img">'+
                                  '<img src="'+'{{asset('assets/images/products/gallery').'/'}}'+arr[k]['photo']+'" alt="gallery image">'+
                                  '<div class="gallery-close">'+
                                  '<input type="hidden" value="'+arr[k]['id']+'">'+
                                  '<i class="fa fa-close"></i>'+
                                  '</div>'+
                                  '</div>'+
                                  '</div>');
                          }
                       }

                    }
                  });
      });



  $(document).on('click', '#prod_gallery' ,function() {
    $('#gallery').click();
  });

  $("#gallery").change(function(){
    var pid = $("#pid").val();
    var total_file = document.getElementById("gallery").files.length;
    $("#form-gallery").submit();
   });
    </script>
    <script type="text/javascript">
  $(document).on('submit', '#form-gallery' ,function() {
  $.ajax({
                    url:"{{URL::to('/json/addgallery')}}",
   method:"POST",
   data:new FormData(this),
   dataType:'JSON',
   contentType: false,
   cache: false,
   processData: false,
   success:function(data)
   {
    if(data != 0)
    {
                          var arr = $.map(data, function(el) {
                          return el });
                          for(var k in arr)
                          {
        $('.gallery-wrap .row').append('<div class="col-sm-4">'+
                                  '<div class="gallery__img">'+
                                  '<img src="'+'{{asset('assets/images/products/gallery').'/'}}'+data[k]['photo']+'" alt="gallery image">'+
                                  '<div class="gallery-close">'+
                                  '<input type="hidden" value="'+data[k]['id']+'">'+
                                  '<i class="fa fa-close"></i>'+
                                  '</div>'+
                                  '</div>'+
                                  '</div>');
                          }
    }

                       }

  });
  return false;
 });

    </script>
<script type="text/javascript">
    $(document).on('click', '.gallery-close' ,function() {
    var pid = $(this).find('input[type=hidden]').val();
    $(this).parent().parent().remove();
              $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/removegallery')}}",
                    data:{id:pid}
                  });
  });
</script>

@endsection

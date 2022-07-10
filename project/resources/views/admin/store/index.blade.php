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
                                                    <h2>All Stores</h2>
                                                    <p>Dashboard <i class="fa fa-angle-right" style="margin: 0 2px;"></i> Stores <i class="fa fa-angle-right" style="margin: 0 2px;"></i> All Stores</p>
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
                                      <table class="table table-striped table-hover products dt-responsive" cellspacing="0" width="100%">
                                              <thead>
                                                  <tr>
                                                    <th style="width: 150px;">S. No.</th>
                                                    <th style="width: 150px;">Store Name</th>
                                                    <th style="width: 370px;">Actions</th></tr>
                                              </thead>

                                              <tbody>
                                                @foreach($stores as $store)
                                              <tr role="row" class="odd">
                                              <td>{{$store->id}}</td>
                                              <td>{{$store->store_name}}</td>
                                              <td>
                                              <a href="{{route('admin-store-edit',$store->id)}}" class="btn btn-primary product-btn"><i class="fa fa-edit"></i> Edit</a>
                                              </td>
                                              </tr>
                                                @endforeach
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




@endsection

@section('scripts')
<script type="text/javascript">

  $( document ).ready(function() {
        $(".add-button").append('<div class="col-sm-4 add-product-btn text-right">'+
          '<a href="{{route('admin-cat-create')}}" class="add-newProduct-btn">'+
          '<i class="fa fa-plus"></i> Add New Store</a>'+
          '</div>');
});
</script>


@endsection

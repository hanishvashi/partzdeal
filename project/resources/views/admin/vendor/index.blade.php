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
                                                    <h2>Artists</h2>
                                                    <p>Dashboard <i class="fa fa-angle-right" style="margin: 0 2px;"></i> Artists <i class="fa fa-angle-right" style="margin: 0 2px;"></i> Artists List</p>
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
                                      <table id="product-table_wrapper" class="table table-striped table-hover products dt-responsive" cellspacing="0" width="100%">
                                              <thead>
                                                  <tr>
                                                    <th>Store Name</th>
                                                    <th>Artist Email</th>
                                                    <th>Phone</th>
                                                    <th>Address</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                  </tr>
                                              </thead>

                                              <tbody>
                                                @foreach($users as $user)                                                  
                                              <tr role="row" class="odd">

                                                      <td><a href="{{route('front.vendor',str_replace(' ', '-',($user->shop_name)))}}" target="_blank">{{$user->shop_name}}</a></td>
                                                      <td>{{$user->email}}</td>
                                                      <td>{{$user->shop_number}}</td>
                                                      <td>{{$user->shop_address}}</td>
                                                      <td>
                                                        <span class="dropdown">
                                            <button class="btn btn-{{$user->is_vendor == 2 ? "success" : "danger"}} product-btn dropdown-toggle btn-xs" type="button" data-toggle="dropdown" style="font-size: 14px;">{{$user->is_vendor == 2 ? "Activated" : "Deactivated"}}
                                                <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="{{route('admin-vendor-st',['id1'=>$user->id,'id2'=>2])}}">Active</a></li>
                                                            <li><a href="{{route('admin-vendor-st',['id1'=>$user->id,'id2'=>1])}}">Deactive</a></li>
                                                        </ul>
                                                        </span>
                                                      </td>
                                                      <td>
                                                        <input type="hidden" value="{{$user->email}}">
                                                      <a href="{{route('admin-vendor-show',$user->id)}}" class="btn btn-primary product-btn"><i class="fa fa-eye"></i> View Details</a>
                                                      <a href="{{route('admin-vendor-edit',$user->id)}}" class="btn btn-info product-btn"><i class="fa fa-edit"></i> Edit</a>
                                                      <a style="cursor: pointer; background-color: #0165cbc9;" class="btn btn-success product-btn email1"  data-toggle="modal" data-target="#emailModal1"><i class="fa fa-send"></i> Send Message</a>
                                                      <a href="javascript:;" data-href="{{route('admin-vendor-delete',$user->id)}}" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger product-btn"><i class="fa fa-trash"></i> Remove</a>

                                                      </td>
                                                  </tr>
                                                  @endforeach
                                                  </tbody>
                                          </table></div></div>
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
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center" id="myModalLabel">Confirm Delete</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">You are about to delete this Artist. Everything will be deleted under this Artist.</p>
                    <p class="text-center">Do you want to proceed?</p>
                </div>
                <div class="modal-footer" style="text-align: center;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok">Delete</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirm-delete2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center" id="myModalLabel">Accept Artist</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">You are about to accept this Artist.</p>
                    <p class="text-center">Do you want to proceed?</p>
                </div>
                <div class="modal-footer" style="text-align: center;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-success btn-ok">Accept</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirm-delete1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center" id="myModalLabel">Reject Artist</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">You are about to reject this Artist.</p>
                    <p class="text-center">Do you want to proceed?</p>
                </div>
                <div class="modal-footer" style="text-align: center;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok">Reject</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

<script type="text/javascript">
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
        $('#confirm-delete1').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
        $('#confirm-delete2').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });

</script>

@endsection
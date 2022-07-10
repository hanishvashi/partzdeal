@extends('layouts.customer')
@section('content')      

        <section class="customer-profile">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!-- Starting of Dashboard add-product-1 area -->
                        <div class="section-padding add-product-1">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="add-product-box">
                                    <div class="product__header">
                                        <div class="row reorder-xs">
                                            <div class="col-lg-8 col-md-5 col-sm-5 col-xs-12">
                                                <div class="product-header-title">
                                                    <h2>Edit Profile</h2>
                                                </div>
                                            </div>
                                             
                                        </div>   
                                    </div>
                                        <form class="form-horizontal" action="{{route('customer-profile-update',$user->id)}}" method="POST" enctype="multipart/form-data">
                                            @include('includes.form-error')
                                            @include('includes.form-success')
                                            {{csrf_field()}}
                                            <div class="form-group row">
											<div class="col-sm-2">
											 <label class="control-label " for="admin_current_photo">Current Photo *</label>
											@if($user->is_provider == 1)
											<img style="width: 100%; height: auto;" src="{{ $user->photo ? $user->photo:asset('assets/images/noimage.png')}}" alt="profile image">
											@else
											<img  style="width: 100%; height: auto;" id="adminimg" src="{{ $user->photo ? asset('assets/images/'.$user->photo):asset('assets/images/noimage.png')}}" alt="profile image">
											@endif

											</div>
                                                @if($user->is_provider != 1)
                                                <div class="col-sm-4">
                                                    <input style="display:none" type="file" id="uploadFile" class="hidden" name="photo" value="">
                                                    <button  type="button" id="uploadTrigger" onclick="uploadclick()" class="btn btn-block add-product_btn adminImg-btn"><i class="fa fa-upload"></i> Change Photo</button>
                                                </div>
                                                @endif
                                            </div>
											
											
											
                                            <div class="form-group row">
											<div class="col-sm-6">
											<label class="control-label" for="dash_fname">{{$lang->fname}} *</label>
											<input class="form-control" type="text" name="name" id="dash_fname" placeholder="{{$lang->fname}}" value="{{$user->name}}" required>
											</div>
												
											<div class="col-sm-6">
											<label class="control-label" for="dash_lname">{{$lang->doeml}} *</label>
											<input class="form-control" type="email" name="email" id="dash_lname" placeholder="{{$lang->doeml}}" value="{{$user->email}}" required>
											</div>
												
                                            </div>
											
											
											<div class="form-group row">
											<div class="col-sm-6">
											<label class="control-label" for="dash_email">{{$lang->doad}} *</label>
                                                    <input class="form-control" type="text" name="address" id="dash_email" placeholder="{{$lang->doad}}" value="{{$user->address}}" required>
											</div>
												
											<div class="col-sm-6">
											<label class="control-label" for="dash_phone">{{$lang->doph}} *</label>
                                                    <input class="form-control" type="text" name="phone" id="dash_phone" placeholder="{{$lang->cop}}" value="{{$user->phone}}" required>
											</div>
                                            </div>
                                            
											
											<div class="form-group row">
											<div class="col-sm-6">
											<label class="control-label" for="dash_city">{{$lang->doct}} *</label>
                                             <input class="form-control" type="text" name="city" id="dash_city" placeholder="{{$lang->doct}}" value="{{$user->city}}" required>
											</div>
												
											<div class="col-sm-6">
											<label class="control-label" for="customer_state">State *</label>
								<select class="form-control" required="" id="customer_state" name="state">
								<option value="" selected="selected">Select State</option>
								@include('includes.customer-states')
								</select>
											
											</div>
                                            </div>
											
                                            
                                            <div class="form-group row">
											<div class="col-sm-6">
                                             <label class="control-label" for="dash_zip">{{$lang->suph}} *</label>
                                             <input class="form-control" type="text" name="zip" id="dash_zip" placeholder="{{$lang->suph}}" value="{{$user->zip}}" required>
                                            </div> 
										<div class="col-sm-6">		
										<label class="control-label" for="dash_fax">{{$lang->dofx}}</label>
										<input class="form-control" type="text" name="fax" id="dash_fax" placeholder="{{$lang->dofx}}" value="{{$user->fax}}">
										</div>									  
                                            </div>

                                            <hr>
                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">{{$lang->doupl}}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Ending of Dashboard add-product-1 area -->
                    </div>
                </div>
            </div>
        </section>

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
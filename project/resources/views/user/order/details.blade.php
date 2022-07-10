@extends('layouts.user')

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
                                    <div class="product__header">
                                        <div class="row reorder-xs">
                                            <div class="col-lg-8 col-md-5 col-sm-5 col-xs-12">
                                                <div class="product-header-title">
                                                    <h2>Order Details <a href="{{ route('vendor-order-index') }}" class="btn add-newProduct-btn" style="padding: 5px 12px;"  class="print-order-btn">
                                                    <i class="fa fa-arrow-left"></i> Back
                                                </a> <a href="{{ route('vendor-order-invoice',$order->order_number) }}" style="padding: 5px 12px;" class="btn add-back-btn"><i class="fa fa-file"></i> Invoice</a></h2>
                                                    <p>Dashboard <i class="fa fa-angle-right" style="margin: 0 2px;"></i> Vendor Orders <i class="fa fa-angle-right" style="margin: 0 2px;"></i>Order Details</p>
                                                </div>
                                            </div>
                                              @include('includes.user-notification')
                                        </div>
                                    </div>
<main>


<br>
                            <table id="example" class="table">
                                <h4 class="text-center">Product Inquiry</h4><hr>
                                <thead>
                                <tr>
                                    <th width="10%">Product ID#</th>
                                    <th>Product Title</th>
                                    <th width="10%">Quantity</th>
                                    <th width="10%">Size</th>
                                    <th width="10%">Color</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($cart->items as $key => $product)
                                @if($product['item']['user_id'] != 0)
                                    @if($product['item']['user_id'] == $user->id)
                                        <tr>
                                        <input type="hidden" value="{{$key}}">
                                                <td>{{ $product['item']['id'] }}</td>
                                                <td>
                                                <input type="hidden" value="{{ $product['license'] }}">
                                                    <a target="_blank" href="{{route('front.product',['id1' => $product['item']['id'], $product['item']['name']])}}">{{strlen($product['item']['name']) > 30 ? substr($product['item']['name'],0,30).'...' : $product['item']['name']}}</a>
                                                @if($product['license'] != '')
                              <a href="javascript:;" data-toggle="modal" data-target="#confirm-delete" class="btn btn-info product-btn" id="license" style="padding: 5px 12px;"><i class="fa fa-eye"></i> View License</a>
                                                @endif
                                                </td>
                                                <td>{{$product['qty']}} {{ $product['item']['measure'] }}</td>
                                                <td>{{$product['size']}}</td>
                                                <td><span style="width: 40px; height: 20px; display: block; background: {{$product['color']}};"></span></td>
                                        </tr>
                                    @endif
                                @endif
                                @endforeach


                                </tbody>
                            </table>
                        </main>
                            @if($gs->ship_info == 1)
                        <hr>
                        <div class="text-center">
                            <input type="hidden" value="{{$order->customer_email}}">
                            <a style="cursor: pointer;"  data-toggle="modal" data-target="#sendQuoteModal"class="btn btn-success email"><i class="fa fa-send"></i> Send Quote</a>
                        </div>
                            @endif
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!-- Ending of Dashboard area -->
                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="sendQuoteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="ti-close"></i></span></button>
              <h4 class="modal-title" id="myModalLabel">Send Quotation</h4>
            </div>
            <form id="emailreply"  method="POST">
              {{csrf_field()}}
            <div class="modal-body" id="quoteformdata">

                  <input type="hidden" name="name" value="{{Auth::guard('user')->user()->name}}">
                  <input type="hidden" name="user_id" value="{{Auth::guard('user')->user()->id}}">
            </div>
            <div class="modal-footer">
              <button type="submit" id="emlsub" class="btn btn-default email-btn">Send</button>
            </div>
             </form>
          </div>
        </div>
      </div>

  <div class="modal vendor" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="ti-close"></i></span></button>
            <h4 class="modal-title" id="myModalLabel">Send Message</h4>
          </div>
          <form id="emailreply"  method="POST">
            {{csrf_field()}}
          <div class="modal-body">
                <div class="form-group">
                    <input type="email" class="form-control" id="eml" name="email" placeholder="Email"  value="" readonly="">
                </div>
                <div class="form-group">
                    <input type="text" name="subject" id="subj" class="form-control" placeholder="Subject">
                </div>
                <div class="form-group">
                    <textarea name="message" id="msg" class="form-control" rows="5" placeholder="Message *" required=""></textarea>
                </div>
                <input type="hidden" name="name" value="{{Auth::guard('user')->user()->name}}">
                <input type="hidden" name="user_id" value="{{Auth::guard('user')->user()->id}}">
          </div>
          <div class="modal-footer">
            <button type="submit" id="emlsub" class="btn btn-default email-btn">Send</button>
          </div>
           </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center" id="myModalLabel">License Key</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">The Licenes Key is :  <span id="key"></span> <a id="license-edit" style="cursor: pointer;">Edit License</a><a id="license-cancel" style="cursor: pointer; display: none;">Cancel</a></p>
                    <form method="POST" action="{{route('vendor-order-license',$order->order_number)}}" id="edit-license" style="display: none;">
                        {{csrf_field()}}
                        <input type="hidden" name="license_key" id="license-key" value="">
                        <div class="form-group text-center">
                    <input type="text" name="license" placeholder="Enter New License Key" style="width: 40%;" required=""><input type="submit" name="submit" class="btn btn-primary" style="border-radius: 0; padding: 2px; margin-bottom: 2px;">
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="text-align: center;">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).on("click", ".email" , function(){
        var email = $(this).parent().find('input[type=hidden]').val();
        $("#eml").val(email);
        $(".modal-backdrop, .modal.vendor").css('background-color','rgba(0,0,0,0)');
    });
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
          $(document).on("submit", "#emailreply" , function(){
          var token = $(this).find('input[name=_token]').val();
          var subject = $(this).find('input[name=subject]').val();
          var message =  $(this).find('textarea[name=message]').val();
          var email = $(this).find('input[name=email]').val();
          var name = $(this).find('input[name=name]').val();
          var user_id = $(this).find('input[name=user_id]').val();
          $('#eml').prop('disabled', true);
          $('#subj').prop('disabled', true);
          $('#msg').prop('disabled', true);
          $('#emlsub').prop('disabled', true);
     $.ajax({
            type: 'post',
            url: "{{URL::to('/user/user/contact')}}",
            data: {
                '_token': token,
                'subject'   : subject,
                'message'  : message,
                'email'   : email,
                'name'  : name,
                'user_id'   : user_id
                  },
            success: function( data) {
          $('#eml').prop('disabled', false);
          $('#subj').prop('disabled', false);
          $('#msg').prop('disabled', false);
          $('#subj').val('');
          $('#msg').val('');
        $('#emlsub').prop('disabled', false);
        if(data == 0)
        $.notify("Email Not Found !!","error");
        else
        $.notify("Message Sent !!","success");
        $('.ti-close').click();
            }
        });
          return false;
        });
</script>
    <script type="text/javascript">
        $(document).on('click','#license' , function(e){
            var id = $(this).parent().find('input[type=hidden]').val();
            var key = $(this).parent().parent().find('input[type=hidden]').val();
            $('#key').html(id);
            $('#license-key').val(key);
    });
        $(document).on('click','#license-edit' , function(e){
            $(this).hide();
            $('#edit-license').show();
            $('#license-cancel').show();
        });
        $(document).on('click','#license-cancel' , function(e){
            $(this).hide();
            $('#edit-license').hide();
            $('#license-edit').show();
        });
    </script>
@endsection

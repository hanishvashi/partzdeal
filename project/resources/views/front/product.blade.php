@extends('layouts.front')
@section('title')
{{$gs->title}} - {{$product->name}}
@endsection
@section('styles')
    <style type="text/css">
.replay-btn, .replay-btn-edit, .replay-btn-delete, .replay-btn-edit1, .replay-btn-delete1, .replay-btn-edit2, .replay-btn-delete2, .subreplay-btn, .view-replay-btn {
    color: {{$gs->colors == null ? 'gray' : $gs->colors}};
    font-weight: 700;
    }
    #comments .reply {
    padding-left: 52px;
    }
    @if($lang->rtl == 1)
    #comments .reply {
    padding-left: 0;
    padding-right: 52px;
    }
    .single-blog-comments-wrap.replay {margin-left: 0; margin-right: 40px;}
    @endif
    </style>
@endsection
@section('content')
@php
$i=1;
$j=1;
@endphp


<section class="mb-5 pt-5 pb-1 product-details-wrapper">
<div class="container-fluid">

  <div class="row">
  <div class="col-12 col-md-4 col-lg-3 col-xl-3">
  @include('includes.home-brand-filter')
  @include('includes.home-catalog')
  </div>
    <div class="col-12 col-md-8 col-lg-9 col-xl-9">
    <div class="row">
    <div class="col-md-6 mb-4 mb-md-0">
    	@include('includes.product-gallery')
    </div>
    <div class="col-md-6">
    	@include('includes.product-details')
    </div>
      <div class="col-md-12">
      @include('includes.product-detail-tabs')
      </div>

    </div>
  </div>
  </div>
  </div>

</section>

    <div id="detail_product" class="section-padding product-details-wrapper pt-5 pb-1">
      <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
				<!--  Starting of product detail tab area   -->

				<!--  Ending of product detail tab area   -->

        @include('includes.related-products')
            </div>

          </div>
      </div>
    </div>
    <!--  Ending of product description area   -->

    <!--  Starting of product detail tab area   -->




    <div class="modal fade" id="product-information-modal" tabindex="-1" role="dialog" aria-labelledby="overview-tab-1-Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="transition: .5s;" role="document">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <h2 class="heading_three mb-4">{{$lang->ddesc}}</h2>
                        @if(strlen($product->description) > 70)
                            <p {!! $lang->rtl == 1 ? 'dir="rtl"' : ''!!}>{!! $product->description !!}</p>
                        @else
                            <p {!! $lang->rtl == 1 ? 'dir="rtl"' : ''!!}>{!! $product->description !!}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="reviews-modal" tabindex="-1" role="dialog" aria-labelledby="location-tab-3-Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="transition: .5s;" role="document">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        @if(Auth::guard('user')->check())

                        @if(Auth::guard('user')->user()->orders()->count() > 0)
                        <h1 class="heading_three mb-4">{{$lang->fpr}}</h1>
                        <hr>
                        @include('includes.form-success')
                        <div class="product-reviews">
                            <div class="review-star">
                              <div class='starrr' id='star_mobile'></div>
                                <div>
                                    <span class='your-choice-was' style='display: none;'>
                                      {{$lang->dofpl}}: <span class='choice'></span>.
                                    </span>
                                </div>
                            </div>
                        </div>
                        <form class="product-review-form" action="{{route('front.review.submit')}}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_id" value="{{Auth::guard('user')->user()->id}}">
                            <input type="hidden" name="rating" id="rate_mobile" value="5">
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <div class="form-group">
                                <textarea name="review" id="" rows="5" placeholder="{{$lang->suf}}" class="form-control" style="resize: vertical;" required></textarea>
                            </div>
                            <div class="form-group text-center">
                                <input name="btn" type="submit" class="btn-review" value="Submit Review">
                            </div>
                        </form>
                        @else
                        <h3 class="heading_three mb-3">{{ $lang->product_review }}.</h3>
                        @endif
                        <hr>
                          <h1 class="heading_three mb-3">{{$lang->dttl}}: </h1>
                        <hr>
                        @forelse($product->reviews as $review)
                            <div class="review-rating-description">
                                <div class="row">
                                  <div class="col-md-3 col-sm-3">
                                    <p>{{$review->user->name}}</p>
                                    <p class="product-reviews">
                                      <div class="ratings">
                                        <div class="empty-stars"></div>
                                        <div class="full-stars" style="width:{{$review->rating*20}}%"></div>
                                      </div>
                                    </p>
                                    <p>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $review->review_date)->diffForHumans()}}</p>
                                  </div>
                                  <div class="col-md-9 col-sm-9">
                                    <p>{{$review->review}}</p>
                                  </div>
                                </div>
                            </div>
                            @empty
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>{{$lang->md}}</h4>
                                </div>
                            </div>
                            @endforelse

                        @else

                            <h2 class="heading_three mb-4">{{$lang->dttl}}</h2>
                            @forelse($product->reviews as $review)
                            <div class="review-rating-description">
                                <div class="row">
                                  <div class="col-12 col-md-3">
                                    <p>{{$review->user->name}}</p>
                                    <p class="product-reviews">
                                      <div class="ratings">
                                        <div class="empty-stars"></div>
                                        <div class="full-stars" style="width:{{$review->rating*20}}%"></div>
                                      </div>
                                  </p>
                                    <p>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $review->review_date)->diffForHumans()}}</p>
                                  </div>
                                  <div class="col-12 col-md-9">
                                    <p>{{$review->review}}</p>
                                  </div>
                                </div>
                            </div>
                            @empty
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>{{$lang->md}}</h4>
                                </div>
                            </div>
                        @endforelse
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  Ending of product detail tab area   -->




@endsection

@section('scripts')


<script type="text/javascript">


    // var size = $(this).html();
    // $('#size').val(size);

    $('#star1').starrr({
        rating: 5,
        change: function(e, value){
            if (value) {
                $('.your-choice-was').show();
                $('.choice').text(value);
                $('#rate').val(value);
            } else {
                $('.your-choice-was').hide();
            }
        }
    });


	 $('#star_mobile').starrr({
        rating: 5,
        change: function(e, value){
            if (value) {
                $('.your-choice-was').show();
                $('.choice').text(value);
                $('#rate_mobile').val(value);
            } else {
                $('.your-choice-was').hide();
            }
        }
    });

	$(".product_slider").owlCarousel({
            items: 4,
            autoplay: true,
            margin: 30,
            loop: true,
            dots: true,
            nav: true,

            navText: ["<button type='button' data-role='none' class='slick-prev slick-arrow' aria-label='Previous' role='button' style=''>Previous</button>", "<button type='button' data-role='none' class='slick-next slick-arrow' aria-label='Next' role='button' style=''>Next</button>"],
            smartSpeed: 800,
            responsive : {
              0 : {
              items: 1,
              },
              420 : {
              items: 1,
              },
              768 : {
              items: 3,
              },
              992 : {
              items: 4
              },
              1200 : {
              items: 4
              }
            }
        });

</script>

<script type="text/javascript">
    var sizes = "";
    var colors = "";
    var stock = $("#stock").val();

    $(document).on("click", "#qsub" , function(){
         var qty = $("#qval").html();
         var pid = $("#pid").val();
         qty--;
         if(qty < 1)
         {
         $("#qval").html("{{$product->min_qty}}");
         }
         else{
         $("#qval").html(qty);
         }

         if(qty > 0){
         $.ajax({
                 type: "POST",
                 url:"{{URL::to('/json/filtertierproductajax')}}",
                 data:{"_token": "{{ csrf_token() }}",product_id:pid,qty:qty},
                 success:function(data){
                   console.log(data);
                     $('.pricetxts').html(data);
                   }
           });
         }

    });
    $(document).on("click", "#qadd" , function(){
        var qty = $("#qval").html();
        var pid = $("#pid").val();
        if(stock != "")
        {
        var stk = parseInt(stock);
          if(qty < stk)
          {
             qty++;
             $("#qval").html(qty);
          }

        }
        else{
         qty++;
         $("#qval").html(qty);
        }

        $.ajax({
                type: "POST",
                url:"{{URL::to('/json/filtertierproductajax')}}",
                data:{"_token": "{{ csrf_token() }}",product_id:pid,qty:qty},
                success:function(data){
                  console.log(data);
                  $('.pricetxts').html(data);
                  }
          });

    });

	var sizes = "";
    var size_qty = "";
    var size_price = "";
    var size_key = "";
    var colors = "";
    var total = "";
    var stock = $("#stock").val();
    var keys = "";
    var values = "";
    var prices = "";

    // Product Details Product Size Active Js Code
    $(document).on('click', '.product-size .siz-list .box', function () {
        $('#qval').html('{{$product->min_qty}}');
        var parent = $(this).parent();
         size_qty = $(this).find('.size_qty').val();
         size_price = $(this).find('.size_price').val();
         size_key = $(this).find('.size_key').val();
         sizes = $(this).find('.size').val();
                $('.product-size .siz-list li').removeClass('active');
                parent.addClass('active');
         total = getAmount()+parseFloat(size_price);
         total = total.toFixed(2);
         stock = size_qty;

		$('#product_option_size').val('1');
         var pos = $('#curr_pos').val();
         var sign = "€ ";
		 $('.productDetails-price').html(sign+total);
    });

	$(document).on('click', '.product-color .color-list .box', function () {
        colors = $(this).data('color');
        var parent = $(this).parent();
            $('.product-color .color-list li').removeClass('active');
            parent.addClass('active');
			$('#product_option_color').val('1');
    });

    $(document).on("click", ".addtocartajax" , function(){
		var product_option_color = $('#product_option_color').val();
		var product_option_size = $('#product_option_size').val();
		if(product_option_size=='0')
		{
			$.notify("Please select product item size.","warning");

			return false;
		}
		if(product_option_color=='0')
		{
			$.notify("Please select product item color.","warning");
			return false;
		}
     var qty = $("#qval").html();
     var pid = $("#pid").val();
             $(".empty").html("");
                $.ajax({
                        type: "GET",
                        url:"{{URL::to('/json/addnumcart')}}",
                        data:{id:pid,qty:qty,size:sizes,size_qty:size_qty,size_price:size_price,size_key:size_key,color:colors},
						success:function(data){
						console.log(data);
                        if(data == 0)
                        {
                        $.notify("{{$gs->cart_error}}","error");
                        }
                        else{
                        $(".empty").html("");
                        $(".total").html("{{$curr->sign}}"+(data[0] * {{$curr->value}}).toFixed(2));
                        $(".cart-quantity").html(data[2]);
                        var arr = $.map(data[1], function(el) {
                        return el });
                        $(".js-cart-product-template").html("");
						if(data[2]>=1)
						{
              $(".cart_text_footer_btn").html("");
var checkoutbutton = '<a class="button" href="{{route("front.checkout")}}" title="Checkout">Checkout</a><a class="button ml-4" href="{{route("front.cart")}}" title="View Cart">View Cart</a>';
							$(".cart_text_footer_btn").html(checkoutbutton);
							$(".cart__empty").hide();
						}else{
						    $(".cart__empty").show();
						}
                        for(var k in arr)
                        {
                            var x = arr[k]['item']['name'];
                            var p = x.length  > 45 ? x.substring(0,45)+'...' : x;
                            var measure = arr[k]['item']['measure'] != null ? arr[k]['item']['measure'] : "";
                            $(".js-cart-product-template").append(
                             '<div class="single-myCart">'+
            '<p class="cart-close" onclick="remove('+arr[k]['item']['id']+')"><i class="fa fa-close"></i></p>'+
                            '<div class="cart-img">'+
                    '<img src="{{ asset('assets/images/'.$store_code.'/products/') }}/thumb_'+arr[k]['item']['photo']+'" alt="Product image">'+
                            '</div>'+
                            '<div class="cart-info">'+
        '<a href="{{url('/')}}/'+arr[k]['item']['slug']+'.html" style="color: black; padding: 0 0;">'+'<h5>'+p+'</h5></a>'+
        '<div class="productDetails-quantity"><p>{{$lang->cquantity}}: <span class="quantity-btn side_reducing"><i class="fa fa-minus"></i></span>'+
        '<span id="cqt'+arr[k]['item']['id']+'">'+arr[k]['qty']+'</span><input type="hidden" value="'+arr[k]['item']['id']+'"><input type="hidden" class="itemid" value="'+arr[k]['item']['id']+'">'+
        '<input type="hidden" class="size_qty" value=""/><input type="hidden" class="size_price" value=""/><input type="hidden" class="size_key" value=""/><input type="hidden" class="size" value=""/>'+
        '<input type="hidden" id="stock'+arr[k]['item']['id']+'" value=""><span class="quantity-btn side_adding"><i class="fa fa-plus"></i></span></p></div>'+

                        @if($gs->sign == 0)
                        '<p class="total_item_amount">{{$curr->sign}}<span id="prct'+arr[k]['item']['id']+'">'+(arr[k]['price'] * {{$curr->value}}).toFixed(2)+'</span></p>'+
                        @else
                        '<p class="total_item_amount"><span id="prct'+arr[k]['item']['id']+'">'+(arr[k]['price'] * {{$curr->value}}).toFixed(2)+'</span>{{$curr->sign}}</p>'+
                        @endif
                        '</div>'+
                        '</div>');
                          }
                        $.notify("{{$gs->cart_success}}","success");
                        $("#qval").html("{{$product->min_qty}}");
                        }
                      }
                  });

    });

</script>


    <script>
        $(document).on("click", "#wish" , function(){
            var pid = $("#pid").val();
            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/wish')}}",
                    data:{id:pid},
                    success:function(data){
                        if(data == 1)
                        {
                            $.notify("{{$gs->wish_success}}","success");
							setTimeout(function () {
							location.reload(true);
							}, 1000);
                        }
                        else {
                            $.notify("{{$gs->wish_error}}","error");
                        }
                      }
              });

            return false;
        });
		$(document).on("click", "#rmwish" , function(){
            var pid = $("#pid").val();
            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/removewish')}}",
                    data:{id:pid},
                    success:function(data){
					$.notify("{{$gs->wish_remove}}","success");
					setTimeout(function () {
					location.reload(true);
					}, 1000);
                      }
              });

            return false;
        });
    </script>
    <script>
        $(document).on("click", "#favorite" , function(){
          $("#favorite").hide();
            var pid = $("#fav").val();
            $.ajax({
                    type: "GET",
                    url:"{{URL::to('/json/favorite')}}",
                    data:{id:pid},
                    success:function(data){
                      $('.product-headerInfo__btns').html('<a class="headerInfo__btn colored"><i class="fa fa-check"></i> {{ $lang->product_favorite }}</a>');
                      }
              });

        });
    </script>



<script type="text/javascript">
//*****************************COMMENT******************************//
        $("#cmnt").submit(function(){
          var uid = $("#user_id").val();
          var pid = $("#product_id").val();
          var cmnt = $("#txtcmnt").val();
          $("#txtcmnt").prop('disabled', true);
          $('.btn blog-btn comments').prop('disabled', true);
     $.ajax({
            type: 'post',
            url: "{{URL::to('json/comment')}}",
            data: {
                '_token': $('input[name=_token]').val(),
                'uid'   : uid,
                'pid'   : pid,
                'cmnt'  : cmnt
                  },
            success: function(data) {
              $("#comments").prepend(
                    '<div id="comment'+data[3]+'">'+
                        '<div class="row single-blog-comments-wrap">'+
                            '<div class="col-lg-12">'+
                              '<h4><a class="comments-title">'+data[0]+'</a></h4>'+
                                '<div class="comments-reply-area">'+data[1]+'</div>'+
                                 '<p id="cmntttl'+data[3]+'">'+data[2]+'</p>'+
                                '<div class="replay-form">'+
                    '<p class="text-right"><input type="hidden" value="'+data[3]+'"><button class="replay-btn">{{$lang->reply_button}} <i class="fa fa-reply-all"></i></button><button class="replay-btn-edit">{{$lang->edit_button}} <i class="fa fa-edit"></i></button><button class="replay-btn-delete">{{$lang->remove}} <i class="fa fa-trash"></i></button>'+
                    '</p>'+'<form action="" method="POST" class="comment-edit">'+
                                      '{{csrf_field()}}'+
                                '<input type="hidden" name="comment_id" value="'+data[3]+'">'+
                                      '<div class="form-group">'+
                            '<textarea rows="2" id="editcmnt'+data[3]+'" name="text" class="form-control"'+
                            'placeholder="{{$lang->edit_comment}}" style="resize: vertical;" required=""></textarea>'+
                                      '</div>'+
                                      '<div class="form-group">'+
                    '<button type="submit" class="btn btn-no-border hvr-shutter-out-horizontal">{{$lang->update_comment}}</button>&nbsp;'+
                        '<button type="button" class="btn btn-no-border hvr-shutter-out-horizontal cancel">{{$lang->cancel_edit}}</button>'+
                                      '</div>'+
                                    '</form>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                      '</div>');
                    $("#comment"+data[3]).append('<div id="replies'+data[3]+'" style="display: none;"></div>');
                     $("#replies"+data[3]).append('<div class="rapper" style="display: none;"></div>');
                     $("#replies"+data[3]).append('<form action="" method="POST" class="reply" style="display: none;">'+
                      '{{csrf_field()}}'+
                      '<input type="hidden" name="comment_id" id="comment_id'+data[3]+'" value="'+data[3]+'">'+
                      '<input type="hidden" name="user_id" id="user_id'+data[4]+'" value="'+data[4]+'">'+
                        '<div class="form-group">'+
                          '<textarea rows="2" name="text" id="txtcmnt'+data[3]+'" class="form-control"'+ 'placeholder="{{$lang->write_reply}}" required="" style="resize: vertical;"></textarea>'+
                        '</div>'+
                      '<div class="form-group">'+
                        '<button type="submit" class="btn btn-no-border hvr-shutter-out-horizontal">{{$lang->reply_button}}</button>'+
                      '</div>'+'</form>');






                      //-----------Replay button details-----------
            if (data[5] > 1){
              $("#cmnt-text").html("{{ $lang->comments }}(<span id='cmnt_count'>"+ data[5]+"</span>)");
            }
            else{
              $("#cmnt-text").html("{{ $lang->comment }} (<span id='cmnt_count'>"+ data[5]+"</span>)");
            }
        $("#txtcmnt").prop('disabled', false);
        $("#txtcmnt").val("");
        $('.btn blog-btn comments').prop('disabled', false);
            }
        });
          return false;
        });
//*****************************COMMENT ENDS******************************
</script>

<script type="text/javascript">

//***************************** REPLY TOGGLE******************************//
          $(document).on("click", ".replay-form p button.view-replay-btn" , function(){
          var id = $(this).parent().next().find('input[name=comment_id]').val();
          $("#replies"+id+" .rapper").show();
          $("#replies"+id).show();
          });

          $(document).on("click", ".replay-form p button.replay-btn, .replay-form p button.subreplay-btn" , function(){
          var id = $(this).parent().find('input[type=hidden]').val();
          $("#replies"+id).show();
          $("#replies"+id).find('.reply').show();
          $("#replies"+id).find('.reply textarea').focus();
          });
//*****************************REPLY******************************//
          $(document).on("submit", ".reply" , function(){
          var uid = $(this).find('input[name=user_id]').val();
          var cid = $(this).find('input[name=comment_id]').val();
          var rpl = $(this).find('textarea').val();
          $(this).find('textarea').prop('disabled', true);
          $('.btn btn-no-border hvr-shutter-out-horizontal').prop('disabled', true);
     $.ajax({
            type: 'post',
            url: "{{URL::to('json/reply')}}",
            data: {
                '_token': $('input[name=_token]').val(),
                'uid'   : uid,
                'cid'   : cid,
                'rpl'  : rpl
                  },
            success: function(data) {
              $("#replies"+cid).prepend('<div id="reply'+data[3]+'">'+
                        '<div class="row single-blog-comments-wrap replay">'+
                            '<div class="col-lg-12">'+
                              '<h4><a class="comments-title">'+data[0]+'</a></h4>'+
                                '<div class="comments-reply-area">'+data[1]+'</div>'+
                                 '<p id="rplttl'+data[3]+'">'+data[2]+'</p>'+
                                '<div class="replay-form">'+
                    '<p class="text-right"><input type="hidden" value="'+cid+'"><button class="subreplay-btn">{{$lang->reply_button}} <i class="fa fa-reply-all"></i></button><button class="replay-btn-edit1">{{$lang->edit_button}} <i class="fa fa-edit"></i></button><button class="replay-btn-delete1">{{$lang->remove}} <i class="fa fa-trash"></i></button></p>'+
                                    '<form action="" method="POST" class="reply-edit">'+
                                      '{{csrf_field()}}'+
                                  '<input type="hidden" name="reply_id" value="'+data[3]+'">'+
                                      '<div class="form-group">'+
                                    '<textarea rows="2" id="editrpl'+data[3]+'" name="text" class="form-control"'+ 'placeholder="{{$lang->edit_reply}}"  style="resize: vertical;" required=""></textarea>'+
                                      '</div>'+
                                      '<div class="form-group">'+
                                      '<button type="submit" class="btn btn-no-border hvr-shutter-out-horizontal">'+'{{$lang->update_comment}}</button>&nbsp;'+
                                      '<button type="button" class="btn btn-no-border hvr-shutter-out-horizontal cancel">{{$lang->cancel_edit}}</button>'+
                                      '</div>'+
                                    '</form>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '</div>');
                      //-----------REPLY button details-----------
        $("#txtcmnt"+cid).prop('disabled', false);
        $("#txtcmnt"+cid).val("");
        $('.btn btn-no-border hvr-shutter-out-horizontal').prop('disabled', false);
            }
        });
          return false;
        });
//*****************************REPLY ENDS******************************//

</script>

<script type="text/javascript">

  $(document).on("click", ".replay-btn-edit" , function(){
          var id = $(this).parent().find('input[type=hidden]').val();
          var txt = $("#cmntttl"+id).html();
          $(this).parent().parent().parent().find('.comment-edit textarea').val(txt);
          $(this).parent().parent().parent().find('.comment-edit').toggle();
  });
  $(document).on("click", ".cancel" , function(){
          $(this).parent().parent().hide();
  });
  //*****************************SUB REPLY******************************//
          $(document).on("submit", ".comment-edit" , function(){
          var cid = $(this).find('input[name=comment_id]').val();
          var text = $(this).find('textarea').val();
           $(this).find('textarea').prop('disabled', true);
          $('.hvr-shutter-out-horizontal').prop('disabled', true);
     $.ajax({
            type: 'post',
            url: "{{URL::to('json/comment/edit')}}",
            data: {
                '_token': $('input[name=_token]').val(),
                'cid'   : cid,
                'text'  : text
                  },
            success: function(data) {
        $("#cmntttl"+cid).html(data);
        $("#editcmnt"+cid).prop('disabled', false);
        $("#editcmnt"+cid).val("");
        $('.hvr-shutter-out-horizontal').prop('disabled', false);
            }
        });
          return false;
        });

</script>

<script type="text/javascript">
  $(document).on("click", ".replay-btn-delete" , function(){
              var id = $(this).parent().next().find('input[name=comment_id]').val();
              $("#comment"+id).hide();
              var count = parseInt($("#cmnt_count").html());
              count--;
              if(count <= 1)
              {
              $("#cmnt-text").html("COMMENT (<span id='cmnt_count'>"+ count+"</span>)");
              }
              else
              {
              $("#cmnt-text").html("COMMENTS (<span id='cmnt_count'>"+ count+"</span>)");
              }
     $.ajax({
            type: 'get',
            url: "{{URL::to('json/comment/delete')}}",
            data: {'id': id}
        });
  });
</script>


<script type="text/javascript">
  $(document).on("click", ".replay-btn-edit1" , function(){
          var id = $(this).parent().parent().parent().find('.reply-edit input[name=reply_id]').val();
          var txt = $("#rplttl"+id).html();
          $(this).parent().parent().parent().find('.reply-edit textarea').val(txt);
          $(this).parent().parent().parent().find('.reply-edit').toggle();
          var txt = $("#cmntttl"+id).html();
  });

  //*****************************SUB REPLY******************************//
          $(document).on("submit", ".reply-edit" , function(){
          var cid = $(this).find('input[name=reply_id]').val();
          var text = $(this).find('textarea').val();
           $(this).find('textarea').prop('disabled', true);
          $('.hvr-shutter-out-horizontal').prop('disabled', true);
     $.ajax({
            type: 'post',
            url: "{{URL::to('json/reply/edit')}}",
            data: {
                '_token': $('input[name=_token]').val(),
                'cid'   : cid,
                'text'  : text
                  },
            success: function(data) {
        $("#rplttl"+cid).html(data);
        $("#editrpl"+cid).prop('disabled', false);
        $("#editrpl"+cid).val("");
        $('.hvr-shutter-out-horizontal').prop('disabled', false);
            }
        });
          return false;
        });

</script>

<script type="text/javascript">
  $(document).on("click", ".replay-btn-delete1" , function(){
              var id = $(this).parent().next().find('input[name=reply_id]').val();
              $("#reply"+id).hide();
     $.ajax({
            type: 'get',
            url: "{{URL::to('json/reply/delete')}}",
            data: {'id': id}
        });
  });

  function getAmount()
{
  var total = 0;
  var value = parseFloat($('#product_price').val());

  total += value;
  return total;
}

    // Product Detail Sidebar Fixed when scrolling

	function sticky_addtoCart()
	{
		var window_top = $(window).scrollTop();
		var stickyaddtocart = $('.detail_product_header');
		if (window_top >= 100)
		{
		stickyaddtocart.addClass('fixed');
		}else{
		stickyaddtocart.removeClass('fixed');
		}
	}
</script>

@endsection

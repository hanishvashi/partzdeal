@extends('layouts.customer')
@section('content')
  <section class="customer-my-orders">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <!-- Starting of Dashboard data-table area -->
        <div class="section-padding add-product-1">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="add-product-box">
                                    <div class="product__header">
                                        <div class="row reorder-xs">
                                            <div class="col-lg-8 col-md-5 col-sm-5 col-xs-12">
                                                <div class="product-header-title">
                                                    <h2>Purchased Items</h2>
                                                </div>
                                            </div>
                                        </div>   
                                    </div>
                <div>
                  @include('includes.form-success')
                  <div class="row">
                    <div class="col-sm-12">
                                    <div class="table-responsive">
                                      <table id="product-table_wrapper" class="table table-striped table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr class="table-header-row">
                          <th>Order#</th>
                          <th>Date</th>
                          <th>Order Total</th>
                          <th>Order Status</th>
                          <th>Details</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                          <tr>
                            <td>{{$order->order_number}}</td>
                            <td>{{date('d M Y',strtotime($order->created_at))}}</td>
                            <td>{{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}</td>
                            <td>{{ucfirst($order->status)}}</td>
                            <td><a href="{{route('customer-order',$order->id)}}">View Order</a></td>
                          </tr>
                        @endforeach
                        </tbody>
                      </table></div></div>
                    </div>
					<div class="row">
    			<div class="col-md-12 text-center"> 
    			    {!! $orders->links() !!}               
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
  </section>


@endsection

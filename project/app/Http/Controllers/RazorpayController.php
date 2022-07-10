<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Coupon;
use App\Currency;
use App\Generalsetting;
use App\Notification;
use App\Order;
use App\Package;
use App\Payment;
use App\PricingTable;
use App\Product;
use App\User;
use App\VendorOrder;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Input;
use Redirect;
use Razorpay\Api\Api;
use URL;
use Validator;

class RazorpayController extends Controller
{
    public function store(Request $request){
        if (!Session::has('cart')) {
            return redirect()->route('front.cart')->with('success',"You don't have any product to checkout.");
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
            if (Session::has('currency')) 
            {
              $curr = Currency::find(Session::get('currency'));
            }
            else
            {
                $curr = Currency::where('is_default','=',1)->first();
            }

        $settings = Generalsetting::findOrFail(1);
        $order = new Order;
        $success_url = action('PaymentController@payreturn');
        $item_name = $settings->title." Order";
        $item_number = str_random(4).time();
		$item_amount = $request->total;
		$input = $request->all();
	   
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
		$totalamount = $cart->totalPrice;
		$RazororderData = [
		'receipt'         => $item_number,
		'amount'          => $item_amount * 100, //
		'currency'        => 'INR',
		'payment_capture' => 1 // auto capture
		];
		
		$logo =URL::to('/')."/assets/images/".$settings['logo'];
		$sitename = $settings['title'];
		if($settings['razorpay_sandbox_check']==1) // SandBox Payment
		{
			$keyId = $settings['razorpay_sandbox_keyid'];
			$keySecret = $settings['razorpay_sandbox_keysecret'];
		}else{ // Live Payment
			$keyId = $settings['razorpay_live_keyid'];
			$keySecret = $settings['razorpay_live_keysecret'];
		}
		
		$api = new Api($keyId, $keySecret);
		$razorpayOrder = $api->order->create($RazororderData);
		$razorpayOrderId = $razorpayOrder['id'];
		$displayAmount = $amount = $RazororderData['amount'];
		
		$paymentdata = [
		"key"               => $keyId,
		"amount"            => $amount,
		"name"              => $sitename.'- '.$item_number,
		"description"       => $sitename.'- '.$item_number,
		"image"             => $logo,
		"prefill"           => [
		"name"              => $input['name'],
		"email"             => $input['email'],
		"contact"           => $input['phone'],
		],
		"theme"             => [
		"color"             => "#F37254"
		],
		"razorpay_order_id"  => $razorpayOrderId,
		];
	   
                    $order['user_id'] = $request->user_id;
                    $order['cart'] = utf8_encode(bzcompress(serialize($cart), 9));
                    $order['totalQty'] = $request->totalQty;
                    $order['pay_amount'] = round($item_amount / $curr->value, 2);
                    $order['method'] = "RazorPay";
                    $order['customer_email'] = $request->email;
                    $order['customer_name'] = $request->name;
                    $order['customer_phone'] = $request->phone;
                    $order['order_number'] = $item_number;
                    $order['shipping'] = $request->shipping;
                    $order['pickup_location'] = $request->pickup_location;
                    $order['customer_address'] = $request->address;
                    $order['customer_country'] = $request->customer_country;
                    $order['customer_city'] = $request->city;
                    $order['customer_zip'] = $request->zip;
                    $order['shipping_email'] = $request->shipping_email;
                    $order['shipping_name'] = $request->shipping_name;
                    $order['shipping_phone'] = $request->shipping_phone;
                    $order['shipping_address'] = $request->shipping_address;
                    $order['shipping_country'] = $request->shipping_country;
                    $order['shipping_city'] = $request->shipping_city;
                    $order['shipping_zip'] = $request->shipping_zip;
                    $order['order_note'] = $request->order_note;
                    $order['coupon_code'] = $request->coupon_code;
                    $order['coupon_discount'] = $request->coupon_discount;
                    $order['payment_status'] = "Pending";
					$order['razorpay_orderid'] = $razorpayOrderId;
                   // $order['txnid'] = $charge['balance_transaction'];
                    //$order['charge_id'] = $charge['id'];
                    $order['currency_sign'] = $curr->sign;
                    $order['currency_value'] = $curr->value;
                    $order['shipping_cost'] = $request->shipping_cost;
                    $order['tax'] = $request->tax;
					$order['dp'] = $request->dp;
					if($order['dp'] == 1)
					{
					$order['status'] = 'completed';
					}
            
                    $order->save();
					$order_id = $order->id;
					$coupon_id = $request->coupon_id;
		return view('front.razorpay', ['coupon_id'=>$coupon_id,'item_number' => $item_number, 'order_id' => $order_id, 'paymentdata' => $paymentdata]);                 			
    }
	
	public function VerifyPayment(Request $request)
	{
		 $input = $request->all();
		 $order_id = $input['order_id'];
		 $order_number = $input['order_number'];
		 $orderdata = Order::findOrFail($order_id);
		 $razorpay_payment_details['_token'] = $input['_token'];
		 $razorpay_payment_details['order_number'] = $order_number;
		 $razorpay_payment_details['razorpay_payment_id'] = $input['razorpay_payment_id'];
		 $razorpay_payment_details['razorpay_order_id'] = $input['razorpay_order_id'];
		 $razorpay_payment_details['razorpay_signature'] = $input['razorpay_signature'];
		 $razorpay_payment_details['org_logo'] = $input['org_logo'];
		 $razorpay_payment_details['org_name'] = $input['org_name'];
		 $razorpay_payment_details['checkout_logo'] = $input['checkout_logo'];
		 $razorpay_payment_details['custom_branding'] = $input['custom_branding'];
		 $razorpay_payment_details_json = json_encode($razorpay_payment_details,true);
		 $orderdata->razorpay_payment_details =  $razorpay_payment_details_json;
		 $orderdata->payment_status =  "Completed";
		 $orderdata->update();
		 
					$oldCart = Session::get('cart');
					$cart = new Cart($oldCart);
					$notification = new Notification;
                    $notification->order_id = $order_id;
                    $notification->save();
                    if($request->coupon_id != "")
                    {
                       $coupon = Coupon::findOrFail($request->coupon_id);
                       $coupon->used++;
                       if($coupon->times != null)
                       {
                            $i = (int)$coupon->times;
                            $i--;
                            $coupon->times = (string)$i;
                       }
                        $coupon->update();
                    }
                    foreach($cart->items as $prod)
						{
						$x = (string)$prod['stock'];
						if($x != null)
						{
						$product = Product::findOrFail($prod['item']['id']);
						$product->stock =  $prod['stock'];
						$product->update();                
						}
						}
                    foreach($cart->items as $prod)
                    {
                        if($prod['item']['user_id'] != 0)
                        {
                            $vorder =  new VendorOrder;
                            $vorder->order_id = $order_id;
                            $vorder->user_id = $prod['item']['user_id'];
                            $vorder->qty = $prod['qty'];
                            $vorder->price = $prod['price'];
                            $vorder->order_number = $order_number;             
                            $vorder->save();
                        }
                    }
		$success_url = action('PaymentController@payreturn');
		Session::forget('cart');
		return redirect($success_url);
	}
}

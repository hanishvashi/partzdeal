<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Counter;
use App\Category;
use App\Subcategory;
use App\Childcategory;
use DB;

class VendorFrontController extends Controller
{

    public function __construct()
    {
        if(isset($_SERVER['HTTP_REFERER'])){
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
        }
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
	
	
	public function CountResult($user_id,$min,$max)
	{
		
		$count  = DB::table('products')
			->select('products.*')
			->where('products.status',1)->where('products.is_approve',1)->where('products.user_id',$user_id)->count();
		if(!empty($min) || !empty($min))
        {
			$count = DB::table('products')
			->select('products.*')
			->where('products.status',1)->where('products.is_approve',1)->where('products.user_id',$user_id)->whereBetween('products.cprice', [$min, $max])->count();
		}
		return $count;	
	}
	
    public function vendor(Request $request,$slug)
    {
		
        $sort = '';
        $vendor = User::where('shop_url','=',$slug)->first();
		$vprods = DB::table('products')
			->select('products.*')
			->where('products.status',1)->where('products.is_approve',1)->where('products.user_id',$vendor->id)->orderBy('products.id','desc')->paginate(9);
		$total_product = $this->CountResult($vendor->id,'','');
        if(!empty($request->min) || !empty($request->max))
        {
        $min = $request->min;
        $max = $request->max;
		
		$vprods = DB::table('products')
			->select('products.*')
			->where('products.status',1)->where('products.is_approve',1)->where('products.user_id',$vendor->id)->whereBetween('products.cprice', [$min, $max])->orderBy('products.cprice','asc')->paginate(9);
		$total_product = $this->CountResult($vendor->id,$min,$max);
		
        return view('front.vendor',compact('vendor','vprods','sort','min','max','total_product'));
        }
        return view('front.vendor',compact('vendor','vprods','sort','total_product'));
    }

    public function vendorsort($slug,$sorted)
    {
        $sort = $sorted;
        $string = str_replace('-', ' ', $slug);
        $vendor = User::where('shop_name','=',$string)->first();
        if($sort == "new")
        {
        $vprods = $vendor->products()->where('status','=',1)->orderBy('id','desc')->paginate(9);
        }
        else if($sort == "old")
        {
        $vprods = $vendor->products()->where('status','=',1)->paginate(9);
        }
        else if($sort == "low")
        {
        $vprods = $vendor->products()->where('status','=',1)->orderBy('cprice','asc')->paginate(9);
        }
        else if($sort == "high")
        {
        $vprods = $vendor->products()->where('status','=',1)->orderBy('cprice','desc')->paginate(9);
        }
        return view('front.vendor',compact('vendor','vprods','sort'));
    }

    public function vendorcategory(Request $request,$slug1,$slug2)
    {
        $sort = '';
        $string = str_replace('-', ' ', $slug1);
        $vendor = User::where('shop_name','=',$string)->first();
        $vcat = Category::where('cat_slug','=',$slug2)->first();
        $vcats = $vcat->products()->where('status','=',1)->where('user_id','=',$vendor->id)->orderBy('id','desc')->paginate(9);
        if(!empty($request->min) || !empty($request->max))
        {
        $min = $request->min;
        $max = $request->max;
        $vcats = $vcat->products()->where('status','=',1)->where('user_id','=',$vendor->id)->whereBetween('cprice', [$min, $max])->orderBy('cprice','asc')->paginate(9);
        return view('front.vendorcategory',compact('vendor','vcat','vcats','sort','min','max'));
        }
        return view('front.vendorcategory',compact('vendor','vcat','vcats','sort'));
    }

    public function vendorcategorysort($slug1,$slug2,$sorted)
    {
        $sort = $sorted;
        $string = str_replace('-', ' ', $slug1);
        $vendor = User::where('shop_name','=',$string)->first();
        $vcat = Category::where('cat_slug','=',$slug2)->first();
        if($sort == "new")
        {
        $vcats = $vcat->products()->where('status','=',1)->where('user_id','=',$vendor->id)->orderBy('id','desc')->paginate(9);
        }
        else if($sort == "old")
        {
        $vcats = $vcat->products()->where('status','=',1)->where('user_id','=',$vendor->id)->paginate(9);
        }
        else if($sort == "low")
        {
        $vcats = $vcat->products()->where('status','=',1)->where('user_id','=',$vendor->id)->orderBy('cprice','asc')->paginate(9);
        }
        else if($sort == "high")
        {
        $vcats = $vcat->products()->where('status','=',1)->where('user_id','=',$vendor->id)->orderBy('cprice','desc')->paginate(9);
        }
        return view('front.vendorcategory',compact('vendor','vcat','vcats','sort'));
    }

    public function vendorsubcategory(Request $request,$slug1,$slug2)
    {
        $sort = '';
        $string = str_replace('-', ' ', $slug1);
        $vendor = User::where('shop_name','=',$string)->first();
        $vsubcat = Subcategory::where('sub_slug','=',$slug2)->first();
        $vsubcats = $vsubcat->products()->where('status','=',1)->where('user_id','=',$vendor->id)->orderBy('id','desc')->paginate(9);        
        if(!empty($request->min) || !empty($request->max))
        {
        $min = $request->min;
        $max = $request->max;
        $vsubcats = $vsubcat->products()->where('status','=',1)->where('user_id','=',$vendor->id)->whereBetween('cprice', [$min, $max])->orderBy('cprice','asc')->paginate(9);
        return view('front.vendorsubcategory',compact('vendor','vsubcat','vsubcats','sort','min','max'));
        }
        return view('front.vendorsubcategory',compact('vendor','vsubcat','vsubcats','sort'));
    }

    public function vendorsubcategorysort($slug1,$slug2,$sorted)
    {
        $sort = $sorted;
        $string = str_replace('-', ' ', $slug1);
        $vendor = User::where('shop_name','=',$string)->first();
        $vsubcat = Subcategory::where('sub_slug','=',$slug2)->first();
        if($sort == "new")
        {
		$vsubcats = $vsubcat->products()->where('status','=',1)->where('user_id','=',$vendor->id)->orderBy('id','desc')->paginate(9);
        }
        else if($sort == "old")
        {
        $vsubcats = $vsubcat->products()->where('status','=',1)->where('user_id','=',$vendor->id)->paginate(9);
        }
        else if($sort == "low")
        {
        $vsubcats = $vsubcat->products()->where('status','=',1)->where('user_id','=',$vendor->id)->orderBy('cprice','asc')->paginate(9);
        }
        else if($sort == "high")
        {
        $vsubcats = $vsubcat->products()->where('status','=',1)->where('user_id','=',$vendor->id)->orderBy('cprice','desc')->paginate(9);
        }
        return view('front.vendorsubcategory',compact('vendor','vsubcat','vsubcats','sort'));
    }


    public function vendorchildcategory(Request $request,$slug1,$slug2)
    {
        $sort = '';
        $string = str_replace('-', ' ', $slug1);
        $vendor = User::where('shop_name','=',$string)->first();
        $vchildcat = Childcategory::where('child_slug','=',$slug2)->first();
        $vchildcats = $vchildcat->products()->where('status','=',1)->where('user_id','=',$vendor->id)->orderBy('id','desc')->paginate(9);  
        if(!empty($request->min) || !empty($request->max))
        {
        $min = $request->min;
        $max = $request->max;
        $vchildcats = $vchildcat->products()->where('status','=',1)->where('user_id','=',$vendor->id)->whereBetween('cprice', [$min, $max])->orderBy('cprice','asc')->paginate(9);
        return view('front.vendorchildcategory',compact('vendor','vchildcat','vchildcats','sort','min','max'));
        }
        return view('front.vendorchildcategory',compact('vendor','vchildcat','vchildcats','sort'));
    }

    public function vendorchildcategorysort($slug1,$slug2,$sorted)
    {
        $sort = $sorted;
        $string = str_replace('-', ' ', $slug1);
        $vendor = User::where('shop_name','=',$string)->first();
        $vchildcat = Childcategory::where('child_slug','=',$slug2)->first();
        if($sort == "new")
        {
$vchildcats = $vchildcat->products()->where('status','=',1)->where('user_id','=',$vendor->id)->whereBetween('cprice', [$min, $max])->orderBy('cprice','asc')->paginate(9);
        }
        else if($sort == "old")
        {
$vchildcats = $vchildcat->products()->where('status','=',1)->where('user_id','=',$vendor->id)->paginate(9);
        }
        else if($sort == "low")
        {
$vchildcats = $vchildcat->products()->where('status','=',1)->where('user_id','=',$vendor->id)->orderBy('cprice','asc')->paginate(9);
        }
        else if($sort == "high")
        {
$vchildcats = $vchildcat->products()->where('status','=',1)->where('user_id','=',$vendor->id)->orderBy('cprice','desc')->paginate(9);
        }
        return view('front.vendorchildcategory',compact('vendor','vchildcat','vchildcats','sort'));
    }
}

<?php

namespace App\Providers;

use App\Admin;
use App\Advertise;
use App\Blog;
use App\Category;
use App\Classes\GeniusMailer;
use App\Currency;
use App\Generalsetting;
use App\Brand;
use App\Language;
use App\Page;
use App\Pagesetting;
use App\Product;
use App\Seotool;
use App\Sociallink;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Session;
use App\Traits\StoreTrait;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    use StoreTrait;
    public $store_id;
    public $store_code;
    public function boot()
    {
    //  print_r($_SERVER['SERVER_NAME']); die();
        Admin::auth_admins();
        Schema::defaultStringLength(191);

        $smtpdata = Generalsetting::find(1);
        Config::set('mail.port', $smtpdata->smtp_port);
        Config::set('mail.host', $smtpdata->smtp_host);
        Config::set('mail.username', $smtpdata->smtp_user);
        Config::set('mail.password', $smtpdata->smtp_pass);

        $settings = Generalsetting::find(1);
        view()->composer('*',function($settings){
            $slugs = explode("/", $_SERVER['REQUEST_URI']);
            if(!in_array('admin',$slugs))
            {
            $settings->with('store_code', $this->getStorecode('store_code'));
            $settings->with('store_id', $this->getStorecode('store_id'));
            }
            if(!empty($this->store_id))
            {
            $settings->with('gs', Generalsetting::where('store_id',$this->store_id)->first());
            }else{
            $settings->with('gs', Generalsetting::find(1));
            }
            $settings->with('sl', Sociallink::find(1));
            $settings->with('seo', Seotool::find(1));
            $settings->with('ps', Pagesetting::find(1));
            if (Session::has('language'))
            {
                $settings->with('lang', Language::find(Session::get('language')));
            }
            else
            {
                $settings->with('lang', Language::where('is_default','=',1)->first());
            }
            if (!Session::has('popup'))
            {
                $settings->with('visited', 1);
            }
            Session::put('popup' , 1);
            if (Session::has('currency'))
            {
                $settings->with('curr', Currency::find(Session::get('currency')));
            }
            else
            {
              if(!empty($this->store_id))
              {
              $settings->with('curr', Currency::where('store_id','=',$this->store_id)->first());
              }else{
              $settings->with('curr', Currency::where('is_default','=',1)->first());
              }
            }

            if(!in_array('admin',$slugs))
            {
		      	$categories = $this->getCategories();
            $brands = Brand::orderBy('brand_name','asc')->where('store_id','=',$this->store_id)->get();
            $settings->with('categories', $categories);
            $settings->with('brands', $brands);
            }

            // if(Category::where('status','=',1)->count() > 10)
            // {
                // $settings->with('catgories', Category::where('status','=',1)->skip(10)->take(count(Category::all()) - 10)->get());
            // }

            $settings->with('lblogs', Blog::orderBy('created_at', 'desc')->limit(4)->get());
            $settings->with('pages', Page::orderBy('pos','asc')->get());
        });


    }

    public function getStorecode($arg)
    {
      if (Session::has('FRONT_STORE_ID')){
      $store_id = $this->store_id = session('FRONT_STORE_ID');
      $store_code = $this->store_code = session('FRONT_STORE_CODE');
      }else{
        //$ip = '203.192.237.76'; /* Static IP address */
        $ip = $_SERVER['REMOTE_ADDR'];
        $storeinfo = $this->getCurrentStoreLocation($ip);
        $store_id = $this->store_id = $storeinfo->id;
        $store_code = $this->store_code =  $storeinfo->store_code;
        session()->put('FRONT_STORE_CODE', $store_code);
        session()->put('FRONT_STORE_ID', $store_id);
      }
      $store_data['store_id'] = $store_id;
      $store_data['store_code'] = $store_code;
      return $store_data[$arg];
    }

	public function getCategories()
	{
		$categories = Category::where('status','=',1)->where('parent_id','=',0)->where('store_id','=',$this->store_id)->orderBy('cat_name','asc')->get();
		$allcategories = array();
		foreach($categories as $key=>$category){
		$allcategories[$key]['cat_name'] = $category['cat_name'];
		$allcategories[$key]['cat_slug'] = $category['cat_slug'];
		$allcategories[$key]['id'] = $category['id'];
		$allcategories[$key]['short_description'] = $category['short_description'];
		$allcategories[$key]['parent_id'] = $category['parent_id'];
		$allcategories[$key]['childcategories'] = $this->getChildCategories($category['id']);

		}
		return $allcategories;
	}

	public function getChildCategories($parent_id)
	{
		$childcategories = Category::where('status','=',1)->where('parent_id','=',$parent_id)->orderBy('cat_name','asc')->get();
		return $childcategories;
	}

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

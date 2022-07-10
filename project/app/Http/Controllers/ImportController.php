<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Brand;
use App\Series;
use App\Gallery;
use App\Currency;
use App\ProductCategory;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreValidationRequest;
use App\Http\Requests\UpdateValidationRequest;
use DB;
use Illuminate\Support\Str;
use Excel;
use File;
use Image;
use App\Traits\StoreTrait;
class ImportController extends Controller
{
    use StoreTrait;
    public $store_id;
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function getStoreid()
    {
      $this->store_id = session('CURRENT_STORE_ID');
      return $this->store_id;
    }

    public function create()
    {
        return view('admin.import.create');
    }

    public function downloadExcel($type)
    {
        $data = Post::get()->toArray();
        return Excel::create('laravelcode', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    }

    public function getCategories($categories_string)
    {
      $categorynamesarray = explode("/",$categories_string);
       if(isset($categorynamesarray[0])){
      $cat_ids = Category::where('cat_name', $categorynamesarray[0])->where('store_id',$this->getStoreid())->first();
          if(!empty($cat_ids)){
           return $cat_ids->id;   
          }else{
           return '0';   
          }
      
       }else{
          return '0';
      }
    }

    public function getSubCategory($categories_string)
    {
      $categorynamesarray = explode("/",$categories_string);
      if(isset($categorynamesarray[1])){
        $cat_ids = Category::where('cat_name', $categorynamesarray[1])->where('store_id',$this->getStoreid())->first();
        if(!empty($cat_ids)){
           return $cat_ids->id;   
          }else{
           return '0';   
          } 
      }else{
          return '0';
      }
     
    }

    public function getTirePrices($tier_price_allstring)
    {
      $alltierpricearray = explode(";",$tier_price_allstring);
      $product_prices = array();

      	$x=0;
      foreach($alltierpricearray as $allprices)
      {
        $singlepricearray = explode(":",$allprices);
        $product_prices[$x]['price_qty'] = $singlepricearray[0];
        $product_prices[$x]['price'] = $singlepricearray[1];
        $x++;
      }
        return $product_prices;
    }

    public function CheckProductExist($sku)
    {
      $product = Product::where('sku','=',$sku)->where('store_id',$this->getStoreid())->first();
      if(!empty($product))
      {
        return true;
      }else{
        return false;
      }
    }

    public function getProductIdBySku($sku)
    {
      $product = Product::where('sku','=',$sku)->where('store_id',$this->getStoreid())->first();
      return $product->id;
    }

    public function getBrandIdByName($brand_name)
    {
      $brand = Brand::where('brand_name','=',$brand_name)->where('store_id',$this->getStoreid())->first(['id','brand_name']);
      return $brand->id;
    }

    public function getSeriesIdByName($series_name)
    {
      $series = Series::where('series_name','=',$series_name)->where('store_id',$this->getStoreid())->first(['id','series_name']);
      if(!empty($series))
      {
        return $series->id;
      }else{
        return 0;
      }

    }

    public function store(StoreValidationRequest $request)
    {
      //$input = $request->all();
      ini_set('max_execution_time', 0);
      ini_set('memory_limit', '128M');
      $mode_type = $request->get("mode_type");
      if($request->hasFile('import_file')){
        if($mode_type=='create')  // create new product
        {
        Excel::load($request->file('import_file')->getRealPath(), function ($reader) {
          foreach ($reader->toArray() as $key => $row) {
                    $sku = $row['sku'];
                    $product_prices = array();
                    if(isset($row['tier_price_all']))
                    {
                      $tier_price_allstring = $row['tier_price_all'];
                      $product_prices = $this->getTirePrices($tier_price_allstring);
                    }else{
                      $product_prices = array();
                    }
                    $cat_ids = 0;
                    $sub_cat_id =0;
                    if(isset($row['category']))
                    {
                      $categories_string = $row['category'];
                     $cat_ids  = $this->getCategories($categories_string);
                     $sub_cat_id  = $this->getSubCategory($categories_string);
                    }else{
                      $cat_ids = 0;
                      $sub_cat_id =0;
                    }

                    if(isset($row['series']))
                    {
                      $series_id = $this->getSeriesIdByName($row['series']);
                    }else{
                      $series_id = 0;
                    }

                    if(isset($row['manufacturer']))
                    {
                      $brand_id = $this->getBrandIdByName($row['manufacturer']);
                    }else{
                      $brand_id = 0;
                    }

                    if(isset($row['status']))
                    {
                      $status = $row['status'];
                    }else{
                      $status = 1;
                    }

                    if(isset($row['name']))
                    {
                      $product_name = $row['name'];
                    }else{
                      $product_name = "";
                    }

                    $slug = Str::slug($product_name.'-'.$sku);

                    if(isset($row['short_description']))
                    {
                      $product_description = $row['short_description'];
                    }else{
                      $product_description = "";
                    }

                    if(isset($row['price']))
                    {
                      $product_price = $row['price'];
                    }else{
                      $product_price = 0;
                    }

                    if(isset($row['image']))
                    {
                      $product_image = $row['image'];
                    }else{
                      $product_image = "";
                    }

                    if(isset($row['media_gallery']))
                    {
                      $media_gallery_string = $row['media_gallery'];
                      $mediagalleryarray = explode(";",$media_gallery_string);
                    }else{
                      $mediagalleryarray = array();
                    }

                    if(!$this->CheckProductExist($sku))
                    {
              $this->InsertBulkProducts($sku,$cat_ids,$sub_cat_id,$series_id,$brand_id,$status,$product_name,$slug,$product_description,$product_price,$product_prices,$product_image,$mediagalleryarray);
                    }

                }
        });
      }elseif($mode_type=='update'){
        Excel::load($request->file('import_file')->getRealPath(), function ($reader) {
          foreach ($reader->toArray() as $key => $row) {
                    if(!isset($row['sku']))
                    {
                      Session::flash('error', 'SKU not derife in file.');
                      return redirect()->route('admin-import-create');
                    }
                    $sku = $row['sku'];
                    if(isset($row['tier_price_all']))
                    {
                      $tier_price_allstring = $row['tier_price_all'];
                      $product_prices = $this->getTirePrices($tier_price_allstring);
                    }else{
                      $product_prices = array();
                    }

                    if(isset($row['category']))
                    {
                      $categories_string = $row['category'];
                      $cat_ids  = $this->getCategories($categories_string);
                      $sub_cat_id  = $this->getSubCategory($categories_string);
                    }else{
                      $cat_ids = 0;
                      $sub_cat_id = 0;
                    }

                    if(isset($row['series']))
                    {
                      $series_id = $this->getSeriesIdByName($row['series']);
                    }else{
                      $series_id = 0;
                    }

                    if(isset($row['manufacturer']))
                    {
                      $brand_id = $this->getBrandIdByName($row['manufacturer']);
                    }else{
                      $brand_id = 0;
                    }

                    if(isset($row['status']))
                    {
                      $status = $row['status'];
                    }else{
                      $status = 0;
                    }

                    if(isset($row['name']))
                    {
                      $product_name = $row['name'];
                    }else{
                      $product_name = "";
                    }

                    $slug = Str::slug($product_name.'-'.$sku);

                    if(isset($row['short_description']))
                    {
                      $product_description = $row['short_description'];
                    }else{
                      $product_description = "";
                    }

                    if(isset($row['price']))
                    {
                      $product_price = $row['price'];
                    }else{
                      $product_price = 0;
                    }

                    if(isset($row['image']))
                    {
                      $product_image = $row['image'];
                    }else{
                      $product_image = "";
                    }

                    if(isset($row['media_gallery']))
                    {
                      $media_gallery_string = $row['media_gallery'];
                      $mediagalleryarray = explode(";",$media_gallery_string);
                    }else{
                      $mediagalleryarray = array();
                    }

                    if($this->CheckProductExist($sku))
                    {
              $this->UpdateBulkProducts($sku,$cat_ids,$sub_cat_id,$series_id,$brand_id,$status,$product_name,$slug,$product_description,$product_price,$product_prices,$product_image,$mediagalleryarray);
                    }

                }
        });
      }

      }
        Session::flash('success', 'Product Imported Successfully.');
        return redirect()->route('admin-import-create');
    }

    public function InsertBulkProducts($sku,$cat_ids,$sub_cat_id,$series_id,$brand_id,$status,$product_name,$slug,$product_description,$product_price,$product_prices,$product_image,$mediagalleryarray)
    {
        $product = Product::where('sku',$sku)->where('store_id',$this->getStoreid())->first();
        if(empty($product)){
        $prod = new Product;
        $sign = Currency::where('is_default','=',1)->where('store_id',$this->getStoreid())->first();

        if(empty($product_prices))
        {
          $inputdata['is_tier_price']	= 0;
          $inputdata['tier_prices'] = json_encode($product_prices,true);
        }else{
          $inputdata['is_tier_price']	= 1;
          $inputdata['tier_prices'] = json_encode($product_prices,true);
        }
        $inputdata['sku']= $sku;
        $inputdata['store_id'] = $this->getStoreid();
        $inputdata['slug']= $slug;
        $inputdata['category_id']= $cat_ids;
        $inputdata['subcategory_id']= $sub_cat_id;
        $inputdata['size'] = null;
        $inputdata['size_qty'] = null;
        $inputdata['size_price'] = null;
        $inputdata['features'] = null;
        $inputdata['colors'] = null;
        $inputdata['color'] = null;
        $inputdata['product_condition'] = 0;
        $inputdata['min_qty'] = 1;
        $inputdata['is_approve'] = 1;
        $inputdata['status'] = $status;
        $inputdata['brand_id'] = $brand_id;
        $inputdata['series_id'] = $series_id;
        $inputdata['name'] = $product_name;
        $inputdata['cprice'] = $product_price;
        $inputdata['stock'] = null;
        $inputdata['description'] = $product_description;
        $store_code = $this->getStoreCode($this->getStoreid());
        if(!empty($product_image))
        {
        if (file_exists( public_path('import/' . $product_image)))
         {
          File::copy(public_path('import/' . $product_image), public_path('assets/images/'.$store_code.'/products/'.$product_image));
          $inputdata['photo'] = $product_image;
          $img = Image::make(public_path('assets/images/'.$store_code.'/products/'.$product_image));
          $imagename = "thumb_".$product_image;
          $img->resize(350, 350, function ($constraint) {
            $constraint->aspectRatio();
          })->save('assets/images/'.$store_code.'/products/'.$imagename);
          }else{
            $inputdata['photo'] = "partzdeal-placeholder.png";
            }
        }else{
          $inputdata['photo'] = "partzdeal-placeholder.png";
        }
        $prod->fill($inputdata)->save();
        $lastid = $prod->id;

        if(!empty($mediagalleryarray))
        {
          foreach($mediagalleryarray as $mediaimage)
          {
            if (file_exists( public_path('import/' . $mediaimage))) {
              File::copy(public_path('import/' . $mediaimage), public_path('assets/images/'.$store_code.'/products/gallery/'.$mediaimage));
              $gallery = new Gallery;
              $gallery['photo'] = $mediaimage;
              $gallery['product_id'] = $lastid;
              $gallery->save();
              }
          }
        }
        }

    }

    public function UpdateBulkProducts($sku,$cat_ids,$sub_cat_id,$series_id,$brand_id,$status,$product_name,$slug,$product_description,$product_price,$product_prices,$product_image,$mediagalleryarray)
    {
        $prodid = $this->getProductIdBySku($sku);
        $prod = Product::findOrFail($prodid);
        $sign = Currency::where('is_default','=',1)->first();

        if(!empty($product_prices))
        {
          $inputdata['is_tier_price']	= 1;
          $inputdata['tier_prices'] = json_encode($product_prices,true);
        }

        if(!empty($cat_ids))
        {
        $inputdata['category_id'] = $cat_ids;
        }
        if(!empty($sub_cat_id))
        {
        $inputdata['subcategory_id'] = $sub_cat_id;
        }

        if(!empty($status))
        {
        $inputdata['status'] = $status;
        }
        if(!empty($brand_id))
        {
        $inputdata['brand_id'] = $brand_id;
        }
        if(!empty($series_id))
        {
        $inputdata['series_id'] = $series_id;
        }
        if(!empty($product_name))
        {
        $inputdata['name'] = $product_name;
        }
        if(!empty($product_price))
        {
        $inputdata['cprice'] = $product_price;
        }
        if(!empty($product_description))
        {
        $inputdata['description'] = $product_description;
        }

        if(!empty($product_image))
        {
        if (file_exists( public_path('import/' . $product_image)))
         {
          File::copy(public_path('import/' . $product_image), public_path('assets/images/'.$store_code.'/products/'.$product_image));
          $inputdata['photo'] = $product_image;
          $img = Image::make(public_path('assets/images/'.$store_code.'/products/'.$product_image));
          $imagename = "thumb_".$product_image;
          $img->resize(350, 350, function ($constraint) {
            $constraint->aspectRatio();
          })->save('assets/images/'.$store_code.'/products/'.$imagename);
          }else{
            $inputdata['photo'] = "partzdeal-placeholder.png";
            }
        }
        if(!empty($inputdata))
        {
          $prod->update($inputdata);
        }

        if(!empty($mediagalleryarray))
        {
          foreach($mediagalleryarray as $mediaimage)
          {
            if (file_exists( public_path('import/' . $mediaimage))) {
              DB::table('galleries')->where('product_id', $prodid)->delete();
              File::copy(public_path('import/' . $mediaimage), public_path('assets/images/'.$store_code.'/products/gallery/'.$mediaimage));
              $gallery = new Gallery;
              $gallery['photo'] = $mediaimage;
              $gallery['product_id'] = $prodid;
              $gallery->save();
              }
          }
        }
    }
}

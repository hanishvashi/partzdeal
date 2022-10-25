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
use File;
use Image;
use App\Traits\StoreTrait;
class ProductController extends Controller
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

    public function index()
    {
        $prods = Product::orderBy('id','desc')->where('store_id',$this->getStoreid())->paginate(20);
        $sign = Currency::where('is_default','=',1)->first();
        $cats = Category::all();
        return view('admin.product.index',compact('prods','cats','sign'));
    }

    public function CheckProductExist($sku)
    {
      $product = Product::where('sku','=',$sku)->first();
      if(!empty($product))
      {
        return true;
      }else{
        return false;
      }
    }

    public function getProducts(Request $request)
    {
      $sign = Currency::where('is_default','=',1)->first();

      $draw = $request->get('draw');
      $start = $request->get("start");
      $rowperpage = $request->get("length");
      $columnIndex_arr = $request->get('order');
      $columnName_arr = $request->get('columns');
      $order_arr = $request->get('order');
      $search_arr = $request->get('search');
      $columnIndex = $columnIndex_arr[0]['column']; // Column index
      $columnName = $columnName_arr[$columnIndex]['data']; // Column name
      $columnSortOrder = $order_arr[0]['dir']; // asc or desc
      $searchValue = $search_arr['value']; // Search value

      $totalRecords = Product::orderBy('id','desc')->count();
      $totalRecordswithFilter = Product::select('count(*) as allcount')->where('store_id',$this->getStoreid())->where('sku', 'like', '%' .$searchValue . '%')->count();
      // Fetch records
     $records = Product::orderBy($columnName,$columnSortOrder)
        ->where('store_id',$this->getStoreid())
       ->where('sku', 'like', '%' .$searchValue . '%')
       //->orWhere('name', 'like', '%' .$searchValue . '%')
       ->select('*')
       ->skip($start)
       ->take($rowperpage)
       ->get();

       $data_arr = array();

        foreach($records as $prod){
        $id = $prod->id;
        $sku = $prod->sku;
        $name = $prod->name;
        $cprice = $sign->sign.''.$prod->cprice;
$frontpageurl = route('front.page',['slug' => $prod->slug]);
$editurl = route('admin-prod-edit',$prod->id);

$deleteurl = route('admin-prod-delete',$prod->id);

$actionbutton = '<a href='.$editurl.' class="btn btn-primary product-btn"><i class="fa fa-edit"></i> Edit</a>';
$actionbutton .='<a style="cursor: pointer;" class="btn btn-info product-btn feature" data-toggle="modal" data-target="#feature">
  <input type="hidden" value='.$prod->id.'><i class="fa fa-star"></i> Highlight</a>';

$actionbutton .='<a style="cursor: pointer; background-color: #0165cb;" class="btn btn-info product-btn view-gallery" data-toggle="modal" data-target="#myModal">
  <input type="hidden" value='.$prod->id.'><i class="fa fa-eye"></i> Gallery</a>';

$actionbutton .='<a href="javascript:;" data-href='.$deleteurl.' data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger product-btn"><i class="fa fa-trash"></i></a>';

$namecolumn = '<a href='.$frontpageurl.' target="_blank">'.$prod->name.'</a>';


    $activateurl = route('admin-prod-st',['id1'=>$prod->id,'id2'=>1]);
    $deactivateurl = route('admin-prod-st',['id1'=>$prod->id,'id2'=>0]);
    if($prod->status == 1)
    {
    $prodstatustxt = "Activated";
    $btnclass = 'btn-success';
    }else{
    $prodstatustxt   = "Deactivated";
    $btnclass = 'btn-danger';
    }

$statusbutton = '<span class="dropdown">';
$statusbutton .='<button class="btn '.$btnclass.' product-btn dropdown-toggle btn-xs" type="button" data-toggle="dropdown" style="font-size: 14px;">'.$prodstatustxt.'<span class="caret"></span></button>';
$statusbutton .='<ul class="dropdown-menu">';
$statusbutton .='<li><a class="activateproduct" data-id="'.$prod->id.'"  href='.$activateurl.'>Active</a></li>';
$statusbutton .='<li><a class="deactivateproduct" data-id="'.$prod->id.'"  href='.$deactivateurl.'>Deactive</a></li>';
$statusbutton .='</ul></span>';
        $data_arr[] = array(
        "name" => $namecolumn,
        "sku" => $sku,
        "cprice" => $cprice,
        "statusbutton" => $statusbutton,
        "actionbutton"=>$actionbutton
        );
        }

      $response = array(
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordswithFilter,
      "aaData" => $data_arr
      );

      echo json_encode($response);
      exit;
    }


    public function deactive()
    {

        $prods = Product::where('status','=',0)->where('store_id',$this->getStoreid())->get();
        $sign = Currency::where('is_default','=',1)->first();
        $cats = Category::all();
        return view('admin.product.deactive',compact('prods','cats','sign'));
    }

    public function create()
    {
        $cats = Category::where('parent_id',0)->orderBy('cat_name','asc')->where('store_id',$this->getStoreid())->get();
        $brands = Brand::orderBy('brand_name','asc')->where('store_id',$this->getStoreid())->get();
        $allseries = Series::orderBy('series_name','asc')->where('store_id',$this->getStoreid())->get();
        $sign = Currency::where('is_default','=',1)->first();
        return view('admin.product.create',compact('brands','allseries','cats','sign'));
    }

      public function status($id1,$id2)
        {
            $prod = Product::findOrFail($id1);
            $prod->status = $id2;
            $prod->update();
            Session::flash('success', 'Successfully Updated The Status.');
            return redirect()->back();
        }

    public function store(StoreValidationRequest $request)
    {
        $this->validate($request, [
               'photo' => 'required',
           ]);
        $prod = new Product;
        $sign = Currency::where('is_default','=',1)->first();
        $input = $request->all();
        if($this->CheckProductExist($input['sku']))
        {
          Session::flash('error', 'This sku Product already exists.');
          return redirect()->route('admin-prod-create');
        }

			$product_prices = array();
			if(isset($input['product']))
			{
				$input['is_tier_price']	= 1;
			$x=0;
			foreach($input['product']['tier_price'] as $tierprice)
			{
			$product_prices[$x]['price_qty'] = $tierprice['price_qty'];
			$product_prices[$x]['price'] = $tierprice['price'];
			$x++;
			}
			}else{
			$input['is_tier_price']	= 0;
			}
			$input['tier_prices'] = json_encode($product_prices,true);

      $slug = Str::slug($input['name'].'-'.$input['sku']);
      $input['slug']= $slug;

      $store_code = $this->getStoreCode($this->getStoreid());

            if(in_array(null, $request->features) || in_array(null, $request->colors))
            {
                $input['features'] = null;
                $input['colors'] = null;
            }
            else
            {
                $input['features'] = implode(',', $request->features);
                $input['colors'] = implode(',', $request->colors);
            }

            if(empty($request->scheck ))
            {
                $input['size'] = null;
                $input['size_qty'] = null;
                $input['size_price'] = null;
            }
            else{
              if(in_array(null, $request->size) || in_array(null, $request->size_qty))
              {
                  $input['size'] = null;
                  $input['size_qty'] = null;
                  $input['size_price'] = null;
              }
              else
              {
                  $input['size'] = implode(',', $request->size);
                  $input['size_qty'] = implode(',', $request->size_qty);
                  $input['size_price'] = implode(',', $request->size_price);
              }
            }


            if(empty($request->colcheck ))
            {
                $input['color'] = null;
            }
            else{
            $input['color'] = implode(',', $request->color);
            }

            if ($file = $request->file('photo'))
            {
              //  echo $file_extention = $file->extension(); echo '<pre>';
                $extension = $file->getClientOriginalExtension();
                $name = time().$file->getClientOriginalName();
                //$name = $input['sku'].'_1.'.$extension;
                $file->move('assets/images/'.$store_code.'/products',$name);

                $imagename = "thumb_".$name;
                /*$file->resize(350, 350, function ($constraint) {
                $constraint->aspectRatio();
                })->save('assets/images/'.$store_code.'/products'.$imagename);*/

                $input['photo'] = $name;
            }

        if (!empty($request->tags))
         {
            $input['tags'] = implode(',', $request->tags);
         }

        if ($request->pccheck == ""){
            $input['product_condition'] = 0;
        }
        if ($request->shcheck == ""){
            $input['ship'] = null;
        }
        if (!empty($request->meta_tag))
         {
            $input['meta_tag'] = implode(',', $request->meta_tag);
         }
        if ($request->mescheck == "")
         {
            $input['measure'] = null;
         }
        if ($request->secheck == "")
         {
            $input['meta_tag'] = null;
            $input['meta_description'] = null;
         }
         $input['cprice'] = ($input['cprice'] / $sign->value);
         $input['pprice'] = ($input['pprice'] / $sign->value);

         $input['store_id'] = $this->getStoreid();

        $prod->fill($input)->save();
        $lastid = $prod->id;
        if ($files = $request->file('gallery')){
            foreach ($files as  $key => $file){
                if(in_array($key, $request->galval))
                {
                    $gallery = new Gallery;
                    $extension = $file->getClientOriginalExtension();
                    $name = time().$file->getClientOriginalName();
                    $file->move('assets/images/'.$store_code.'/products/gallery',$name);

                    $imagename = "thumb_".$name;
                    /*$file->resize(350, 350, function ($constraint) {
                    $constraint->aspectRatio();
                  })->save('assets/images/'.$store_code.'/products/gallery'.$imagename);*/

                    $gallery['photo'] = $name;
                    $gallery['product_id'] = $lastid;
                    $gallery->save();
                }
            }
        }

        Session::flash('success', 'New Product added successfully.');
        return redirect()->route('admin-prod-index');
    }

    public function edit($id)
    {
        $cats = Category::where('parent_id',0)->orderBy('cat_name','asc')->where('store_id',$this->getStoreid())->get();
        $brands = Brand::orderBy('brand_name','asc')->where('store_id',$this->getStoreid())->get();
        $allseries = Series::orderBy('series_name','asc')->where('store_id',$this->getStoreid())->get();
        $prod = Product::findOrFail($id);

        $subcats = Category::where('parent_id',$prod->category_id)->orderBy('cat_name','asc')->get();


        $sign = Currency::where('is_default','=',1)->first();
        if($prod->size != null)
        {
            $size = explode(',', $prod->size);
            $size_qty = explode(',', $prod->size_qty);
            $size_price = explode(',', $prod->size_price);
        }else{
			$size = array();
      $size_qty = array();
      $size_price = array();
		    }
        if($prod->color != null)
        {
            $colrs = explode(',', $prod->color);
        }else{
			$colrs = array();
		}
        if($prod->tags != null)
        {
            $tags = explode(',', $prod->tags);
        }else{
			$tags = array();
		}
        if($prod->meta_tag != null)
        {
            $metatags = explode(',', $prod->meta_tag);
        }else{
			$metatags = array();
		}
        if($prod->features!=null && $prod->colors!=null)
        {
            $title = explode(',', $prod->features);
            $details = explode(',', $prod->colors);
        }else{
			$title = array();
			$details = array();
		}
        if($prod->license!=null && $prod->license_qty!=null)
        {
            $title1 = explode(',,', $prod->license);
            $details1 = explode(',', $prod->license_qty);
        }else{
			$title1 = array();
			$details1 = array();
		}
        $mescheck  = 1;
        $string = $prod->measure;
        if($prod->measure == 'Litre')
        {
        $mescheck  = 0;
        }
        if($prod->measure == 'Pound')
        {
        $mescheck  = 0;
        }
        if($prod->measure == 'Gram')
        {
        $mescheck  = 0;
        }
        if($prod->measure == 'Kilogram')
        {
        $mescheck  = 0;
        }

      return view('admin.product.edit',compact('subcats','brands','allseries','cats','prod','size','size_qty','size_price','colrs','tags','metatags','title','details','sign','title1','details1','mescheck'));
    }

    public function update(UpdateValidationRequest $request, $id)
    {
        $prod = Product::findOrFail($id);
        $sign = Currency::where('is_default','=',1)->first();
        $input = $request->all();
        $store_code = $this->getStoreCode($this->getStoreid());
		 $product_prices = array();
			if(isset($input['product']))
			{
				$input['is_tier_price']	= 1;
			$x=0;
			foreach($input['product']['tier_price'] as $tierprice)
			{
			$product_prices[$x]['price_qty'] = $tierprice['price_qty'];
			$product_prices[$x]['price'] = $tierprice['price'];
			$x++;
			}
			}else{
			$input['is_tier_price']	= 0;
			}

      $slug = Str::slug($input['name'].'-'.$input['sku']);
      $input['slug']= $slug;

	$input['tier_prices'] = json_encode($product_prices,true);
        if ($request->galdel == 1){
            $gals = Gallery::where('product_id',$id)->get();
            foreach ($gals as $gal) {
                    if (file_exists(public_path().'/assets/images/'.$gal->photo)) {
                        unlink(public_path().'/assets/images/'.$gal->photo);
                    }
                $gal->delete();
            }

        }
        if(!in_array(null, $request->features) && !in_array(null, $request->colors))
        {
            $input['features'] = implode(',', $request->features);
            $input['colors'] = implode(',', $request->colors);
        }
        else
        {
            if(in_array(null, $request->features) || in_array(null, $request->colors))
            {
                $input['features'] = null;
                $input['colors'] = null;
            }
            else
            {
                $features = explode(',', $prod->features);
                $colors = explode(',', $prod->colors);
                $input['features'] = implode(',', $features);
                $input['colors'] = implode(',', $colors);
            }
        }

        if(empty($request->scheck ))
        {
            $input['size'] = null;
            $input['size_qty'] = null;
            $input['size_price'] = null;
        }
        else{
          if(in_array(null, $request->size) || in_array(null, $request->size_qty))
          {
              $input['size'] = null;
              $input['size_qty'] = null;
              $input['size_price'] = null;
          }
          else
          {
              $input['size'] = implode(',', $request->size);
              $input['size_qty'] = implode(',', $request->size_qty);
              $input['size_price'] = implode(',', $request->size_price);
          }
        }

            if(empty($request->colcheck ))
            {
                $input['color'] = null;
            }
            else{
                if (!empty($request->color))
                 {
                    $input['color'] = implode(',', $request->color);
                 }
                if (empty($request->color))
                 {
                    $input['color'] = null;
                 }
            }

            if ($file = $request->file('photo'))
            {
                $name = time().$file->getClientOriginalName();
                //$file->move('assets/images/products',$name);
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images/'.$store_code.'/products',$name);
                if($prod->photo != null)
                {
                    if (file_exists(public_path().'assets/images/'.$store_code.'/products/'.$prod->photo)) {
                        unlink(public_path().'/assets/images'.$store_code.'/products/'.$prod->photo);
                    }
                }
                $input['photo'] = $name;
            }

        if (!empty($request->tags))
         {
            $input['tags'] = implode(',', $request->tags);
         }
        if (empty($request->tags))
         {
            $input['tags'] = null;
         }
        if ($request->pccheck == ""){
            $input['product_condition'] = 0;
        }
        if ($request->shcheck == ""){
            $input['ship'] = null;
        }
        if (!empty($request->meta_tag))
         {
            $input['meta_tag'] = implode(',', $request->meta_tag);
         }
        if ($request->secheck == "")
         {
            $input['meta_tag'] = null;
            $input['meta_description'] = null;
         }
        if ($request->mescheck == "")
         {
            $input['measure'] = null;
         }
         $input['cprice'] = $input['cprice'] / $sign->value;
         $input['pprice'] = $input['pprice'] / $sign->value;
         //return $input;

        $prod->update($input);

        Session::flash('success', 'Product updated successfully.');
        return redirect()->route('admin-prod-index');
    }

    public function feature(Request $request, $id)
    {
        $prod = Product::findOrFail($id);
        $input = $request->all();

            if($request->featured == "")
            {
                $input['featured'] = 0;
            }
            if($request->hot == "")
            {
                $input['hot'] = 0;
            }
            if($request->best == "")
            {
                $input['best'] = 0;
            }
            if($request->top == "")
            {
                $input['top'] = 0;
            }
            if($request->latest == "")
            {
                $input['latest'] = 0;
            }
            if($request->big == "")
            {
                $input['big'] = 0;
            }

        $prod->update($input);
        Session::flash('success', 'Product Highlight Updated Successfully.');
        return redirect()->route('admin-prod-index');
    }
    public function destroy($id)
    {
        $prod = Product::findOrFail($id);
        if($prod->galleries->count() > 0)
        {
            foreach ($prod->galleries as $gal) {
                    if (file_exists(public_path().'/assets/images/gallery/'.$gal->photo)) {
                        unlink(public_path().'/assets/images/gallery/'.$gal->photo);
                    }
                $gal->delete();
            }

        }
        if($prod->reviews->count() > 0)
        {
            foreach ($prod->reviews as $gal) {
                $gal->delete();
            }
        }
        if($prod->wishlists->count() > 0)
        {
            foreach ($prod->wishlists as $gal) {
                $gal->delete();
            }
        }
        if($prod->clicks->count() > 0)
        {
            foreach ($prod->clicks as $gal) {
                $gal->delete();
            }
        }
        if($prod->comments->count() > 0)
        {
            foreach ($prod->comments as $gal) {
            if($gal->replies->count() > 0)
            {
                foreach ($gal->replies as $key) {
                    if($key->subreplies->count() > 0)
                    {
                        foreach ($key->subreplies as $key1) {
                            $key1->delete();
                        }
                    }
                    $key->delete();
                }
            }
                $gal->delete();
            }
        }
                    if (file_exists(public_path().'/assets/images/'.$prod->photo)) {
                        unlink(public_path().'/assets/images/'.$prod->photo);
                    }
                if($prod->file != null){
                    if (file_exists(public_path().'/assets/files/'.$prod->file)) {
                        unlink(public_path().'/assets/files/'.$prod->file);
                    }
                }
        $prod->delete();
        Session::flash('success', 'Product deleted successfully.');
        return redirect()->back();
    }
}

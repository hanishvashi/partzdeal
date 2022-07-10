<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Gallery;
use App\Currency;
use App\ProductCategory;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreValidationRequest;
use App\Http\Requests\UpdateValidationRequest;
use Auth;

class UserProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:user');
    }
    public function index()
    {
        $user = Auth::guard('user')->user();
        $package = $user->subscribes()->orderBy('id','desc')->first();
        $prods = $user->products()->orderBy('id','desc')->get();
        $sign = Currency::where('is_default','=',1)->first();
        $cats = Category::all();
        return view('user.product.index',compact('prods','cats','sign'));
    }

    public function create()
    {
        $cats = Category::all();
        $sign = Currency::where('is_default','=',1)->first();
        return view('user.product.create',compact('cats','sign'));
    }

      public function status($id1,$id2)
        {
            $prod = Product::findOrFail($id1);
            $prod->status = $id2;
            $prod->update();
            Session::flash('success', 'Successfully Updated The Status.');
            return redirect()->route('user-prod-index');
        }
    public function store(StoreValidationRequest $request)
    {
        $user = Auth::guard('user')->user();
        $package = $user->subscribes()->orderBy('id','desc')->first();
        $prods = $user->products()->orderBy('id','desc')->get()->count();
		
        if($prods < $package->allowed_products)
        {

        $this->validate($request, [
               'photo' => 'required',
           ]);
        $prod = new Product;
        $sign = Currency::where('is_default','=',1)->first();
        $input = $request->all();
		
		if (!empty($request->file('size_guide')))
            {
				$sizefile = $request->file('size_guide');
                $size_guide = time().$sizefile->getClientOriginalName();
                $sizefile->move('assets/images/size_guide',$size_guide);
				$input['size_guide'] = $size_guide;
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
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images',$name);
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
        if ($request->secheck == "")
         {
            $input['meta_tag'] = null;
            $input['meta_description'] = null;
         }
        if ($request->mescheck == "")
         {
            $input['measure'] = null;
         }
         $input['cprice'] = ($input['cprice'] / $sign->value);
         $input['pprice'] = ($input['pprice'] / $sign->value);
         $input['user_id'] = $user->id;
		 $input['is_approve'] = 0;
        $prod->fill($input)->save();
        $lastid = $prod->id;

        if ($files = $request->file('gallery')){
            foreach ($files as  $key => $file){
                if(in_array($key, $request->galval))
                {
                $gallery = new Gallery;
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images/gallery',$name);
                $gallery['photo'] = $name;
                $gallery['product_id'] = $lastid;
                $gallery->save();
            }
            }
        }
		
		foreach($input['category_id'] as $category_id){
		$ProductCategory = new ProductCategory;
		$ProductCategory['category_id'] = $category_id;
		$ProductCategory['product_id'] = $lastid;
		$ProductCategory->save();
		}
		
        Session::flash('success', 'New Product added successfully.');
        return redirect()->route('user-prod-index');
        }

        else
        {
        return redirect()->route('user-prod-index')->with('unsuccess', 'You Can\'t Add More Product.');
        }

    }

    public function edit($id)
    {
        $cats = Category::all();
        $prod = Product::findOrFail($id);
        $sign = Currency::where('is_default','=',1)->first();
		$productcategories = ProductCategory::where('product_id', $id)->get();
		$category_ids = array();
		foreach($productcategories as $categories)
		{
		$category_ids[] = $categories['category_id'];	
		}
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
			$title  = array();
			$details = array();
		}
        if($prod->license!=null && $prod->license_qty!=null)
        {
            $title1 = explode(',,', $prod->license);
            $details1 = explode(',', $prod->license_qty);
        }else{
			$title1  = array();
			$details1 = array();
		}
        $mescheck  = 1;
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
        $tags = array();
        $metatags = array();
        $title = '';
        if($prod->type == 1)
            return view('user.product.digital_edit',compact('category_ids','cats','prod','size','size_qty','size_price','colrs','tags','metatags','title','details','sign','title1','details1'));
        elseif($prod->type == 2)
            return view('user.product.license_edit',compact('category_ids','cats','prod','size_qty','size_price','size','colrs','tags','metatags','title','details','sign','title1','details1'));
        else
            return view('user.product.edit',compact('category_ids','cats','prod','size','size_qty','size_price','colrs','tags','metatags','title','details','sign','title1','details1','mescheck'));
    }

    public function update(UpdateValidationRequest $request, $id)
    {
        $user = Auth::guard('user')->user();
        $prod = Product::findOrFail($id);
        $sign = Currency::where('is_default','=',1)->first();
        $input = $request->all();
		
		if (!empty($request->file('size_guide')))
            {
				$sizefile = $request->file('size_guide');
                $size_guide = time().$sizefile->getClientOriginalName();
                $sizefile->move('assets/images/size_guide',$size_guide);
				$input['size_guide'] = $size_guide;
            }
			
        if ($request->galdel == 1){
            $gals = Gallery::where('product_id',$id)->get();
            foreach ($gals as $gal) {
                    if (file_exists(public_path().'/assets/images/gallery'.$gal->photo)) {
                        unlink(public_path().'/assets/images/gallery/'.$gal->photo);
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
                $file->move('assets/images',$name);
                if($prod->photo != null)
                {
                    if (file_exists(public_path().'/assets/images/'.$prod->photo)) {
                        unlink(public_path().'/assets/images/'.$prod->photo);
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
        $input['user_id'] = $user->id;
		$input['is_approve'] = 0;
        $prod->update($input);
		
		DB::table('product_categories')->where('product_id', $id)->delete();
		foreach($input['category_id'] as $category_id){
		$ProductCategory = new ProductCategory;
		$ProductCategory['category_id'] = $category_id;
		$ProductCategory['product_id'] = $id;
		$ProductCategory->save();
		}
        Session::flash('success', 'Product updated successfully.');
        return redirect()->route('user-prod-index');
    }

    public function destroy($id)
    {
        $prod = Product::findOrFail($id);
        if($prod->user_id != Auth::guard('user')->user()->id)
        {
            return redirect()->back();
        }
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
        return redirect()->route('user-prod-index');
    }

}

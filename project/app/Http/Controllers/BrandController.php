<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreValidationRequest;
use App\Http\Requests\UpdateValidationRequest;
use App\BrandSeries;
use App\BrandCategory;
use App\Category;
use App\Series;

class BrandController extends Controller
{
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

    public function getAllCategories()
    {
      $items = Category::orderBy('cat_name','asc')->where('store_id',$this->getStoreid())->get();
      return $items;
    }

    public function getAllSeries()
    {
      $items = Series::orderBy('series_name','asc')->where('store_id',$this->getStoreid())->get();
      return $items;
    }

  	public function index()
    {
        $ads = Brand::orderBy('id','desc')->where('store_id',$this->getStoreid())->get();
        return view('admin.brands.index',compact('ads'));
    }


    public function create()
    {
        $allcategories = $this->getAllCategories();
        $allseries = $this->getAllSeries();
        return view('admin.brands.create',compact('allcategories','allseries'));
    }


    public function store(StoreValidationRequest $request)
    {
		$this->validate($request, [
		       'brand_name' => 'required',
		   ]);
        $ad = new Brand();
        $data = $request->all();
        if ($file = $request->file('photo'))
         {
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images',$name);
            $data['photo'] = $name;
        }
        $data['store_id'] = $this->getStoreid();
        $ad->fill($data)->save();

        $brand_id = $ad->id;

        if(!empty($data['category_id']))
        {
          $BrandCategory = new BrandCategory();
          foreach($data['category_id'] as $category_id)
          {
            $brandcatdata['brand_id'] = $brand_id;
            $brandcatdata['category_id'] = $category_id;
            $BrandCategory::insert($brandcatdata);
          }
        }

        if(!empty($data['series_id']))
        {
          $BrandSeries = new BrandSeries();
          foreach($data['series_id'] as $series_id)
          {
            $brandsrsdata['brand_id'] = $brand_id;
            $brandsrsdata['series_id'] = $series_id;
            $BrandSeries::insert($brandsrsdata);
          }
        }

        return redirect()->route('admin-img-index')->with('success','New Image Added Successfully.');
    }


    public function edit($id)
    {
        $ad = Brand::findOrFail($id);
        $allcategories = $this->getAllCategories();
        $allseries = $this->getAllSeries();
        $brandcatids = $this->getBrandCategory($id);
        $brandseriesids = $this->getBrandSeries($id);

        return view('admin.brands.edit',compact('ad','allcategories','allseries','brandseriesids','brandcatids'));
    }

    public function getBrandSeries($brand_id)
    {
      $BrandSeries = new BrandSeries();
      $brandseriesresult = $BrandSeries::where('brand_id',$brand_id)->get();

      $items = array();
      if(count($brandseriesresult)>0){
      foreach ($brandseriesresult as $bsrow) {
      $items[] = $bsrow['series_id'];
      }
      }
      return $items;
    }

    public function getBrandCategory($brand_id)
    {
      $BrandCategory = new BrandCategory();
      $brandcategoryresult = $BrandCategory::where('brand_id',$brand_id)->get();

      $items = array();
      if(count($brandcategoryresult)>0){
      foreach ($brandcategoryresult as $bsrow) {
      $items[] = $bsrow['category_id'];
      }
      }
      return $items;
    }

    public function update(StoreValidationRequest $request, $id)
    {
        $ad = Brand::findOrFail($id);
        $data = $request->all();
            if ($file = $request->file('photo'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images',$name);
                if($ad->photo != null)
                {
                    if (file_exists(public_path().'/assets/images/'.$ad->photo)) {
                        unlink(public_path().'/assets/images/'.$ad->photo);
                    }
                }
            $data['photo'] = $name;
            }
            else
            {
            	$data['photo'] = $ad->photo;
            }
        $ad->update($data);

        if(!empty($data['category_id']))
        {
          $BrandCategory = new BrandCategory();
          $BrandCategory::where('brand_id', $id)->delete();
          foreach($data['category_id'] as $category_id)
          {
            $brandcatdata['brand_id'] = $id;
            $brandcatdata['category_id'] = $category_id;
            $BrandCategory::insert($brandcatdata);
          }
        }

        if(!empty($data['series_id']))
        {
          $BrandSeries = new BrandSeries();
          $BrandSeries::where('brand_id', $id)->delete();
          foreach($data['series_id'] as $series_id)
          {
            $brandsrsdata['brand_id'] = $id;
            $brandsrsdata['series_id'] = $series_id;
            $BrandSeries::insert($brandsrsdata);
          }
        }

        return redirect()->route('admin-img-index')->with('success','Image Updated Successfully.');
    }


    public function destroy($id)
    {
        $ad = Brand::findOrFail($id);
                    if (file_exists(public_path().'/assets/images/'.$ad->photo)) {
                        unlink(public_path().'/assets/images/'.$ad->photo);
                    }
        $ad->delete();

        BrandCategory::where('brand_id', $id)->delete();
        BrandSeries::where('brand_id', $id)->delete();
        return redirect()->route('admin-img-index')->with('success','Image Deleted Successfully.');
    }
}

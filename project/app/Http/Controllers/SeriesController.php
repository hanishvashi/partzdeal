<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreValidationRequest;
use App\Http\Requests\UpdateValidationRequest;
use App\BrandSeries;
use App\BrandCategory;
use App\Series;
use Illuminate\Support\Facades\Session;

class SeriesController extends Controller
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

  	public function index()
    {
        $ads = Series::orderBy('id','desc')->where('store_id',$this->getStoreid())->get();
        return view('admin.series.index',compact('ads'));
    }


    public function create()
    {
        return view('admin.series.create');
    }


    public function store(StoreValidationRequest $request)
    {
        $ad = new Series();
        $data = $request->all();
        $data['store_id'] = $this->getStoreid();
        $ad->fill($data)->save();
        return redirect()->route('admin-series-index')->with('success','Series Added Successfully.');
    }


    public function edit($id)
    {
        $ad = Series::findOrFail($id);
        return view('admin.series.edit',compact('ad'));
    }

    public function update(StoreValidationRequest $request, $id)
    {
        $ad = Series::findOrFail($id);
        $data = $request->all();
        $ad->update($data);
        return redirect()->route('admin-series-index')->with('success','Series Updated Successfully.');
    }


    public function destroy($id)
    {
        $ad = Series::findOrFail($id);
        $ad->delete();

      //  BrandCategory::where('brand_id', $id)->delete();
      //  BrandSeries::where('brand_id', $id)->delete();
        return redirect()->route('admin-series-index')->with('success','Series Deleted Successfully.');
    }
}

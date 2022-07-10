<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreValidationRequest;
use App\Http\Requests\UpdateValidationRequest;
use App\Shipping;
use Illuminate\Support\Facades\Session;
use App\Traits\StoreTrait;

class ShippingController extends Controller
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
        $ads = Shipping::orderBy('id','desc')->where('store_id',$this->getStoreid())->get();
        return view('admin.shipping.index',compact('ads'));
    }

    public function create()
    {
        return view('admin.shipping.create');
    }


    public function store(StoreValidationRequest $request)
    {
        $ad = new Shipping();
        $data = $request->all();
        $data['store_id'] = $this->getStoreid();
        $ad->fill($data)->save();

        return redirect()->route('admin-shipping-index')->with('success','Shipping Method Added Successfully.');
    }


    public function edit($id)
    {
        $ad = Shipping::findOrFail($id);
        return view('admin.shipping.edit',compact('ad'));
    }

    public function update(StoreValidationRequest $request, $id)
    {
        $ad = Shipping::findOrFail($id);
        $data = $request->all();
        $ad->update($data);
        return redirect()->route('admin-shipping-index')->with('success','Shipping Method Updated Successfully.');
    }


    public function destroy($id)
    {
        $ad = Shipping::findOrFail($id);
        $ad->delete();
        return redirect()->route('admin-shipping-index')->with('success','Shipping Method Deleted Successfully.');
    }
}

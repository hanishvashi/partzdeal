<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VendorSlider;
use App\Http\Requests\StoreValidationRequest;
use App\Http\Requests\UpdateValidationRequest;
use Auth;

class VendorSliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }

  	public function index()
    {
        $ads = VendorSlider::where('user_id','=',Auth::guard('user')->user()->id)->orderBy('id','desc')->get();
        return view('user.slider.index',compact('ads'));
    }


    public function create()
    {
        return view('user.slider.create');
    }


    public function store(StoreValidationRequest $request)
    {
		$this->validate($request, [
		       'photo' => 'required',
		   ]);
        $ad = new VendorSlider();
        $data = $request->all();
        if ($file = $request->file('photo')) 
         {      
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images',$name);           
            $data['photo'] = $name;
        } 
        $data['user_id'] = Auth::guard('user')->user()->id;
        $ad->fill($data)->save();
        return redirect()->route('user-sl-index')->with('success','New Slider Added Successfully.');
    }


    public function edit($id)
    {
        $ad = VendorSlider::findOrFail($id);
        if($ad->user_id != Auth::guard('user')->user()->id)
        {
            return redirect()->back();
        }
        return view('user.slider.edit',compact('ad'));
    }

    public function update(StoreValidationRequest $request, $id)
    {
        $ad = VendorSlider::findOrFail($id);
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
        return redirect()->route('user-sl-index')->with('success','Slider Updated Successfully.');
    }


    public function destroy($id)
    {
        $ad = VendorSlider::findOrFail($id);
        if($ad->user_id != Auth::guard('user')->user()->id)
        {
            return redirect()->back();
        }
                    if (file_exists(public_path().'/assets/images/'.$ad->photo)) {
                        unlink(public_path().'/assets/images/'.$ad->photo);
                    }
        $ad->delete();
        return redirect()->route('user-sl-index')->with('success','Slider Deleted Successfully.');
    }
    
}

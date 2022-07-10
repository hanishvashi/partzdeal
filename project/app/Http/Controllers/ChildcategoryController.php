<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Subcategory;
use App\Childcategory;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreValidationRequest;
use App\Http\Requests\UpdateValidationRequest;

class ChildcategoryController extends Controller
{
    public $store_id;
    public function __construct()
    {
        $this->middleware('auth:admin');
        $CURRENT_STORE_ID = session('CURRENT_STORE_ID');
        $this->store_id  = $CURRENT_STORE_ID;
    }

    public function index()
    {
        $childcats = Childcategory::orderBy('id','desc')->where('store_id',$this->store_id)->get();
        return view('admin.childcategory.index',compact('childcats'));
    }

    public function create()
    {
        $cats = Category::all();
        return view('admin.childcategory.create',compact('cats'));
    }

    public function status($id1,$id2)
    {
        $cat = Childcategory::findOrFail($id1);
        $cat->status = $id2;
        $cat->update();
        Session::flash('success', 'Successfully Updated The Status.');
        return redirect()->route('admin-childcat-index');
    }

    public function store(StoreValidationRequest $request)
    {
        $cat = new Childcategory;
        $input = $request->all();
        $input['store_id'] = $this->store_id;
        $cat->fill($input)->save();
        Session::flash('success', 'New Child Category added successfully.');
        return redirect()->route('admin-childcat-index');
    }

    public function edit($id)
    {
        $cats = Category::all();
        $subcats = Subcategory::all();
        $childcat = Childcategory::findOrFail($id);
        $ct = $childcat->subcategory->category;
        return view('admin.childcategory.edit',compact('childcat','cats','subcats','ct'));
    }

    public function update(UpdateValidationRequest $request, $id)
    {
        $cat = Childcategory::findOrFail($id);
        $input = $request->all();
        $cat->update($input);
        Session::flash('success', 'Child Category updated successfully.');
        return redirect()->route('admin-childcat-index');
    }

    public function destroy($id)
    {
        $cat = Childcategory::findOrFail($id);
        if($cat->products->count()>0)
        {
            Session::flash('unsuccess', 'Remove the products first !!!!');
            return redirect()->route('admin-childcat-index');
        }
        $cat->delete();
        Session::flash('success', 'Child Category deleted successfully.');
        return redirect()->route('admin-childcat-index');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    //
    public function index(){
        $brands = Brand::get();
        return view('admin.management.brands.index',compact('brands'));
    }

    public function create(){
        return view('admin.management.brands.create');
    }

    public function store(Request $request){
        $request->validate([
            'name'=> 'required|unique:brands',
        ]);
        $brand = $request->all();
        Brand::create($brand);          
        return redirect()->route('brand.index')->with(['success' => 'brand created successfully']);
    }

    public function edit($id){
        $brand = Brand::findOrFail($id);
        return view('admin.management.brands.edit',compact('brand'));
    }

    public function update(Request $request, $id){
        $brand = Brand::findOrFail($id);
        $request->validate([
            'name'=> 'required',
        ]);
        $brand->update($request->all());
        return redirect()->route('brand.index')->with(['success' => 'brand updated successfully']);
    }

    public function destroy($id){
        Brand::where('id',$id)->delete();
        return redirect()->back()->with(['success' => 'Brand deleted successfully']);
    }

    public function updateBrandStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=='active'){
                $status = 0;
            }else{
                $status=1;
            }
            Brand::where('id',$data['brand_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'brand_id'=>$data['brand_id']]);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryValidation;
use App\Models\Category;
use App\Models\Section;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function index(){
        $categories = Category::with(['sections','parent_category'])->get()->toArray();
        //dd($getCategories);
        return view('admin.management.categories.index',compact('categories'));
    }

    public function create(){
        $getSections = Section::get()->toArray();
        return view('admin.management.categories.create',compact('getSections'));
    }

    public function store(CategoryValidation $request){
        $categories = Category::with(['sections','parent_category'])->get();

        $category = $request->all();
        if(empty($category['category_discount'])){
            $category['category_discount'] =0;
        }
        Category::create($category);
        $getSections = Section::get()->toArray();
        return redirect()->route('category.index')->withDetails('getSections','categories')->with(['success' => 'category created successfully']);
    }

    public function appendCategories(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $getCategories = Category::with('sub_categories')->where(['parent_id'=>0,'section_id'=>$data['section_id']])->get();
            return view('admin.management.categories.append-categories')->with(compact('getCategories'));
        }    

    }

    public function edit($id){
        //
        $category = Category::find($id);
        $getSections = Section::get()->toArray();
        return view('admin.management.categories.edit',compact('category','getSections'));
    }

    public function update(CategoryValidation $request, $id){
        //
        $category = Category::find($id);
        $categories = Category::with(['sections','parent_category'])->where(['parent_id'=>0,'section_id'=>$category['section_id']])->get()->toArray();
        
        $category->update($request->all());
        $getSections = Section::get()->toArray();
        return redirect()->route('category.index')->withDetails('getSections','category','categories')->with(['success' => 'category updated successfully']);
    }

    public function destroy($id){
        Category::where('id',$id)->delete();
        return redirect()->back()->with(['success' => 'category deleted successfully']);
    }

    public function updateCategoryStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=='active'){
                $status = 0;
            }else{
                $status=1;
            }
            Category::where('id',$data['category_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'category_id'=>$data['category_id']]);
        }
    }
}

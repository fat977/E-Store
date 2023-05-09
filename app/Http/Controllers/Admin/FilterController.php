<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterValueValidation;
use App\Models\ProductFilter;
use App\Models\ProductFilterValue;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View as FacadesView;


class FilterController extends Controller
{
    //
    public function filters(){
        $filters = ProductFilter::get();
      
        return view('admin.management.filters.index',compact('filters'));
    }

    public function addEditFilter(Request $request,$id=null){

        if($id==""){
            $title = "Add new Filter Column";
            $filter = new ProductFilter;
            $message = "Filter is added successfully";
        }else{
            $title = "Edit Filter Column";
            $filter = ProductFilter::find($id);
            $message = "Filter is updated successfully";
        }
        if($request->isMethod('post')){
            $data = $request->all();
            $catIds = implode(',',$data['cat_ids']);

            //save
            $filter->cat_ids = $catIds;
            $filter->filter_name = $data['filter_name'];
            $filter->filter_column = $data['filter_column'];
            $filter->status=1;
            $filter->save();
            // add filter column in products table
            if($id==""){
                DB::statement('Alter table products add '.$data['filter_column'].' varchar(255)
                after description');
            }else{
                DB::statement('UPDATE products SET '. $filter->filter_name = $data['filter_name']);
            }
            return redirect('admin/filter/filters')->with(['success' => $message]);

        }
        
          // get sections  with categories and sub categories
       $categories = Section::with('categories')->get();
       return view('admin.management.filters.add_edit_filter',compact('title','categories','filter'));
    }

    public function updateFilterStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=='active'){
                $status = 0;
            }else{
                $status=1;
            }
            ProductFilter::where('id',$data['filter_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'filter_id'=>$data['filter_id']]);
        }
    }

    public function destroy($id){
        ProductFilter::where('id',$id)->delete();
        return redirect()->back()->with(['success' => 'Filter is deleted successfully']);
    }


    //////////// filter value ///////////////

    public function deleteFilterValue($id){
        ProductFilterValue::where('id',$id)->delete();
        return redirect()->back()->with(['success' => 'Filter Value is deleted successfully']);

    }


    public function filters_values(){
        $filters_values = ProductFilterValue::get();
        return view('admin.management.filters_values.index',compact('filters_values'));
    }

    public function create_filter_value(){
        $filters = ProductFilter::where('status',1)->get();
        return view('admin.management.filters_values.create',compact('filters'));
    }

    public function store_filter_value(FilterValueValidation $request){
        $filter = $request->all();
        ProductFilterValue::create($filter);
        $filters = ProductFilter::where('status',1)->get();
        return redirect()->route('filter.value.index')->withDetails('filters','filter')->with(['success' => 'Filter Value created successfully']);
    }

    public function edit_filter_value($id){
        $filter= ProductFilterValue::find($id);
        $product_filters = ProductFilter::where('status',1)->get();
        //echo $filter; die;
        return view('admin.management.filters_values.edit',compact('product_filters','filter'));

    }

    public function update_filter_value(FilterValueValidation $request,$id){
        $filter= ProductFilterValue::find($id);
        $filter->update($request->all());
        return redirect()->route('filter.value.index')->withDetails('filter')->with(['success' => 'Filter value updated successfully']);


    }  

    public function updateFilterValueStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=='active'){
                $status = 0;
            }else{
                $status=1;
            }
            ProductFilterValue::where('id',$data['filter_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'filter_id'=>$data['filter_id']]);
        }
    }

    public function categoryFilters(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $category_id = $data['category_id'];
            return response()->json(['view'=>(String)FacadesView::make('admin.management.filters.category_filters'
            ,compact('category_id'))]);
        }

    }

   /*  public function addEditFilterValue(Request $request,$id=null){
        if($id==""){
            $title = "Add new Filter Value";
            $filter = new ProductFilterValue;
            $message = "Filter Value is added successfully";
        }else{
            $title = "Edit Filter Value";
            $filter = ProductFilterValue::find($id);
            $message = "Filter Value is updated successfully";
        }
        if($request->isMethod('post')){
            $data = $request->all();

            //save
            $filter->filter_id = $data['filter_id'];
            $filter->filter_value = $data['filter_value'];
            $filter->status=1;
            $filter->save();
          
            return redirect('admin/filters-values')->with(['success' => $message]);

        }
        // get filters
        $filters = ProductFilter::where('status',1)->get()->toArray();
    
       return view('admin.admins.filters.add_edit_filter_value',compact('title','filter','filters'));
    } */


   /*  public function create_filter(){
        $filter = ProductFilter::get();

        //echo $filter; die;
        // get sections  with categories and sub categories
        $categories = Section::with('categories')->get();
        return view('admin.management.filters.create',compact('filter','categories'));
    }
    public function edit_filter($id){
        $filter = ProductFilter::find($id);
         // get sections  with categories and sub categories
         $categories = Section::with('categories')->get();
         return view('admin.management.filters.edit',compact('filter','categories'));
    }
    public function update_filter(Request $request,$id){

        $filter = ProductFilter::find($id);
        //$filter['cat_ids']=[''];
        $catIds = implode(',',$filter['cat_ids']);

        $filter['cat_ids'] = $catIds;
    
        $filter->update($request->all());

        DB::statement('Alter table products add '.$filter['filter_column'].' varchar(255)
        after description');

        // get sections  with categories and sub categories
        $categories = Section::with('categories')->get();
        return redirect()->route('filter.index')->withDetails('categories','filter')->with(['success' => 'Filter updated successfully']);

    }
    public function store_filter(Request $request){
        $filter = $request->all();
        $catIds = implode(',',$filter['cat_ids']);

            //save
        $filter['cat_ids'] = $catIds;
        ProductFilter::create($filter);

        DB::statement('Alter table products add '.$filter['filter_column'].' varchar(255)
        after description');

        // get sections  with categories and sub categories
        $categories = Section::with('categories')->get();
        return redirect()->route('filter.index')->withDetails('categories','filter')->with(['success' => 'Filter created successfully']);

    } */
}

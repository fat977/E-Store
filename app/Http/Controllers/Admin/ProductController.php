<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductFilter;
use App\Models\ProductImage;
use App\Models\Section;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //
    use ImageTrait;

    public function index(){
        $products =Product::with(['section'=>function($query){
            $query->select('id','name');
        },'category'=>function($query){
            $query->select('id','category_name');
        }]);
        $products= $products->get()->toArray();
      // dd($products);
       return view('admin.management.products.index',compact('products'));
    }

    public function addEditProduct(Request $request,$id=null){
        if($id==""){
            $title = "Add new Product";
            $product = new Product;
            $message = "Product is added successfully";
            
        }else{
            $title = "Edit Product";
            $product = Product::find($id);
            $message = "Product is updated successfully";
        }
        if($request->isMethod('post')){
           /*  $request->validate([
                'brand_id'=> 'required','category_id'=>  'required','section_id'=>'required',
                'product_name'=>'required|regex:/^[a-zA-Z]*$/i|max:255',
                'product_code'=>'required','product_color'=>'required','product_price'=>'required',
                'product_weight'=>'required',
                'description'=>'required',
                'url'=>'required',
                'meta_title'=>'required',
                'meta_keywords'=>'required',
                'meta_description'=>'required',
            ]); */
            $data = $request->all();
            if(!empty($request->product_image)){
                $path= $this->uploadImage($request,'products');
                $product->product_image = $path;
            }
             // save  product details
            $categoryDetails = Category::find($data['category_id']);
            $product->section_id =$categoryDetails['section_id'];
            $product->category_id =$data['category_id'];
            $product->brand_id =$data['brand_id'];

            $productFilter = ProductFilter::product_filters();
            foreach ($productFilter as $filter){
                $filterAvailable = ProductFilter::filterAvailable($filter['id'],$data['category_id']);
                if ($filterAvailable=="Yes"){
                    if(isset($filter['filter_column']) && $data[$filter['filter_column']]){
                        $product->{$filter['filter_column']} = $data[$filter['filter_column']];
                    }
                }
            }
            
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];

            if(!empty($data['is_featured'])){
                $product->is_featured =$data['is_featured'];
            }else{
                $product->is_featured ="No";
            }

            if(!empty($data['bestseller'])){
                $product->bestseller =$data['bestseller'];
            }else{
                $product->bestseller ="No";
            }

            if(empty($data['product_discount'])){
                $product->product_discount =0;
            }
            if(empty($data['product_weight'])){
                $product->product_weight =0;
            }

            $product->status = 1;
            $product->save();

            return redirect('admin/product/index')->with(['success' => $message]);

        }
       // get sections  with categories and sub categories
       $categories = Section::with('categories')->get();

       $brands = Brand::where('status',1)->get();
        return view('admin.management.products.add-edit-product',compact('title','categories','brands','product'));
    }


    public function updateProductStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=='active'){
                $status = 0;
            }else{
                $status=1;
            }
            product::where('id',$data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'product_id'=>$data['product_id']]);
        }
    }

    public function deleteProduct($id){
        $product=Product::where('id',$id)->first();
       
        Storage::disk('fatma')->delete($product->product_image); // Delete attachement with keeping the folder

        // Storage::disk('fatma')->deleteDirectory($product->id);   // Delete all the folder
        
        $product->forceDelete();
        $message = "Product has been deleted successfully";
        return redirect()->back()->with(['success' => $message]);

    }

    public function deleteProductImage($id){
        $product_image = Product::select('product_image')->where('id',$id)->first();
        $image_path = 'assets/admin/images/products/';
        if(file_exists($image_path.$product_image->product_image)){
            unlink($image_path.$product_image->product_image);
        }
        Product::where('id',$id)->update(['product_image'=>'']);
        $message = "Product Image has been deleted successfully";
        return redirect()->back()->with(['success' => $message]);

    }


    //////////////////////////// Attributes /////////////////////////////
    public function create_attribute($id){
        $product = Product::with('attributes')->select('id','product_name','product_code','product_color','product_price','product_image')->with('attributes')->find($id);
        //$productAttribute = ProductAttribute::pluck('id');
        //echo $productAttribute; die;
        return view('admin.management.product_attributes.create',compact('product'));
    }

    public function store_attribute(Request $request,$id){
        $product = Product::select('id','product_name','product_code','product_color','product_price','product_image')->with('attributes')->find($id);
        $data = $request->all();
            foreach($data['sku'] as $key=>$value){
                if(!empty($value)){

                    $skuCount = ProductAttribute::where('sku',$value)->count();
                    if($skuCount > 0){
                        return redirect()->back()->with(['error' => 'sku already exists']);
                    }
                    $attribute = new ProductAttribute;
                    $attribute->product_id =$id;
                    $attribute->sku =  $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();

                }
            }
            $message = "Product Attributes has been added successfully";
            return redirect()->back()->with(['success' => $message]);
        
    }

    public function edit_attribute($id){
        $product = Product::select('id','product_name','product_code','product_color','product_price','product_image')->with('attributes')->find($id);
        return view('admin.management.product_attributes.edit',compact('product'));
    }

    public function update_attribute(Request $request){
        $data = $request->all();
        foreach ($data['attributeId'] as $key => $attribute) {
            # code...
            if(!empty($attribute)){
                ProductAttribute::where(['id'=>$data['attributeId'][$key]])->update(['price'=>$data['price'][$key],
                'stock'=>$data['stock'][$key]]);
            }
        }
        $message = "Product Attributes has been updated successfully";
        return redirect()->back()->with(['success' => $message]);
    }

    public function updateAttributeStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=='active'){
                $status = 0;
            }else{
                $status=1;
            }
            ProductAttribute::where('id',$data['attribute_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'attribute_id'=>$data['attribute_id']]);
        }
    }

    public function deleteAttribute($id){
        ProductAttribute::where('id',$id)->delete();
        $message = "Product Attribute has been deleted successfully";
        return redirect()->back()->with(['success' => $message]);
        //return $id;

    }

    //////////////////  Images ///////////////////
    public function addImages(Request $request,$id){
        $product = Product::select('id','product_name','product_code','product_color','product_price','product_image')->with('images')->find($id);

        if($request->isMethod('post')){
            $data = $request->all();
            if($request->hasFile('image')){
                $i=1;
                foreach($request->file('image') as $imageFile){
                
                    $imageName = time().$i++.'.'.$imageFile->getClientOriginalExtension();
                    $imageFile->move('assets/admin/images/products',$imageName);
                
                    $product->images()->create([
                        'product_id'=> $product->id,
                        'image' => $imageName,
                        'status'=>1
                    ]);
                }
            }
            $message = "Images has been added successfully";
            return redirect()->back()->with(['success' => $message]);
        }
        return view('admin.management.product_images.add-images',compact('product'));

    }

    public function updateImageStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=='active'){
                $status = 0;
            }else{
                $status=1;
            }
            ProductImage::where('id',$data['image_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'image_id'=>$data['image_id']]);
        }
    }

    public function deleteImage($id){
        $product_image = ProductImage::select('image')->where('id',$id)->first();
        $image_path = 'assets/admin/images/products/';
        if(file_exists($image_path.$product_image->image)){
            unlink($image_path.$product_image->image);
        }
        ProductImage::where('id',$id)->delete();
        $message = " Image has been deleted successfully";
        return redirect()->back()->with(['success' => $message]);
    }


    /* public function create(){

        $categories = Section::with('categories')->get();
        $brands = Brand::where('status',1)->get();
        $product = Product::first();
        //echo $product; die;
        
       return view('admin.management.products.create',compact('categories','brands','product'));
    }

    public function store(Request $request){

        $product = $request->all();

        $file_name = time() . '.' . request()->product_image->getClientOriginalExtension();
        //dd($file_name);
        request()->product_image->move(public_path('assets/admin/images/products'), $file_name);
        $product['product_image']="$file_name";

        $productFilter = ProductFilter::product_filters();
            foreach ($productFilter as $filter){
                $filterAvailable = ProductFilter::filterAvailable($filter['id'],$product['category_id']);
                if ($filterAvailable=="Yes"){
                    if(isset($filter['filter_column']) && $product[$filter['filter_column']]){
                        $product["{$filter['filter_column']}"] = $product[$filter['filter_column']];
                        //echo $product["{$filter['filter_column']}"]; die;
                    }
                }
            }

        if(!empty($product['is_featured'])){
            $product['is_featured'] = $product['is_featured'];
        }else{
            $product['is_featured'] ="No";
        }

        if(!empty($product['bestseller'])){
            $product['bestseller']= $product['bestseller'];
        }else{
            $product['bestseller'] ="No";
        }

        if(empty($product['product_discount'])){
            $product['product_discount'] =0;
        }

        $categoryDetails = Category::find($product['category_id']);
        $product['section_id'] =$categoryDetails['section_id'];
        Product::create($product);
        return redirect()->route('product.index')->with(['success' => 'product created successfully']);
    }

    public function edit($id){

        $product = Product::find($id);
        $categories = Section::with('categories')->get();
        $brands = Brand::where('status',1)->get();
       // $product = Product::with(['categories','sections'])->get();
        return view('admin.management.products.edit',compact('categories','brands','product'));
    }

    public function update(Request $request,$id){ 
        $product = Product::find($id);
        $data = $request->all();
        if($request->hasFile('product_image')){
            $image_tmp = $request->file('product_image');
               //Upload image 
            if($image_tmp->isValid()){
                $product_image = $request->product_image;
                if(!empty($product_image)){
                    $imageName = time().'.'.$product_image->getClientOriginalExtension();
                    $request->product_image->move('assets/admin/images/products/',$imageName);
                }
                $product->product_image = $imageName;
            }
        }
        if(!empty($product['is_featured'])){
            $product['is_featured'] = $product['is_featured'];
        }else{
            $product['is_featured'] ="No";
        }

        if(!empty($product['bestseller'])){
            $product['bestseller']= $product['bestseller'];
        }else{
            $product['bestseller'] ="No";
        }

        if(empty($product['product_discount'])){
            $product['product_discount'] =0;
        }

        $product->update($request->all());
        return redirect()->route('product.index')->with(['success' => 'product updated successfully']);


    } */

    public function getBrands($id)
    {

        $brands = DB::table("brands")->where("category_id", $id)->pluck("name", "id");
        return json_encode($brands);
    }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
}

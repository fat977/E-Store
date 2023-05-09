<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductFilter;
use App\Models\ProductFilterValue;
use App\Models\ProductRecentView;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    //
   public function test(){
      $product = Product::select('material')->where('material','!=',null)->get();
      echo ($product); die;
   }

   public function listing(Request $request){
      if($request->ajax()){
         $data = $request->all();
        
         $url = $data['url'];
         $_GET['sort']=$data['sort'];
         $categoryCount = Category::where(['url'=>$url ,'status'=>1])->count();
         if($categoryCount > 0){
             $categoryDetails = Category::categoryDetails($url);
             $categoryProduct = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);
            
             // check dynamic filter
            $productFilter = ProductFilter::product_filters();
            foreach($productFilter as $key => $filter){
               //if filter is selected
               if(isset($filter['filter_column']) && isset($data[$filter['filter_column']]) && 
               !empty($filter['filter_column']) && !empty($data[$filter['filter_column']]) ){
                  $categoryProduct->whereIn($filter['filter_column'],$data[$filter['filter_column']]);
                  
               }
               
            }
           
           

             // check sort 
            if(isset($_GET['sort']) && !empty($_GET['sort'])){
              if($_GET['sort']=="product_latest"){
                 $categoryProduct->orderby('products.id','Desc');
              }elseif($_GET['sort']=="price_lowest"){
                 $categoryProduct->orderby('products.product_price','Asc');
              }elseif($_GET['sort']=="price_highest"){
                 $categoryProduct->orderby('products.product_price','Desc');
              }elseif($_GET['sort']=="name_a_z"){
                 $categoryProduct->orderby('products.product_name','Asc');
              }elseif($_GET['sort']=="name_z_a"){
                 $categoryProduct->orderby('products.product_name','Desc');
              }
 
            }

            // check for size
            if(isset($data['size']) && !empty($data['size'])){
               $getProductIds=ProductAttribute::select('product_id')->whereIn('size',$data['size'])->
               pluck('product_id')->toArray();
               $categoryProduct->whereIn('id',$getProductIds);
            }

              // check for color
              if(isset($data['color']) && !empty($data['color'])){
               $getProductIds=Product::select('id')->whereIn('product_color',$data['color'])->
               pluck('id')->toArray();
               $categoryProduct->whereIn('products.id',$getProductIds);
            }

             // check for price
             if(isset($data['price']) && !empty($data['price'])){
               foreach($data['price'] as $key=>$price){
                  $priceArr= explode('-',$price);
                  $getProductIds[]=Product::select('id')->whereBetween('product_price',[$priceArr[0],
                  $priceArr[1]])->pluck('id')->toArray();
               }
              $getProductIds = call_user_func_array('array_merge',$getProductIds);
              $categoryProduct->whereIn('products.id',$getProductIds);
            }

              // check for brand
              if(isset($data['brand']) && !empty($data['brand'])){
               $getProductIds=Product::select('id')->whereIn('brand_id',$data['brand'])->
               pluck('id')->toArray();
               $categoryProduct->whereIn('products.id',$getProductIds);
            }

            $categoryProduct=  $categoryProduct->Paginate(30);
 
            // dd($categoryProduct);
 
             return view('front.products.ajax_products_listing',compact('categoryDetails','categoryProduct','url'));
         }
      }else{
         $url = Route::getFacadeRoot()->current()->uri();
         $categoryCount = Category::where(['url'=>$url ,'status'=>1])->count();
         if($categoryCount > 0){
             $categoryDetails = Category::categoryDetails($url);
             $categoryProduct = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);
            //echo $categoryProduct; die;
             if(isset($_GET['sort']) && !empty($_GET['sort'])){
              if($_GET['sort']=="product_latest"){
                 $categoryProduct->orderby('products.id','Desc');
              }elseif($_GET['sort']=="price_lowest"){
                 $categoryProduct->orderby('products.product_price','Asc');
              }elseif($_GET['sort']=="price_highest"){
                 $categoryProduct->orderby('products.product_price','Desc');
              }elseif($_GET['sort']=="name_a_z"){
                 $categoryProduct->orderby('products.product_name','Asc');
              }elseif($_GET['sort']=="name_z_a"){
                 $categoryProduct->orderby('products.product_name','Desc');
              }
             
            }
            $categoryProduct=  $categoryProduct->Paginate(30);

            $category = Category::pluck('id');

            //echo ($category); die;
            $product = Product::select('material')->where('category_id',$categoryDetails)->get();
            
            //echo ($product); die;
             return view('front.products.listing',compact('product','categoryDetails','categoryProduct','url'));
         }

      }
   }

   public function details($id){
      $productDetails = Product::with(['section','category','brand','attributes'=>function($query){
         $query->where('stock','>',0)->where('status',1);
      },'images','attributes'])->find($id);
      $categoryDetails = Category::categoryDetails($productDetails['category']['url']);
      //echo ($productDetails['attributes']['size']); die;

       //reviews
       $product = Product::where('id',$productDetails['id'])->where('status',1)->first();
       if($product){
           $product_id = $product->id;
          
           $verified_purchase = Order::where('orders.user_id',Auth::id())->
               join('order_items','orders.id','order_items.order_id')
               ->where('order_items.product_id',$product_id)->get();
           
           
       }else{
           return redirect()->back()->with('error','the link you follow is broken');
       }

      // ratings
      $ratings = Rating::where('product_id',$productDetails['id'])->get();

      $rating_sum = Rating::where('product_id',$productDetails['id'])->sum('stars_rated');
      $stars_rated = Rating::where('product_id',$productDetails['id'])->where('user_id',Auth::user()->id)->count('stars_rated');

      if($ratings->count() > 0){
         $rating_value = $rating_sum / $ratings->count();
      }else{
         $rating_value=0;
      }

      $user_rating =  Rating::where('product_id',$productDetails['id'])->where('user_id',Auth::id())->first();



      //similar products
      $similarProducts = Product::with('brand')->where('category_id',$productDetails['category']['id'])
      ->where('id','!=',$id)->limit(6)->get();
      $totalStock = ProductAttribute::where('product_id',$product_id)->pluck('stock');
      //dd($total);

      //recent viewed
      if(empty(Session::get('session_id'))){
         $session_id = md5(uniqid(rand(),true));
      }else{
         $session_id = Session::get('session_id');
      }
      Session::put('session_id',$session_id);
      $countRecentViewProduct = ProductRecentView::where(['product_id'=>$id,'session_id'=>$session_id])->count();
      if( $countRecentViewProduct == 0){
         ProductRecentView::insert(['product_id'=>$id,'session_id'=>$session_id]);
      }

      // get recent viewed products id
      $recentProductIds = ProductRecentView::select('product_id')->where('product_id','!=',$id)
      ->where('session_id',$session_id)->inRandomOrder()->get()->take(4)->pluck('product_id');

       //recent viewed products
       $recentViewProducts = Product::with('brand')->where('category_id',$productDetails['category']['id'])
       ->where('id','!=',$id)->limit(6)->get();

       //get group products (products color)
       $groupProducts=array();
       if(!empty($productDetails['group_code'])){
         $groupProducts = Product::select('id','product_image')->where('id','!=',$id)->
         where(['group_code'=>$productDetails['group_code'],'status'=>1])->get()->toArray();
         //dd($groupProducts);
       }

       $totalStock = ProductAttribute::where('product_id',$id)->sum('stock');
       $size = ProductAttribute::where('product_id',$id)->where('size','!=','NULL')->first();
       //echo $size;

      return view('front.products.details',compact('productDetails','categoryDetails','totalStock',
      'similarProducts','groupProducts','recentViewProducts','verified_purchase',
      'user_rating','ratings','rating_value','stars_rated','size'));
   }

   public function getProductsPrice(Request $request){
      if($request->ajax()){
         $data = $request->all();
         $getDiscountAttributePrice = Product::getDiscountAttributePrice($data['product_id'],$data['size']);
         return $getDiscountAttributePrice;
      }

   }
}

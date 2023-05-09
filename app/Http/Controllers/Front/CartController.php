<?php

namespace App\Http\Controllers\Front;
use App\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rules\Exists;

class CartController extends Controller
{
    //
   public function cartAdd(Request $request){
      if($request->isMethod('post')){
         $product_id = $request->input('product_id');
         $data = $request->all();
         //dd($data);
         
         // check product stock is available or not
         $getProductStock = ProductAttribute::getProductStock($data['size']);
         //  dd($getProductStock);

         if($getProductStock<$data['quantity']){
            return redirect()->back()->with(['error_message' => 'required quantity not available']);
         }
         
         // generate session id if not exist
         $session_id = Session::get('session_id');
         if(!empty($session_id)){
            $session_id = Session::getId();
            Session::put('session_id',$session_id);
         }

         // check product if already exist in user cart
         if(Auth::check()){
            // user is logged in
            $user_id = Auth::user()->id;
         // $countProduct = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'user_id'=>$user_id])->count();
            $countProduct = Cart::where(['size'=>$data['size'],'user_id'=>$user_id])->count();
         }else{
            // user is not logged in
            $user_id=0;
            //$countProduct = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'session_id'=>$session_id])->count();
            $countProduct = Cart::where(['size'=>$data['size'],'session_id'=>$session_id])->count();
         }

         if($countProduct>0){
            return redirect()->back()->with(['error_message'=>'product is already exists']);
         }

         // save products in cart table
         $item = new Cart;
         $item->session_id=$session_id;
         $item->user_id=$user_id;
         $item->product_id = $data['product_id'];
         $item->size = $data['size'];
         $item->quantity = $data['quantity'];
         $item->save();

         return redirect()->back()->with(['success_message' => 'Product has been added in Cart
         <a style="text-decoration:underline" href="/cart/cart"> View Cart </a>']);
      }
   }
  
      public function cartUpdate(Request $request){
        if($request->ajax()){
           $data = $request->all();
  
           Cart::where('id',$data['cartid'])->update(['quantity'=>$data['qty']]);
  
           //get cart details
           $cartDetails = Cart::find($data['cartid']);
  
           //get available product stock
           $availableStock = ProductAttribute::select('stock')->where(['product_id'=>$cartDetails['product_id'],
           'size'=>$cartDetails['size']])->first()->toArray();
  
           if($data['qty']>$availableStock['stock']){
              $getCartItem =Cart::getCartItems();
              return response()->json([
                 'status'=>false,
                 'message'=>'Product stock is not available',
                 'view'=>(String)View::make('front.cart.cart_items',compact('getCartItem')),
                 'headerView'=>(String)View::make('front.layout.header_cart_items',compact('getCartItem'))
              ]);
           }
  
           // check if product size is available
           $availableSize = ProductAttribute::where(['product_id'=>$cartDetails['product_id'],
           'size'=>$cartDetails['size'],'status'=>1])->count();
  
           if($availableSize==0){
              $getCartItem =Cart::getCartItems();
              return response()->json([
                 'status'=>false,
                 'message'=>'Product size is not available',
                 'view'=>(String)View::make('front.cart.cart_items',compact('getCartItem')),
                 'headerView'=>(String)View::make('front.layout.header_cart_items',compact('getCartItem'))
              ]);
           }
  
  
           $getCartItem =Cart::getCartItems();
           $totalCartItems = totalCartItems();
  
           return response()->json([
              'status'=> true,
              'totalCartItems'=>$totalCartItems,
              'view' => (String)View::make('front.cart.cart_items',compact('getCartItem')),
              'headerView'=>(String)View::make('front.layout.header_cart_items',compact('getCartItem'))
           ]);
        }
      }
  
      public function cartDelete(Request $request){
        if($request->ajax()){
           $data = $request->all();
           //dd($data);
           Cart::where('id',$data['cartid'])->delete();
           $getCartItem =Cart::getCartItems();
           $totalCartItems = totalCartItems();
  
           return response()->json([
              'totalCartItems'=>$totalCartItems,
              'view' => (String)View::make('front.cart.cart_items',compact('getCartItem')),
              'headerView'=>(String)View::make('front.layout.header_cart_items',compact('getCartItem'))
           ]);
        }
      }
  
      public function cart(){
        $getCartItem = Cart::getCartItems();
        //dd($getCartItem);
        return view('front.cart.cart',compact('getCartItem'));
      }
}

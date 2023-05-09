<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class WishlistController extends Controller
{
    //
    public function wishlist(){
      
        $getWishlistItem = wishlist::getWishlistItems();
        return view('front.wishlist.wishlist',compact('getWishlistItem'));
    }

    public function addToWishlist(Request $request){
        $product_id = $request->input('product_id');
          
        if(Auth::check()){
            $product_check = Product::where('id',$product_id)->first();
            if($product_check){
                if(Wishlist::where('product_id',$product_id)->where('user_id',Auth::id())->exists()){
                    return response()->json(['type'=>'error','message'=>$product_check->product_name.' '.'Already added to wishlist']);
                  /*   return redirect()->back()->with(['success_message' => $product_check->product_name.' '. 'already has been added in Cart
                    <a style="text-decoration:underline" href="/cart"> View Cart </a>']); */
                }else{
                    $wishlist = new Wishlist();
                    $wishlist->product_id =$product_id;
                    $wishlist->user_id =Auth::id();
                    $wishlist->save();
                    return response()->json(['type'=>'success','message'=>$product_check->product_name.' '.'Added successfully to Wishlist']);
                    /* return redirect()->back()->with(['success_message' => $product_check->product_name.' '.'has been added in Cart
                    <a style="text-decoration:underline" href="/cart"> View Cart </a>']); */
                }   
            }
        }else{
            return response()->json(['type'=>'error','message'=>'Login to continue']);
        }

    }

    public function wishlistCount(){
        $wishlistCount = Wishlist::where('user_id',Auth::id())->count();
        return response()->json(['count'=>$wishlistCount]);
    }

    public function wishlistDelete(Request $request){
        if(Auth::check()){
            $product_id = $request->input('product_id');
            if(Wishlist::where('product_id',$product_id)->where('user_id',Auth::id())->exists()){
                $wishlistItem = Wishlist::where('product_id',$product_id)->where('user_id',Auth::id())->first();
                $wishlistItem->delete();
                return response()->json(['status'=>'Product is deleted successfully from wishlist']);
            }
        }else{
            return response()->json(['status'=>'Login to continue']);
        }

    }

    /* public function wishlistDelete(Request $request){
        if(Auth::check()){
            $product_id = $request->input('product_id');
            if(Wishlist::where('product_id',$product_id)->where('user_id',Auth::id())->exists()){
                $wishlistItem = Wishlist::where('product_id',$product_id)->where('user_id',Auth::id())->first();
                $wishlistItem->delete();
                return redirect()->back()->with(['success_message'=>'Product is deleted successfully from wishlist']);
            }
        }else{
            return response()->json(['status'=>'Login to continue']);
        }

    } */
}

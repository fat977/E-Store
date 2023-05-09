<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    //
    public function add(Request $request){
        $stars = $request->input('product_rating');
        $user_review = $request->input('user_review');
        $product_id = $request->input('product_id');

        $product_check = Product::where('id',$product_id)->where('status',1)->first();
        if($product_check){
            $verified_purchase = Order::where('orders.user_id',Auth::id())->
            join('order_items','orders.id','order_items.order_id')
            ->where('order_items.product_id',$product_id)->get();

            if($verified_purchase->count() > 0){
                $existing_rating = Rating::where('user_id',Auth::id())->where('product_id',$product_id)->first();

                if($existing_rating){
                    return view('front.reviews.edit-review',compact('existing_rating'));
                }else{
                    Rating::create([
                        'user_id'=>Auth::id(),
                        'product_id'=>$product_id,
                        'stars_rated'=>$stars,
                        'user_review'=>$user_review
                    ]);
                }
                return redirect()->back()->with('success_message','thanks for rating this product');
               
            }else{
                return redirect()->back()->with('error_message','you can not rate this product without purchase');
            }
        }else{
            return redirect()->back()->with('error','the link you follow is broken');
        }
    }

    public function edit($id){
        $product = Product::where('id',$id)->where('status',1)->first();
        if($product){
            $product_id =$product->id;
            $existing_rating = Rating::where('user_id',Auth::id())->where('product_id',$product_id)->first();
            if($existing_rating){
                return view('front.reviews.edit-review',compact('existing_rating'));
            }
        }

    }

    public function update(Request $request){
        $user_review = $request->input('user_review');
        $stars_rated = $request->input('product_rating');

        if($user_review != ''){
            $review_id = $request->input('review_id');
            $existing_rating = Rating::where('id',$review_id)->where('user_id',Auth::id())->first();
            if($existing_rating){
                $existing_rating->user_review = $request->input('user_review');
                $existing_rating->stars_rated = $request->input('product_rating');
                $existing_rating->update();
                return redirect('product/'.$existing_rating->product->id)->with('success_message','review is updated successfully');
            }else{
                return redirect()->back()->with('error_message','You follow un broken link');
            }
        }else{
            return redirect()->back()->with('error_message','You can not submit an empty review');
        }
    }

    public function delete(Request $request){

        if(Auth::check()){
            $product_id = $request->input('product_id');
            if(Rating::where('product_id',$product_id)->where('user_id',Auth::id())->exists()){
                $RatingItem = Rating::where('product_id',$product_id)->where('user_id',Auth::id())->first();
                $RatingItem->delete();
                return redirect()->back()->with('success_message','review is deleted successfully');
            }
        }else{
            return redirect()->back()->with('error_message','You must login!');
        }

    }
}

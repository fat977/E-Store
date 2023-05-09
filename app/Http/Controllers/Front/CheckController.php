<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\User;
use App\Notifications\PlaceOrder;
use Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class CheckController extends Controller
{
    //
    public function checkout(){
        /* $oldCartItems = Cart::with('products')->where('user_id',Auth::id())->get();
        foreach($oldCartItems as $item){
            if(!Book::where('id',$item['book_id'])->where('stock','>=',$item['quantity'])->exists()){
                $removeItem = Cart::where('user_id',Auth::id())->where('user_id',$item['user_id'])->first();
                $removeItem->delete();
                $book = Book::where('stock',$item['quantity'])->first();
                $book->stock=0;
                $book->update();      
            }            
        } */
        if(Auth::check()){
            $cartItems = Cart::where('user_id',Auth::id())->get();
            return view('front.checkout.checkout',compact('cartItems'));
        }else{
            return view('front.users.login_register');
        }
       
    }

    public function placeOrder(Request $request){

        $order = new Order();
        $order->user_id =Auth::id();
        $order->name =$request->input('name');
        $order->email =$request->input('email');
        $order->mobile =$request->input('mobile');
        $order->address =$request->input('address');
        $order->city =$request->input('city');
        $order->state =$request->input('state');
        $order->country =$request->input('country');
        $order->pincode =$request->input('pincode');
        $order->payment_mode =$request->input('payment_mode');

        // calculate price
        $total =0;
        $cartItems_totals = Cart::where('user_id',Auth::id())->get();
        foreach($cartItems_totals as $item){
            $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
            if($getDiscountAttributePrice['discount']>0){
                $total += ($getDiscountAttributePrice['final_price'])*($item->quantity);
            }else{
                $total += $getDiscountAttributePrice['final_price'] * $item->quantity;
            }
            
        }
        $order->total_price = $total;
        $order->tracking_no =  $order->name.rand(1111,9999);
        $order->save();

        

        $cartItems = Cart::where('user_id',Auth::id())->get();
        foreach($cartItems as $item){
            $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
            if($getDiscountAttributePrice['discount']>0){
                $total = ($getDiscountAttributePrice['final_price'])*($item->quantity);
            }else{
                $total = $getDiscountAttributePrice['final_price'] * $item->quantity;
            }
            OrderItem::create([
                'order_id'=> $order->id,
                'product_id'=> $item->product_id,
                'quantity' => $item->quantity,
                'price'=> $total
            ]);
            $attribute = ProductAttribute::where('product_id',$item['product_id'])->first();
            
            //echo $item['quantity']; die;
            $attribute->stock= $attribute->stock - $item['quantity'];
            //echo $attribute->stock; die;
            $attribute->update(); 

        }

        if(Auth::user()->address == null){
            $user = User::where('id',Auth::id())->first();
            $user->name =$request->input('name');
            //$user->email =$request->input('email');
            $user->mobile =$request->input('mobile');
            $user->address =$request->input('address');
            $user->city =$request->input('city');
            $user->state =$request->input('state');
            $user->country =$request->input('country');
            $user->pincode =$request->input('pincode');
            $user->update();
        }
        $cartItems = Cart::where('user_id',Auth::id())->get();
        Cart::destroy($cartItems);

        /* if($request->input('payment_mode')=='paid by paypal'){
            return response()->json(['status'=>'ordered placed successfully']);
        } */

        $admin = Admin::where('email','fatma@gmail.com')->get();
        $orders = Order::latest()->first();
        Notification::send($admin,new PlaceOrder($orders));
        return redirect('my-orders')->with(['success_message'=>'ordered placed successfully']);
    }

    
}

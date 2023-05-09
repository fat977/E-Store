<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //
    public function orders(){
        $orders = Order::where('status',0)->get();
        //echo $orders; die;
        return view('admin.management.orders.orders',compact('orders'));
    }

    public function viewOrders($id){
        $orders = Order::where('id',$id)->first();
        $getNotificationId = DB::table('notifications')->where('data->id',$id)->pluck('id');
        DB::table('notifications')->where('id',$getNotificationId)->update([
            'read_at'=>now()
        ]);
        return view('admin.management.orders.view-orders',compact('orders','getNotificationId'));
    }

    public function updateOrders(Request $request,$id){
        $orders = Order::find($id);
        $orders->status = $request->input('order_status');
        $orders->update();
        return redirect('admin/order/orders')->with('success','Order is updated successfully');
    }

    public function orderHistory(){
        $orders = Order::where('status',1)->get();
        //echo $orders; die;
        return view('admin.management.orders.orders-history',compact('orders'));
    }

    public function MarkAsRead_all(){
        $userUnReadNotifications = Auth::user()->unreadNotifications;
        if($userUnReadNotifications){
            $userUnReadNotifications->markAsRead();
            return back();
        }
    }
}

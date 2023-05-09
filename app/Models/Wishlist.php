<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Wishlist extends Model
{
    use HasFactory;
    public static function getWishlistItems(){
        if(Auth::check()){
            $getWishlistItem = Wishlist::with(['product'=>function($query){
                $query->select('id','category_id','product_name','product_code','product_color',
                'product_image');
            }])->orderby('id','Desc')->where('user_id',Auth::user()->id)->get()->toArray();
        }
       
        return $getWishlistItem;
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}

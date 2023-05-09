<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;
    protected $fillable = ['product_id','size','price','stock','sku','status'];
    
    public static function getProductStock($size){
        $getProductStock = ProductAttribute::select('stock')->where('size',$size)->first();
        return $getProductStock->stock;
    }

    public static function getProductStockk(){
        $getProductStockk = ProductAttribute::select('stock')->first();
        return $getProductStockk->stock;
    }

    public static function totalStock($id){
        $totalStock = ProductAttribute::where('product_id',$id)->sum('stock');
        return $totalStock;
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable =['section_id','category_id','brand_id',
    'product_name','product_code','product_color','product_image','product_price','product_discount',
    'product_weight','bestseller','is_featured',
    'description','url','meta_title','meta_description','meta_keywords','status'];

    public function section(){
        return $this->belongsTo(Section::class,'section_id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id');
    }

    public function attributes(){
        return $this->hasMany(ProductAttribute::class,'product_id');
    }

    public function images(){
        return $this->hasMany(ProductImage::class);
    }

    public static function getDiscountPrice($product_id){
        $proDetails = Product::select('product_discount','category_id','product_price')->where('id',$product_id)->first();
        $proDetails = json_decode(json_encode($proDetails),true);
        $catDetails = Category::select('category_discount')->where('id',$proDetails['category_id'])->first();
        $catDetails = json_decode(json_encode($catDetails),true);

        if($proDetails['product_discount']>0){
            $discount = $proDetails['product_price'] - ($proDetails['product_price']*
                        $proDetails['product_discount']/100);

        }else if($catDetails['category_discount']>0){
            $discount = $proDetails['product_price'] - ($proDetails['product_price']*
                        $catDetails['category_discount']/100);
        }else{
            $discount=0;
        }
        return $discount;

    }

    public static function getDiscountAttributePrice($product_id,$size){
        $proAttrPrice = ProductAttribute::where(['product_id'=>$product_id,'size'=>$size])->first()->toArray();
        $proDetails = Product::select('product_discount','category_id')->where('id',$product_id)->first();
        $proDetails = json_decode(json_encode($proDetails),true);
        $catDetails = Category::select('category_discount')->where('id',$proDetails['category_id'])->first();
        $catDetails = json_decode(json_encode($catDetails),true);

        if($proDetails['product_discount']>0){
            $final_price =$proAttrPrice['price']-($proAttrPrice['price']*
            $proDetails['product_discount']/100);
            $discount = $proAttrPrice['price']-$final_price;

        }else if($catDetails['category_discount']>0){
            $final_price =$proAttrPrice['price']-($proAttrPrice['price']*
            $catDetails['category_discount']/100);
            $discount = $proAttrPrice['price']-$final_price;


        }else{
            $final_price =$proAttrPrice['price'];
            $discount=0;
        }
        return array('product_price'=> $proAttrPrice['price'],'final_price' => $final_price, 'discount'
         => $discount);

    }
    
    public static function isProductNew($product_id){
        $productIds = Product::select('id')->where('status',1)->orderby('id','Desc')->limit(5)
        ->pluck('id');
        $productIds =json_decode(json_encode($productIds),true);
        if(in_array($product_id,$productIds)){
            $isProductNew = 'Yes';
        }else{
            $isProductNew = 'No';
        }
        return $isProductNew;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable =['parent_id','section_id','category_name','category_discount','description','url',
    'meta_title','meta_description','meta_keywords','status'];

    public function sections(){
        return $this->belongsTo(Section::class,'section_id');
    }

    public function parent_category(){
        return $this->belongsTo(Category::class,'parent_id')->select('id','category_name');
    }
    public function sub_categories(){
        return $this->hasMany(Category::class,'parent_id')->where('status',1);
    }

    public static function categoryDetails($url){
        $categoryDetails = Category::select('id','parent_id','category_name','url','description')->with(['sub_categories'=>function($query){
            $query->select('id','parent_id','category_name','url','description');
        }])->where('url',$url)->first()->toArray();
        //dd($categoryDetails);
        $catIds = array();
        $catIds[] = $categoryDetails['id'];

        if($categoryDetails['parent_id']==0){
            $breadcrumbs =  '<li class="is-marked">
            <a href="'.url($categoryDetails['url']).'">'.$categoryDetails['category_name'].' </a>
        </li>';
        }else{
            $parentCategory = Category::select('category_name','url')->where('id',$categoryDetails['parent_id'])->
            first()->toArray();

            $breadcrumbs =  '<li class="has-separator">
            <a href="'.url($parentCategory['url']).'">'.$parentCategory['category_name'].'</a>
            </li>
            <li class="is-marked">
            <a href="'.url($categoryDetails['url']).'">'.$categoryDetails['category_name'].' </a>
            </li>';
        }
        foreach($categoryDetails['sub_categories'] as $key => $subcat){
            $catIds[]=$subcat['id'];
        }
        $resp = array('catIds'=>$catIds,'categoryDetails'=>$categoryDetails,'breadcrumbs'=>$breadcrumbs);
        return $resp;
    }

    public static function getCategoryName($category_id){
        $getCategoryName = Category::select('category_name')->where('id',$category_id)->first();
        return  $getCategoryName->category_name;
    }

}

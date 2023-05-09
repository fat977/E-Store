<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $productsRecords = [
            ['id'=>1,
             'section_id'=>1,
             'category_id'=>10,
             'brand_id'=>1,
             'product_name'=>'skirt product',
             'product_code'=>'RN 11',
             'product_color'=>'Blue',
             'product_price'=>15000,
             'product_discount'=>10,
             'product_weight'=>500,
             'product_image'=>'',
             'description'=>'',
             'meta_title'=>'',
             'meta_description'=>'',
             'meta_keywords'=>'', 
             'is_featured'=>'Yes', 
             'status'=>1         
            ],
           
        ];

        Product::insert($productsRecords);
    }
}

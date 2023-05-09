<?php

namespace Database\Seeders;

use App\Models\ProductFilter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $filterRecords = [
            ['id'=>1 ,'cat_ids'=>'1,10','filter_name'=>'Fabric','filter_column'=>'fabric',
            'status'=>1],
        ];
        ProductFilter::insert($filterRecords);
    }
}

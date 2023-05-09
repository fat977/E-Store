<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $adminsRecords = [
            [
                'id'=> 1,
                'name'=>'Fatma',
                'email'=>'fatma@gmail.com',
                'password'=>bcrypt('12345678'),
            ],
        ];
            Admin::insert($adminsRecords);
    }
}

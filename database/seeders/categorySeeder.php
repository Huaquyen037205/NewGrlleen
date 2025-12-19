<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class categorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Trái cây',
                'status'=>'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rau củ',
                'status'=>'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Thực phẩm',
                'status'=>'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'name' => 'Ngũ cốc',
                'status'=>'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

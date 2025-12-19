<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class imageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('images')->insert([
        //1
            [
                'product_id'=> 1,
                'name' => 'dauTay.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //2
            [
               'product_id'=> 2,
                'name' => 'tao.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //3
            [
                'product_id'=> 3,
                'name' => 'namKimCham.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //4
            [
                'product_id'=> 4,
                'name' => 'rauMuong.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //5
            [
                'product_id'=> 5,
                'name' => 'nguCoc.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //6
            [
                'product_id'=> 6,
                'name' => 'yenMach.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //7
            [
                'product_id'=> 7,
                'name' => 'bapCai.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //8
            [
                'product_id'=> 8,
                'name' => 'buncai.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //9
            [
                'product_id'=> 9,
                'name' => 'bongCai.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //10
            [
                'product_id'=> 10,
                'name' => 'Otchuong.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //11
            [
                'product_id'=> 11,
                'name' => 'duaChuot.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //12
            [
                'product_id'=> 12,
                'name' => 'caTim.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //13
            [
                'product_id'=> 13,
                'name' => 'caChua.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //14
            [
                'product_id'=> 14,
                'name' => 'chuoi.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //15
            [
                'product_id'=> 15,
                'name' => 'cam.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //16
            [
                'product_id'=> 16,
                'name' => 'nho.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //17
            [
                'product_id'=> 17,
                'name' => 'duaHau.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //18
            [
                'product_id'=> 18,
                'name' => 'le.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //19
            [
                'product_id'=> 19,
                'name' => 'dao.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //20
            [
                'product_id'=> 20,
                'name' => 'bapBo.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //21
            [
                'product_id'=> 21,
                'name' => 'caHoi.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //22
            [
                'product_id'=> 22,
                'name' => 'hau.webp',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //23
            [
                'product_id'=> 23,
                'name' => 'boKobe.webp',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //24
            [
                'product_id'=> 24,
                'name' => 'Muc.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //25
            [
                'product_id'=> 25,
                'name' => 'suonHeo.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //26
            [
                'product_id'=> 26,
                'name' => 'thitLon.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        //27
            [
                'product_id'=> 27,
                'name' => 'bo.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

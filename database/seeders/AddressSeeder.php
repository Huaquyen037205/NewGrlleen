<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('addresses')->insert([
            [
                'user_id' => 1,
                'address' => '123 Đường test, Quận 1, TP.HCM',
                'is_default' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

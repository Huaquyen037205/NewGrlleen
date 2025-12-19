<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('payments')->insert([
            [
                'payment_method' => 'Tiền mặt',
                'payment_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'payment_method' => 'Vnpay',
                'payment_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

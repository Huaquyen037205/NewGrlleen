<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'Admin@gmail.com',
                'password' => bcrypt('Admin@123'),
                'phone' => '0123456789',
                'role' => 'admin',
                'avatar' => 'avatar1.jpg',
                'is_active' => 'active',
                'google_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ReadTest',
                'email' => 'ReadTest@gmail.com',
                'password' => bcrypt('Test@123'),
                'phone' => '0123456789',
                'role' => 'user',
                'avatar' => 'toi.jpg',
                'is_active' => 'active',
                'google_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

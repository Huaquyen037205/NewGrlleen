<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
use Illuminate\Support\Facades\DB;

echo 'Total orders: ' . DB::table('orders')->count() . PHP_EOL;
echo 'Paid orders in 2026: ' . DB::table('orders')->where('status', 'paid')->whereYear('created_at', 2026)->count() . PHP_EOL;

$monthlyRevenueRaw = DB::table('orders')
    ->where('status', 'paid')
    ->select(
        DB::raw('MONTH(created_at) as month'),
        DB::raw('IFNULL(SUM(total_amount - COALESCE(shipping_fee,0)),0) as revenue')
    )
    ->whereYear('created_at', 2026)
    ->groupBy('month')
    ->pluck('revenue', 'month')
    ->toArray();

echo 'Monthly revenue in 2026: ';
print_r($monthlyRevenueRaw);

$ordersByMonthRaw = DB::table('orders')
    ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as cnt'))
    ->whereYear('created_at', 2026)
    ->groupBy('month')
    ->pluck('cnt', 'month')
    ->toArray();

echo 'Monthly orders in 2026: ';
print_r($ordersByMonthRaw);
?>
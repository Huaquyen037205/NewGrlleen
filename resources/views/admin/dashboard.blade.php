@extends('template.admin')
@section('admin')
    <div class="min-h-screen bg-[#f5f6f8] text-gray-800 font-[Inter] p-8 space-y-10">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold">Dashboard Tổng Quan</h1>
            <div class="flex items-center gap-4">
                <input type="text" placeholder="Tìm kiếm..."
                    class="px-4 py-2 w-72 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#7cc652] outline-none">
                <div class="w-10 h-10 bg-[#7cc652] text-white rounded-full flex items-center justify-center shadow-md">
                    AD
                </div>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition text-center">
                <p class="text-gray-500 text-sm">Tổng doanh thu</p>
                <h2 class="text-2xl font-semibold mt-2">{{ number_format($revenue ?? 0) }}₫</h2>
                <p class="text-[#7cc652] text-sm mt-1">▲ +12%</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition text-center">
                <p class="text-gray-500 text-sm">Số đơn hàng</p>
                <h2 class="text-2xl font-semibold mt-2">{{ number_format($ordersCount ?? 0) }}</h2>
                <p class="text-[#7cc652] text-sm mt-1">▲ +8%</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition text-center">
                <p class="text-gray-500 text-sm">Khách hàng mới</p>
                <h2 class="text-2xl font-semibold mt-2">{{ number_format($usersCount ?? 0) }}</h2>
                <p class="text-[#7cc652] text-sm mt-1">▲ +5%</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition text-center">
                <p class="text-gray-500 text-sm">Tỉ lệ hoàn hàng</p>
                <h2 class="text-2xl font-semibold mt-2">2.3%</h2>
                <p class="text-red-400 text-sm mt-1">▼ -0.4%</p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition col-span-2">
                <h3 class="text-lg font-semibold mb-4">Doanh thu theo tháng</h3>
                <canvas id="revenueChart" height="90"></canvas>
            </div>

            <div
                class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition flex flex-col justify-center items-center">
                <h3 class="text-lg font-semibold mb-4">Tỉ lệ sản phẩm bán chạy</h3>
                <div class="w-48 h-48">
                    <canvas id="productPie"></canvas>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition">
            <h3 class="text-lg font-semibold mb-4">Số đơn hàng theo tháng</h3>
            <canvas id="orderChart" height="90"></canvas>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Đơn hàng hôm nay</h2>
                <a href="{{route('admin.order')}}" class="text-[#7cc652] text-sm font-medium hover:underline">Xem tất cả</a>
            </div>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-sm uppercase">
                        <th class="py-3 px-4 rounded-l-lg">Mã đơn</th>
                        <th class="py-3 px-4">Khách hàng</th>
                        <th class="py-3 px-4">Ngày đặt</th>
                        <th class="py-3 px-4">Tổng tiền</th>
                        <th class="py-3 px-4 rounded-r-lg">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($ordersToday->isEmpty())
                        <tr>
                            <td colspan="5" class="py-4 px-4 text-center text-gray-500">Không có đơn hàng hôm nay.</td>
                        </tr>
                    @else
                        @foreach ($ordersToday as $order)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="py-3 px-4 font-medium">{{ $order->order_code }}</td>
                                <td class="py-3 px-4">{{ $order->user->name ?? ($order->customer_name ?? '-') }}</td>
                                <td class="py-3 px-4">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-3 px-4 text-[#7cc652] font-semibold">
                                    {{ number_format($order->total_amount ?? ($order->total_price ?? 0), 0, ',', '.') }}₫
                                </td>
                                @if ($order->status == 'pending')
                                    <td class="py-3 px-4"><span
                                            class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">{{ $order->status }}</span>
                                    </td>
                                @elseif ($order->status == 'paid')
                                    <td class="py-3 px-4"><span
                                            class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">{{ $order->status }}</span>
                                    </td>
                                @elseif ($order->status == 'processing')
                                    <td class="py-3 px-4"><span
                                            class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">{{ $order->status }}</span>
                                    </td>
                                @else
                                    <td class="py-3 px-4"><span
                                            class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">{{ $order->status }}</span>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const monthLabels = ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6', 'Th7', 'Th8', 'Th9', 'Th10', 'Th11', 'Th12'];

        const revenueData = {!! json_encode($monthlyRevenue ?? array_fill(0, 12, 0)) !!};
        const ordersData = {!! json_encode($monthlyOrders ?? array_fill(0, 12, 0)) !!};
        const productLabels = {!! json_encode($productLabels ?? []) !!};
        const productValues = {!! json_encode($productValues ?? []) !!};

        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctxRevenue, {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Doanh thu (₫)',
                    data: revenueData,
                    borderColor: '#7cc652',
                    backgroundColor: 'rgba(124,198,82,0.12)',
                    fill: true,
                    tension: 0.3,
                    borderWidth: 2,
                    pointRadius: 3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            callback: function(value) {
                                return value ? value.toLocaleString() + '₫' : '0₫';
                            }
                        },
                        grid: {
                            color: '#f0f0f0'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        const ctxOrder = document.getElementById('orderChart').getContext('2d');
        new Chart(ctxOrder, {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Số đơn hàng',
                    data: ordersData,
                    backgroundColor: 'rgba(124,198,82,0.6)',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        grid: {
                            color: '#f0f0f0'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        const ctxPie = document.getElementById('productPie').getContext('2d');
        new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: productLabels,
                datasets: [{
                    data: productValues,
                    backgroundColor: ['#7cc652', '#a3d977', '#c9f4a1', '#ddeed1', '#bfe7a6'],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 14,
                            color: '#444'
                        }
                    }
                }
            }
        });
    </script>
@endsection

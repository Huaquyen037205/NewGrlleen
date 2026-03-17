@extends('template.admin')

@section('admin')
    <div class="p-6 bg-gray-50 min-h-screen space-y-8">
        <div class="border-b pb-4">
            <h1 class="text-2xl font-bold text-gray-800">Quản lý đơn hàng</h1>
            <p class="text-sm text-gray-500 mt-1">Theo dõi, xử lý và quản lý các đơn hàng của hệ thống</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-lg shadow-sm flex justify-between items-center border">
                <div>
                    <p class="text-sm text-gray-500">Tổng đơn hàng</p>
                    <h2 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalOrders }}</h2>
                    <p class="text-xs text-green-600 mt-1">↑ 5.3%</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                    <i class="fa-solid fa-box"></i>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm flex justify-between items-center border">
                <div>
                    <p class="text-sm text-gray-500">Đơn hàng đã giao</p>
                    <h2 class="text-2xl font-bold text-gray-800 mt-1">{{ $completedOrders }}</h2>
                    <p class="text-xs text-green-600 mt-1">↑ 3.2%</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full text-green-600">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm flex justify-between items-center border">
                <div>
                    <p class="text-sm text-gray-500">Đơn hàng đang xử lý</p>
                    <h2 class="text-2xl font-bold text-gray-800 mt-1">{{ $pendingOrders }}</h2>
                    <p class="text-xs text-gray-500 mt-1">—</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full text-yellow-600">
                    <i class="fa-solid fa-spinner"></i>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm flex justify-between items-center border">
                <div>
                    <p class="text-sm text-gray-500">Đơn hàng bị hủy</p>
                    <h2 class="text-2xl font-bold text-gray-800 mt-1">{{ $cancelledOrders }}</h2>
                    <p class="text-xs text-red-600 mt-1">↓ 1.2%</p>
                </div>
                <div class="p-3 bg-red-100 rounded-full text-red-600">
                    <i class="fa-solid fa-xmark"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border">
            <div class="p-4 border-b flex flex-wrap gap-2 justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">Danh sách đơn hàng</h2>

                <div class="flex flex-wrap gap-2">
                    <input type="text" placeholder="Tìm kiếm..."
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-400">

                    <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <option value="">Tất cả trạng thái</option>
                        <option value="đang xử lý">Đang xử lý</option>
                        <option value="đã giao">Đã giao</option>
                        <option value="bị hủy">Bị hủy</option>
                    </select>
                    <button class="bg-green-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-green-600">Lọc</button>
                    <button class="border border-gray-300 text-sm px-4 py-2 rounded-lg hover:bg-gray-100">Reset</button>
                </div>
            </div>

            <table class="w-full text-left text-sm text-gray-700">
                <thead class="bg-gray-100 border-b text-gray-600">
                    <tr>
                        <th class="px-6 py-3">Mã đơn</th>
                        <th class="px-6 py-3">Khách hàng</th>
                        <th class="px-6 py-3">Tổng tiền</th>
                        <th class="px-6 py-3">Trạng thái</th>
                        <th class="px-6 py-3">Ngày tạo</th>
                        <th class="px-6 py-3">Last Update</th>
                        <th class="px-6 py-3 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($orders->isEmpty())
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">Không có đơn hàng nào.</td>
                        </tr>
                    @else
                        @foreach ($orders as $order)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium">{{ $order->order_code }}</td>
                                <td class="px-6 py-4">{{ $order->user->name }}</td>
                                <td class="px-6 py-4">{{ number_format($order->total_amount) }}₫</td>
                                @if ($order->status == 'paid')
                                    <td class="px-6 py-4"><span
                                            class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">Đã
                                            giao</span>
                                    </td>
                                @elseif ($order->status == 'processing')
                                    <td class="px-6 py-4"><span
                                            class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">Đang
                                            vận chuyển</span></td>
                                @elseif ($order->status == 'pending')
                                    <td class="px-6 py-4"><span
                                            class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">Đang xử
                                            lý</span></td>
                                @else
                                    <td class="px-6 py-4"><span
                                            class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">Bị hủy</span>
                                    </td>
                                @endif

                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($order->update_at)->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-center relative">
                                    <button class="p-2 hover:bg-gray-100 rounded-lg transition toggle-menu-btn">
                                        <i class="fa-solid fa-ellipsis-vertical text-gray-600"></i>
                                    </button>
                                    <div
                                        class="action-menu absolute right-2 top-10 w-40 bg-white border rounded-lg shadow-lg hidden z-20">
                                        <ul class="text-sm text-gray-700">
                                            <li>
                                                <a href="{{ route('admin.orderDetail', ['id' => $order->id]) }}"
                                                    class="view-detail-btn flex items-center gap-2 px-3 py-2 hover:bg-gray-100 w-full text-left">
                                                    <i class="fa-solid fa-eye"></i> Xem chi tiết
                                                </a>
                                            </li>
                                            <li>
                                                <button type="button"
                                                    class="flex items-center gap-2 w-full text-left px-3 py-2 text-red-600 hover:bg-gray-100">
                                                    <i class="fa-solid fa-xmark"></i> Hủy đơn
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.querySelectorAll('.toggle-menu-btn').forEach(btn => {
            btn.addEventListener('click', e => {
                const menu = btn.nextElementSibling;
                document.querySelectorAll('.action-menu').forEach(m => m.classList.add('hidden'));
                menu.classList.toggle('hidden');
                e.stopPropagation();
            });
        });

        document.addEventListener('click', () => {
            document.querySelectorAll('.action-menu').forEach(m => m.classList.add('hidden'));
        });
    </script>
@endsection

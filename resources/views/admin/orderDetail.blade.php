@extends('template.admin')

@section('admin')
    <div class="p-6 bg-gray-50 min-h-screen space-y-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Chi tiết đơn hàng</h1>
            <p class="text-sm text-gray-500 mt-1">Xem thông tin khách hàng và các sản phẩm thuộc đơn hàng</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h2 class="font-semibold text-lg text-gray-800 mb-4">Thông tin khách hàng</h2>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p><span class="font-medium">Họ tên:</span> {{ $order->user->name ?? 'N/A' }}</p>
                        <p><span class="font-medium">Email:</span> {{ $order->user->email ?? 'N/A' }}</p>
                        <p><span class="font-medium">Số điện thoại:</span> {{ $order->user->phone ?? 'N/A' }}</p>
                        <p><span class="font-medium">Địa chỉ:</span> {{ $order->address->address ?? 'N/A' }}</p>
                        <p><span class="font-medium">Phương thức thanh toán:</span> {{ $order->payment->method ?? 'COD' }}
                        </p>
                    </div>
                </div>

                <div>
                    <h2 class="font-semibold text-lg text-gray-800 mb-4">Thông tin đơn hàng</h2>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p><span class="font-medium">Mã đơn:</span> {{ $order->order_code }}</p>
                        <p><span class="font-medium">Trạng thái:</span>
                            <span
                                class="
                            px-3 py-1 rounded-full text-xs font-semibold
                            @if ($order->status === 'pending') bg-yellow-100 text-yellow-700
                            @elseif($order->status === 'processing') bg-blue-100 text-blue-700
                            @elseif($order->status === 'paid') bg-green-100 text-green-700
                            @elseif($order->status === 'cancelled') bg-red-100 text-red-700 @endif
                        ">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                        <p><span class="font-medium">Tổng tiền:</span>
                            {{ number_format($order->total_amount, 0, ',', '.') }}₫</p>
                        <p><span class="font-medium">Ngày tạo:</span> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                        <p><span class="font-medium">Cập nhật:</span> {{ $order->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @if (session('success'))
            <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 border border-green-200">
                <strong class="font-semibold">Thành công: </strong>{{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 border border-red-200">
                <strong class="font-semibold">Lỗi: </strong>{{ session('error') }}
            </div>
        @endif

        @if (session('info'))
            <div class="mb-4 p-4 rounded-lg bg-blue-100 text-blue-800 border border-blue-200">
                <strong class="font-semibold">Thông báo: </strong>{{ session('info') }}
            </div>
        @endif
        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="mt-4" onsubmit="return confirmStatusChange()">
            @csrf
            @method('PUT')
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Cập nhật trạng thái:</label>
            <div class="flex items-center gap-3">
                <select name="status" id="status"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-400 focus:border-green-400">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Đang xử lý</option>
                    <option value="processing"{{ $order->status === 'processing' ? 'selected' : '' }}>Đang vận chuyển</option>
                    <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Hoàn thành</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                </select>

                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-lg transition">
                    Cập nhật
                </button>
            </div>
        </form>
        <script>
            function confirmStatusChange() {
                const select = document.getElementById('status');
                const selectedText = select.options[select.selectedIndex].text;

                return confirm(`Bạn có chắc muốn chuyển trạng thái đơn hàng sang "${selectedText}" không?`);
            }
        </script>
        <div class="bg-white p-6 rounded-xl shadow-sm border">
            <h2 class="font-semibold text-lg text-gray-800 mb-4">Sản phẩm trong đơn hàng</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left border">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Sản phẩm</th>
                            <th class="px-6 py-3">Size</th>
                            <th class="px-6 py-3">Giá</th>
                            <th class="px-6 py-3">Số lượng</th>
                            <th class="px-6 py-3">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($order->orderItems as $item)
                            <tr class="border-t hover:bg-gray-50 transition">
                                <td class="px-6 py-4 flex items-center gap-3">
                                    <img src="{{ optional($item->variant)->image_url ?? asset('img/default.jpg') }}" alt="Product Image"
                                        class="w-12 h-12 rounded-lg border object-cover">
                                    <span class="font-medium">{{ $item->variant->products->name ?? 'Sản phẩm' }}</span>
                                </td>
                                <td class="px-6 py-4 text-gray-500">
                                    {{ $item->variant->size ?? '-' }}
                                </td>
                                <td class="px-6 py-4">{{ number_format($item->price, 0, ',', '.') }}₫</td>
                                <td class="px-6 py-4">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 font-medium">
                                    {{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end mt-6 text-right">
                <p class="text-lg font-semibold text-gray-800">
                    Tổng cộng:
                    <span class="text-green-600">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
                </p>
            </div>
        </div>
        <div class="mt-6 text-right">
            <a href="{{ route('admin.order') }}"
                class="inline-block bg-green-500 hover:bg-green-600 text-white text-sm font-medium px-5 py-2 rounded-lg">
                ← Quay lại danh sách
            </a>
        </div>
    </div>
@endsection

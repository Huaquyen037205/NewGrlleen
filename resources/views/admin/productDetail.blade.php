@extends('template.admin')

@section('admin')
    <div class="p-6 bg-gray-50 min-h-screen space-y-6">
        <div>
            <h1 class="text-2xl font-bold mb-1">Chi tiết sản phẩm</h1>
            <p class="text-sm text-gray-500">Quản lý biến thể sản phẩm, thêm, sửa, cập nhật thông tin sản phẩm</p>
            <nav class="text-sm text-gray-400 mt-1">
                <a href="#" class="hover:text-indigo-600">Biến thể</a> /
                <span class="text-gray-600">Chi tiết sản phẩm</span>
            </nav>
        </div>

        <!-- THỐNG KÊ -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Tổng số biến thể -->
            <div class="bg-white p-4 rounded-lg shadow-sm flex justify-between items-center border">
                <div>
                    <p class="text-sm text-gray-500">Tổng biến thể</p>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $variants->count() }}</h2>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fa-solid fa-layer-group text-blue-500 text-xl"></i>
                </div>
            </div>

            <!-- Biến thể bán chạy nhất -->
            <div class="bg-white p-4 rounded-lg shadow-sm flex justify-between items-center border">
                <div>
                    <p class="text-sm text-gray-500">Biến thể hot nhất</p>
                    <h2 class="text-lg font-bold text-gray-800">
                        {{ $topVariant->size ?? 'Chưa có dữ liệu' }}
                    </h2>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fa-solid fa-fire text-yellow-500 text-xl"></i>
                </div>
            </div>

            <!-- Tổng tồn kho -->
            <div class="bg-white p-4 rounded-lg shadow-sm flex justify-between items-center border">
                <div>
                    <p class="text-sm text-gray-500">Tổng tồn kho</p>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $totalVariants }}</h2>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fa-solid fa-boxes-stacked text-green-500 text-xl"></i>
                </div>
            </div>

            <!-- Biến thể hết hàng -->
            <div class="bg-white p-4 rounded-lg shadow-sm flex justify-between items-center border">
                <div>
                    <p class="text-sm text-gray-500">Hết hàng</p>
                    <h2 class="text-2xl font-bold text-red-600">{{ $outOfStockCount }}</h2>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <i class="fa-solid fa-triangle-exclamation text-red-500 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="flex justify-end mb-4">
            <button id="btn-show-form" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                + Thêm biến thể
            </button>
        </div>

        <form id="variant-form" action="{{ route('variants.store') }}" method="POST"
            class="hidden mt-4 bg-gray-100 p-6 rounded-xl shadow space-y-4">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="size" class="block text-sm font-medium text-gray-700">Kích thước</label>
                    <input type="text" id="size" name="size"
                        class="w-full border-gray-300 rounded-lg mt-1 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Giá</label>
                    <input type="text" id="price" name="price"
                        class="w-full border-gray-300 rounded-lg mt-1 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>

                <div>
                    <label for="" class="block text-sm font-medium text-gray-700">Số lượng</label>
                    <input type="number" id="stock_quantity" name="stock_quantity"
                        class="w-full border-gray-300 rounded-lg mt-1 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>

                <div>
                    <label for="sale_price" class="block text-sm font-medium text-gray-700">Giá khuyến mãi ( nếu có
                        )</label>
                    <input type="text" id="sale_price" name="sale_price"
                        class="w-full border-gray-300 rounded-lg mt-1 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>

                <div>
                    <label for="active" class="block text-sm font-medium text-gray-700">Trạng thái hoạt động</label>
                    <select id="active" name="active"
                        class="w-full border-gray-300 rounded-lg mt-1 px-3 py-2 bg-white focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        <option value="on">Đang bán</option>
                        <option value="off">Ngừng bán</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Tình trạng</label>
                    <select id="status" name="status"
                        class="w-full border-gray-300 rounded-lg mt-1 px-3 py-2 bg-white focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        <option value="còn hàng">Còn hàng</option>
                        <option value="hết hàng">Hết hàng</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="submit"
                        class="bg-green-500 text-white px-5 py-2 rounded-lg hover:bg-green-600 transition">Lưu</button>
                    <button type="button" id="btn-cancel"
                        class="bg-gray-400 text-white px-5 py-2 rounded-lg hover:bg-gray-500 transition">Hủy</button>
                </div>
            </div>
        </form>
        <!-- BẢNG & CHI TIẾT -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- BẢNG BIẾN THỂ -->
            <div class="bg-white rounded-xl shadow-md p-6 border">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Danh sách biến thể</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                            <tr class="text-center">
                                <th class="px-4 py-3">STT</th>
                                <th class="px-4 py-3">Size</th>
                                <th class="px-4 py-3">Giá</th>
                                <th class="px-4 py-3">Số lượng</th>
                                <th class="px-4 py-3">Trạng thái</th>
                                <th class="px-4 py-3">Tình trạng</th>
                                <th class="px-4 py-3">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 divide-y divide-gray-200">
                            @if ($variants->isEmpty())
                                <tr>
                                    <td colspan="7"
                                        class="px-4 py-12 text-center text-gray-400 text-base font-medium align-middle">
                                        Không có biến thể nào
                                    </td>
                                </tr>
                            @else
                                @foreach ($variants as $variant)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-center font-medium">{{ $variant->size }}</td>
                                        <td class="px-4 py-3 text-center">{{ number_format($variant->price) }}₫</td>
                                        <td class="px-4 py-3 text-center">{{ $variant->stock_quantity }}</td>
                                        <td class="px-4 py-3 text-center">
                                            @if ($variant->status == 'còn hàng')
                                                <span class="text-green-600 font-medium">Còn hàng</span>
                                            @else
                                                <span class="text-red-600 font-medium">Hết hàng</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            @if ($variant->active == 'on')
                                                <span class="text-green-600 font-medium">Đang bán</span>
                                            @else
                                                <span class="text-red-600 font-medium">Ngừng bán</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <button
                                                class="btn-edit-variant p-2 hover:bg-gray-100 rounded-lg transition toggle-menu-btn"
                                                title="Tùy chọn" data-variant-id="{{ $variant->id }}"
                                                data-size="{{ $variant->size }}" data-price="{{ $variant->price }}"
                                                data-sale-price="{{ $variant->sale_price }}"
                                                data-stock-quantity="{{ $variant->stock_quantity }}"
                                                data-status="{{ $variant->status }}"
                                                data-active="{{ $variant->active }}">
                                                <i class="fa-solid fa-pen-to-square text-gray-600"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- CHI TIẾT SẢN PHẨM -->
            <div class="bg-white rounded-xl shadow-md p-6 border">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Chi tiết sản phẩm</h2>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tên sản phẩm:</span>
                        <span class="font-medium text-gray-800">{{ $product->name }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">Danh mục:</span>
                        <span class="font-medium">{{ $product->category->name ?? 'Không có' }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">Xuất xứ:</span>
                        <span class="font-medium">{{ $product->origin ?? 'Không rõ' }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">Trạng thái:</span>
                        <span
                            class="font-medium {{ $product->status == 'còn hàng' ? 'text-green-600' : 'text-red-600' }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">Tình trạng bán:</span>
                        <span
                            class="font-medium {{ $product->active == 'đang bán' ? 'text-blue-600' : 'text-gray-600' }}">
                            {{ ucfirst($product->active) }}
                        </span>
                    </div>

                    <div>
                        <span class="block text-gray-500 mb-1">Mô tả:</span>
                        <p class="p-3 rounded bg-gray-50 text-gray-700 border">
                            {{ $product->description ?? 'Chưa có mô tả' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- QUAY LẠI -->
        <div class="mt-6 text-right">
            <a href="{{ route('admin.products.list') }}"
                class="inline-block bg-green-500 hover:bg-green-600 text-white text-sm font-medium px-5 py-2 rounded-lg">
                ← Quay lại danh sách
            </a>
        </div>

        <div id="editVariantModal"
            class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Chỉnh sửa biến thể</h2>

                <form id="editVariantForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="variant_id" id="edit_variant_id">

                    <div class="mb-3">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Kích thước</label>
                        <input type="text" id="edit_size" name="size"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div class="mb-3">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Giá</label>
                        <input type="text" id="edit_price" name="price"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div class="mb-3">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Giá khuyến mãi</label>
                        <input type="text" id="edit_sale_price" name="sale_price"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div class="mb-3">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Số Lượng</label>
                        <input type="text" id="edit_stock_quantity" name="stock_quantity"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div class="mb-3">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Trạng thái</label>
                        <select id="edit_active" name="active"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500">
                            <option value="on">Đang bán</option>
                            <option value="off">Ngừng bán</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Tình trạng</label>
                        <select id="edit_status" name="status"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500">
                            <option value="còn hàng">Còn hàng</option>
                            <option value="hết hàng">Hết hàng</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-2 mt-5">
                        <button type="button" id="cancelEditVariant"
                            class="px-4 py-2 border rounded-lg hover:bg-gray-100 transition">Hủy</button>
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">Lưu thay
                            đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btnShow = document.getElementById('btn-show-form');
            const btnCancel = document.getElementById('btn-cancel');
            const form = document.getElementById('variant-form');

            btnShow.addEventListener('click', () => {
                form.classList.remove('hidden');
                btnShow.classList.add('hidden');
            });

            btnCancel.addEventListener('click', () => {
                form.classList.add('hidden');
                btnShow.classList.remove('hidden');
                form.reset();
            });
        });

        document.querySelectorAll('.btn-edit-variant').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.variantId;
                const form = document.getElementById('editVariantForm');

                form.action = `/admin/edit/variant/${id}`;

                document.getElementById('edit_variant_id').value = this.dataset.variantId;
                document.getElementById('edit_size').value = this.dataset.size;
                document.getElementById('edit_price').value = this.dataset.price;
                document.getElementById('edit_sale_price').value = this.dataset.salePrice;
                document.getElementById('edit_stock_quantity').value = this.dataset.stockQuantity;
                document.getElementById('edit_status').value = this.dataset.status;
                document.getElementById('edit_active').value = this.dataset.active;

                document.getElementById('editVariantModal').classList.remove('hidden');
            });
        });

        document.getElementById('cancelEditVariant').addEventListener('click', function() {
            document.getElementById('editVariantModal').classList.add('hidden');
        });

        document.getElementById('editVariantModal').addEventListener('click', function(e) {
            if (e.target === this) this.classList.add('hidden');
        });
    </script>
@endsection

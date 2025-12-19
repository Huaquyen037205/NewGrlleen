@extends('template.admin')
@section('admin')
    <div class="bg-gray-50 text-gray-800">
        <div class="p-6 space-y-6">
            <!-- Header -->
            <div>
                <h1 class="text-2xl font-bold mb-1">Quản lý sản phẩm</h1>
                <p class="text-sm text-gray-500">Quản lý thông tin sản phẩm, danh mục và trạng thái hiển thị</p>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-lg shadow-sm flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Tổng sản phẩm</p>
                        <h2 class="text-2xl font-bold">{{ $totalProducts }}</h2>
                        <p class="text-green-600 text-sm mt-1">↑ 5.6%</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fa-solid fa-box text-purple-500 text-xl"></i>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-sm flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Đang bán</p>
                        <h2 class="text-2xl font-bold">{{ $activeProducts }}</h2>
                        <p class="text-green-600 text-sm mt-1">↑ 3.2%</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fa-solid fa-check text-green-500 text-xl"></i>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-sm flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Hết hàng</p>
                        <h2 class="text-2xl font-bold">{{ $outOfStock }}</h2>
                        <p class="text-red-600 text-sm mt-1">↓ 2.4%</p>
                    </div>
                    <div class="bg-red-100 p-3 rounded-full">
                        <i class="fa-solid fa-xmark text-red-500 text-xl"></i>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-sm flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Sản phẩm mới</p>
                        <h2 class="text-2xl font-bold">{{ $newProducts }}</h2>
                        <p class="text-gray-600 text-sm mt-1">0%</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fa-solid fa-plus text-blue-500 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Product List -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <!-- Header -->
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-lg font-semibold">Danh sách sản phẩm</h2>
                    <div class="flex gap-2">
                        <button id="openModalBtn"
                            class="bg-green-500 text-white px-4 py-2 text-sm rounded-lg hover:bg-green-600">+ Thêm
                            sản phẩm
                        </button>
                    </div>
                </div>

                <!-- Filters -->
                <div class="flex flex-wrap items-center gap-3 mb-6">
                    <form action="{{ route('admin.product.search') }}" method="GET">
                        <input id="productSearchInput" type="text" name="q" placeholder="Tìm kiếm..."
                            value="{{ $q ?? '' }}" autocomplete="off"
                            class="border border-gray-300 rounded-lg px-3 py-2 text-sm flex-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                    </form>

                    <form action="{{ route('admin.products.list') }}" method="GET" class="flex gap-2">
                        <select name="category_id"
                            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-400">
                            <option value="">Tất cả danh mục</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ isset($categoryId) && $categoryId == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <select name="status"
                            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-400">
                            <option value="">Tất cả trạng thái</option>
                            <option value="còn hàng" {{ isset($status) && $status == 'còn hàng' ? 'selected' : '' }}>Còn
                                hàng</option>
                            <option value="hết hàng" {{ isset($status) && $status == 'hết hàng' ? 'selected' : '' }}>Hết
                                hàng</option>
                        </select>

                        <button type="submit"
                            class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-600">Lọc</button>

                        <a href="{{ route('admin.products.list') }}"
                            class="border border-gray-200 px-4 py-2 rounded-lg text-sm hover:bg-gray-50">Reset</a>
                    </form>
                </div>

                <!-- Table -->
                <div class="overflow-hidden rounded-lg border border-gray-200">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wide">
                            <tr>
                                <th class="px-4 py-3 font-medium">Ảnh</th>
                                <th class="px-4 py-3 font-medium">Tên sản phẩm</th>
                                <th class="px-4 py-3 font-medium">Danh mục</th>
                                <th class="px-4 py-3 font-medium">Xuất xứ</th>
                                <th class="px-4 py-3 font-medium text-center">Trạng thái</th>
                                <th class="px-4 py-3 font-medium text-center">Tình trạng</th>
                                <th class="px-4 py-3 font-medium text-center">Ngày thêm</th>
                                <th class="px-4 py-3 font-medium text-right">Hành động</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @foreach ($products as $product)
                                <tr class="hover:bg-gray-50 transition relative">
                                    <td class="px-4 py-3">
                                        @if ($product->images && $product->images->first())
                                            <div class="flex items-center justify-center">
                                                <img src="{{ asset('img/' . $product->images->first()->name) }}"
                                                    class="w-14 h-14 rounded-lg object-cover border border-gray-200 hover:scale-105 transition-transform">
                                            </div>
                                        @else
                                            <div class="flex items-center justify-center">
                                                <img src="{{ asset('images/no-image.png') }}" alt="No Image"
                                                    class="w-14 h-14 rounded-lg object-cover opacity-70 border border-gray-200">
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $product->name }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $product->category->name }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $product->origin }}</td>

                                    <td class="px-4 py-3 text-center">
                                        @if ($product->status === 'còn hàng')
                                            <span
                                                class="bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full font-medium">Còn
                                                hàng</span>
                                        @else
                                            <span
                                                class="bg-red-100 text-red-700 text-xs px-2.5 py-1 rounded-full font-medium">Hết
                                                hàng</span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        @if ($product->active === 'đang bán')
                                            <span
                                                class="bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full font-medium">Đang
                                                bán</span>
                                        @else
                                            <span
                                                class="bg-red-100 text-red-700 text-xs px-2.5 py-1 rounded-full font-medium">Ngừng
                                                bán</span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 text-gray-600 text-center">
                                        {{ $product->created_at->format('d/m/Y H:i') }}
                                    </td>

                                    <td class="px-4 py-3 text-right relative">
                                        <button class="p-2 hover:bg-gray-100 rounded-lg transition toggle-menu-btn">
                                            <i class="fa-solid fa-ellipsis-vertical text-gray-600"></i>
                                        </button>

                                        <div
                                            class="action-menu absolute right-2 top-10 w-40 bg-white border rounded-lg shadow-lg hidden z-20">
                                            <ul class="text-sm text-gray-700">
                                                <li>
                                                    <a href="{{ route('admin.productDetail', $product->id) }}"
                                                        class="flex items-center gap-2 px-3 py-2 hover:bg-gray-100">
                                                        <i class="fa-solid fa-eye"></i> Xem chi tiết
                                                    </a>
                                                </li>
                                                <li>
                                                    <button type="button"
                                                        class="edit-btn flex items-center gap-2 px-3 py-2 hover:bg-gray-100 w-full text-left"
                                                        data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                                        data-category="{{ $product->category_id }}"
                                                        data-description="{{ $product->description }}"
                                                        data-status="{{ $product->status }}"
                                                        data-active="{{ $product->active }}"
                                                        data-origin="{{ $product->origin }}">
                                                        <i class="fa-solid fa-pen-to-square"></i> Chỉnh sửa
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button"
                                                        class="flex items-center gap-2 w-full text-left px-3 py-2 text-red-600 hover:bg-gray-100">

                                                        <i class="fa-solid fa-eye-slash"></i> Ẩn sản phẩm
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $products->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="addProductModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative animate-fadeIn">
            <h2 class="text-lg font-semibold mb-4">Thêm sản phẩm mới</h2>

            <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                <!-- Tên sản phẩm -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tên sản phẩm</label>
                    <input type="text" name="name" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Xuất xứ</label>
                    <input type="file" name="images[]" multiple
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-400 focus:outline-none">
                </div>

                <!-- Danh mục -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Danh mục</label>
                    <select name="category_id" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-400 focus:outline-none">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Mô tả -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
                    <textarea name="description" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-400 focus:outline-none"></textarea>
                </div>

                <!-- Trạng thái -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tình trạng</label>
                    <select name="status"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-400 focus:outline-none">
                        <option value="còn hàng">Còn hàng</option>
                        <option value="hết hàng">Hết hàng</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                    <select name="active"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-400 focus:outline-none">
                        <option value="đang bán">Đang bán</option>
                        <option value="ngừng bán">Ngừng bán</option>
                    </select>
                </div>

                <!-- Xuất xứ -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Xuất xứ</label>
                    <input type="text" name="origin"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-400 focus:outline-none">
                </div>

                <!-- Nút hành động -->
                <div class="flex justify-end gap-3 pt-3">
                    <button type="button" id="closeModalBtn"
                        class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-100">Hủy</button>
                    <button type="submit"
                        class="px-4 py-2 text-sm bg-green-500 text-white rounded-lg hover:bg-green-600">Thêm</button>
                </div>
            </form>
        </div>
    </div>


    <div id="editProductModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative animate-fadeIn">
            <h2 class="text-lg font-semibold mb-4">Chỉnh sửa sản phẩm</h2>

            <form id="editProductForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Ảnh -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ảnh sản phẩm</label>
                    <input type="file" name="images[]" multiple
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>

                <!-- Tên sản phẩm -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tên sản phẩm</label>
                    <input type="text" name="name" id="editName" required
                        value="{{ old('name', $product->name) }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>

                <!-- Danh mục -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Danh mục</label>
                    <select name="category_id" id="editCategory" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
                    <input type="text" name="description" id="editDescription" required
                        value="{{ old('description', $product->description) }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>

                <!-- Trạng thái -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tình trạng (Còn hàng / Hết hàng)</label>
                    <select name="status" id="editStatus"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        <option value="còn hàng">Còn hàng</option>
                        <option value="hết hàng">Hết hàng</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Xuất xứ</label>
                    <input type="text" name="origin" id="editOrigin" required
                        value="{{ old('origin', $product->origin) }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>
                <!-- Tình trạng -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái (Đang bán / Ngừng bán)</label>
                    <select name="active" id="editActive"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        <option value="đang bán">Đang bán</option>
                        <option value="ngừng bán">Ngừng bán</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-3">
                    <button type="button" id="closeEditModalBtn"
                        class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-100">Hủy</button>
                    <button type="submit"
                        class="px-4 py-2 text-sm bg-green-500 text-white rounded-lg hover:bg-green-600">Lưu thay
                        đổi</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const addProductModal = document.getElementById('addProductModal');

        openModalBtn.addEventListener('click', () => {
            addProductModal.classList.remove('hidden');
        });

        closeModalBtn.addEventListener('click', () => {
            addProductModal.classList.add('hidden');
        });

        addProductModal.addEventListener('click', (e) => {
            if (e.target === addProductModal) {
                addProductModal.classList.add('hidden');
            }
        });

        document.addEventListener("DOMContentLoaded", () => {
            const buttons = document.querySelectorAll(".toggle-menu-btn");

            buttons.forEach((btn) => {
                btn.addEventListener("click", (e) => {
                    e.stopPropagation();
                    const menu = btn.parentElement.querySelector(".action-menu");
                    document.querySelectorAll(".action-menu").forEach(m => m.classList.add(
                        "hidden"));
                    menu.classList.toggle("hidden");
                });
            });

            document.addEventListener("click", () => {
                document.querySelectorAll(".action-menu").forEach(m => m.classList.add("hidden"));
            });
        });

        const editProductModal = document.getElementById('editProductModal');
        const closeEditModalBtn = document.getElementById('closeEditModalBtn');
        const editProductForm = document.getElementById('editProductForm');

        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const id = btn.dataset.id;
                const name = btn.dataset.name;
                const category = btn.dataset.category;
                const description = btn.dataset.description;
                const status = btn.dataset.status;
                const active = btn.dataset.active;
                const origin = btn.dataset.origin;
                // Điền dữ liệu vào form
                document.getElementById('editName').value = name;
                document.getElementById('editCategory').value = category;
                document.getElementById('editDescription').value = description;
                document.getElementById('editStatus').value = status;
                document.getElementById('editActive').value = active;
                document.getElementById('editOrigin').value = origin;

                editProductForm.action = `/admin/edit/product/${id}`;

                // Hiện modal
                editProductModal.classList.remove('hidden');
            });
        });

        closeEditModalBtn.addEventListener('click', () => {
            editProductModal.classList.add('hidden');
        });

        editProductModal.addEventListener('click', (e) => {
            if (e.target === editProductModal) {
                editProductModal.classList.add('hidden');
            }
        });


        const searchInput = document.getElementById('productSearchInput');
        let typingTimer;

        searchInput.addEventListener('keyup', () => {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                document.querySelector('form').submit();
            }, 500);
        });
    </script>
@endsection

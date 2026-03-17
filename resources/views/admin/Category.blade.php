@extends('template.admin')

@section('admin')
    <div class="p-6 bg-gray-50 min-h-screen space-y-8">
        <div class="border-b pb-4">
            <h1 class="text-2xl font-bold text-gray-800">Quản lý danh mục</h1>
            <p class="text-sm text-gray-500 mt-1">Theo dõi, chỉnh sửa và thêm danh mục sản phẩm</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white p-5 rounded-xl shadow-sm border flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Tổng danh mục</p>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $totalCategories }}</h2>
                </div>
                <span class="bg-purple-100 text-purple-500 p-3 rounded-full">
                    <i class="fa-solid fa-layer-group"></i>
                </span>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Đang hoạt động</p>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $activeCategories }}</h2>
                </div>
                <span class="bg-green-100 text-green-500 p-3 rounded-full">
                    <i class="fa-solid fa-circle-check"></i>
                </span>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Đang ẩn</p>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $hiddenCategories }}</h2>
                </div>
                <span class="bg-red-100 text-red-500 p-3 rounded-full">
                    <i class="fa-solid fa-eye-slash"></i>
                </span>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Danh mục mới</p>
                    <h2 class="text-2xl font-bold text-gray-800">+{{ $newCategories ?? 0 }}</h2>
                </div>
                <span class="bg-blue-100 text-blue-500 p-3 rounded-full">
                    <i class="fa-solid fa-plus"></i>
                </span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
                <h2 class="text-lg font-semibold text-gray-800">Danh sách danh mục</h2>
                <button type="button" onclick="openAddModal()"
                    class="bg-green-500 text-white px-5 py-2.5 rounded-lg text-sm font-medium shadow hover:bg-green-600 transition">
                    + Thêm danh mục
                </button>
            </div>

            <div class="mb-6">
                <form action="" method="GET" class="flex flex-wrap items-center gap-3">
                    <input type="text" name="q" placeholder="Tìm kiếm..." value="{{ $q ?? '' }}"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-400 w-48">

                    <select name="status"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-400 w-44">
                        <option value="">Tất cả trạng thái</option>
                        <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="inactive" {{ $status == 'active' ? 'selected' : '' }}>Ẩn</option>
                    </select>

                    <button type="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-600 transition">Lọc</button>
                    <a href="{{ route('admin.category.list') }}"
                        class="border border-gray-300 px-4 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition">Reset</a>
                </form>
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-100">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-5 py-3">Tên danh mục</th>
                            <th class="px-5 py-3">Số sản phẩm</th>
                            <th class="px-5 py-3">Ngày tạo</th>
                            <th class="px-5 py-3">Trạng thái</th>
                            <th class="px-5 py-3 text-right">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-5 py-3 font-medium text-gray-800">{{ $category->name }}</td>
                                <td class="px-5 py-3">{{ $category->products_count ?? 0 }}</td>
                                <td class="px-5 py-3">{{ $category->created_at->format('d/m/Y') }}</td>
                                @if ($category->status == 'active')
                                    <td class="px-5 py-3">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $category->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-green-200 text-green-600' }}">
                                            {{ ucfirst($category->status) }}
                                        </span>
                                    </td>
                                @else
                                    <td class="px-5 py-3">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $category->status == 'inactive' ? 'bg-red-100 text-red-700' : 'bg-red-200 text-red-600' }}">
                                            {{ ucfirst($category->status) }}
                                        </span>
                                    </td>
                                @endif
                                <td class="px-5 py-3 text-right space-x-2">
                                    <button type="button"
                                        onclick="openEditModal({{ $category->id }}, '{{ $category->name }}')"
                                        class="text-blue-500 hover:underline font-medium">
                                        Sửa
                                    </button>

                                    <form action="{{ route('admin.category.status', $category->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @if ($category->status === 'active')
                                            <button type="submit" class="text-red-500 hover:underline font-medium"
                                                onclick="return confirm('Xác nhận ẩn danh mục này?')">Ẩn</button>
                                        @else
                                            <button type="submit" class="text-green-500 hover:underline font-medium"
                                                onclick="return confirm('Xác nhận hiển thị lại danh mục này?')">Hiển
                                                thị</button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-500 text-sm">Không có danh mục nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">
                {{ $categories->links() }}
            </div>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Chỉnh sửa danh mục</h2>

            <form id="editCategoryForm" method="POST" action="">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tên danh mục</label>
                    <input type="text" id="editCategoryName" name="name"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-400"
                        required>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 text-gray-600 border rounded-lg hover:bg-gray-50 transition">
                        Hủy
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="addModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Thêm danh mục mới</h2>

            <form id="addCategoryForm" method="POST" action="{{ route('admin.category.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tên danh mục</label>
                    <input type="text" id="addCategoryName" name="name"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-400"
                        placeholder="Nhập tên danh mục..." required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                    <select name="status"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-400">
                        <option value="active">Hoạt động</option>
                        <option value="inactive">Ẩn</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeAddModal()"
                        class="px-4 py-2 text-gray-600 border rounded-lg hover:bg-gray-50 transition">
                        Hủy
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                        Thêm mới
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function openEditModal(id, name) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editCategoryForm');
            const nameInput = document.getElementById('editCategoryName');

            nameInput.value = name;
            form.action = `/admin/edit/category/${id}`;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function openAddModal() {
            const modal = document.getElementById('addModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeAddModal() {
            const modal = document.getElementById('addModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
@endsection

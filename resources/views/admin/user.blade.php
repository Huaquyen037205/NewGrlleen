@extends('template.admin')
@section('admin')
    <div class="bg-gray-50 text-gray-800">
        <div class="p-6 space-y-6">
            <div>
                <h1 class="text-2xl font-bold mb-1">Quản lý người dùng</h1>
                <p class="text-sm text-gray-500">Quản lý người dùng hệ thống, vai trò, quyền và kiểm soát truy cập</p>
                <nav class="text-sm text-gray-400 mt-1">
                    <a href="#" class="hover:text-indigo-600">Báo cáo, thống kê</a> /
                    <span class="text-gray-600">Người Dùng</span>
                </nav>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Tổng người dùng</p>
                            <h2 class="text-2xl font-semibold mt-1">{{ $totalUsers ?? 0 }}</h2>
                            <p class="text-green-500 text-sm mt-1">↑ 12.5%</p>
                        </div>
                        <div class="bg-indigo-100 text-indigo-600 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a4 4 0 00-3-3.87M9 12a5 5 0 110-10 5 5 0 010 10z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Tài khoản đang kích hoạt</p>
                            <h2 class="text-2xl font-semibold mt-1">{{ $activeUsers ?? 0 }}</h2>
                            <p class="text-green-500 text-sm mt-1">↑ 8.2%</p>
                        </div>
                        <div class="bg-green-100 text-green-600 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Người dùng mới</p>
                            <h2 class="text-2xl font-semibold mt-1">{{ $newUsers ?? 0 }}</h2>
                            <p class="text-gray-400 text-sm mt-1">— 0%</p>
                        </div>
                        <div class="bg-cyan-100 text-cyan-600 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Tài khoản đã khóa</p>
                            <h2 class="text-2xl font-semibold mt-1">{{ $inactiveUsers ?? 0 }}</h2>
                            <p class="text-red-500 text-sm mt-1">↓ 4.3%</p>
                        </div>
                        <div class="bg-red-100 text-red-600 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364 5.636l-12.728 12.728M5.636 5.636l12.728 12.728" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
                    <h2 class="font-semibold text-lg">Danh sách người dùng</h2>
                    <div class="flex items-center space-x-2">
                        <button class="border rounded-lg px-3 py-2 text-sm hover:bg-gray-100">Export</button>
                        <button id="openModalBtn"
                            class="bg-green-500 text-white px-4 py-2 text-sm rounded-lg hover:bg-green-600">+ Thêm
                            người dùng
                        </button>

                        <div id="addUserModal"
                            class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
                            <div class="bg-white rounded-xl w-96 shadow-lg p-6 relative">
                                <button id="closeModalBtn"
                                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-xl">
                                    ×
                                </button>

                                <h2 class="text-lg font-semibold mb-4 text-gray-800">Thêm người dùng mới</h2>

                                <form id="addUserForm" method="POST" action="">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-gray-600 mb-1">Tên</label>
                                        <input type="text" name="name" required
                                            class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 outline-none" />
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                                        <input type="email" name="email" required
                                            class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 outline-none" />
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-gray-600 mb-1">Số điện thoại</label>
                                        <input type="text" name="phone"
                                            class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 outline-none" />
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-600 mb-1">Vai trò</label>
                                        <select name="role"
                                            class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                                            <option value="user">User</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>

                                    <div class="flex justify-end space-x-2">
                                        <button type="button" id="cancelModalBtn"
                                            class="px-4 py-2 text-sm border rounded-lg hover:bg-gray-100">Hủy</button>
                                        <button type="submit"
                                            class="px-4 py-2 text-sm bg-[#7cc652] text-white rounded-lg hover:bg-[#6bb244]">Lưu</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 mb-4">
                    <input type="text" placeholder="Tìm kiếm..."
                        class="border rounded-lg px-3 py-2 text-sm w-full sm:w-60 focus:outline-none focus:ring-2 focus:ring-indigo-500" />

                    <form method="GET" action="{{ route('admin.user') }}">
                        <select name="role"
                            class="border rounded-lg px-3 py-2 text-sm w-full sm:w-40 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Tất cả vai trò</option>
                            @foreach ($roles as $r)
                                <option value="{{ $r }}" {{ isset($role) && $role == $r ? 'selected' : '' }}>
                                    {{ $r }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="px-3 py-2 bg-[#7cc652] text-white rounded">Lọc</button>

                        <select name="status"
                            class="border rounded-lg px-3 py-2 text-sm w-full sm:w-40 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Tất cả trạng thái</option>
                            @foreach ($statuses as $s)
                                <option value="{{ $s }}"
                                    {{ isset($status) && $status == $s ? 'selected' : '' }}>
                                    {{ ucfirst($s) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="px-3 py-2 bg-[#7cc652] text-white rounded">Lọc</button>
                    </form>
                    <button class="border rounded-lg px-3 py-2 text-sm hover:bg-gray-100 flex items-center">
                        ⟳ Reset
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border-t text-sm">
                        <thead>
                            <tr class="text-gray-500 text-left border-b">
                                <th class="py-3 px-4">Tên</th>
                                <th class="py-3 px-4">Email</th>
                                <th class="py-3 px-4">Vai trò</th>
                                <th class="py-3 px-4">Trạng thái</th>
                                <th class="py-3 px-4">Ngày tạo</th>
                                <th class="py-3 px-4">Last Active</th>
                                <th class="py-3 px-4">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-b hover:bg-gray-50">

                                    <td class="py-3 px-4 flex items-center gap-3">
                                        <div
                                            class="bg-indigo-100 text-indigo-600 font-semibold rounded-full h-10 w-10 flex items-center justify-center">
                                            TW</div>
                                        <div>
                                            <p class="font-medium">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-400">
                                                {{ '@' . strtolower(str_replace(' ', '', $user->name)) }}</p>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">{{ $user->email }}</td>
                                    @if ($user->role === 'admin')
                                        <td class="py-3 px-4"><span
                                                class="bg-red-100 px-2 py-1 rounded text-red-700 text-xs">{{ $user->role }}</span>
                                        </td>
                                    @elseif ($user->role === 'user')
                                        <td class="py-3 px-4"><span
                                                class="bg-blue-100 px-2 py-1 rounded text-blue-700 text-xs">{{ $user->role }}</span>
                                        </td>
                                    @endif

                                    @if ($user->is_active === 'active')
                                        <td class="py-3 px-4"><span
                                                class="bg-green-100 px-2 py-1 rounded text-green-700 text-xs">{{ $user->is_active }}</span>
                                        </td>
                                    @elseif ($user->is_active === 'inactive')
                                        <td class="py-3 px-4"><span
                                                class="bg-red-100 px-2 py-1 rounded text-red-700 text-xs">{{ $user->is_active }}</span>
                                        </td>
                                    @endif
                                    <td class="py-3 px-4">
                                        {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i') }}</td>
                                    <td class="py-3 px-4 text-gray-500">1 month ago</td>
                                    <td class="py-3 px-4 text-right">
                                        <button class="action-btn border rounded-md px-2 py-1 hover:bg-gray-100">
                                            ⋮
                                        </button>

                                        <!-- Dropdown Menu -->
                                        <div
                                            class="action-menu absolute right-0 mt-2 w-32 bg-white border rounded-lg shadow-lg hidden z-10">
                                            <ul class="text-sm text-gray-700">
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center gap-2 px-3 py-2 hover:bg-gray-100">
                                                        <i class="fa-solid fa-eye"></i>Xem chi tiết
                                                    </a>
                                                </li>
                                                <li>
                                                    <button type="button"
                                                        class="flex items-center gap-2 px-3 py-2 hover:bg-gray-100 edit-role-btn"
                                                        data-id="{{ $user->id }}" data-role="{{ $user->role }}">
                                                        <i class="fa-solid fa-pen-to-square"></i>Chỉnh sửa
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button"
                                                        class="flex items-center gap-2 w-full text-left px-3 py-2 text-red-600 hover:bg-green-50 edit-status-btn"
                                                        data-id="{{ $user->id }}"
                                                        data-status="{{ $user->is_active }}">
                                                        <i class="fa-solid fa-eye-slash"></i>Ẩn người dùng
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div id="editUserModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
                        <div class="bg-white rounded-xl shadow-lg w-[420px] p-6 relative">
                            <button id="closeEditModal"
                                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-xl">×</button>
                            <h2 class="text-lg font-semibold mb-4">Chỉnh sửa vai trò người dùng</h2>

                            <form id="editUserForm" method="POST" action="#">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="user_id" id="modal_user_id">

                                <div class="mb-4">
                                    <label for="modal_role" class="block text-sm font-medium mb-1">Vai trò</label>
                                    <select name="role" id="modal_role"
                                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#7cc652] outline-none">
                                        <option value="user">Người dùng</option>
                                        <option value="admin">Quản trị viên</option>
                                    </select>
                                </div>

                                <div class="flex justify-end gap-3">
                                    <button type="button" id="modalCancel"
                                        class="px-4 py-2 border rounded-lg hover:bg-gray-100">Hủy</button>
                                    <button type="submit"
                                        class="px-4 py-2 bg-[#7cc652] text-white rounded-lg hover:bg-[#69b94a]">Lưu</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div id="editStatusModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
                        <div class="bg-white rounded-xl shadow-lg w-[420px] p-6 relative">
                            <button id="closeStatusModal"
                                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-xl">×</button>
                            <h2 class="text-lg font-semibold mb-4">Cập nhật trạng thái người dùng</h2>

                            <form id="editStatusForm" method="POST" action="#">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="user_id" id="status_user_id">

                                <div class="mb-4">
                                    <label for="modal_status" class="block text-sm font-medium mb-1">Trạng thái</label>
                                    <select name="is_active" id="modal_status"
                                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#7cc652] outline-none">
                                        <option value="active">Hoạt động</option>
                                        <option value="inactive">Không hoạt động</option>
                                    </select>
                                </div>

                                <div class="flex justify-end gap-3">
                                    <button type="button" id="cancelStatus"
                                        class="px-4 py-2 border rounded-lg hover:bg-gray-100">Hủy</button>
                                    <button type="submit"
                                        class="px-4 py-2 bg-[#7cc652] text-white rounded-lg hover:bg-[#69b94a]">Lưu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page">
        <div class="btn-page">
            @if ($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                {{ $users->links('pagination::bootstrap-4') }}
            @endif
        </div>
    </div>
    </section>

    <script>
        const modal = document.getElementById('addUserModal');
        const openBtn = document.getElementById('openModalBtn');
        const closeBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelModalBtn');

        openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
        closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
        cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));

        window.addEventListener('click', (e) => {
            if (e.target === modal) modal.classList.add('hidden');
        });

        document.addEventListener('DOMContentLoaded', () => {
            const actionButtons = document.querySelectorAll('.action-btn');

            actionButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.stopPropagation();

                    const menu = button.nextElementSibling;
                    document.querySelectorAll('.action-menu').forEach(m => {
                        if (m !== menu) m.classList.add('hidden');
                    });
                    menu.classList.toggle('hidden');
                });
            });

            window.addEventListener('click', () => {
                document.querySelectorAll('.action-menu').forEach(menu => menu.classList.add('hidden'));
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.getElementById('editUserModal');
            const closeBtn = document.getElementById('closeEditModal');
            const cancelBtn = document.getElementById('modalCancel');
            const form = document.getElementById('editUserForm');
            const roleSelect = document.getElementById('modal_role');
            const userIdInput = document.getElementById('modal_user_id');

            const editBaseUrl = "{{ url('admin/edit/role') }}";

            document.querySelectorAll('.edit-role-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;
                    const role = this.dataset.role ?? 'user';

                    form.action = `${editBaseUrl}/${id}`;
                    userIdInput.value = id;
                    roleSelect.value = role;

                    editModal.classList.remove('hidden');
                    editModal.classList.add('flex');
                });
            });

            function closeModal() {
                editModal.classList.add('hidden');
                editModal.classList.remove('flex');
            }

            closeBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);

            editModal.addEventListener('click', function(e) {
                if (e.target === editModal) closeModal();
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const statusModal = document.getElementById('editStatusModal');
            const closeStatusBtn = document.getElementById('closeStatusModal');
            const cancelStatusBtn = document.getElementById('cancelStatus');
            const formStatus = document.getElementById('editStatusForm');
            const statusSelect = document.getElementById('modal_status');
            const userIdStatus = document.getElementById('status_user_id');

            const baseStatusUrl = "{{ url('admin/edit/active') }}";

            document.querySelectorAll('.edit-status-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;
                    const status = this.dataset.status ?? 'inactive';

                    formStatus.action = `${baseStatusUrl}/${id}`;
                    userIdStatus.value = id;
                    statusSelect.value = status;

                    statusModal.classList.remove('hidden');
                    statusModal.classList.add('flex');
                });
            });

            function closeStatusModal() {
                statusModal.classList.add('hidden');
                statusModal.classList.remove('flex');
            }

            closeStatusBtn.addEventListener('click', closeStatusModal);
            cancelStatusBtn.addEventListener('click', closeStatusModal);

            statusModal.addEventListener('click', function(e) {
                if (e.target === statusModal) closeStatusModal();
            });
        });
    </script>
@endsection

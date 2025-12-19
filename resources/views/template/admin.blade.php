<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organic Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/5a06f65a96.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', sans - serif],
                    },

                    fontSize: {
                        base: '13px',
                        lg: '14px',
                    },
                },
            },
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans text-[14px] bg-[#f5f6f8] text-gray-800">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-[#222831] text-gray-200 flex flex-col justify-between p-6 shadow-xl fixed h-full">
            <div>
                {{-- <h1 class="text-2xl font-bold mb-10 tracking-wide">Concept<span class="text-[#7cc652]">+</span></h1> --}}
                <img style="margin: 20px 0px" src="/img/logo.webp" alt="">
                <nav class="space-y-3">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 p-3 rounded-xl font-medium
                {{ request()->routeIs('admin.dashboard')
                    ? 'bg-[#7cc652]/10 text-[#7cc652]'
                    : 'text-gray-300 hover:bg-[#7cc652]/10' }}">
                        <i class="fa-solid fa-file-lines"></i> Báo cáo, thống kê
                    </a>
                    <a href="{{route('admin.products.list')}}"
                      class="flex items-center gap-3 p-3 rounded-xl font-medium
                {{ request()->routeIs('admin.products.list*')
                    ? 'bg-[#7cc652]/10 text-[#7cc652]'
                    : 'text-gray-300 hover:bg-[#7cc652]/10' }}">
                        <span><i class="fa-solid fa-box-open"></i></span> Sản phẩm
                    </a>
                    <a href="{{ route('admin.user') }}"
                        class="flex items-center gap-3 p-3 rounded-xl font-medium
                {{ request()->routeIs('admin.user*') ? 'bg-[#7cc652]/10 text-[#7cc652]' : 'text-gray-300 hover:bg-[#7cc652]/10' }}">
                        <span><i class="fa-solid fa-users"></i></span> Người dùng
                    </a>
                    <a href="{{ route('admin.category.list') }}"
                        class="flex items-center gap-3 p-3 rounded-xl font-medium
                {{ request()->routeIs('admin.category.list*') ? 'bg-[#7cc652]/10 text-[#7cc652]' : 'text-gray-300 hover:bg-[#7cc652]/10' }}">
                        <span><i class="fa-solid fa-list"></i></span> Danh mục sản phẩm
                    </a>
                    <a href="{{ route('admin.order') }}"
                        class="flex items-center gap-3 p-3 rounded-xl font-medium
                {{ request()->routeIs('admin.order*') ? 'bg-[#7cc652]/10 text-[#7cc652]' : 'text-gray-300 hover:bg-[#7cc652]/10' }}">
                        <span><i class="fa-solid fa-boxes-stacked"></i></span> Đơn hàng
                    </a>
                </nav>
            </div>
            <p class="text-xs text-gray-500 text-center mt-8">© 2025 ReadTest</p>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="ml-64 p-8 min-h-screen w-full">
            <!-- Header -->
            <header class="flex justify-between items-center mb-8">
                <input type="text" placeholder="Tìm kiếm..."
                    class="px-4 py-2 w-80 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#7cc652] outline-none">
                <div class="flex items-center gap-4">
                    <button class="p-2 bg-gray-100 rounded-full hover:bg-gray-200">🔔</button>
                    <button class="p-2 bg-gray-100 rounded-full hover:bg-gray-200">📩</button>
                    <div
                        class="w-10 h-10 bg-[#7cc652] rounded-full flex items-center justify-center text-white font-bold shadow-sm">
                        JA</div>
                </div>
            </header>

            <!-- Stats -->
            @yield('admin')
        </main>
    </div>
</body>

</html>

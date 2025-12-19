@extends('template.user')
@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <section class="max-w-7xl mx-auto px-6 py-16 space-y-12">

        <!-- ABOUT SECTION -->
        <div class="text-center space-y-4">
            <h1 class="text-3xl md:text-4xl font-bold text-[#7cc652]">
                GllGreen – Thực Phẩm xanh, Sống Organic 🌿
            </h1>
            <p class="text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Có bao giờ bạn cảm thấy hạnh phúc chỉ từ một bữa ăn giản dị, với rau tươi, trái ngọt và hương vị nguyên lành
                như chính thiên nhiên ban tặng?
                Đó cũng là lý do GllGreen ra đời — để đưa sự tươi mát ấy trở lại trong từng căn bếp, từng bữa cơm của gia
                đình Việt.
            </p>
            <p class="text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Chúng tôi bắt đầu từ niềm tin rất đơn giản: <span class="text-[#7cc652] font-semibold">“Ăn sạch – sống khỏe –
                    và yêu Trái Đất nhiều hơn mỗi ngày.”</span>,
                Từ những nông trại xanh mướt, chúng tôi chọn lọc kỹ lưỡng từng cọng rau, từng quả chín mọng.
                Không hóa chất. Không chất bảo quản.
                Chỉ là những sản phẩm organic thuần khiết, được nuôi dưỡng bằng đất lành, nước sạch và tình yêu của người
                nông dân.

                GllGreen không chỉ là nơi bạn mua sắm thực phẩm —
                mà là một hành trình cùng nhau sống xanh hơn, chậm lại một chút để cảm nhận vị thật của cuộc sống.
                Bởi chúng tôi tin rằng:
                <span class="text-[#7cc652] font-semibold">🌾 Khi bạn chọn organic, bạn đang gieo mầm cho một tương lai xanh
                    hơn — cho bản thân, cho gia đình, và cho hành tinh này.</span>
            </p>
        </div>

        <!-- CONTACT SECTION -->
        <div class="flex flex-col lg:flex-row gap-10 items-start">
            <!-- LEFT: MAP -->
            <div class="lg:w-1/2 w-full rounded-xl overflow-hidden shadow">
                <iframe
                    src="https://www.google.com/maps?q=Tầng+11+Tòa+T,+Công+Viên+Phần+Mềm+Quang+Trung,+Quang+Trung,+Quận+12,+TP.+Hồ+Chí+Minh&output=embed"
                    class="w-full h-[500px] border-0" allowfullscreen loading="lazy">
                </iframe>
            </div>

            <!-- RIGHT: CONTACT FORM -->
            <div class="lg:w-1/2 w-full space-y-6">
                <div>
                    <h3 class="text-[#7cc652] text-xl italic font-medium">GllGreen</h3>
                    <h2 class="text-3xl font-bold text-gray-800 mt-1">Gửi thông tin cho chúng tôi</h2>
                    <p class="text-gray-600 mt-2">
                        Hãy liên hệ ngay với chúng tôi để nhận được nhiều ưu đãi hấp dẫn dành cho bạn!
                    </p>
                </div>

                <!-- CONTACT INFO -->
                <ul class="space-y-3 text-gray-700">
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-location-dot text-[#7cc652] text-lg mt-1"></i>
                        <p><span class="font-semibold">Địa chỉ:</span> Tầng 11 Tòa T, Quận 12, Quang Trung, Tp.Hồ Chí Minh
                        </p>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-envelope text-[#7cc652] text-lg mt-1"></i>
                        <p><span class="font-semibold">Email:</span> support@gllgreen.vn</p>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-phone text-[#7cc652] text-lg mt-1"></i>
                        <p><span class="font-semibold">Hotline:</span> 1900 6750</p>
                    </li>
                </ul>

                <!-- FORM -->
                <form action="#" method="POST" class="pt-4 space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="name" placeholder="Họ và tên*" required
                            class="border border-gray-300 rounded-full px-4 py-3 w-full focus:ring-2 focus:ring-[#7cc652]/40 focus:border-[#7cc652] outline-none">
                        <input type="email" name="email" placeholder="Email*" required
                            class="border border-gray-300 rounded-full px-4 py-3 w-full focus:ring-2 focus:ring-[#7cc652]/40 focus:border-[#7cc652] outline-none">
                    </div>
                    <input type="text" name="phone" placeholder="Điện thoại"
                        class="border border-gray-300 rounded-full px-4 py-3 w-full focus:ring-2 focus:ring-[#7cc652]/40 focus:border-[#7cc652] outline-none">
                    <textarea name="message" rows="4" placeholder="Nội dung liên hệ..."
                        class="border border-gray-300 rounded-2xl px-4 py-3 w-full focus:ring-2 focus:ring-[#7cc652]/40 focus:border-[#7cc652] outline-none resize-none"></textarea>
                    <button type="submit"
                        class="bg-[#7cc652] hover:bg-[#6ab141] text-white font-semibold rounded-full px-6 py-3 transition">
                        Gửi thông tin
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection

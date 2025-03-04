<x-app-layout>
    <div class="flex flex-col gap-4">
        <div class="grid grid-cols-2 items-center text-gray-600 rounded-[30px] bg-[#cccccc] w-fit">
            <button id="btn-courses" class="section-btn active-btn transition-all duration-300 ease-in-out">Courses</button>
            <button id="btn-articles" class="section-btn transition-all duration-300 ease-in-out">Articles</button>
        </div>
        <!-- FILTER FORM -->
        <form method="GET" action="{{ route('front.progress') }}" class="flex flex-wrap gap-2 items-center bg-gray-100 p-4 rounded-lg">
            <!-- Search -->
            <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" class="px-3 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-orange-400">

            <!-- Filter Kategori -->
            <select name="category" class="px-3 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-orange-400" id="filter-category">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <!-- Filter Tanggal -->
            <input type="date" name="date" value="{{ request('date') }}" class="px-3 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-orange-400">

            <!-- Filter Status (Khusus Kursus) -->
            <select name="status" class="px-3 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-orange-400" id="filter-status">
                <option value="">All Status</option>
                <option value="Done" {{ request('status') == 'Done' ? 'selected' : '' }}>Done</option>
                <option value="Progress" {{ request('status') == 'Progress' ? 'selected' : '' }}>Progress</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600">Apply</button>
        </form>

        <!-- COURSES SECTION -->
        <div id="section-courses" class="section hidden">
            <p class="text-xl font-bold text-center py-4">Courses Section</p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 w-full">
                @forelse ($courses as $course)
                                <div class="course-card w-full">
                                    <div class="flex flex-col rounded-t-[12px] rounded-b-[24px] gap-4 bg-white w-full pb-2 overflow-hidden ring-1 ring-[#DADEE4] transition-all duration-300 hover:ring-2 hover:ring-[#FF6129]">
                                        <a href="{{ route('front.details', $course->slug) }}" class="thumbnail w-full h-[200px] shrink-0 rounded-[10px] overflow-hidden">
                                            <img src="{{ Storage::url($course->thumbnail) }}" class="w-full h-full object-cover" alt="thumbnail">
                                        </a>
                                        <div class="flex flex-col px-4 gap-3">
                                            <div class="flex flex-col gap-2">
                                                <a href="{{ route('front.details', $course->slug) }}" class="font-semibold text-lg line-clamp-2 hover:line-clamp-none min-h-[40px]">
                                                    {{ $course->name }}
                                                </a>

                                                <!-- Menampilkan kategori sebagai badge -->
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach($course->categories as $category)
                                                        <span class="text-xs text-white bg-[#FF6129] px-2 py-1 rounded-full">
                                                            {{ $category->name }}
                                                        </span>
                                                    @endforeach
                                                </div>

                                                <!-- Bagian views dan jumlah siswa + Status Badge -->
                                                <div class="flex justify-between items-center">
                                                    <div class="flex items-center gap-1 text-[#6D7786]">
                                                        <i class="ti ti-eye"></i>
                                                        <p class="text-[#6D7786]">{{ $course->students->count() }}</p>
                                                    </div>

                                                    <!-- Tampilkan Badge Progress atau Done jika user login -->
                                                    @if(auth()->check())
                                                        @php
                                                            $status = auth()->user()->courseStatus($course->id);
                                                        @endphp
                                                        @if($status !== 'No Videos' && $status !== 'Not Watched')
                                                            <span class="text-xs font-semibold px-3 py-1 rounded-full
                                                                {{ $status == 'Done' ? 'bg-green-500 text-white' : 'bg-yellow-500 text-white' }}">
                                                                {{ $status }}
                                                            </span>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                                    <img src="{{ Storage::url($course->teacher->user->avatar) }}" class="w-full h-full object-cover" alt="icon">
                                                </div>
                                                <div class="flex flex-col">
                                                    <p class="font-semibold">{{ $course->teacher->user->name }}</p>
                                                    <p class="text-[#6D7786]">{{ $course->teacher->user->occupation }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-3 flex flex-col items-center justify-center text-center">
                                    <div class="w-full flex justify-center">
                                        <img src="{{ asset('assets/images/background/no-data.jpg') }}" alt="No Data"
                                            class="w-[clamp(150px,50vw,300px)]">
                                    </div>
                                    <p class="text-gray-500 mt-2">No Data available</p>
                                </div>
                            @endforelse
            </div>
            <div class="py-4 flex justify-end">
                {{ $courses->appends(request()->query())->links() }}
            </div>
        </div>

        <!-- ARTICLES SECTION -->
        <div id="section-articles" class="section hidden">
            <p class="text-xl font-bold text-center py-4">Articles Section</p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($visitedArticles as $artikel)
                    <div class="course-card w-full">
                        <div class="flex flex-col rounded-lg bg-white w-full pb-2 ring-1 ring-gray-300 hover:ring-2 hover:ring-orange-500">
                            <x-artikel-list title="{{ $artikel->title }}"
                                image="{{ asset(getenv('CUSTOM_TUMBNAIL_LOCATION') . '/' . $artikel->tumbnail) }}"
                                user="{{ $artikel->user->name }}" link="{{ route('artikel.show', ['slug' => $artikel->slug]) }}"
                                :date="$artikel->created_at" />
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center text-gray-500">No Data available</div>
                @endforelse
            </div>
            <div class="py-4 flex justify-end">
                {{ $visitedArticles->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const buttons = document.querySelectorAll(".section-btn");
        const sections = document.querySelectorAll(".section");
        const filterStatus = document.getElementById("filter-status");
        const filterCategory = document.getElementById("filter-category");

        // Ambil tab terakhir dari localStorage atau default ke "btn-courses"
        let activeTab = localStorage.getItem("activeTab") || "btn-courses";

        function showTab(buttonId) {
            buttons.forEach((button) => {
                const sectionId = button.id.replace("btn-", "section-");
                const section = document.getElementById(sectionId);

                if (button.id === buttonId) {
                    section.classList.remove("hidden");
                    button.classList.add("active-btn");
                } else {
                    section.classList.add("hidden");
                    button.classList.remove("active-btn");
                }
            });

            // Tampilkan/hilangkan filter status khusus Courses
            filterStatus.classList.toggle("hidden", buttonId === "btn-articles");
            filterCategory.classList.toggle("hidden", buttonId === "btn-articles");

            // Simpan pilihan tab ke localStorage
            localStorage.setItem("activeTab", buttonId);

            // Saat berpindah tab, hapus parameter page dari URL & tambahkan parameter tab
            const url = new URL(window.location.href);
            url.searchParams.set("tab", buttonId.replace("btn-", "")); // Tambahkan tab ke URL
            url.searchParams.delete("page"); // Hapus page agar pagination tidak ikut terbawa
            window.history.replaceState(null, "", url);
        }

        // Saat halaman termuat, pastikan tab yang dipilih sesuai dengan URL
        const urlParams = new URLSearchParams(window.location.search);
        const urlTab = urlParams.get("tab");
        if (urlTab) {
            activeTab = `btn-${urlTab}`;
            localStorage.setItem("activeTab", activeTab);
        }

        // Tampilkan tab yang sesuai berdasarkan localStorage atau URL
        showTab(activeTab);

        buttons.forEach((button) => {
            button.addEventListener("click", () => {
                showTab(button.id);
            });
        });
    });
</script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <script src="{{ asset('build/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
</x-app-layout>

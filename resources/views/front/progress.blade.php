@extends('../layouts.master')
@section('content')

    <body class="text-black font-poppins pt-10 pb-[50px]">
        <div id="hero-section"
            class="max-w-[1200px] mx-auto w-full flex flex-col gap-10 bg-[url('{{ asset('assets/background/Hero-Banner.png') }}')] bg-center bg-no-repeat bg-cover rounded-[32px] overflow-hidden">
            <x-navcat />
        </div>

        <section id="Top-Categories" class="max-w-[1200px] mx-auto flex flex-col py-[70px] gap-[30px]">
            <div class="flex flex-col gap-[30px]">
                <div
                    class="gradient-badge w-fit p-[8px_16px] rounded-full border border-[#FED6AD] flex items-center gap-[6px]">
                    <div>
                        <img src="{{ asset('assets/icon/medal-star.svg') }}" alt="icon">
                    </div>
                    <p class="font-medium text-sm text-[#FF6129]">Best courses</p>
                </div>
                <div class="flex items-start justify-between mb-6">
                    <!-- Bagian Judul -->
                    <div>
                        <h2 class="font-bold text-[40px] leading-[60px]">Learning Progress</h2>
                    </div>

                    <!-- Bagian Pencarian -->
                    <div class="flex items-center border border-[#898D93] rounded-full px-4 py-2 w-[300px] shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5 text-[#898D93]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 19a8 8 0 100-16 8 8 0 000 16z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35" />
                        </svg>
                        <input type="text" name="query" placeholder="Search Artikel"
                            class="ml-3 w-full text-sm outline-none text-[#898D93] placeholder-[#898D93] bg-transparent border-none focus:ring-0 focus:border-none" />
                    </div>
                </div>

                <div class="relative max-w-[1200px] mx-auto flex flex-col pt-[70px] pb-[50px] px-[100px] gap-[50px] bg-[#F5F8FA] rounded-[32px]">
                    <h1 class="text-2xl font-semibold mb-4">Course History</h1>

                    <!-- Tombol Navigasi untuk Kursus -->
                    <button class="btn-prev-kursus absolute left-[-60px] top-1/2 transform -translate-y-1/2 z-30 bg-white p-3 rounded-full shadow-lg pointer-events-auto">
                        <img src="assets/icon/arrow-right.svg" class="rotate-180 w-6 h-6" alt="Previous">
                    </button>

                    <div class="relative overflow-hidden" data-aos="fade-up" data-aos-duration="1000">
                        <!-- Swiper Container untuk Kursus -->
                        <div class="swiper-container kursus-slider w-full relative pointer-events-none">
                            <div class="swiper-wrapper pointer-events-auto">
                                @forelse ($courses as $course)
                                    <div class="swiper-slide">
                                        <div class="article-card w-full px-3 pb-[70px]">
                                            <div class="flex flex-col rounded-t-[12px] rounded-b-[24px] gap-[20px] bg-white w-full pb-[10px] overflow-hidden transition-all duration-300 hover:ring-2 hover:ring-[#FF6129]">
                                                <a href="{{ route('front.details', $course->slug) }}"
                                                    class="thumbnail w-full h-[200px] shrink-0 rounded-[10px] overflow-hidden">
                                                    <img src="{{ Storage::url($course->thumbnail) }}"
                                                        class="w-full h-full object-cover" alt="thumbnail">
                                                </a>
                                                <div class="flex flex-col px-4 gap-[10px]">
                                                    <a href="{{ route('front.details', $course->slug) }}"
                                                        class="font-semibold text-lg line-clamp-2 hover:line-clamp-none min-h-[56px]">
                                                        {{ $course->name }}
                                                    </a>
                                                    <div class="flex justify-between items-center">
                                                        <p class="text-sm text-gray-600 font-semibold">{{ $course->students->count() }} Students</p>
                                                        <div class="flex items-center gap-2">
                                                            <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                                                <img src="{{ Storage::url($course->teacher->user->avatar) }}"
                                                                    class="w-full h-full object-cover" alt="icon">
                                                            </div>
                                                            <div class="flex flex-col">
                                                                <p class="font-semibold">{{ $course->teacher->user->name }}</p>
                                                                <p class="text-[#6D7786]">{{ $course->teacher->user->occupation }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="w-full text-center">
                                        <p class="text-gray-500 mt-4">No courses available</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Navigasi untuk Kursus -->
                    <button class="btn-next-kursus absolute right-[-60px] top-1/2 transform -translate-y-1/2 z-30 bg-white p-3 rounded-full shadow-lg pointer-events-auto">
                        <img src="assets/icon/arrow-right.svg" class="w-6 h-6" alt="Next">
                    </button>
                </div>


                <div class="relative max-w-[1200px] mx-auto flex flex-col pt-[70px] pb-[50px] px-[100px] gap-[50px] bg-[#F5F8FA] rounded-[32px]">
                    <h1 class="text-2xl font-semibold mb-4">Article History</h1>

                    <!-- Tombol Navigasi untuk Artikel -->
                    <button class="btn-prev-artikel absolute left-[-60px] top-1/2 transform -translate-y-1/2 z-30 bg-white p-3 rounded-full shadow-lg pointer-events-auto">
                        <img src="assets/icon/arrow-right.svg" class="rotate-180 w-6 h-6" alt="Previous">
                    </button>

                    <div class="relative overflow-hidden" data-aos="fade-up" data-aos-duration="1000">
                        <!-- Swiper Container untuk Artikel -->
                        <div class="swiper-container artikel-slider w-full relative pointer-events-none">
                            <div class="swiper-wrapper pointer-events-auto">
                                @forelse ($articles as $article)
                                    <div class="swiper-slide">
                                        <div class="article-card w-full px-3 pb-[70px]">
                                            <div class="flex flex-col rounded-t-[12px] rounded-b-[24px] gap-[20px] bg-white w-full pb-[10px] overflow-hidden transition-all duration-300 hover:ring-2 hover:ring-[#FF6129]">
                                                <a href="{{ route('artikel.show', ['slug' => $article->slug]) }}"
                                                    class="thumbnail w-full h-[200px] shrink-0 rounded-[10px] overflow-hidden">
                                                    <img src="{{ asset(getenv('CUSTOM_TUMBNAIL_LOCATION') . '/' . $article->tumbnail) }}"
                                                        class="w-full h-full object-cover" alt="thumbnail">
                                                </a>
                                                <div class="flex flex-col px-4 gap-[10px]">
                                                    <a href="{{ route('artikel.show', ['slug' => $article->slug]) }}"
                                                        class="font-semibold text-lg line-clamp-2 hover:line-clamp-none min-h-[56px]">
                                                        {{ Str::limit($article->title, 47) }}
                                                    </a>
                                                    <div class="flex justify-between items-center">
                                                        <p class="text-sm text-gray-600 font-semibold hover:text-[#FF6129]">By {{ $article->user->name }}</p>
                                                        <p class="text-sm text-gray-600">
                                                            @if ($article->created_at->diffInHours(now()) < 24)
                                                                {{ $article->created_at->diffForHumans() }}
                                                            @else
                                                                {{ $article->created_at->isoFormat('dddd, D MMMM Y') }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="w-full text-center">
                                        <p class="text-gray-500 mt-4">No data available</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Navigasi untuk Artikel -->
                    <button class="btn-next-artikel absolute right-[-60px] top-1/2 transform -translate-y-1/2 z-30 bg-white p-3 rounded-full shadow-lg pointer-events-auto">
                        <img src="assets/icon/arrow-right.svg" class="w-6 h-6" alt="Next">
                    </button>
                </div>

                </div>

        </section>
        <x-footer />
<!-- JavaScript -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
        <script src="{{ asset('build/js/main.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
        <script>
            // Inisialisasi Swiper untuk Slider Kursus
            var swiperKursus = new Swiper(".kursus-slider", {
                slidesPerView: 3,
                spaceBetween: 30,
                loop: false,
                navigation: {
                    nextEl: ".btn-next-kursus",
                    prevEl: ".btn-prev-kursus",
                },
                on: {
                    init: function () {
                        updateNavButtons(this, ".btn-prev-kursus", ".btn-next-kursus");
                    },
                    slideChange: function () {
                        updateNavButtons(this, ".btn-prev-kursus", ".btn-next-kursus");
                    }
                },
            });

            // Inisialisasi Swiper untuk Slider Artikel
            var swiperArtikel = new Swiper(".artikel-slider", {
                slidesPerView: 3,
                spaceBetween: 30,
                loop: false,
                navigation: {
                    nextEl: ".btn-next-artikel",
                    prevEl: ".btn-prev-artikel",
                },
                on: {
                    init: function () {
                        updateNavButtons(this, ".btn-prev-artikel", ".btn-next-artikel");
                    },
                    slideChange: function () {
                        updateNavButtons(this, ".btn-prev-artikel", ".btn-next-artikel");
                    }
                },
            });

            // Fungsi untuk menyembunyikan tombol jika di awal atau akhir
            function updateNavButtons(swiper, prevBtn, nextBtn) {
                document.querySelector(prevBtn).style.display = swiper.isBeginning ? "none" : "block";
                document.querySelector(nextBtn).style.display = swiper.isEnd ? "none" : "block";
            }
        </script>

    </body>
@endsection

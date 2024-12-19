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
                <div class="flex items-center justify-between mb-6">
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
                            class="ml-3 w-full text-sm outline-none text-[#898D93] placeholder-[#898D93] bg-transparent focus:ring-0 focus:border-none" />
                    </div>
                </div>
                <div class="container mx-auto p-6">
                    <h1 class="text-2xl font-semibold" style="margin-bottom: 20px; ">Course History</h1>

                    <!-- Wrapper Grid -->
                    <div class="flex flex-wrap gap-6 justify-between w-full">
                        <!-- Card 1 -->
                        <div class="bg-[#F5F8FA] rounded-2xl shadow-md p-4 flex gap-2 items-center w-[260px] h-[100px]">
                            <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="Course Image"
                                class="w-16 h-16 object-cover rounded-xl mr-4">
                            <div >
                                <h4 class="text-sm font-bold text-black">Membuat Laporan Keuangan</h4>
                                <p class="text-xs text-gray-500">Data Analyst</p>
                            </div>
                        </div>
                        <!-- Card 2 -->
                        <div class="bg-[#F5F8FA] rounded-2xl shadow-md p-4 flex gap-2 items-center w-[260px] h-[100px]">
                            <img src="course2.jpg" alt="Course Image" class="w-16 h-16 object-cover rounded-lg mr-4">
                            <div>
                                <h4 class="text-sm font-bold text-black">Tutorial Blockchain</h4>
                                <p class="text-xs text-gray-500">Web 3 Developer</p>
                            </div>
                        </div>
                        <!-- Card 3 -->
                        <div class="bg-[#F5F8FA] rounded-2xl shadow-md p-4 flex gap-2 items-center w-[260px] h-[100px]">
                            <img src="course3.jpg" alt="Course Image" class="w-16 h-16 object-cover rounded-lg mr-4">
                            <div>
                                <h4 class="text-sm font-bold text-black">Membuat Laporan Keuangan</h4>
                                <p class="text-xs text-gray-500">Data Analyst</p>
                            </div>
                        </div>
                        <!-- Card 4 -->
                        <div class="bg-[#F5F8FA] rounded-2xl shadow-md p-4 flex gap-2 items-center w-[260px] h-[100px]">
                            <img src="course4.jpg" alt="Course Image" class="w-16 h-16 object-cover rounded-lg mr-4">
                            <div>
                                <h4 class="text-sm font-bold text-black">Tutorial Blockchain</h4>
                                <p class="text-xs text-gray-500">Web 3 Developer</p>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="container mx-auto p-6">
                    <h1 class="text-2xl font-semibold mb-6">Lastest Artikel</h1>

                    <div class="flex flex-wrap gap-6 w-full">
                        <div class="bg-[#F5F8FA] rounded-2xl shadow-md p-4" style="width: 40%; height: 300px;">
                            <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="Article Image" class="w-full object-cover rounded-xl border-2 border-gray-300 mb-4" style="height: 100px;">
                            <div class="p-4">
                                <h4 class="text-lg font-bold">Manta Terbang Menuju Jurang</h4>
                                <p class="text-sm text-gray-500 mt-2">Deskripsi untuk cara menjadi seorang programmer web 3</p>
                                 <div class="flex justify-between items-center text-xs text-gray-400 mt-4">
                                    <span> Sarada</span>
                                    <span>Wed, 4/12/2024</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-[#F5F8FA] rounded-2xl shadow-md p-4" style="width: 40%; height: 300px;">
                            <img src="{{ asset('assets/images/profile/user-2.jpg') }}" alt="Article Image" class="w-full object-cover rounded-xl border-2 border-gray-300 mb-4" style="height: 100px;">
                            <div class="p-4">
                                <h4 class="text-lg font-bold">Judul Artikel Kedua</h4>
                                <p class="text-sm text-gray-500 mt-2">Deskripsi menarik untuk artikel kedua ini.</p>
                                 <div class="flex justify-between items-center text-xs text-gray-400 mt-4">
                                    <span> Naruto</span>
                                    <span>Thu, 5/12/2024</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-[#F5F8FA] rounded-2xl shadow-md p-4" style="width: 40%; height: 300px;">
                            <img src="{{ asset('assets/images/profile/user-3.jpg') }}" alt="Article Image" class="w-full object-cover rounded-xl border-2 border-gray-300 mb-4" style="height: 100px;">
                            <div class="p-4">
                                <h4 class="text-lg font-bold">Judul Artikel Ketiga</h4>
                                <p class="text-sm text-gray-500 mt-2">Deskripsi singkat untuk artikel ketiga.</p>
                                 <div class="flex justify-between items-center text-xs text-gray-400 mt-4">
                                    <span> Luffy</span>
                                    <span>Fri, 6/12/2024</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-[#F5F8FA] rounded-2xl shadow-md p-4" style="width: 40%; height: 300px;">
                            <img src="{{ asset('assets/images/profile/user-4.jpg') }}" alt="Article Image" class="w-full object-cover rounded-xl border-2 border-gray-300 mb-4" style="height: 100px;">
                            <div class="p-4">
                                <h4 class="text-lg font-bold">Judul Artikel Keempat</h4>
                                <p class="text-sm text-gray-500 mt-2">Penjelasan singkat tentang artikel keempat.</p>
                                <div class="flex justify-between items-center text-xs text-gray-400 mt-4 ">
                                    <span> Sarada</span>
                                    <span>Wed, 4/12/2024</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                        {{-- <div class="bg-[#F5F8FA] rounded-2xl shadow-md p-4 flex-col gap-4 items-center w-[300px]">
                            <img src="{{ asset('assets/images/profile/user-2.jpg') }}" alt="Article Image" class="w-full object-cover rounded-xl border-2 border-gray-300">
                            <div class="p-4">
                                <h4 class="text-lg font-bold mt-4">Tutorial Blockchain</h4>
                                <p class="text-sm text-gray-500 mt-2">Panduan lengkap tentang blockchain dan cara penggunaannya</p>
                                <div class="flex justify-between items-center text-xs text-gray-400 mt-4">
                                    <span>Author: John Doe</span>
                                    <span>Mon, 6/12/2024</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-[#F5F8FA] rounded-2xl shadow-md p-4 flex-col gap-4 items-center w-[300px]">
                            <img src="{{ asset('assets/images/profile/user-3.jpg') }}" alt="Article Image" class="w-full object-cover rounded-xl border-2 border-gray-300">
                            <div class="p-4">
                                <h4 class="text-lg font-bold mt-4">Membangun Aplikasi Web</h4>
                                <p class="text-sm text-gray-500 mt-2">Langkah-langkah membuat aplikasi web menggunakan</p>
                                <div class="flex justify-between items-center text-xs text-gray-400 mt-4">
                                    <span>Author: Jane Doe</span>
                                    <span>Tue, 5/12/2024</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-[#F5F8FA] rounded-2xl shadow-md p-4 flex-col gap-4 items-center w-[300px]">
                            <img src="{{ asset('assets/images/profile/user-4.jpg') }}" alt="Article Image" class="w-full object-cover rounded-xl border-2 border-gray-300">
                            <div class="p-4">
                                <h4 class="text-lg font-bold mt-4">Mengenal ReactJS</h4>
                                <p class="text-sm text-gray-500 mt-2">Tutorial dasar ReactJS untuk pemula</p>
                                <div class="flex justify-between items-center text-xs text-gray-400 mt-4">
                                    <span>Author: Michael</span>
                                    <span>Thu, 7/12/2024</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}




                    <div class="grid grid-cols-3 gap-[30px] w-full">
                        @forelse ($courses as $course)
                            <div class="course-card">
                                <div
                                    class="flex flex-col rounded-t-[12px] rounded-b-[24px] gap-[32px] bg-white w-full pb-[10px] overflow-hidden ring-1 ring-[#DADEE4] transition-all duration-300 hover:ring-2 hover:ring-[#FF6129]">
                                    <a href="{{ route('front.details', $course->slug) }}"
                                        class="thumbnail w-full h-[200px] shrink-0 rounded-[10px] overflow-hidden">
                                        <img src="{{ Storage::url($course->thumbnail) }}" class="w-full h-full object-cover"
                                            alt="thumbnail">
                                    </a>
                                    <div class="flex flex-col px-4 gap-[32px]">
                                        <div class="flex flex-col gap-[10px]">
                                            <a href="{{ route('front.details', $course->slug) }}"
                                                class="font-semibold text-lg line-clamp-2 hover:line-clamp-none min-h-[56px]">Modern
                                                JavaScript: Bikin Projek Website Seperti Twitter</a>
                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center gap-[2px]">
                                                    <div>
                                                        <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                                    </div>
                                                    <div>
                                                        <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                                    </div>
                                                    <div>
                                                        <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                                    </div>
                                                    <div>
                                                        <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                                    </div>
                                                    <div>
                                                        <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                                    </div>
                                                </div>
                                                <p class="text-right text-[#6D7786]">{{ $course->students->count() }}</p>
                                            </div>
                                        </div>
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
                        @empty
                        @endforelse
                    </div>
                </div>

        </section>
        <section id="Zero-to-Success"
            class="max-w-[1200px] mx-auto flex flex-col py-[70px] px-[50px] gap-[30px] bg-[#F5F8FA] rounded-[32px]">
            <div class="flex flex-col gap-[30px] items-center text-center">
                <div
                    class="gradient-badge w-fit p-[8px_16px] rounded-full border border-[#FED6AD] flex items-center gap-[6px]">
                    <div>
                        <img src="{{ asset('assets/icon/medal-star.svg') }}" alt="icon">
                    </div>
                    <p class="font-medium text-sm text-[#FF6129]">Zero to Success People</p>
                </div>
                <div class="flex flex-col">
                    <h2 class="font-bold text-[40px] leading-[60px]">Happy & Success Students</h2>
                    <p class="text-[#6D7786] text-lg -tracking-[2%]">Acquiring skills and new high paying career become
                        much easier</p>
                </div>
            </div>
            <div class="testi w-full overflow-hidden flex flex-col gap-6 relative">
                <div class="fade-overlay absolute z-10 h-full w-[50px] bg-gradient-to-r from-[#F5F8FA] to-[#F5F8FA00]">
                </div>
                <div
                    class="fade-overlay absolute right-0 z-10 h-full w-[50px] bg-gradient-to-r from-[#F5F8FA00] to-[#F5F8FA]">
                </div>
                <div class="group/slider flex flex-nowrap w-max items-center">
                    <div
                        class="testi-container animate-[slideToL_50s_linear_infinite] group-hover/slider:pause-animate flex gap-6 pl-6 items-center flex-nowrap">
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/photo/photo4.png') }}" class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Shayna</p>
                            </div>
                            <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career,
                                thank you!</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                            </div>
                        </div>
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/photo/photo4.png') }}" class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Shayna</p>
                            </div>
                            <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career,
                                thank you!</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                            </div>
                        </div>
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/photo/photo4.png') }}" class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Shayna</p>
                            </div>
                            <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career,
                                thank you!</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                            </div>
                        </div>
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/photo/photo4.png') }}" class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Shayna</p>
                            </div>
                            <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career,
                                thank you!</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="logo-container animate-[slideToL_50s_linear_infinite] group-hover/slider:pause-animate flex gap-6 pl-6 items-center flex-nowrap ">
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/photo/photo4.png') }}" class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Shayna</p>
                            </div>
                            <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career,
                                thank you!</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                            </div>
                        </div>
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/photo/photo4.png') }}" class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Shayna</p>
                            </div>
                            <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career,
                                thank you!</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                            </div>
                        </div>
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/photo/photo4.png') }}" class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Shayna</p>
                            </div>
                            <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career,
                                thank you!</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                            </div>
                        </div>
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/photo/photo4.png') }}" class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Shayna</p>
                            </div>
                            <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career,
                                thank you!</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="group/slider flex flex-nowrap w-max items-center">
                    <div
                        class="logo-container animate-[slideToR_50s_linear_infinite] group-hover/slider:pause-animate flex gap-6 pl-6 items-center flex-nowrap">
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/photo/photo4.png') }}" class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Shayna</p>
                            </div>
                            <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career,
                                thank you!</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                            </div>
                        </div>
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/photo/photo4.png') }}" class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Shayna</p>
                            </div>
                            <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career,
                                thank you!</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                            </div>
                        </div>
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/photo/photo4.png') }}" class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Shayna</p>
                            </div>
                            <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career,
                                thank you!</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                            </div>
                        </div>
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/photo/photo4.png') }}" class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Shayna</p>
                            </div>
                            <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career,
                                thank you!</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="logo-container animate-[slideToR_50s_linear_infinite] group-hover/slider:pause-animate flex gap-6 pl-6 items-center flex-nowrap ">
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/photo/photo4.png') }}" class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Shayna</p>
                            </div>
                            <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career,
                                thank you!</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                            </div>
                        </div>
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/photo/photo4.png') }}" class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Shayna</p>
                            </div>
                            <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career,
                                thank you!</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                            </div>
                        </div>
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/photo/photo4.png') }}" class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Shayna</p>
                            </div>
                            <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career,
                                thank you!</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                            </div>
                        </div>
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/photo/photo4.png') }}" class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Shayna</p>
                            </div>
                            <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career,
                                thank you!</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                                <div>
                                    <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="FAQ" class="max-w-[1200px] mx-auto flex flex-col py-[70px] px-[100px]">
            <div class="flex justify-between items-center">
                <div class="flex flex-col gap-[30px]">
                    <div
                        class="gradient-badge w-fit p-[8px_16px] rounded-full border border-[#FED6AD] flex items-center gap-[6px]">
                        <div>
                            <img src="{{ asset('assets/icon/medal-star.svg') }}" alt="icon">
                        </div>
                        <p class="font-medium text-sm text-[#FF6129]">Grow Your Career</p>
                    </div>
                    <div class="flex flex-col">
                        <h2 class="font-bold text-[36px] leading-[52px]">Get Your Answers</h2>
                        <p class="text-lg text-[#475466]">It’s time to upgrade skills without limits!</p>
                    </div>
                    <a href=""
                        class="text-white font-semibold rounded-[30px] p-[16px_32px] bg-[#FF6129] transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980] w-fit">Contact
                        Our Sales</a>
                </div>
                <div class="flex flex-col gap-[30px] w-[552px] shrink-0">
                    <div
                        class="flex flex-col p-5 rounded-2xl bg-[#FFF8F4] has-[.hide]:bg-transparent border-t-4 border-[#FF6129] has-[.hide]:border-0 w-full">
                        <button class="accordion-button flex justify-between gap-1 items-center"
                            data-accordion="accordion-faq-1">
                            <span class="font-semibold text-lg text-left">Can beginner join the course?</span>
                            <div class="arrow w-9 h-9 flex shrink-0">
                                <img src="{{ asset('assets/icon/add.svg') }}" alt="icon">
                            </div>
                        </button>
                        <div id="accordion-faq-1" class="accordion-content hide">
                            <p class="leading-[30px] text-[#475466] pt-[10px]">Yes, we have provided a variety range of
                                course from beginner to intermediate level to prepare your next big career,</p>
                        </div>
                    </div>
                    <div
                        class="flex flex-col p-5 rounded-2xl bg-[#FFF8F4] has-[.hide]:bg-transparent border-t-4 border-[#FF6129] has-[.hide]:border-0 w-full">
                        <button class="accordion-button flex justify-between gap-1 items-center"
                            data-accordion="accordion-faq-2">
                            <span class="font-semibold text-lg text-left">How long does the implementation take?</span>
                            <div class="arrow w-9 h-9 flex shrink-0">
                                <img src="{{ asset('assets/icon/add.svg') }}" alt="icon">
                            </div>
                        </button>
                        <div id="accordion-faq-2" class="accordion-content hide">
                            <p class="leading-[30px] text-[#475466] pt-[10px]">Lorem ipsum dolor, sit amet consectetur
                                adipisicing elit. Dolore placeat ut nostrum aperiam mollitia tempora aliquam perferendis
                                explicabo eligendi commodi.</p>
                        </div>
                    </div>
                    <div
                        class="flex flex-col p-5 rounded-2xl bg-[#FFF8F4] has-[.hide]:bg-transparent border-t-4 border-[#FF6129] has-[.hide]:border-0 w-full">
                        <button class="accordion-button flex justify-between gap-1 items-center"
                            data-accordion="accordion-faq-3">
                            <span class="font-semibold text-lg text-left">Do you provide the job-guarantee program?</span>
                            <div class="arrow w-9 h-9 flex shrink-0">
                                <img src="{{ asset('assets/icon/add.svg') }}" alt="icon">
                            </div>
                        </button>
                        <div id="accordion-faq-3" class="accordion-content hide">
                            <p class="leading-[30px] text-[#475466] pt-[10px]">Lorem ipsum dolor sit amet consectetur
                                adipisicing elit. Molestiae itaque facere ipsum animi sunt iure!</p>
                        </div>
                    </div>
                    <div
                        class="flex flex-col p-5 rounded-2xl bg-[#FFF8F4] has-[.hide]:bg-transparent border-t-4 border-[#FF6129] has-[.hide]:border-0 w-full">
                        <button class="accordion-button flex justify-between gap-1 items-center"
                            data-accordion="accordion-faq-4">
                            <span class="font-semibold text-lg text-left">How to issue all course certificates?</span>
                            <div class="arrow w-9 h-9 flex shrink-0">
                                <img src="{{ asset('assets/icon/add.svg') }}" alt="icon">
                            </div>
                        </button>
                        <div id="accordion-faq-4" class="accordion-content hide">
                            <p class="leading-[30px] text-[#475466] pt-[10px]">Lorem ipsum dolor sit amet consectetur
                                adipisicing elit. Molestiae itaque facere ipsum animi sunt iure!</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <x-footer />
        <!-- JavaScript -->
        <script src="{{ asset('build/js/main.js') }}"></script>

    </body>
@endsection

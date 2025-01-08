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

                <div class="">
                    <h1 class="text-2xl font-semibold mb-6">Course History</h1>

                    <div class="flex flex-wrap gap-6 w-full">
                        <!-- Card 1 -->
                        <div class="bg-[#F5F8FA] rounded-[20px] p-4 flex gap-4 items-center max-w-[380px] w-full">
                            <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="Course Image"
                                class="w-20 h-20 object-cover rounded-[20px] mr-4">
                            <div>
                                <h4 class="text-base font-bold text-black">Creating Financial Reports</h4>
                                <div class="flex gap-4 text-xs text-gray-500">
                                    <p>Created by John . Released Jan 15, 2024</p>
                                </div>
                            </div>
                        </div>
                        <!-- Card 2 -->
                        <div class="bg-[#F5F8FA] rounded-[20px] p-4 flex gap-4 items-center max-w-[380px] w-full">
                            <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="Course Image"
                                class="w-20 h-20 object-cover rounded-[20px]">
                            <div>
                                <h4 class="text-base font-bold text-black">Tutorial Blockchain</h4>
                                <div class="text-xs text-gray-500">
                                    <p>Created by Jane . Released Feb 20, 2024</p>
                                </div>
                            </div>
                        </div>
                        <!-- Card 3 -->
                        <div class="bg-[#F5F8FA] rounded-[20px] p-4 flex gap-4 items-center max-w-[380px] w-full">
                            <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="Course Image"
                                class="w-20 h-20 object-cover rounded-[20px] mr-4">
                            <div>
                                <h4 class="text-base font-bold text-black">Creating Financial Reports</h4>
                                <div class="flex gap-4 text-xs text-gray-500">
                                    <p>Created by John Doe . Released Jan 15, 2024</p>
                                </div>
                            </div>
                        </div>
                        <!-- Card 4 -->
                        <div class="bg-[#F5F8FA] rounded-[20px] p-4 flex gap-4 items-center max-w-[380px] w-full">
                            <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="Course Image"
                                class="w-20 h-20 object-cover rounded-[20px] mr-4">
                            <div>
                                <h4 class="text-base font-bold text-black">Tutorial Blockchain</h4>
                                <div class="flex gap-4 text-xs text-gray-500">
                                    <p>Created by Jane Smith . Released Feb 20, 2024</p>
                                </div>
                            </div>
                        </div>
                    </div>





                <div class="container mx-auto p-6">
                    <h1 class="text-2xl font-semibold mb-6">Lastest Artikel</h1>

                    <div class="grid grid-cols-3 gap-4 w-full">
                        @forelse ($articles as $article)
                            <div class="bg-[#F5F8FA] rounded-2xl shadow-md p-4" style="w-full">
                                <a href="{{ route('artikel.show', ['slug' => $article->slug]) }}">
                                    <img src="{{ asset(getenv('CUSTOM_TUMBNAIL_LOCATION') . '/' . $article->tumbnail) }}"
                                        alt="Article Image"
                                        class="w-full object-cover rounded-xl border-2 border-gray-300 mb-4 h-[200px]">
                                    <div class="p-2 h-[150px] flex flex-col justify-between overflow-y-hidden">
                                        <h4 class="text-lg font-bold hover:underline hover:text-[#FF6129]">
                                            {{ Str::limit($article->title, 47) }}</h4>
                                        <p class="text-sm text-gray-500 mt-2">{!! Str::limit($article->content, 60) !!}</p>
                                        <div class="flex justify-between items-center text-xs text-gray-400 mt-4">
                                            <span>By {{ $article->user->name }}</span>
                                            <span>
                                                @if ($article->created_at->diffInHours(now()) < 24)
                                                    {{ $article->created_at->diffForHumans() }}
                                                @else
                                                    {{ $article->created_at->isoFormat('dddd, D MMMM Y') }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                        @endforelse
                    </div>
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

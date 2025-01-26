@extends('../layouts.master')
@section('content')

    <body class="text-black font-poppins pt-10 pb-[50px]">
        <div id="hero-section"
            class="max-w-[1200px] mx-auto w-full flex flex-col gap-10 pb-[50px] bg-[url('{{ asset('assets/background/Hero-Banner.png') }}')] bg-center bg-no-repeat bg-cover rounded-[32px] overflow-hidden">
            <x-nav />
            <div class="flex flex-col items-center gap-[30px]">

                <div class="w-fit flex items-center gap-3 p-2 pr-6 rounded-full bg-[#FFFFFF1F] border border-[#3477FF24]">
                    <div class="w-[100px] h-[48px] flex shrink-0">
                        <img src="assets/icon/avatar-group.png" class="object-contain" alt="icon">
                    </div>
                    <p class="font-semibold text-sm text-white">Join 3 million users</p>
                </div>

                <div class="flex flex-col gap-[10px]">
                    <h1 class="font-semibold text-[80px] leading-[82px] text-center gradient-text-hero">Build Future Career.
                    </h1>
                    <p class="text-center text-xl leading-[36px] text-[#F5F8FA]">My Course provides high quality online
                        courses for you to grow <br>
                        your skills and build outstanding portfolio to tackle job interviews</p>
                </div>
                <div class="flex gap-6 w-fit">
                    <form action="{{ route('front.search') }}" method="GET"
                        class="flex items-center bg-white rounded-full pl-6 h-fit focus-within:ring-2 focus-within:ring-[#FF6B2C] transition-all duration-300">
                        @csrf
                        <div class="flex items-center w-full mr-6 gap-[10px]">
                            <div class="flex shrink-0">
                                <img src="{{ asset('assets/icon/search.svg') }}" alt="icon">
                            </div>
                            <input name="keyword" type="text" autocomplete="off"
                                class="appearance-none w-full outline-none font-semibold placeholder:font-normal placeholder:text-[#0E0140] focus:outline-none  [border:none] focus:ring-white focus:border-none"
                                placeholder="Search course...">
                        </div>
                        <button type="submit"
                            class="rounded-full py-5 px-[30px] bg-[#FF6B2C] font-semibold text-white text-nowrap hover:shadow-[0_10px_20px_0_#FF6B2C66] transition-all duration-300">Cari</button>
                    </form>
                </div>
            </div>

        </div>
        <section id="Top-Categories" class="max-w-[1200px] mx-auto flex flex-col p-[70px_50px] gap-[30px]">
            <div class="flex flex-col gap-[30px]">
                <div
                    class="gradient-badge w-fit p-[8px_16px] rounded-full border border-[#FED6AD] flex items-center gap-[6px]">
                    <div>
                        <img src="assets/icon/medal-star.svg" alt="icon">
                    </div>
                    <p class="font-medium text-sm text-[#FF6129]">Top Categories</p>
                </div>
                <div class="flex flex-col">
                    <h2 class="font-bold text-[40px] leading-[60px]">Browse Courses</h2>
                    <p class="text-[#6D7786] text-lg -tracking-[2%]">Catching up the on demand skills and high paying career
                        this year</p>
                </div>
            </div>
            <div class="grid grid-cols-4 gap-[30px]">
                @forelse ($categories as $category)
                    <a href="{{ route('front.category', $category->slug) }}"
                        class="card flex items-center p-4 gap-3 ring-1 ring-[#DADEE4] rounded-2xl hover:ring-2 hover:ring-[#FF6129] transition-all duration-300">
                        <div class="w-[70px] h-[70px] flex shrink-0">
                            <img src="{{ Storage::url($category->icon) }}" class="object-contain" alt="icon">
                        </div>
                        <p class="font-bold text-lg">{{ $category->name }}</p>
                    </a>
                @empty
                @endforelse

            </div>
        </section>
        <section id="Popular-Courses"
            class="max-w-[1200px] mx-auto flex flex-col p-[70px_82px_0px] gap-[30px] bg-[#F5F8FA] rounded-[32px]">
            <div class="flex flex-col gap-[30px] items-center text-center">
                <div
                    class="gradient-badge w-fit p-[8px_16px] rounded-full border border-[#FED6AD] flex items-center gap-[6px]">
                    <div>
                        <img src="assets/icon/medal-star.svg" alt="icon">
                    </div>
                    <p class="font-medium text-sm text-[#FF6129]">Popular Courses</p>
                </div>
                <div class="flex flex-col">
                    <h2 class="font-bold text-[40px] leading-[60px]">Don’t Missed It, Learn Now</h2>
                    <p class="text-[#6D7786] text-lg -tracking-[2%]">Catching up the on demand skills and high paying career
                        this year</p>
                </div>
            </div>
            <div class="relative">
                <button class="btn-prev absolute rotate-180 -left-[52px] top-[216px]">
                    <img src="assets/icon/arrow-right.svg" alt="icon">
                </button>
                <button class="btn-prev absolute -right-[52px] top-[216px]">
                    <img src="assets/icon/arrow-right.svg" alt="icon">
                </button>
                <div id="course-slider" class="w-full">
                    @forelse ($courses as $course)
                        <div class="course-card w-1/3 px-3 pb-[70px] mt-[2px]">
                            <div
                                class="flex flex-col rounded-t-[12px] rounded-b-[24px] gap-[32px] bg-white w-full pb-[10px] overflow-hidden transition-all duration-300 hover:ring-2 hover:ring-[#FF6129]">
                                <a href="{{ route('front.details', $course->slug) }}"
                                    class="thumbnail w-full h-[200px] shrink-0 rounded-[10px] overflow-hidden">
                                    <img src="{{ Storage::url($course->thumbnail) }}" class="w-full h-full object-cover"
                                        alt="thumbnail">
                                </a>
                                <div class="flex flex-col px-4 gap-[10px]">
                                    <a href="{{ route('front.details', $course->slug) }}"
                                        class="font-semibold text-lg line-clamp-2 hover:line-clamp-none min-h-[56px]">{{ $course->name }}</a>
                                    <div class="flex justify-between items-center">
                                        {{-- <div class="flex items-center gap-[2px]">
                                    <div>
                                        <img src="assets/icon/star.svg" alt="star">
                                    </div>
                                    <div>
                                        <img src="assets/icon/star.svg" alt="star">
                                    </div>
                                    <div>
                                        <img src="assets/icon/star.svg" alt="star">
                                    </div>
                                    <div>
                                        <img src="assets/icon/star.svg" alt="star">
                                    </div>
                                    <div>
                                        <img src="assets/icon/star.svg" alt="star">
                                    </div>
                                </div> --}}
                                        <p class="text-right text-[#6D7786]">{{ $course->students->count() }} Students</p>
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
        <section id="Pricing" class="max-w-[1200px] mx-auto flex justify-between items-center p-[70px_100px]">
            <div class="relative">
                <div class="w-[355px] h-[488px]">
                    <img src="assets/background/benefit_illustration.png" alt="icon">
                </div>
                <div
                    class="absolute w-[230px] transform -translate-y-1/2 top-1/2 left-[214px] bg-white z-10 rounded-[20px] gap-4 p-4 flex flex-col shadow-[0_17px_30px_0_#0D051D0A]">
                    <p class="font-semibold">Materials</p>
                    <div class="flex gap-2 items-center">
                        <div>
                            <img src="assets/icon/video-play.svg" alt="icon">
                        </div>
                        <p class="font-medium">Videos</p>
                    </div>
                    <div class="flex gap-2 items-center">
                        <div>
                            <img src="assets/icon/note-favorite.svg" alt="icon">
                        </div>
                        <p class="font-medium">Handbook</p>
                    </div>
                    <div class="flex gap-2 items-center">
                        <div>
                            <img src="assets/icon/3dcube.svg" alt="icon">
                        </div>
                        <p class="font-medium">Assets</p>
                    </div>

                </div>
            </div>
            <div class="flex flex-col text-left gap-[30px]">
                <h2 class="font-bold text-[36px] leading-[52px]">Be a Teacher And,<br>Get Some Benefits</h2>
                <p class="text-[#475466] text-lg leading-[34px]">Growing new skills would be more flexible without <br>
                    limit we help you to access all course materials.</p>
                <a href="{{ route('teacher.reapply') }}"
                    class="text-white font-semibold rounded-[30px] p-[16px_32px] bg-[#FF6129] transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980] w-fit">Reapply</a>
            </div>
        </section>
        <section id="Zero-to-Success"
            class="max-w-[1200px] mx-auto flex flex-col py-[70px] px-[50px] gap-[30px] bg-[#F5F8FA] rounded-[32px]">
            <div class="flex flex-col gap-[30px] items-center text-center">
                <div
                    class="gradient-badge w-fit p-[8px_16px] rounded-full border border-[#FED6AD] flex items-center gap-[6px]">
                    <div>
                        <img src="assets/icon/medal-star.svg" alt="icon">
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
                            <p class="text-sm text-[#475466]">My Course has helped me to grow from zero to perfect career,
                                thank you!</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                            </div>
                        </div>
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src={{ asset('assets/photo/photo1.png') }} class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Michael</p>
                            </div>
                            <p class="text-sm text-[#475466]">The course materials are easy to understand and have helped
                                me grow professionally.</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                            </div>
                        </div>
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src={{ asset('assets/photo/photo2.png') }} class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Stepen</p>
                            </div>
                            <p class="text-sm text-[#475466]">This course has been extremely helpful in improving my
                                practical skills in the workplace.</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                            </div>
                        </div>
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src={{ asset('assets/photo/photo3.png') }} class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Azriel</p>
                            </div>
                            <p class="text-sm text-[#475466]">I highly recommend My Course to anyone looking to enhance
                                their skills.</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
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
                                    <img src={{ asset('assets/photo/photo4.png') }} class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Shayna</p>
                            </div>
                            <p class="text-sm text-[#475466]">My Course has helped me to grow from zero to perfect career,
                                thank you!</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                            </div>
                        </div>
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src={{ asset('assets/photo/photo1.png') }} class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Michael</p>
                            </div>
                            <p class="text-sm text-[#475466]">The course materials are easy to understand and have helped
                                me grow professionally.</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                            </div>
                        </div>
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src={{ asset('assets/photo/photo2.png') }} class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Stepen</p>
                            </div>
                            <p class="text-sm text-[#475466]">This course has been extremely helpful in improving my
                                practical skills in the workplace.</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                            </div>
                        </div>
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src={{ asset('assets/photo/photo3.png') }} class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Azriel</p>
                            </div>
                            <p class="text-sm text-[#475466]">I highly recommend My Course to anyone looking to enhance
                                their skills.</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="logo-container animate-[slideToR_50s_linear_infinite] group-hover/slider:pause-animate flex gap-6 pl-6 items-center flex-nowrap ">
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src={{ asset('assets/photo/photo5.png') }} class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Rani</p>
                            </div>
                            <p class="text-sm text-[#475466]">My Course The Best Material. I Like My Course, The price is
                                quite affordable
                                Thankyou!</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                            </div>
                        </div>
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src={{ asset('assets/photo/photo6.png') }} class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Sano</p>
                            </div>
                            <p class="text-sm text-[#475466]">Thanks to My Course, I was able to switch careers smoothly
                                and land my dream job.
                                The lessons were practical and easy to follow!</p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                            </div>
                        </div>
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src={{ asset('assets/photo/Demas.jpg') }} class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Ncos</p>
                            </div>
                            <p class="text-sm text-[#475466]">Enrolling in My Course was the best decision I've ever made.
                                It gave me the tools to succeed and stand out in a competitive job market.
                            </p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                            </div>
                        </div>
                        <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src={{ asset('assets/photo/photo4.png') }} class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <p class="font-semibold">Shayna</p>
                            </div>
                            <p class="text-sm text-[#475466]">The support and guidance I received from My Course were
                                outstanding.
                                It truly transformed my career and opened new opportunities!
                            </p>
                            <div class="flex gap-[2px]">
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
                                </div>
                                <div>
                                    <img src="assets/icon/star.svg" alt="star">
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
                            <img src="assets/icon/medal-star.svg" alt="icon">
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
                                <img src="assets/icon/add.svg" alt="icon">
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
                                <img src="assets/icon/add.svg" alt="icon">
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
                                <img src="assets/icon/add.svg" alt="icon">
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
                                <img src="assets/icon/add.svg" alt="icon">
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
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
        <script src="{{ asset('build/js/main.js') }}"></script>

    </body>
@endsection

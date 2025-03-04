@extends('../layouts.master')
@section('content')
<body class="text-black font-poppins pt-10 pb-[50px]">
    <div id="hero-section" class="max-w-[1200px] mx-auto w-full h-[393px] flex flex-col gap-10 pb-[50px] bg-[url('{{ asset('assets/background/Hero-Banner.png') }}')] bg-center bg-no-repeat bg-cover rounded-[32px] overflow-hidden absolute transform -translate-x-1/2 left-1/2">
        <x-nav/>
    </div>
    <section id="video-content" class="max-w-[1100px] w-full mx-auto mt-[130px]">
        <div class="video-player relative flex flex-nowrap gap-5">
            <div class="plyr__video-embed w-full overflow-hidden relative rounded-[20px]" id="player">
                <iframe
                    src="https://www.youtube.com/embed/{{$video->path_video}}?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1"
                    allowfullscreen
                    allowtransparency
                    allow="autoplay"
                ></iframe>
            </div>
            <div class="video-player-sidebar flex flex-col shrink-0 w-[330px] h-[470px] bg-[#F5F8FA] rounded-[20px] p-5 gap-5 pb-0 overflow-y-scroll no-scrollbar">
                <p class="font-bold text-lg text-black">{{$course->course_videos->count()}} Lessons</p>
                <div class="flex flex-col gap-3">

                    <div class="group p-[12px_16px] flex items-center gap-[10px] bg-[#E9EFF3] rounded-full hover:bg-[#3525B3] transition-all duration-300">
                        <div class="text-black group-hover:text-white transition-all duration-300">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.97 2C6.44997 2 1.96997 6.48 1.96997 12C1.96997 17.52 6.44997 22 11.97 22C17.49 22 21.97 17.52 21.97 12C21.97 6.48 17.5 2 11.97 2ZM14.97 14.23L12.07 15.9C11.71 16.11 11.31 16.21 10.92 16.21C10.52 16.21 10.13 16.11 9.76997 15.9C9.04997 15.48 8.61997 14.74 8.61997 13.9V10.55C8.61997 9.72 9.04997 8.97 9.76997 8.55C10.49 8.13 11.35 8.13 12.08 8.55L14.98 10.22C15.7 10.64 16.13 11.38 16.13 12.22C16.13 13.06 15.7 13.81 14.97 14.23Z" fill="currentColor"/>
                            </svg>
                        </div>
                        <a href="{{route('front.details', $course)}}">
                            <p class="font-semibold group-hover:text-white transition-all duration-300">Course Trailer</p>
                        </a>
                    </div>
                    @forelse ($course->course_videos as $video)
                        @if(!$video->deleted_at)
                            @php
                                $currentVideoId = Route::current()->parameter('courseVideoId');
                                $isActive = $currentVideoId == $video->id;
                                $isWatched = in_array($video->id, $watchedVideos); // ✅ Cek apakah sudah ditonton
                            @endphp

                            <div class="group p-[12px_16px] flex items-center gap-[10px] {{$isActive ? 'bg-[#3525B3]' : 'bg-[#E9EFF3]'}} rounded-full hover:bg-[#3525B3] transition-all duration-300">
                                <div class="{{$isActive ? 'text-white' : 'text-black'}} group-hover:text-white transition-all duration-300">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.97 2C6.44997 2 1.96997 6.48 1.96997 12C1.96997 17.52 6.44997 22 11.97 22C17.49 22 21.97 17.52 21.97 12C21.97 6.48 17.5 2 11.97 2ZM14.97 14.23L12.07 15.9C11.71 16.11 11.31 16.21 10.92 16.21C10.52 16.21 10.13 16.11 9.76997 15.9C9.04997 15.48 8.61997 14.74 8.61997 13.9V10.55C8.61997 9.72 9.04997 8.97 9.76997 8.55C10.49 8.13 11.35 8.13 12.08 8.55L14.98 10.22C15.7 10.64 16.13 11.38 16.13 12.22C16.13 13.06 15.7 13.81 14.97 14.23Z" fill="currentColor"/>
                                    </svg>
                                </div>
                                <a href="{{ route('front.learning', [$course, 'courseVideoId' => $video->id]) }}">
                                    <p class="font-semibold group-hover:text-white transition-all duration-300 {{$isActive ? 'text-white' : 'text-black'}}">
                                        {{$video->name}}
                                    </p>
                                </a>

                                {{-- ✅ Tambahkan centang jika video sudah ditonton --}}
                                @if ($isWatched)
                                    <img src="{{ asset('assets/icon/tick-circle.svg') }}" alt="Watched" class="w-6 h-6">
                                @endif
                            </div>
                        @endif
                    @empty
                        <p>No videos available.</p>
                    @endforelse

                </div>
            </div>
        </div>
    </section>
    <section id="Video-Resources" class="flex flex-col mt-5">
        <div class="max-w-[1100px] w-full mx-auto flex flex-col gap-3">
            <h1 class="title font-extrabold text-[30px] leading-[45px]">{{$video->name}}</h1>
            <div class="flex items-center gap-5">
                <div class="flex items-center gap-[6px]">
                    <div>
                        <img src="{{ asset('assets/icon/crown.svg') }}" alt="icon">
                    </div>
                    <p class="font-semibold">
                        @foreach($course->categories as $category)
                            {{ $category->name }}@if (!$loop->last), @endif
                        @endforeach
                    </p>
                </div>


                <div class="flex items-center gap-[6px]">
                    <div>
                        <img src="{{asset('assets/icon/profile-2user.svg')}}" alt="icon">
                    </div>
                    <p class="font-semibold">{{$course->students->count()}} Students</p>
                </div>

            </div>
        </div>
        <div
        class="max-w-[1100px] w-full mx-auto mt-10 tablink-container flex gap-3 px-4 sm:p-0 no-scrollbar overflow-x-scroll">
            <div class="tablink font-semibold text-lg h-[47px] transition-all duration-300 cursor-pointer hover:text-[#FF6129]"
                onclick="openPage('About', this)" id="defaultOpen">About</div>
            <div class="tablink font-semibold text-lg h-[47px] transition-all duration-300 cursor-pointer hover:text-[#FF6129]"
                onclick="openPage('Resources', this)">Resources</div>
            <div class="tablink font-semibold text-lg h-[47px] transition-all duration-300 cursor-pointer hover:text-[#FF6129]"
                onclick="openPage('Discussions', this)">Discussions</div>
        </div>
        <div class="
            {{-- bg-[#F5F8FA] --}}
            bg-white
             py-[50px]">
                <div class="max-w-[1100px] w-full mx-auto flex flex-col gap-[70px]">
                    <div class="flex gap-[50px]">
                        <div class="tabs-container w-[700px] flex shrink-0">
                            <div id="About" class="tabcontent hidden">
                                <div class="flex flex-col gap-5 w-[700px] shrink-0">
                                    <h3 class="font-bold text-2xl">Grow Your Career</h3>
                                    <p class="font-medium leading-[30px]">
                                        {!! $course->about !!}
                                    </p>
                                    <div class="grid grid-cols-2 gap-x-[30px] gap-y-5">
                                        @forelse ($course->course_keypoints as $keypoint)
                                            <div class="benefit-card flex items-center gap-3">
                                                <div class="w-6 h-6 flex shrink-0">
                                                    <img src="{{ asset('assets/icon/tick-circle.svg') }}" alt="icon">
                                                </div>
                                                <p class="font-medium leading-[30px]">{{ $keypoint->name }}</p>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            <div id="Resources" class="tabcontent hidden">
                                <div class="flex flex-col gap-5 w-[700px] shrink-0">
                                    <h3 class="font-bold text-2xl">Resources</h3>
                                    <p class="font-medium leading-[30px]">
                                        Access our Resource Page, your one-stop destination for downloading course materials designed to help you learn and excel. From detailed guides to practice files, find everything you need to enhance your learning experience and make the most out of your studies. Click the button below to explore and download the resources now!
                                    </p>
                                    <div class="flex gap-6 w-fit">
                                        <a href="https://drive.google.com/drive/folders/{{ $course->resource }}"
                                            class="text-white font-semibold rounded-[30px] p-[16px_32px] bg-[#FF6129] transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980]">Download
                                            Resource</a>
                                    </div>
                                </div>
                            </div>
                            <div id="Reviews" class="tabcontent hidden">
                                <div class="flex flex-col gap-5 w-[700px] shrink-0">
                                    <h3 class="font-bold text-2xl">Reviews</h3>
                                    <p class="font-medium leading-[30px]">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt eos et accusantium
                                        quia exercitationem reiciendis? Doloribus, voluptate natus voluptas deserunt aliquam
                                        nesciunt blanditiis ipsum porro hic! Iusto maxime ullam soluta.
                                    </p>
                                </div>
                            </div>
                            <div id="Discussions" class="tabcontent hidden">
                                <div class="flex flex-col gap-5 w-[700px] shrink-0">
                                    <h3 class="font-bold text-2xl">Discussions</h3>
                                    <p class="font-medium leading-[30px]">
                                        Join our Discord server, an interactive forum designed for students and mentors to exchange ideas, discuss course materials, receive guidance from experienced mentors, and connect with fellow learners. Click the button below to become part of this inspiring learning community!
                                    </p>
                                    <div class="flex gap-6 w-fit">
                                        <a href="https://discord.gg/JsGNBjmTKE"
                                            class="text-white font-semibold rounded-[30px] p-[16px_32px] bg-[#FF6129] transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980]" target="_blank">Join
                                            Forum</a>
                                    </div>
                                </div>
                            </div>
                            <div id="Rewards" class="tabcontent hidden">
                                <div class="flex flex-col gap-5 w-[700px] shrink-0">
                                    <h3 class="font-bold text-2xl">Rewards</h3>
                                    <p class="font-medium leading-[30px]">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt eos et accusantium
                                        quia exercitationem reiciendis? Doloribus, voluptate natus voluptas deserunt aliquam
                                        nesciunt blanditiis ipsum porro hic! Iusto maxime ullam soluta.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mentor-sidebar flex flex-col gap-[30px] w-full">
                            <div class="mentor-info bg-[#F5F8FA] flex flex-col gap-4 rounded-2xl p-5">
                                <p class="font-bold text-lg text-left w-full">Teacher</p>
                                <div class="flex items-center justify-between w-full">
                                    <div class="flex items-center gap-3">
                                        <a href=""
                                            class="w-[50px] h-[50px] flex shrink-0 rounded-full overflow-hidden">
                                            <img src="{{ Storage::url($course->teacher->user->avatar) }}"
                                                class="w-full h-full object-cover" alt="photo">
                                        </a>
                                        <div class="flex flex-col gap-[2px]">
                                            <a href=""
                                                class="font-semibold">{{ $course->teacher->user->name }}</a>
                                            <p class="text-sm text-[#6D7786]">{{ $course->teacher->user->occupation }}</p>
                                        </div>
                                    </div>
                                    {{-- <a href=""
                                        class="p-[4px_12px] rounded-full bg-[#FF6129] font-semibold text-xs text-white text-center">Follow</a> --}}
                                </div>
                            </div>
                            {{-- <div class="bg-white flex flex-col gap-5 rounded-2xl p-5">
                                <p class="font-bold text-lg text-left w-full">Unlock Badges</p>

                                <div class="flex items-center gap-3">
                                    <div class="w-[50px] h-[50px] flex shrink-0 rounded-full overflow-hidden">
                                        <img src="{{ asset('assets/icon/Group 7.svg') }}"
                                            class="w-full h-full object-cover" alt="icon">
                                    </div>
                                    <div class="flex flex-col gap-[2px]">
                                        <div class="font-semibold">Spirit of Learning</div>
                                        <p class="text-sm text-[#6D7786]">18,393 earned</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-[50px] h-[50px] flex shrink-0 rounded-full overflow-hidden">
                                        <img src="{{ asset('assets/icon/Group 7-1.svg') }}"
                                            class="w-full h-full object-cover" alt="icon">
                                    </div>
                                    <div class="flex flex-col gap-[2px]">
                                        <div class="font-semibold">Everyday New</div>
                                        <p class="text-sm text-[#6D7786]">6,392 earned</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-[50px] h-[50px] flex shrink-0 rounded-full overflow-hidden">
                                        <img src="{{ asset('assets/icon/Group 7-2.svg') }}"
                                            class="w-full h-full object-cover" alt="icon">
                                    </div>
                                    <div class="flex flex-col gap-[2px]">
                                        <div class="font-semibold">Quick Learner Pro</div>
                                        <p class="text-sm text-[#6D7786]">44 earned</p>
                                    </div>
                                </div>

                            </div> --}}
                        </div>
                    </div>
                    {{-- <div id="Screenshots" class="flex flex-col gap-3">
                        <h3 class="title-section font-bold text-xl leading-[30px] ">Students Portfolio</h3>
                        <div class="grid grid-cols-4 gap-5">
                            <div class="rounded-[20px] overflow-hidden w-full h-[200px] hover:shadow-[0_10px_20px_0_#0D051D20] transition-all duration-300"
                                data-src="{{ asset('assets/thumbnail/image.png') }}" data-fancybox="gallery"
                                data-caption="Caption #1">
                                <img src="{{ asset('assets/thumbnail/image.png') }}" class="object-cover h-full w-full"
                                    alt="image">
                            </div>
                            <div class="rounded-[20px] overflow-hidden w-full h-[200px] hover:shadow-[0_10px_20px_0_#0D051D20] transition-all duration-300"
                                data-src="{{ asset('assets/thumbnail/image-1.png') }}" data-fancybox="gallery"
                                data-caption="Caption #1">
                                <img src="{{ asset('assets/thumbnail/image-1.png') }}" class="object-cover h-full w-full"
                                    alt="image">
                            </div>
                            <div class="rounded-[20px] overflow-hidden w-full h-[200px] hover:shadow-[0_10px_20px_0_#0D051D20] transition-all duration-300"
                                data-src="{{ asset('assets/thumbnail/image-2.png') }}" data-fancybox="gallery"
                                data-caption="Caption #1">
                                <img src="{{ asset('assets/thumbnail/image-2.png') }}" class="object-cover h-full w-full"
                                    alt="image">
                            </div>
                            <div class="rounded-[20px] overflow-hidden w-full h-[200px] hover:shadow-[0_10px_20px_0_#0D051D20] transition-all duration-300"
                                data-src="{{ asset('assets/thumbnail/image-3.png') }}" data-fancybox="gallery"
                                data-caption="Caption #1">
                                <img src="{{ asset('assets/thumbnail/image-3.png') }}" class="object-cover h-full w-full"
                                    alt="image">
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </section>
        {{-- <section id="FAQ" class="max-w-[1200px] mx-auto flex flex-col py-[70px] px-[100px]">
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
        </section> --}}
        <x-footer />

    <!-- JavaScript -->

</body>
@endsection
@push('after-scripts')
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous">
    </script>

    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

    <script src="{{asset('build/js/main.js')}}"></script>
@endpush


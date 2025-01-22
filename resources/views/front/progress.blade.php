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
                    <h1 class="text-2xl font-semibold mb-4">Course History</h1>

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


                    <div class="container mx-auto p-6 mt-4">
                        <h1 class="text-2xl font-semibold">Lastest Artikel</h1>

                        <div class="grid grid-cols-3 gap-x-4 w-full">
                            @forelse ($articles as $article)
                                <div class="">
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
                                <div class="text-center">
                                    <div class="col-12 text-center flex justify-center">
                                        <img src="{{ asset('assets/images/background/no-data.jpg') }}" alt="No Data"
                                            class="img-fluid" style="width: clamp(150px, 50vw, 300px);">
                                    </div>
                                    <p class="pb-4 text-gray-500">No data avilable</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

        </section>
        <x-footer />
        <!-- JavaScript -->
        <script src="{{ asset('build/js/main.js') }}"></script>

    </body>
@endsection

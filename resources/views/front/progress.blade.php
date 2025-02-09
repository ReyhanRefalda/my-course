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
                                                class="font-semibold text-lg line-clamp-2 hover:line-clamp-none min-h-[56px]">
                                                {{ $course->name}}
                                             </a>
                                             <div class="flex justify-between items-center">
                                             
                                               
                                                {{-- <p class="text-right text-[#6D7786]">{{ $course->students->count() }}</p> --}}
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


                    <div class="container mx-auto py-6 px-0 mt-4">
                        <h1 class="text-2xl font-semibold">Lastest Artikel</h1>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4 py-4 px-0">
                            @forelse ($articles as $article)
                            <!-- Card -->
                            <div>
                                <div class="mb-2 min-h-[340px] overflow-hidden [border-bottom:1px_solid_#FF6129]">
                                    <a href="{{ route('artikel.show', ['slug' => $article->slug]) }}" class="overflow-hidden">
                                        <img src="{{ asset(getenv('CUSTOM_TUMBNAIL_LOCATION') . '/' . $article->tumbnail) }}"
                                            class="w-full h-[190px] object-cover rounded-lg overflow-hidden transition hover:scale-[1.02] duration-300"
                                            alt="{{ $article->title }}">
                                    </a>
                                    <div class="h-[150px] flex flex-col justify-between p-2 overflow-y-hidden">
                                        <a href="{{ route('artikel.show', ['slug' => $article->slug]) }}"
                                            class="hover:underline hover:text-[#FF6129] text-[#181818] text[1.3rem] font-bold">
                                            <h3 class="text-[1.3rem] font-bold">{{ Str::limit($article->title, 47) }}</h3>
                                        </a>
                                        <div class="flex justify-between">
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
                        @empty
                            <!-- Empty State -->
                            <div class="col-span-full text-center">
                                <div class="flex justify-center">
                                    <img src="{{ asset('assets/images/background/no-data.jpg') }}" alt="No Data"
                                        class="w-[150px] md:w-[200px] lg:w-[300px]">
                                </div>
                                <p class="text-gray-500 mt-4">No data available</p>
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

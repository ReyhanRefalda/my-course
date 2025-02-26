@extends('../layouts.master')
@section('content')
<body class="text-black font-poppins pt-10 pb-[50px]">
    <div id="hero-section" class="max-w-[1200px] mx-auto w-full flex flex-col gap-10 bg-[url('{{ asset('assets/background/Hero-Banner.png') }}')] bg-center bg-no-repeat bg-cover rounded-[32px] overflow-hidden">
        <x-navcat/>
    </div>

    <section id="Top-Categories" class="max-w-[1200px] mx-auto flex flex-col py-[70px] px-[100px] gap-[30px]">
        <div class="flex flex-col gap-[30px]">
            <div class="gradient-badge w-fit p-[8px_16px] rounded-full border border-[#FED6AD] flex items-center gap-[6px]">
                <div>
                    <img src="{{asset('assets/icon/medal-star.svg')}}" alt="icon">
                </div>
                <p class="font-medium text-sm text-[#FF6129]">Best courses</p>
            </div>

            <div class="flex flex-col">
                <h2 class="font-bold text-[40px] leading-[60px]">All of our amazing courses</h2>
                <p class="text-[#6D7786] text-lg -tracking-[2%]">Catching up the on demand skills and high paying career this year</p>
            </div>

            <!-- Filter Form -->
            <form action="{{ route('front.course') }}" method="GET"
                class="flex flex-wrap md:flex-row items-center gap-x-4 mb-6 bg-white p-4 rounded-2xl">

                <!-- Pencarian -->
                <div class="flex items-center space-x-2 bg-white border border-gray-300 rounded-2xl px-4 py-[2px] shadow-sm w-[300px]">
                    <button type="submit" class="text-gray-400">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <input type="text" name="search" placeholder="Search Course" value="{{ request('search') }}"
                        class="block w-full px-0 text-[#525252] bg-[#fff] focus:border-[#fff] sm:text-sm focus:outline-none border-none focus:ring-white">
                </div>

                <div class="flex gap-x-4 justify-between">
                    <!-- Filter Kategori -->
                    <select name="category"
                        class="border border-gray-300 rounded-2xl text-sm px-3 py-2 shadow-sm text-gray-700 w-[200px]">
                        <option value="">Choose Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Filter Tanggal -->
                    <input type="date" name="created_at"
                        class="border border-gray-300 text-sm px-3 py-2 rounded-2xl text-gray-700 w-[200px]"
                        value="{{ request('created_at') }}">

                    <!-- Tombol Filter -->
                    <button type="submit"
                        class="px-4 py-2 text-white bg-[#3525B3] rounded-2xl font-bold hover:bg-indigo-800 transition duration-300 ease-in-out w-[120px]">
                        Filter
                    </button>
                </div>
            </form>

            <!-- Grid Course List -->
            <div class="grid grid-cols-3 gap-[30px] w-full">
                @forelse ($courses as $course)
                <div class="course-card">
                    <div class="flex flex-col rounded-t-[12px] rounded-b-[24px] gap-[32px] bg-white w-full pb-[10px] overflow-hidden ring-1 ring-[#DADEE4] transition-all duration-300 hover:ring-2 hover:ring-[#FF6129]">
                        <a href="{{route('front.details', $course->slug)}}" class="thumbnail w-full h-[200px] shrink-0 rounded-[10px] overflow-hidden">
                            <img src="{{Storage::url($course->thumbnail)}}" class="w-full h-full object-cover" alt="thumbnail">
                        </a>
                        <div class="flex flex-col px-4 gap-[32px]">
                            <div class="flex flex-col gap-[10px]">
                                <a href="{{route('front.details', $course->slug)}}" class="font-semibold text-lg line-clamp-2 hover:line-clamp-none min-h-[56px]">{{$course->name}}</a>
                                <div class="flex justify-between items-center">
                                    {{-- <div class="flex items-center gap-[2px]">
                                        @for ($i = 0; $i < 5; $i++)
                                            <div>
                                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                                            </div>
                                        @endfor
                                    </div> --}}
                                    <p class="text-right text-[#6D7786]">{{$course->students->count()}}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src="{{Storage::url($course->teacher->user->avatar)}}" class="w-full h-full object-cover" alt="icon">
                                </div>
                                <div class="flex flex-col">
                                    <p class="font-semibold">{{$course->teacher->user->name}}</p>
                                    <p class="text-[#6D7786]">{{$course->teacher->user->occupation}}</p>
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
            <div class="py-4 px-12">
                {{$courses->links() }}
            </div>
        </div>
    </section>

    <x-footer/>
    <script src="{{asset('build/js/main.js')}}"></script>
</body>
@endsection

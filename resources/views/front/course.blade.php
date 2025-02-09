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
            <form action="{{ route('front.course') }}" method="GET" class="flex flex-wrap gap-4 mb-6 items-center bg-white p-4 rounded shadow-md">
                <div class="flex flex-wrap gap-4">
                    <div class="w-[200px]">
                        <select name="category" class="p-3 border rounded w-full">
                            <option value="">Choose Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
            
                    <div class="w-[200px]">
                        <input type="date" name="created_at" class="p-3 border rounded w-full" value="{{ request('created_at') }}">
                    </div>
            
                    <div class="w-[120px]">
                        <button type="submit" class="p-3 bg-orange-500 text-white rounded w-full hover:bg-orange-700 transition duration-300">
                            Filter
                        </button>
                    </div>
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
                                    <div class="flex items-center gap-[2px]">
                                        @for ($i = 0; $i < 5; $i++)
                                            <div>
                                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                                            </div>
                                        @endfor
                                    </div>
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
        </div>
    </section>

    <x-footer/>
    <script src="{{asset('build/js/main.js')}}"></script>
</body>
@endsection

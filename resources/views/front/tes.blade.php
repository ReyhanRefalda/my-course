<div class="flex flex-col gap-4
    {{-- justify-between items-center --}}
    ">
        <div class="grid grid-cols-2 items-center text-gray-600 rounded-[30px] bg-[#cccccc] w-fit">
            <button id="btn-courses" class="section-btn active-btn transition-all duration-300 ease-in-out">Courses</button>
            <button id="btn-articles" class="section-btn transition-all duration-300 ease-in-out">Articles</button>
        </div>

        <div class="block space-y-4">

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
                            {{$courses->links() }}
                        </div>
                    </div>


                    <div id="section-articles" class="section hidden">
                        <p class="text-xl font-bold text-center py-4">Articles Section</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @forelse ($visitedArticles as $artikel)
                            <div class="course-card w-full">
                                <div class="flex flex-col rounded-t-[12px] rounded-b-[24px] gap-4 bg-white w-full pb-2 overflow-hidden ring-1 ring-[#DADEE4] transition-all duration-300 hover:ring-2 hover:ring-[#FF6129]">
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
                        <div class="py-4 flex justify-end">{!! $visitedArticles->links() !!}</div>
                    </div>

            @role('owner')
                <div class="alert alert-warning" role="alert">
                    You do not have access to manage withdrawal requests.
                </div>
            @endrole

            @role('teacher')
                <div class="alert alert-warning" role="alert">
                    You do not have access to manage withdrawal requests.
                </div>
            @endrole
        </div>
    </div>

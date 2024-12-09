<x-user>
    <!-- Container -->
    <div class="max-w-7xl mx-auto p-4 [border-bottom:1px_solid_#606060]">

        <!-- Headline Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 mb-6 shadow [border-bottom:1px_solid_#404040]">
            <!-- Main Featured Article -->
            @if ($lastData)
                <div class="group sm:w-[90%] md:w-[800px] m-4 rounded-lg md:col-span-2 relative overflow-hidden">
                    <a href="{{ route('artikel.show', ['slug' => $lastData->slug]) }}">
                        <img src="{{ asset(getenv('CUSTOM_TUMBNAIL_LOCATION') . '/' . $lastData->tumbnail) }}"
                            alt="{{ $lastData->title }}"
                            class="sm:w-[90%] md:w-[800px] md:h-[450px] object-cover rounded-lg transition-transform duration-300 group-hover:scale-105">
                    </a>
                    <div class="absolute inset-0 flex items-end rounded-lg">
                        <div class="w-full bg-black bg-opacity-50 p-4">
                            <a href="{{ route('artikel.show', ['slug' => $lastData->slug]) }}">
                                <h2 class="text-[#f7f9fa] text-2xl md:text-4xl font-semibold hover:underline">
                                    {{ $lastData->title }}</h2>
                            </a>
                            <div class="flex gap-8">
                                <p class="sm:text-[8px] md:text-lg text-yellow-500 mt-2 font-bold">Latest News</p>
                                <p class="sm:text-[8px] md:text-lg text-[#f7f9fa] mt-2 font-semibold">By
                                    {{ $lastData->user->name }}</p>
                                <p class="sm:text-[8px] md:text-lg text-[#f7f9fa] mt-2 font-semibold">
                                    @if ($lastData->created_at->diffInHours(now()) < 24)
                                        {{ $lastData->created_at->diffForHumans() }}
                                    @else
                                        {{ $lastData->created_at->isoFormat('dddd, D MMMM Y') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center text-gray-500 p-4">
                    <p>Tidak ada artikel yang tersedia saat ini.</p>
                </div>
            @endif

            <!-- Sidebar -->
            <div class="space-y-6 m-4">
                <!-- Article Sidebar Items -->
                @foreach ($secondToFifthData as $secondToFifthData)
                    <div class="mb-2 pb-2">
                        <a href="{{ route('artikel.show', ['slug' => $secondToFifthData->slug]) }}"
                            class="flex space-x-4 overflow-hidden rounded-lg">
                            <img src="{{ asset(getenv('CUSTOM_TUMBNAIL_LOCATION') . '/' . $secondToFifthData->tumbnail) }}"
                                class="w-20 h-20 object-cover rounded-lg transition-transform duration-300 hover:scale-105"
                                alt="{{ $secondToFifthData->title }}">
                            <div>
                                <p class="text-lg text-[#181818] font-semibold hover:underline">
                                    {{ $secondToFifthData->title }}</p>
                                <p class="text-xs text-gray-700 mt-2">
                                    <span class="font-semibold">By {{ $secondToFifthData->user->name }}</span> |
                                    @if ($secondToFifthData->created_at->diffInHours(now()) < 24)
                                        {{ $secondToFifthData->created_at->diffForHumans() }}
                                    @else
                                        {{ $secondToFifthData->created_at->isoFormat('dddd, D MMMM Y') }}
                                    @endif
                                </p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
            @foreach ($artikels as $artikel)
                <x-artikel-list title="{{ $artikel->title }}"
                    image="{{ asset(getenv('CUSTOM_TUMBNAIL_LOCATION') . '/' . $artikel->tumbnail) }}"
                    user="{{ $artikel->user->name }}" link="{{ route('artikel.show', ['slug' => $artikel->slug]) }}"
                    :date="$artikel->created_at" />
            @endforeach
        </div>
        {!! $artikels->links() !!}
    </div>

</x-user>

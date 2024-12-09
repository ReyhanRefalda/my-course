@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-end space-x-4">
        {{-- Tombol Previous --}}
        @if ($paginator->onFirstPage())
            <span
                class="inline-flex items-center justify-center w-[40px] h-[40px] rounded-xl bg-gray-200 text-gray-500 cursor-not-allowed">
                &laquo;
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
                class="inline-flex items-center justify-center w-[40px] h-[40px] rounded-xl bg-white text-gray-700 border border-gray-300 hover:bg-[#3525B3] hover:text-white">
                &laquo;
            </a>
        @endif

        {{-- Halaman --}}
        @foreach ($elements as $element)
            {{-- Tiga Titik --}}
            @if (is_string($element))
                <span
                    class="inline-flex items-center justify-center w-[40px] h-[40px] rounded-full text-gray-500">{{ $element }}</span>
            @endif

            {{-- Nomor Halaman --}}
            @if (is_array($element))
                <div class="flex items-center justify-center gap-x-2 border border-[#898D93] rounded-xl bg-white">
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span
                                class="inline-flex items-center justify-center w-[40px] h-[40px] rounded-xl bg-[#3525B3] text-white font-semibold">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                                class="inline-flex items-center justify-center w-[40px] h-[40px] rounded-xl bg-white text-gray-700 ">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif
        @endforeach

        {{-- Tombol Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
                class="inline-flex items-center justify-center w-[40px] h-[40px] rounded-xl bg-white text-gray-700 border border-gray-300 hover:bg-[#3525B3] hover:text-white">
                &raquo;
            </a>
        @else
            <span
                class="inline-flex items-center justify-center w-[40px] h-[40px] rounded-xl bg-gray-200 text-gray-500 cursor-not-allowed">
                &raquo;
            </span>
        @endif
    </nav>
@endif

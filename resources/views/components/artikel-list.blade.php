@props(['title', 'date', 'user', 'link', 'image'])
<div>
    <div class="mb-2 min-h-[340px] bg-[#181818] shadow overflow-hidden [border-bottom:1px_solid_#424242]">
        <a href="{{ $link }}" class="overflow-hidden">
            <img src="{{ $image }}"
                class="w-full h-[190px] object-cover rounded-lg overflow-hidden transition hover:scale-[1.02] duration-300"
                alt="{{ $title }}">
        </a>
        <div class="h-[150px] flex flex-col justify-between p-2 overflow-y-hidden">
            <a href="{{ $link }}" class="hover:underline text-[#f7f9fa] text[1.3rem] font-bold">
                <h3 class="text-[1.3rem] font-bold">{{ $title }}</h3>
            </a>
            <div class="flex justify-between">
                <p class="text-sm text-gray-300 font-semibold">By {{ $user }}</p>
                <p class="text-sm text-gray-300">
                    @if ($date->diffInHours(now()) < 24)
                        {{ $date->diffForHumans() }}
                    @else
                        {{ $date->isoFormat('dddd, D MMMM Y') }}
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

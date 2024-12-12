<x-user>
    <main class="pt-4 pb-16 lg:pt-4 lg:pb-24 antialiased">

        {{-- social media --}}
        <div class="mx-16 mb-4 px-6 py-3 flex justify-between items-center leading-[170%] border-y-2 border-[#3525B3]">
            <div class="flex items-center gap-6">
                <h3 class="text-xl font-semibold text-[#3525B3] [letter-spacing:3px;]">FOLLOW US</h3>
                <a href="#">
                    <img src="{{ asset('assets/socialmedia/instagram-logo.png') }}" alt="instagram"
                        class="w-12 h-12 p-1 rounded-full [border:1px_solid_#3525B3] hover:[border:1px_solid_#3525B3] hover:bg-[#3525B3] transition-all duration-300">
                </a>
                <a href="#">
                    <img src="{{ asset('assets/socialmedia/facebook-logo.png') }}" alt="facebook"
                        class="w-12 h-12 p-1 rounded-full [border:1px_solid_#3525B3] hover:[border:1px_solid_#3525B3] hover:bg-[#3525B3] transition-all duration-300">
                </a>
                <a href="#">
                    <img src="{{ asset('assets/socialmedia/X-logo.png') }}" alt="X"
                        class="w-12 h-12 p-1 rounded-full [border:1px_solid_#3525B3] hover:[border:1px_solid_#3525B3] hover:bg-[#3525B3] transition-all duration-300">
                </a>
                <a href="#">
                    <img src="{{ asset('assets/socialmedia/telegram-logo.png') }}" alt="telegram"
                        class="w-12 h-12 p-1 rounded-full [border:1px_solid_#3525B3] hover:[border:1px_solid_#3525B3] hover:bg-[#3525B3] transition-all duration-300">
                </a>
            </div>
            <div class="flex items-center gap-4">
                <form action="{{ route('artikel.index') }}" method="GET" class="flex items-center max-w-sm mx-auto">
                    <div class="relative w-full">
                        <input type="text" name="search" id="search" placeholder="Search news..."
                            class="block w-full px-4 py-2 text-[#3525B3] [border:2px_solid_#3525B3] rounded-lg focus:ring-[#3525B3] focus:border-[#f7f9fa] sm:text-sm"
                            value="{{ request('search') }}" />
                    </div>
                    <button type="submit"
                        class="p-2.5 ms-2 text-sm font-medium text-[#3525B3] hover:text-[#f7f9fa] bg-[#f7f9fa] rounded-lg border border-[#f7f9fa] hover:border-[#3525B3] hover:bg-[#3525B3] focus:ring-4 focus:outline-none focus:ring-blue-300 transition-all duration-300">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                </form>
            </div>
        </div>

        <div
            class="grid [grid-template-columns:1fr] md:[grid-template-columns:2fr_.9fr] pt-8 px-4 mx-auto max-w-screen-xl ">
            <article
                class="mx-auto w-full max-w-2xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
                <header class="mb-4 lg:mb-6 not-format">
                    <address class="flex items-center mb-6 not-italic">
                        <div class="inline-flex items-center mr-3 text-sm text-gray-900">
                            @if ($artikels->user->avatar)
                                <img src="{{ Storage::url($artikels->user->avatar) }}"
                                    alt="{{ $artikels->user->avatar }}" class="w-10 h-10 rounded-full mr-2" />
                            @else
                                <img src="{{ asset('aset/default-profile.png') }}" alt="Default profile"
                                    class="w-10 h-10 rounded-full mr-2" />
                            @endif
                            <div>
                                <a href="#" rel="author"
                                    class="text-lg font-bold text-gray-800">{{ $artikels->user->name }}</a>
                                <p class="text-sm text-gray-300 dark:text-gray-400">
                                    @if ($artikels->created_at->diffInHours(now()) < 24)
                                        {{ $artikels->created_at->diffForHumans() }}
                                    @else
                                        {{ $artikels->created_at->isoFormat('dddd, D MMMM Y') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </address>
                    <h1 class="text-gray-800 mb-4 text-3xl font-extrabold leading-tight lg:mb-6 lg:text-4xl">
                        {{ $artikels->title }}</h1>
                </header>

                <div class="flex justify-center">
                    <figure><img src="{{ asset(getenv('CUSTOM_TUMBNAIL_LOCATION') . '/' . $artikels->tumbnail) }}"
                            alt="{{ $artikels->title }}" class="flex justify-center rounded-lg max-h-[400px]">
                    </figure>
                </div>

                {{-- social media --}}
                <div
                    class="gradient-badge px-6 py-3 rounded-lg flex justify-between items-center leading-[170%] border-[2px] border-[#FED6AD]">
                    <div class="flex flex-col items-center justify-center w-full">
                        <h3 class="m-0 p-0 text-[12px] font-semibold text-[#FF6129] [letter-spacing:1px;]">FOLLOW US FOR
                            THE LATEST NEWS</h3>
                        <div class="flex items-center justify-center gap-6">
                            <a href="#">
                                <img src="{{ asset('assets/socialmedia/instagram-logo.png') }}" alt="instagram"
                                    class="m-0 w-8 h-8 p-1 rounded-full [border:1px_solid_#404040] hover:[border:1px_solid_#f7f9fa] hover:bg-[#f7f9fa] transition-all duration-300">
                            </a>
                            <a href="#">
                                <img src="{{ asset('assets/socialmedia/facebook-logo.png') }}" alt="facebook"
                                    class="m-0 w-8 h-8 p-1 rounded-full [border:1px_solid_#404040] hover:[border:1px_solid_#f7f9fa] hover:bg-[#f7f9fa] transition-all duration-300">
                            </a>
                            <a href="#">
                                <img src="{{ asset('assets/socialmedia/X-logo.png') }}" alt="X"
                                    class="m-0 w-8 h-8 p-1 rounded-full [border:1px_solid_#404040] hover:[border:1px_solid_#f7f9fa] hover:bg-[#f7f9fa] transition-all duration-300">
                            </a>
                            <a href="#">
                                <img src="{{ asset('assets/socialmedia/telegram-logo.png') }}" alt="telegram"
                                    class="m-0 w-8 h-8 p-1 rounded-full [border:1px_solid_#404040] hover:[border:1px_solid_#f7f9fa] hover:bg-[#f7f9fa] transition-all duration-300">
                            </a>
                        </div>
                    </div>
                </div>

                @auth
                    <p class="trix-content">
                        {!! $artikels->content !!}</p>
                @else
                    <p class="trix-content">
                        {!! Str::limit($artikels->content, 340) !!}</p>

                    <div class="login-invitation flex flex-col items-center justify-center">
                        <p class="text-center text-[#f7f9fa] font-semibold mb-4">Ingin tahu lebih banyak?<br>
                            Login sekarang untuk membaca artikel ini secara lengkap!</p>
                        <a href="{{ route('login') }}"
                            class="text-white bg-[#FF6129] py-2 px-4 rounded-lg text-center no-underline hover:underline hover:bg-[#e75c29] hover:scale-105 active:scale-110 transition-all duration-300">Login</a>
                    </div>
                @endauth
            </article>

            <!-- Sidebar -->
            <div class="hidden md:flex flex-col">
                <div class="sticky top-[80px] space-y-6 m-4">
                    <h3 class="border-b border-[#FF6129] pb-2 text-sm lg:text-lg font-semibold text-[#FF6129] italic">
                        LATEST NEWS</h3>
                    @forelse ($artikleSidebar as $artikel)
                        <div class="mb-2 pb-2 [border-bottom:1px_solid_#FF6129]">
                            <a href="{{ route('artikel.show', ['slug' => $artikel->slug]) }}"
                                class="space-x-4 overflow-hidden rounded-lg">
                                <div>
                                    <p class="text-lg font-semibold hover:underline hover:text-[#FF6129]">
                                        {{ $artikel->title }}</p>
                                    <p class="text-xs text-gray-600 mt-2 hover:text-[#FF6129]"><span
                                            class="font-semibold">By
                                            {{ $artikel->user->name }}</span> |
                                        @if ($artikel->created_at->diffInHours(now()) < 24)
                                            {{ $artikel->created_at->diffForHumans() }}
                                        @else
                                            {{ $artikel->created_at->isoFormat('dddd, D MMMM Y') }}
                                        @endif
                                    </p>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="text-[#181818]">Belum ada artikel terbaru...</p>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
</x-user>

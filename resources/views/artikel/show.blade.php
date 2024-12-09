<x-user>
    <main class="pt-4 pb-16 lg:pt-4 lg:pb-24 antialiased">


        <div class="grid [grid-template-columns:1fr] md:[grid-template-columns:2fr_.9fr] pt-8 px-4 mx-auto max-w-screen-xl ">
            <article
                class="mx-auto w-full max-w-2xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
                <header class="mb-4 lg:mb-6 not-format">
                    <address class="flex items-center mb-6 not-italic">
                        <div class="inline-flex items-center mr-3 text-sm text-gray-900">
                            @if ($artikels->user->avatar)
                                <img src="{{ Storage::url($artikels->user->avatar) }}" alt="{{ $artikels->user->avatar }}"
                                    class="w-10 h-10 rounded-full mr-2" />
                            @else
                                <img src="{{ asset('aset/default-profile.png') }}" alt="Default profile"
                                    class="w-10 h-10 rounded-full mr-2" />
                            @endif
                            <div>
                                <a href="#" rel="author"
                                    class="text-lg font-bold text-gray-800">{{ $artikels->user->name }}</a>
                                <p class="text-sm text-gray-300 dark:text-gray-400">
                                    {{ $artikels->created_at->isoFormat('dddd, D MMMM Y') }}</p>
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

                @auth
                    <p class="trix-content">
                        {!! $artikels->content !!}</p>
                @else
                    <p class="trix-content">
                        {!! Str::limit($artikels->content, 340) !!}</p>

                    <div class="login-invitation flex flex-col items-center justify-center">
                        <p class="text-center text-[#f7f9fa]">Ingin tahu lebih banyak?<br>
                            Login sekarang untuk membaca artikel ini secara lengkap!</p>
                        <a href="{{ route('login') }}"
                            class="bg-[#FCB16B] text-[#f7f9fa] py-2 px-4 rounded-lg text-center no-underline hover:underline hover:bg-[#db8b40] active:scale-110 transition-all duration-300">Login</a>
                    </div>
                @endauth
            </article>

            <!-- Sidebar -->
            <div class="hidden md:flex flex-col">
                <div class="sticky top-[80px] space-y-6 m-4">
                    <h3 class="border-b border-gray-600 pb-2 text-sm lg:text-lg font-semibold text-[#3525B3] italic">
                        BERITA TERBARU</h3>
                    <!-- Article Sidebar Items -->
                    @forelse ($artikleSidebar as $artikel)
                        <div class="mb-2 pb-2 [border-bottom:1px_solid_#424242]">
                            <a href="{{ route('artikel.show', ['slug' => $artikel->slug]) }}"
                                class="space-x-4 overflow-hidden rounded-lg">
                                <div>
                                    <p class="text-lg font-semibold hover:underline">
                                        {{ $artikel->title }}</p>
                                    <p class="text-xs text-gray-600 mt-2"><span class="font-semibold">By
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

<nav class="flex justify-between items-center py-6 px-[50px]">
    <a href="">
        <img src="{{asset('assets/logo/logo-white.png')}}" alt="logo " style="width: 256px; height: auto;">
    </a>
    <ul class="flex items-center gap-[30px] text-white">
        <li>
            <a href="{{route('front.index')}}" class="font-semibold">Home</a>
        </li>
        <li>
            <a href="{{route('front.course')}}" class="font-semibold">Course</a>
        </li>
        <li>
            <a href="{{ route('artikel.index') }}" class="font-semibold">Article</a>
        </li>
        @if (!Auth::check() || (Auth::check() && !Auth::user()->hasActiveSubscription()))
                    <li>
                        <a href="{{ route('front.pricing') }}" class="font-semibold">Pricing</a>
                    </li>
        @endif
        @role('student')
            <li>
                <a href="{{route('front.progress')}}" class="font-semibold">Progress</a>
            </li>
            @endrole
            @role('teacher|owner')
            <li>
                <a href="{{route('dashboard')}}" class="font-semibold">Dashboard</a>
            </li>
            @endrole
    </ul>
    @guest
    <div class="flex gap-[10px] items-center">
        <a href="{{route('register')}}" class="text-white font-semibold rounded-[30px] p-[16px_32px] ring-1 ring-white transition-all duration-300 hover:ring-2 hover:ring-[#FF6129]">Sign Up</a>
        <a href="{{route('login')}}" class="text-white font-semibold rounded-[30px] p-[16px_32px] bg-[#FF6129] transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980]">Sign In</a>
    </div>
    @endguest
    @auth
    <div class="flex gap-[10px] items-center">
        <div class="flex flex-col items-end justify-center">
            <p class="font-semibold text-white">Hi, {{Auth::user()->name}}</p>
            @if (Auth::user()->hasActiveSubscription())
                <p class="p-[2px_10px] rounded-full bg-[#FF6129] font-semibold text-xs text-white text-center">PRO</p>
            @endif
        </div>
        <div class="w-[56px] h-[56px] overflow-hidden rounded-full flex shrink-0">
            <img src="{{Storage::url(Auth::user()->avatar)}}" class="w-full h-full object-cover" alt="photo">
        </div>
    </div>
    @endauth

    <div class="px-4 mt-[7px] mb-2 grid">
        <a href="#"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="btn-outline-primary font-medium text-[15px] w-full hover:bg-blue-600 hover:text-white">
            Logout
        </a>

        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
            @csrf
        </form>

    </div>
</nav>


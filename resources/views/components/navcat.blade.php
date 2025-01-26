<nav class="flex justify-between items-center py-6 px-[50px]">
    <a href="">
        <img src="{{ asset('assets/logo/logo-white.png') }}" alt="logo " style="width: 256px; height: auto;">
    </a>
    <ul class="flex items-center gap-[30px] text-white">
        <li>
            <a href="{{ route('front.index') }}" class="font-semibold">Home</a>
        </li>
        <li>
            <a href="{{ route('front.course') }}" class="font-semibold">Course</a>
        </li>
        <li>
            <a href="{{ route('artikel.index') }}" class="font-semibold">Article</a>
        </li>
        @if (!Auth::check() || (Auth::check() && !Auth::user()->hasActiveSubscription()))
            <li>
                <a href="{{ route('front.pricing') }}" class="font-semibold">Pricing</a>
            </li>
        @endif
        @auth
            @if (Auth::user()->hasRole('student') && !Auth::user()->hasRole('teacher') && !Auth::user()->hasRole('owner'))
                <li>
                    <a href="{{ route('front.progress') }}" class="font-semibold">Progress</a>
                </li>
            @endif
        @endauth
    </ul>
    @guest
        <div class="flex gap-[10px] items-center">
            <a href="{{ route('register') }}"
                class="text-white font-semibold rounded-[30px] p-[16px_32px] ring-1 ring-white transition-all duration-300 hover:ring-2 hover:ring-[#FF6129]">Sign
                Up</a>
            <a href="{{ route('login') }}"
                class="text-white font-semibold rounded-[30px] p-[16px_32px] bg-[#FF6129] transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980]">Sign
                In</a>
        </div>
    @endguest

    @auth
        <div class="flex items-center justify-end">
            <div class="hs-dropdown relative inline-flex [--placement:bottom-right] sm:[--trigger:hover]">
                <div class="flex flex-col items-end justify-center mr-4">
                    <h3 class="text-lg font-semibold mb-1 text-white">Hi, {{ Auth::user()->name }}</h3>
                    {{-- role user  owner, teacher, or student --}}
                    <div class="flex justify-center items-center gap-x-2">
                        @if ($remainingDays !== null)
                            @if ($remainingDays > 0)
                                <span class="text-[#FF6129] text-sm">Remaining {{ $remainingDays }} days!</span>
                            @elseif($remainingDays === 0)
                                <span class="text-[#FF6129] text-sm">Last Day!</span>
                            @endif
                        @endif
                        <p class="text-[12px] text-white bg-[#FF6129] rounded-full px-4 py-1 text-center font-semibold">
                            @if (Auth::user()->hasRole('owner'))
                                <span class="badge badge-success">Owner</span>
                            @elseif (Auth::user()->hasRole('teacher') && Auth::user()->teacher?->status === 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif(Auth::user()->hasRole('teacher'))
                                <span class="badge badge-warning">Teacher</span>
                            @elseif (Auth::user()->hasRole('student') && Auth::user()->hasActiveSubscription())
                                <span class="badge badge-primary">PRO</span>
                            @elseif (Auth::user()->hasRole('student'))
                                <span class="badge badge-warning">Student</span>
                            @endif
                        </p>
                    </div>
                </div>
                <a
                    class="w-12 h-12 relative flex items-center justify-center hs-dropdown-toggle cursor-pointer align-middle rounded-full">
                    <img src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : asset('images/avatar-default.png') }}"
                        alt="Profile Picture" class="object-cover w-12 h-12 rounded-full">
                </a>
                <div class="card hs-dropdown-menu transition-[opacity,margin] border border-gray-300 rounded-[20px] duration hs-dropdown-open:opacity-100 opacity-0 mt-2 min-w-max  px-6 py-2 hidden z-[12]"
                    aria-labelledby="hs-dropdown-custom-icon-trigger">
                    <div class="card-body p-0 py-2">
                        @role('teacher|owner')
                            <div
                                class="mt-[7px] mb-4 flex justify-start items-center gap-x-1 text-gray-800 hover:text-[#FF6129]">
                                <i class="ti ti-dashboard text-[30px]"></i>
                                <a href="{{ route('dashboard') }}" class="font-medium">Dashboard</a>
                            </div>
                        @endrole
                        <div
                            class="mt-[7px] mb-4 flex justify-start items-center gap-x-1 text-gray-800 hover:text-[#FF6129]">
                            <i class="ti ti-settings text-[30px]"></i>
                            <a href="{{ route('profile.edit') }}" class="font-medium">Account Setting</a>
                        </div>
                        <div
                            class="mt-[7px] mb-2 flex justify-start items-center gap-x-1 text-gray-800 hover:text-[#FF6129]">
                            <i class="ti ti-logout text-[30px]"></i>
                            <div class="">
                                <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="font-medium">
                                    Logout
                                </a>
                                <form id="logout-form" method="POST" action="{{ route('logout') }}"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endauth
</nav>

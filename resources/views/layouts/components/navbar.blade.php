<nav class="w-ful flex items-center justify-between" aria-label="Global">
    <ul class="icon-nav flex items-center gap-4">
        <li class="relative xl:hidden">
            <a class="text-xl  icon-hover cursor-pointer text-heading" id="headerCollapse"
                data-hs-overlay="#application-sidebar-brand" aria-controls="application-sidebar-brand"
                aria-label="Toggle navigation" href="javascript:void(0)">
                <i class="ti ti-menu-2 relative z-1"></i>
            </a>
        </li>

        <li class="relative">
            {{ $navbarLink }}
        </li>
    </ul>


    <div class="flex items-center gap-4">
        <div class="hs-dropdown relative inline-flex [--placement:bottom-right] sm:[--trigger:hover]">
            <div class="flex flex-col items-end justify-center mr-4">
                <h3 class="text-xl font-bold mb-1">{{ Auth::user()->name }}</h3>
                {{-- role user  owner, teacher, or student --}}
                <p class="text-[12px] text-white bg-[#FF6129] rounded-full px-4 py-1 text-center font-semibold">
                    @if (Auth::user()->hasRole('owner'))
                        <span class="badge badge-success">Owner</span>
                    @elseif(Auth::user()->hasRole('teacher'))
                        <span class="badge badge-warning">Teacher</span>
                    @elseif(Auth::user()->hasRole('student'))
                        <span class="badge badge-info">Student</span>
                    @elseif (Auth::user()->hasActiveSubscription())
                        <span class="badge badge-primary">PRO</span>
                    @endif
                </p>
            </div>
            <a
                class="relative flex items-center justify-center hs-dropdown-toggle cursor-pointer align-middle rounded-full">
                <img src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : asset('images/avatar-default.png') }}"
                    alt="Profile Picture" class="object-cover w-12 h-12 rounded-full">
            </a>

            <div class="card hs-dropdown-menu transition-[opacity,margin] border border-gray-300 rounded-[30px] duration hs-dropdown-open:opacity-100 opacity-0 mt-2 min-w-max  w-[200px] hidden z-[12]"
                aria-labelledby="hs-dropdown-custom-icon-trigger">
                <div class="card-body p-0 py-2">
                    <div class="grid grid-cols-[1fr_2fr] gap-2 p-4 justify-center items-center">
                        <div class="w-[80px] h-[80px] rounded-full overflow-hidden">
                            <img src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : asset('images/avatar-default.png') }}"
                                alt="Profile Picture" class="object-cover w-full h-full rounded-full">
                        </div>
                        <div class="flex flex-col gap-1">
                            <h2 class="text-xl font-bold text-gray-900">{{ Auth::user()->name }}</h2>
                            <p class="text-sm text-gray-700">{{ Auth::user()->occupation }}</p>
                            <p class="text-sm text-gray-700 flex justify-start items-center gap-x-1">
                                <i class="ti ti-mail text-lg"></i>
                                {{ Auth::user()->email }}
                            </p>
                        </div>
                    </div>
                    <div class="px-4 mt-[7px] mb-2 grid">
                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="btn-outline-primary font-medium text-[15px] w-full hover:bg-[rgb(255,97,41)] hover:text-white">
                            Logout
                        </a>
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</nav>

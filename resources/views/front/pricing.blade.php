@extends('../layouts.master')
@section('content')
<body class="text-black font-poppins pt-10 pb-[50px]">
    <div id="hero-section" class="max-w-[1200px] mx-auto w-full h-[536px] flex flex-col gap-10 pb-[50px] bg-[url('{{ asset('assets/background/Hero-Banner.png') }}')] bg-center bg-no-repeat bg-cover rounded-[32px] overflow-hidden relative">
        <x-nav/>
    </div>
    <section class="max-w-[1100px] w-full mx-auto absolute -translate-x-1/2 left-1/2 top-[170px] mb10">
        <div class="flex flex-col gap-[30px] items-center">
            <div class="gradient-badge w-fit p-[8px_16px] rounded-full border border-[#FED6AD] flex items-center gap-[6px]">
                <div>
                    <img src="{{ asset('assets/icon/medal-star.svg') }}" alt="icon">
                </div>
                <p class="font-medium text-sm text-[#FF6129]">Better Pricing For You</p>
            </div>
            <div class="flex flex-col text-white text-center">
                <h2 class="font-bold text-[40px] leading-[60px]">Invest & Get Bigger Return</h2>
                <p class="text-lg -tracking-[2%]">Catching up the on-demand skills and high-paying career this year</p>
            </div>
            <div class="max-w-[1000px] w-full flex gap-[30px]">
                @forelse ($packages as $package)
                    @php
                        // Tentukan apakah pengguna memiliki langganan aktif
                        $currentPackage = Auth::check() && Auth::user()->hasActiveSubscription()
                            ? Auth::user()->subscribe_transactions()->latest()->first()->package
                            : null;

                        // Tentukan apakah paket ini adalah yang aktif
                        $isCurrentPackage = $currentPackage && $package->id === $currentPackage->id;

                        // Tentukan apakah paket lebih rendah atau sama dibandingkan paket aktif
                        $isLowerOrEqual = $currentPackage && $package->harga <= $currentPackage->harga;
                    @endphp

                    <div class="flex flex-col justify-between rounded-3xl p-8 gap-[30px] bg-white min-h-[520px]">
                        <div class="flex flex-col gap-5">
                            <div class="flex flex-col gap-4">
                                <p class="font-semibold text-4xl leading-[54px]">{{ $package->name }}</p>
                                <p class="text-[#475466] text-lg">{{ $package->description }}</p>
                            </div>
                            <div class="flex flex-col gap-1">
                                <p class="font-semibold text-4xl leading-[54px]">Rp {{ number_format($package->harga, 0, ',', '.') }}</p>
                                <p class="text-[#475466] text-lg">{{ ucfirst($package->tipe) }}</p>
                            </div>
                            <div class="flex flex-col gap-4">
                                @foreach ($package->benefits as $benefit)
                                <div class="flex gap-3">
                                    <div class="w-6 h-6 flex shrink-0">
                                        <img src="{{ asset('assets/icon/tick-circle.svg') }}" class="w-full h-full object-cover" alt="icon">
                                    </div>
                                    <p class="text-[#475466]">{{ $benefit->name }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Kondisi tombol -->
                        @if (Auth::check())
                            @if ($isCurrentPackage)
                                <div class="p-[20px_32px] bg-gray-500 text-white rounded-full text-center font-semibold text-xl cursor-not-allowed">
                                    Current Plan
                                </div>
                            @elseif ($isLowerOrEqual)
                                <div class="p-[20px_32px] bg-gray-500 text-white rounded-full text-center font-semibold text-xl cursor-not-allowed">
                                    Not Available
                                </div>
                            @else
                                <a href="{{ route('front.checkout', $package->id) }}"
                                class="p-[20px_32px] bg-[#FF6129] text-white rounded-full text-center font-semibold text-xl transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980]">
                                    Upgrade
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                            class="p-[20px_32px] bg-[#FF6129] text-white rounded-full text-center font-semibold text-xl transition-all duration-300 hover:shadow-[0_10px_20px_0_#00000080]">
                                Login to Subscribe
                            </a>
                        @endif
                    </div>
                @empty
                    <p>No packages available</p>
                @endforelse
            </div>
        </div>
    </section>
    <section id="Zero-to-Success" class="h-[25px] mt-[264px] max-w-[1200px] mx-auto flex flex-col justify-end py-[70px] px-[50px] gap-[30px] bg-[#F5F8FA] rounded-[32px]">
        <div class="flex flex-col gap-[30px] items-center text-center">
            <div class="gradient-badge w-fit p-[8px_16px] rounded-full border border-[#FED6AD] flex items-center gap-[6px]">
                {{-- <div>
                    <img src="{{asset('assets/icon/medal-star.svg')}}" alt="icon">
                </div>
                <p class="font-medium text-sm text-[#FF6129]">Zero to Success People</p> --}}
            </div>
            <div class="flex flex-col">
                {{-- <h2 class="font-bold text-[40px] leading-[60px]">Happy & Success Students</h2>
                <p class="text-[#6D7786] text-lg -tracking-[2%]">Acquiring skills and new high paying career become much easier</p> --}}
            </div>
        </div>
        {{-- <div class="testi w-full overflow-hidden flex flex-col gap-6 relative">
            <div class="fade-overlay absolute z-10 h-full w-[50px] bg-gradient-to-r from-[#F5F8FA] to-[#F5F8FA00]"></div>
            <div class="fade-overlay absolute right-0 z-10 h-full w-[50px] bg-gradient-to-r from-[#F5F8FA00] to-[#F5F8FA]"></div>
            <div class="group/slider flex flex-nowrap w-max items-center">
                {{-- <div class="testi-container animate-[slideToL_50s_linear_infinite] group-hover/slider:pause-animate flex gap-6 pl-6 items-center flex-nowrap">
                    <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                <img src="{{asset('assets/photo/photo4.png')}}" class="w-full h-full object-cover" alt="photo">
                            </div>
                            <p class="font-semibold">Shayna</p>
                        </div>
                        <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career, thank you!</p>
                        <div class="flex gap-[2px]">
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                <img src="{{asset('assets/photo/photo4.png')}}" class="w-full h-full object-cover" alt="photo">
                            </div>
                            <p class="font-semibold">Shayna</p>
                        </div>
                        <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career, thank you!</p>
                        <div class="flex gap-[2px]">
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                <img src="{{asset('assets/photo/photo4.png')}}" class="w-full h-full object-cover" alt="photo">
                            </div>
                            <p class="font-semibold">Shayna</p>
                        </div>
                        <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career, thank you!</p>
                        <div class="flex gap-[2px]">
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                <img src="{{asset('assets/photo/photo4.png')}}" class="w-full h-full object-cover" alt="photo">
                            </div>
                            <p class="font-semibold">Shayna</p>
                        </div>
                        <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career, thank you!</p>
                        <div class="flex gap-[2px]">
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="logo-container animate-[slideToL_50s_linear_infinite] group-hover/slider:pause-animate flex gap-6 pl-6 items-center flex-nowrap ">
                    <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                <img src="{{asset('assets/photo/photo4.png')}}" class="w-full h-full object-cover" alt="photo">
                            </div>
                            <p class="font-semibold">Shayna</p>
                        </div>
                        <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career, thank you!</p>
                        <div class="flex gap-[2px]">
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                            <img src="{{asset('assets/photo/photo4.png')}}" class="w-full h-full object-cover" alt="photo">
                        </div>
                        <p class="font-semibold">Shayna</p>
                    </div>
                    <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career, thank you!</p>
                    <div class="flex gap-[2px]">
                        <div>
                            <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                        </div>
                        <div>
                            <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                        </div>
                        <div>
                            <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                        </div>
                        <div>
                            <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                        </div>
                        <div>
                            <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                        </div>
                    </div>
                    </div>
                    <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                            <img src="{{asset('assets/photo/photo4.png')}}" class="w-full h-full object-cover" alt="photo">
                        </div>
                        <p class="font-semibold">Shayna</p>
                    </div>
                    <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career, thank you!</p>
                    <div class="flex gap-[2px]">
                        <div>
                            <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                        </div>
                        <div>
                            <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                        </div>
                        <div>
                            <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                        </div>
                        <div>
                            <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                        </div>
                        <div>
                            <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                        </div>
                    </div>
                    </div>
                    <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                            <img src="{{asset('assets/photo/photo4.png')}}" class="w-full h-full object-cover" alt="photo">
                        </div>
                        <p class="font-semibold">Shayna</p>
                    </div>
                    <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career, thank you!</p>
                    <div class="flex gap-[2px]">
                        <div>
                            <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                        </div>
                        <div>
                            <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                        </div>
                        <div>
                            <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                        </div>
                        <div>
                            <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                        </div>
                        <div>
                            <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="group/slider flex flex-nowrap w-max items-center">
                <div class="logo-container animate-[slideToR_50s_linear_infinite] group-hover/slider:pause-animate flex gap-6 pl-6 items-center flex-nowrap">
                    <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                            <img src="{{asset('assets/photo/photo4.png')}}" class="w-full h-full object-cover" alt="photo">
                        </div>
                        <p class="font-semibold">Shayna</p>
                    </div>
                    <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career, thank you!</p>
                    <div class="flex gap-[2px]">
                        <div>
                            <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                        </div>
                        <div>
                            <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                        </div>
                        <div>
                            <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                        </div>
                        <div>
                            <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                        </div>
                        <div>
                            <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                        </div>
                    </div>
                    </div>
                    <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                <img src="{{asset('assets/photo/photo4.png')}}" class="w-full h-full object-cover" alt="photo">
                            </div>
                            <p class="font-semibold">Shayna</p>
                        </div>
                        <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career, thank you!</p>
                        <div class="flex gap-[2px]">
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                <img src="{{asset('assets/photo/photo4.png')}}" class="w-full h-full object-cover" alt="photo">
                            </div>
                            <p class="font-semibold">Shayna</p>
                        </div>
                        <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career, thank you!</p>
                        <div class="flex gap-[2px]">
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                <img src="{{asset('assets/photo/photo4.png')}}" class="w-full h-full object-cover" alt="photo">
                            </div>
                            <p class="font-semibold">Shayna</p>
                        </div>
                        <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career, thank you!</p>
                        <div class="flex gap-[2px]">
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="logo-container animate-[slideToR_50s_linear_infinite] group-hover/slider:pause-animate flex gap-6 pl-6 items-center flex-nowrap ">
                    <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                <img src="{{asset('assets/photo/photo4.png')}}" class="w-full h-full object-cover" alt="photo">
                            </div>
                            <p class="font-semibold">Shayna</p>
                        </div>
                        <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career, thank you!</p>
                        <div class="flex gap-[2px]">
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                <img src="{{asset('assets/photo/photo4.png')}}" class="w-full h-full object-cover" alt="photo">
                            </div>
                            <p class="font-semibold">Shayna</p>
                        </div>
                        <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career, thank you!</p>
                        <div class="flex gap-[2px]">
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                <img src="{{asset('assets/photo/photo4.png')}}" class="w-full h-full object-cover" alt="photo">
                            </div>
                            <p class="font-semibold">Shayna</p>
                        </div>
                        <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career, thank you!</p>
                        <div class="flex gap-[2px]">
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="test-card w-[300px] flex flex-col h-full bg-white rounded-xl gap-3 p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                <img src="{{asset('assets/photo/photo4.png')}}" class="w-full h-full object-cover" alt="photo">
                            </div>
                            <p class="font-semibold">Shayna</p>
                        </div>
                        <p class="text-sm text-[#475466]">Alqowy has helped me to grow from zero to perfect career, thank you!</p>
                        <div class="flex gap-[2px]">
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                            <div>
                                <img src="{{asset('assets/icon/star.svg')}}" alt="star">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </section>
    <section id="FAQ" class="max-w-[1200px] mx-auto flex flex-col py-[70px] px-[100px]">
        <div class="flex justify-between items-center">
            <div class="flex flex-col gap-[30px]">
                <div class="gradient-badge w-fit p-[8px_16px] rounded-full border border-[#FED6AD] flex items-center gap-[6px]">
                    <div>
                        <img src="{{asset('assets/icon/medal-star.svg')}}" alt="icon">
                    </div>
                    <p class="font-medium text-sm text-[#FF6129]">Grow Your Career</p>
                </div>
                <div class="flex flex-col">
                    <h2 class="font-bold text-[36px] leading-[52px]">Get Your Answers</h2>
                    <p class="text-lg text-[#475466]">It’s time to upgrade skills without limits!</p>
                </div>
                <a href="" class="text-white font-semibold rounded-[30px] p-[16px_32px] bg-[#FF6129] transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980] w-fit">Contact Our Sales</a>
            </div>
            <div class="flex flex-col gap-[30px] w-[552px] shrink-0">
                <div class="flex flex-col p-5 rounded-2xl bg-[#FFF8F4] has-[.hide]:bg-transparent border-t-4 border-[#FF6129] has-[.hide]:border-0 w-full">
                    <button class="accordion-button flex justify-between gap-1 items-center" data-accordion="accordion-faq-1">
                        <span class="font-semibold text-lg text-left">Can beginner join the course?</span>
                        <div class="arrow w-9 h-9 flex shrink-0">
                            <img src="{{asset('assets/icon/add.svg')}}" alt="icon">
                        </div>
                    </button>
                    <div id="accordion-faq-1" class="accordion-content hide">
                        <p class="leading-[30px] text-[#475466] pt-[10px]">Yes, we have provided a variety range of course from beginner to intermediate level to prepare your next big career,</p>
                    </div>
                </div>
                <div class="flex flex-col p-5 rounded-2xl bg-[#FFF8F4] has-[.hide]:bg-transparent border-t-4 border-[#FF6129] has-[.hide]:border-0 w-full">
                    <button class="accordion-button flex justify-between gap-1 items-center" data-accordion="accordion-faq-2">
                        <span class="font-semibold text-lg text-left">How long does the implementation take?</span>
                        <div class="arrow w-9 h-9 flex shrink-0">
                            <img src="{{asset('assets/icon/add.svg')}}" alt="icon">
                        </div>
                    </button>
                    <div id="accordion-faq-2" class="accordion-content hide">
                        <p class="leading-[30px] text-[#475466] pt-[10px]">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolore placeat ut nostrum aperiam mollitia tempora aliquam perferendis explicabo eligendi commodi.</p>
                    </div>
                </div>
                <div class="flex flex-col p-5 rounded-2xl bg-[#FFF8F4] has-[.hide]:bg-transparent border-t-4 border-[#FF6129] has-[.hide]:border-0 w-full">
                    <button class="accordion-button flex justify-between gap-1 items-center" data-accordion="accordion-faq-3">
                        <span class="font-semibold text-lg text-left">Do you provide the job-guarantee program?</span>
                        <div class="arrow w-9 h-9 flex shrink-0">
                            <img src="{{asset('assets/icon/add.svg')}}" alt="icon">
                        </div>
                    </button>
                    <div id="accordion-faq-3" class="accordion-content hide">
                        <p class="leading-[30px] text-[#475466] pt-[10px]">Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae itaque facere ipsum animi sunt iure!</p>
                    </div>
                </div>
                <div class="flex flex-col p-5 rounded-2xl bg-[#FFF8F4] has-[.hide]:bg-transparent border-t-4 border-[#FF6129] has-[.hide]:border-0 w-full">
                    <button class="accordion-button flex justify-between gap-1 items-center" data-accordion="accordion-faq-4">
                        <span class="font-semibold text-lg text-left">How to issue all course certificates?</span>
                        <div class="arrow w-9 h-9 flex shrink-0">
                            <img src="{{asset('assets/icon/add.svg')}}" alt="icon">
                        </div>
                    </button>
                    <div id="accordion-faq-4" class="accordion-content hide">
                        <p class="leading-[30px] text-[#475466] pt-[10px]">Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae itaque facere ipsum animi sunt iure!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <x-footer/>

    <!-- JavaScript -->
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous">
    </script>

    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

    <script src="{{asset('build/js/main.js')}}"></script>
</body>
@endsection

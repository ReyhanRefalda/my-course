@extends('../layouts.master')
@section('content')

    <body class="font-poppins text-[#0E0140]">
        <main class="min-h-dvh">
            <div id="left-side" class="fixed top-0 left-0 h-dvh w-[640px] outline outline-1 outline-[#E8E4F8]">
                <img src="{{ asset('assets/background/benefit_illustration.png') }}" class="size-full object-cover"
                    alt="background image" />
            </div>
            <section id="right-side" class="w-dvw h-dvh flex flex-col items-center justify-center pl-[640px] py-[140px]">
                <a href="{{ route('front.index') }}" class="flex shrink-0 justify-start w-[500px] h-[10] mb-[70px]">
                    <img src="{{ asset('assets/logo/logo-black.png') }}" class="object-contain" alt="logo"
                        style="width: 200px; height: auto;" />
                </a>
                @if ($errors->any())
                    <div
                        class="py-3 px-4 w-[500px] mb-5 text-center rounded-3xl bg-red-600 text-black border border-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form id="form-signin" method="POST" action="{{ route('login') }}"
                    class="w-[500px] flex flex-col gap-[30px]">
                    @csrf
                    <h1 class="text-[26px] leading-[39px] font-bold">Sign In</h1>
                    <div class="flex flex-col gap-2">
                        <label for="email" class="text-base font-semibold">Email Address</label>
                        <div
                            class="flex items-center rounded-full py-[14px] px-[24px] gap-[10px] ring-1 ring-[#0E0140] focus-within:ring-2 focus-within:ring-[#FF6B2C] transition-all duration-300">
                            <div class="flex shrink-0 size-6">
                                <img src="assets/icon/sms.svg" alt="email icon" />
                            </div>
                            <input type="email" name="email" id="email"
                                class="w-full focus:outline-none font-semibold placeholder:font-normal bg-transparent placeholder:text-[#0E0140] [border:none] focus:ring-white focus:border-none"
                                placeholder="Write your email address" />
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="password" class="text-base font-semibold">Password</label>
                        <div
                            class="flex items-center rounded-full py-[14px] px-[24px] gap-[10px] ring-1 ring-[#0E0140] focus-within:ring-2 focus-within:ring-[#FF6B2C] transition-all duration-300">
                            <div class="flex shrink-0 size-6">
                                <i class="ti ti-lock text-[#0E0140] text-2xl"></i>
                            </div>
                            <input type="password" name="password" id="password"
                                class="w-full focus:outline-none font-semibold placeholder:font-normal bg-transparent placeholder:text-[#0E0140] [border:none] focus:ring-white focus:border-none"
                                placeholder="Write your password" />
                            <button type="button" id="togglePassword" class="flex items-center justify-center">
                                <i id="showIcon" class="ti ti-eye text-[#0E0140] text-2xl"></i>
                                <i id="hideIcon" class="ti ti-eye-off text-[#0E0140] text-2xl hidden"></i>
                            </button>
                        </div>
                        <a href="#" class="text-sm leading-[21px] hover:underline">Forgot Password</a>
                    </div>
                    <div class="flex flex-col gap-3">
                        <button type="submit"
                            class="flex items-center justify-center py-[14px] px-[30px] bg-[#FF6B2C] font-semibold text-white rounded-full hover:shadow-[0px_10px_20px_0px_#FF6B2C66] transition-all duration-300">
                            Sign In to My Account
                        </button>
                        <a href="{{ route('register') }}"
                            class="flex items-center justify-center py-[14px] px-[30px] font-semibold text-[#0E0140] outline outline-1 outline-[#0E0140] rounded-full">Create
                            New Account</a>
                    </div>
                </form>
            </section>
        </main>
        <script>
            const passwordInput = document.getElementById('password');
            const showIcon = document.getElementById('showIcon');
            const hideIcon = document.getElementById('hideIcon');
            const toggleButton = document.getElementById('togglePassword');

            toggleButton.addEventListener('click', function () {
                const currentType = passwordInput.getAttribute('type');

                if (currentType === 'password') {
                    passwordInput.setAttribute('type', 'text');
                    showIcon.classList.add('hidden');
                    hideIcon.classList.remove('hidden');
                } else {
                    passwordInput.setAttribute('type', 'password');
                    showIcon.classList.remove('hidden');
                    hideIcon.classList.add('hidden');
                }
            });
        </script>
    </body>
@endsection

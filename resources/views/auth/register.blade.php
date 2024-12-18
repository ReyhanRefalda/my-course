@extends('../layouts.master')
@section('content')

    <body class="font-poppins text-[#0E0140]">
        <main class="min-h-screen flex">
            <div id="Left-background"
                class="fixed top-0 left-0 h-screen w-[640px] flex shrink-0 items-baseline ring-1 ring-[#E8E4F8] overflow-hidden">
                <img src="{{ asset('assets/background/benefit_illustration.png') }}"
                    class="background object-cover w-full h-full" alt="background image">
            </div>png
            <section id="Signup-form"
                class="pl-[640px] flex flex-col py-[140px] items-center justify-center w-full gap-[70px]">
                @if ($errors->any())
                    <div
                        class="py-3 px-4 w-[500px] mb-5 text-center rounded-3xl bg-red-600 text-black border border-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif
                <form action="{{ route('register') }}" method="POST" class="max-w-[500px] w-full flex flex-col gap-[30px]"
                    enctype="multipart/form-data">
                    @csrf
                    <a href="{{ route('front.index') }}" class="logo h-[10] flex shrink-0 justify-start mb-10">
                        <img src="{{ asset('assets/logo/logo-black.png') }}" class="object-contain" alt="logo"
                            style="width: 200px; height: auto;">
                    </a>
                    <h1 class="font-bold text-[26px] leading-[39px]">Create Account</h1>
                    <div class="flex items-center gap-4">
                        <button type="button" id="Upload-btn"
                            class="w-[100px] h-[100px] flex shrink-0 rounded-full overflow-hidden">
                            <img id="File-thumbnail" src="{{ asset('assets/icon/Mediamodifier-Design.svg') }}"
                                class="object-cover w-full h-full" alt="avatar">
                        </button>
                        <div class="h-fit flex flex-col gap-1">
                            <label class="font-semibold" for="File-upload">Add Your Avatar</label>
                            <p class="text-sm leading-[21px]">Use professional photo for career</p>
                            <button type="button" id="Replace-photo-btn"
                                class="font-semibold text-sm leading-[21px] text-[#FF6B2C] hover:underline transition-all duration-300 w-fit hidden">Replace
                                Photo</button>
                        </div>
                        <input type="file" id="File-upload" name="avatar" class="hidden" accept="image/*">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="Name" class="font-semibold">Full Name</label>
                        <div
                            class="flex items-center rounded-full p-[14px_24px] gap-[10px] ring-1 ring-[#0E0140] focus-within:ring-2 focus-within:ring-[#FF6B2C] transition-all duration-300">
                            <div class="w-6 h-6 flex shrink-0">
                                <img src="{{ asset('assets/icon/user.svg') }}" alt="icon">
                            </div>
                            <input type="text" id="Name" name="name" autocomplete="off"
                                class="appearance-none w-full outline-none font-semibold placeholder:font-normal placeholder:text-[#0E0140] focus:outline-none [border:none] focus:ring-white focus:border-none"
                                placeholder="Write your full name">
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="Email" class="font-semibold">Email Address</label>
                        <div
                            class="flex items-center rounded-full p-[14px_24px] gap-[10px] ring-1 ring-[#0E0140] focus-within:ring-2 focus-within:ring-[#FF6B2C] transition-all duration-300">
                            <div class="w-6 h-6 flex shrink-0">
                                <img src="assets/icon/sms.svg" alt="icon">
                            </div>
                            <input type="email" id="Email" name="email" autocomplete="off"
                                class="appearance-none w-full outline-none font-semibold placeholder:font-normal placeholder:text-[#0E0140] focus:outline-none [border:none] focus:ring-white focus:border-none"
                                placeholder="Write your email address">
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="Occupation" class="font-semibold">Occupation</label>
                        <div
                            class="flex items-center rounded-full p-[14px_24px] gap-[10px] ring-1 ring-[#0E0140] focus-within:ring-2 focus-within:ring-[#FF6B2C] transition-all duration-300">
                            <div class="w-6 h-6 flex shrink-0">
                                <img src="assets/icon/briefcase.svg" alt="icon">
                            </div>
                            <input type="text" id="Occupation" name="occupation" autocomplete="off"
                                class="appearance-none w-full outline-none font-semibold placeholder:font-normal placeholder:text-[#0E0140] focus:outline-none [border:none] focus:ring-white focus:border-none"
                                placeholder="Type here...">
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="Password" class="font-semibold">Password</label>
                        <div
                            class="flex items-center rounded-full p-[14px_24px] gap-[10px] ring-1 ring-[#0E0140] focus-within:ring-2 focus-within:ring-[#FF6B2C] transition-all duration-300">
                            <div class="w-6 h-6 flex shrink-0">
                                <img src="assets/icon/lock.svg" alt="icon">
                            </div>
                            <input type="password" id="Password" name="password" autocomplete="off"
                                class="appearance-none w-full outline-none font-semibold placeholder:font-normal placeholder:text-[#0E0140] focus:outline-none [border:none] focus:ring-white focus:border-none"
                                placeholder="Write your password">
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="Confirm-Password" class="font-semibold">Confirm Password</label>
                        <div
                            class="flex items-center rounded-full p-[14px_24px] gap-[10px] ring-1 ring-[#0E0140] focus-within:ring-2 focus-within:ring-[#FF6B2C] transition-all duration-300">
                            <div class="w-6 h-6 flex shrink-0">
                                <img src="assets/icon/lock.svg" alt="icon">
                            </div>
                            <input type="password" id="Confirm-Password" name="password_confirmation" autocomplete="off"
                                class="appearance-none w-full outline-none font-semibold placeholder:font-normal placeholder:text-[#0E0140] focus:outline-none [border:none] focus:ring-white focus:border-none"
                                placeholder="Write your password">
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <p class="font-semibold">Account Type</p>
                        <div class="grid grid-cols-2 gap-[30px]">
                            <!-- Opsi Student -->
                            <label
                                class="relative group bg-white rounded-3xl p-[30px_24px] flex flex-col items-center justify-center gap-5 ring-1 ring-[#0E0140] has-[:checked]:ring-2 has-[:checked]:ring-[#FF6B2C] transition-all duration-300">
                                <p class="font-semibold">As a Student</p>
                                <img src="{{ asset('assets/icon/tick-circle-orange.svg') }}"
                                    class="absolute top-[10px] right-[10px] w-6 h-6 opacity-0 group-has-[:checked]:opacity-100 transition-all duration-300"
                                    alt="Checked Icon">
                                <input type="radio" name="account_type" id="student" value="student"
                                    class="absolute -z-10 top-1/2 left-1/2" required>
                            </label>

                            <!-- Opsi Teacher -->
                            <label
                                class="relative group bg-white rounded-3xl p-[30px_24px] flex flex-col items-center justify-center gap-5 ring-1 ring-[#0E0140] has-[:checked]:ring-2 has-[:checked]:ring-[#FF6B2C] transition-all duration-300">
                                <p class="font-semibold">As a Teacher</p>
                                <img src="{{ asset('assets/icon/tick-circle-orange.svg') }}"
                                    class="absolute top-[10px] right-[10px] w-6 h-6 opacity-0 group-has-[:checked]:opacity-100 transition-all duration-300"
                                    alt="Checked Icon">
                                <input type="radio" name="account_type" id="teacher" value="teacher"
                                    class="absolute -z-10 top-1/2 left-1/2" required>
                            </label>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <button type="submit"
                            class="rounded-full p-[14px_30px] bg-[#FF6B2C] font-semibold text-white text-nowrap hover:shadow-[0_10px_20px_0_#FF6B2C66] transition-all duration-300">Sign
                            Up Now</button>
                        <a href="{{ route('login') }}"
                            class="rounded-full border border-[#0E0140] p-[14px_30px] font-semibold text-[#0E0140] text-center">Sign
                            In to My Account</a>
                    </div>
                </form>
            </section>
        </main>
    </body>
@endsection
@push('after-scripts')
    <script>
        document.getElementById('Upload-btn').addEventListener('click', function() {
            document.getElementById('File-upload').click();
        });
        document.getElementById('Replace-photo-btn').addEventListener('click', function() {
            document.getElementById('File-upload').click();
        });

        document.getElementById('File-upload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('File-thumbnail').src = e.target.result;
                    document.getElementById('Replace-photo-btn').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush

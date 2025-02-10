@extends('../layouts.master')
@section('content')
<body class="text-black font-poppins pt-10">
    <div id="checkout-section" class="max-w-[1200px] mx-auto w-full min-h-[calc(100vh-40px)] flex flex-col gap-[30px] bg-[url('{{ asset('assets/background/Hero-Banner.png') }}')] bg-center bg-no-repeat bg-cover rounded-t-[32px] overflow-hidden relative pb-6">
        <x-nav/>
        <div class="flex flex-col gap-[10px] items-center">
            <div class="gradient-badge w-fit p-[8px_16px] rounded-full border border-[#FED6AD] flex items-center gap-[6px]">
                <div>
                    <img src="{{asset('assets/icon/medal-star.svg')}}" alt="icon">
                </div>
                <p class="font-medium text-sm text-[#FF6129]">Invest In Yourself Today</p>
            </div>
            <h2 class="font-bold text-[40px] leading-[60px] text-white">Checkout Subscription</h2>
        </div>
        <div class="flex gap-10 px-[100px] relative z-10">
            <div class="w-[400px] flex shrink-0 flex-col bg-white rounded-2xl p-5 gap-4 h-fit">
                <p class="font-bold text-lg">Package</p>
                <div class="flex items-center justify-between w-full">
                    <div class="flex items-center gap-3">
                        <div class="flex flex-col gap-[2px]">
                            <p class="font-semibold">{{$package->name}}</p>
                        </div>
                    </div>
                    <p class="p-[4px_12px] rounded-full bg-[#FF6129] font-semibold text-xs text-white text-center">Popular</p>
                </div>
                <hr>
                <div class="flex flex-col gap-5">
                    @foreach ($package->benefits as $benefit)
                            <div class="flex gap-3">
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="{{ asset('assets/icon/tick-circle.svg') }}" class="w-full h-full object-cover" alt="icon">
                                </div>
                                <p class="text-[#475466]">{{ $benefit->name }}</p>
                            </div>
                    @endforeach
                </div>
                <p class="font-semibold text-[28px] leading-[42px]">Rp {{ number_format($package->harga, 0, ',', '.') }}</p>
            </div>
            <form action="{{route('front.checkout.store')}}" method="POST" enctype="multipart/form-data" class="w-full flex flex-col bg-white rounded-2xl p-5 gap-5">
                @csrf
                <input type="hidden" name="package_id" value="{{ $package->id }}">
                <p class="font-bold text-lg">Send Payment</p>
                <div class="flex flex-col gap-5">
                    <div class="flex items-center justify-between">
                        <div class="flex gap-3">
                            <div class="w-6 h-6 flex shrink-0">
                                <img src="{{asset('assets/icon/tick-circle.svg')}}" class="w-full h-full object-cover" alt="icon">
                            </div>
                            <p class="text-[#475466]">Bank Name</p>
                        </div>
                        <p class="font-semibold">{{$payment->bank_name}}</p>
                        <input type="hidden" name="bankName" value="Angga Capital">
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex gap-3">
                            <div class="w-6 h-6 flex shrink-0">
                                <img src="{{asset('assets/icon/tick-circle.svg')}}" class="w-full h-full object-cover" alt="icon">
                            </div>
                            <p class="text-[#475466]">Account Number</p>
                        </div>
                        <p class="font-semibold">{{$payment->number}}</p>
                        <input type="hidden" name="accountNumber" value="22081996202191404">
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex gap-3">
                            <div class="w-6 h-6 flex shrink-0">
                                <img src="{{asset('assets/icon/tick-circle.svg')}}" class="w-full h-full object-cover" alt="icon">
                            </div>
                            <p class="text-[#475466]">Account Name</p>
                        </div>
                        <p class="font-semibold">{{$payment->account_name}}</p>
                        <input type="hidden" name="accountName" value="Alqowy Education First">
                    </div>
                </div>
                <hr>
                <p class="font-bold text-lg">Confirm Your Payment</p>
                <div class="relative">
                    {{-- <button type="button" class="p-4 rounded-full flex gap-3 w-full ring-1 ring-black transition-all duration-300 hover:ring-2 hover:ring-[#FF6129]" onclick="document.getElementById('file').click()">
                        <div class="w-6 h-6 flex shrink-0">
                            <img src="{{asset('assets/icon/note-add.svg')}}" alt="icon">
                        </div>
                        <p id="fileLabel">Add a file attachment</p>
                    </button> --}}
                    <button type="button" class="p-[20px_32px] bg-[#FF6129] text-white rounded-full text-center font-semibold transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980]"
                        data-modal-toggle="checkoutConfirmModal">
                        I've Made The Payment
                    </button>
                    <input id="file" type="file" name="proof" class="hidden" onchange="updateFileName(this)">
                </div>
                <button type="submit" class="p-[20px_32px] bg-[#FF6129] text-white rounded-full text-center font-semibold transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980]">I've Made The Payment</button>
            </form>
        </div>
        <div class="flex justify-center absolute transform -translate-x-1/2 left-1/2 bottom-0 w-full">
            <img src="{{asset('assets/background/alqowy.svg')}}" alt="background">
        </div>
    </div>

    <div id="checkoutConfirmModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-50 sm:p-5">
            <button type="button"
                class="absolute top-2.5 right-2.5 bg-transparent hover:text-gray-900 rounded-lg text-sm p-1.5"
                data-modal-toggle="checkoutConfirmModal">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
            <p class="mb-4 text-gray-500">Are you sure you have completed the payment?</p>
            <div class="flex justify-center items-center space-x-4">
                <button type="button" data-modal-toggle="checkoutConfirmModal"
                    class="px-4 py-2 font-semibold bg-gray-300 rounded-lg">
                    Cancel
                </button>
                <button type="submit" id="confirmCheckout"
                    class="px-4 py-2 font-semibold bg-[#FF6129] text-white rounded-lg">
                    Confirm Payment
                </button>
            </div>
        </div>
    </div>
</div>


    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous">
    </script>
    <script src="{{asset('build/js/main.js')}}"></script>
    <script>
        function updateFileName(input) {
            const fileLabel = document.getElementById('fileLabel');
            if (input.files && input.files[0]) {
                fileLabel.textContent = input.files[0].name;
            } else {
                fileLabel.textContent = "Add a file attachment";
            }
        }
    </script>

    <script>
        document.getElementById('confirmCheckout').addEventListener('click', function () {
            document.querySelector('form').submit();
        });
    </script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const modal = document.getElementById("checkoutConfirmModal");
        const openModalBtn = document.querySelector("[data-modal-toggle='checkoutConfirmModal']");
        const closeModalBtns = modal.querySelectorAll("[data-modal-toggle='checkoutConfirmModal']");

        if (openModalBtn && modal) {
            openModalBtn.addEventListener("click", function () {
                modal.classList.remove("hidden");
                modal.classList.add("flex");
            });

            closeModalBtns.forEach(btn => {
                btn.addEventListener("click", function () {
                    modal.classList.add("hidden");
                    modal.classList.remove("flex");
                });
            });
        }

        // Saat klik tombol "Confirm Payment", submit form
        document.getElementById("confirmCheckout").addEventListener("click", function () {
            document.querySelector("form").submit();
        });
    });
</script>
</body>
@endsection

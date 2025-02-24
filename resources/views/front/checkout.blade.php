@extends('../layouts.master')
@section('content')

<body class="text-black font-poppins pt-10">
    <div id="checkout-section"
        class="max-w-[1200px] mx-auto w-full min-h-[calc(100vh-40px)] flex flex-col gap-[30px] bg-[url('{{ asset('assets/background/Hero-Banner.png') }}')] bg-center bg-no-repeat bg-cover rounded-t-[32px] overflow-hidden relative pb-6">
        <x-nav />
        <div class="flex flex-col gap-[10px] items-center">
            <div
                class="gradient-badge w-fit p-[8px_16px] rounded-full border border-[#FED6AD] flex items-center gap-[6px]">
                <div>
                    <img src="{{ asset('assets/icon/medal-star.svg') }}" alt="icon">
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
                            <p class="font-semibold">{{ $package->name }}</p>
                        </div>
                    </div>
                    <p class="p-[4px_12px] rounded-full bg-[#FF6129] font-semibold text-xs text-white text-center">
                        Popular</p>
                </div>
                <hr>
                <div class="flex flex-col gap-5">
                    @foreach ($package->benefits as $benefit)
                        <div class="flex gap-3">
                            <div class="w-6 h-6 flex shrink-0">
                                <img src="{{ asset('assets/icon/tick-circle.svg') }}" class="w-full h-full object-cover"
                                    alt="icon">
                            </div>
                            <p class="text-[#475466]">{{ $benefit->name }}</p>
                        </div>
                    @endforeach
                </div>
                <p class="font-semibold text-[28px] leading-[42px]">Rp {{ number_format($package->harga, 0, ',', '.') }}</p>
            </div>
            <form id="paymentForm" action="{{ route('front.checkout.store') }}" method="POST" enctype="multipart/form-data"
                class="w-full flex flex-col bg-white rounded-2xl p-5 gap-5">
                @csrf
                <input type="hidden" name="package_id" value="{{ $package->id }}">
                <p class="font-bold text-lg">Send Payment</p>
                <div class="flex flex-col gap-5">
                    <div class="flex items-center justify-between">
                        <div class="flex gap-3">
                            <div class="w-6 h-6 flex shrink-0">
                                <img src="{{ asset('assets/icon/tick-circle.svg') }}" class="w-full h-full object-cover"
                                    alt="icon">
                            </div>
                            <p class="text-[#475466]">Bank Name</p>
                        </div>
                        <p class="font-semibold">{{ $payment->bank_name }}</p>
                        <input type="hidden" name="bankName" value="Angga Capital">
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex gap-3">
                            <div class="w-6 h-6 flex shrink-0">
                                <img src="{{ asset('assets/icon/tick-circle.svg') }}" class="w-full h-full object-cover"
                                    alt="icon">
                            </div>
                            <p class="text-[#475466]">Account Number</p>
                        </div>
                        <p class="font-semibold">{{ $payment->number }}</p>
                        <input type="hidden" name="accountNumber" value="22081996202191404">
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex gap-3">
                            <div class="w-6 h-6 flex shrink-0">
                                <img src="{{ asset('assets/icon/tick-circle.svg') }}" class="w-full h-full object-cover"
                                    alt="icon">
                            </div>
                            <p class="text-[#475466]">Account Name</p>
                        </div>
                        <p class="font-semibold">{{ $payment->account_name }}</p>
                        <input type="hidden" name="accountName" value="Alqowy Education First">
                    </div>
                </div>
                <hr>
                <p class="font-bold text-lg">Confirm Your Payment</p>
                <div class="relative">
                    <button type="button"
                        class="p-4 rounded-full flex gap-3 w-full ring-1 ring-black transition-all duration-300 hover:ring-2 hover:ring-[#FF6129]"
                        onclick="document.getElementById('file').click()">
                        <div class="w-6 h-6 flex shrink-0">
                            <img src="{{ asset('assets/icon/note-add.svg') }}" alt="icon">
                        </div>
                        <p id="fileLabel">Add a file attachment</p>
                    </button>
                    <input id="file" type="file" name="proof" class="hidden" onchange="updateFileName(this)">
                </div>
                <button type="button"
                    class="p-[20px_32px] bg-[#FF6129] text-white rounded-full text-center font-semibold transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980]"
                    onclick="confirmPayment()">I've Made The Payment</button>
            </form>
        </div>
        <div class="flex justify-center absolute transform -translate-x-1/2 left-1/2 bottom-0 w-full">
            <img src="{{ asset('assets/background/alqowy.svg') }}" alt="background">
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="{{ asset('build/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function updateFileName(input) {
            const fileLabel = document.getElementById('fileLabel');
            if (input.files && input.files[0]) {
                fileLabel.textContent = input.files[0].name;
            } else {
                fileLabel.textContent = "Add a file attachment";
            }
        }

        function confirmPayment() {
            Swal.fire({
                title: 'Are you sure you want to make this payment?',
                text: "You are about to confirm the payment for this course.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FF6129',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Display alert that payment is being processed
                    Swal.fire({
                        title: 'Payment is being processed!',
                        text: 'Your payment is under review. Please wait a moment.',
                        icon: 'info',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Submit the form after alert
                        document.getElementById("paymentForm").submit();
                    });
                }
            });
        }
    </script>

</body>

@endsection

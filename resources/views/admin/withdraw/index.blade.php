<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Withdraw Balance') }}
            </h2>
        </div>
    </x-slot>

    {{-- Start Button for Change Section --}}
    <div
        class="grig [grid-template-columns:repeat(4,1fr)] grid items-center text-white rounded-[30px] bg-[#3525B3] w-fit">
        <button id="btn-total" class="section-btn active-btn transition-all duration-300 ease-in-out">Withdraw</button>
        <button id="btn-pending" class="section-btn transition-all duration-300 ease-in-out">Pending</button>
        <button id="btn-rejected" class="section-btn transition-all duration-300 ease-in-out">Rejected</button>
        <button id="btn-approved" class="section-btn transition-all duration-300 ease-in-out">Approved</button>
    </div>
    {{-- End Button for Change Section --}}

    <div>
        <!-- Section: Total Amount -->
        <div id="section-total" class="section">
            <!-- Card for Withdrawal Form -->
            @role('teacher')
                <div class="text-white">
                    <div class="container mx-auto p-10 bg-white rounded-3xl shadow-md relative overflow-hidden">
                        <!-- Decorative Circle -->
                        <div class="absolute -top-12 -left-12 bg-[#FF6129] w-40 h-40 rounded-full opacity-30"></div>
                        <div class="absolute -bottom-16 -right-16 bg-[#3525B3] w-60 h-60 rounded-full opacity-40"></div>

                        <div class="relative z-10 text-center">
                            <h1 class="text-4xl font-extrabold text-[#3525B3] drop-shadow-md">Request Your Balance
                                Withdrawal</h1>
                            <p class="text-gray-600 mt-4">
                                Secure your funds and manage withdrawals effortlessly.
                            </p>
                            <p class="text-2xl font-semibold text-[#FF6129] mt-6">
                                Current Balance: Rp {{ number_format($balance, 0, ',', '.') }}
                            </p>
                        </div>

                        <!-- Content Section -->
                        <div class="flex items-center justify-between mt-8 relative z-10">
                            <!-- Illustration -->
                            <div class="hidden lg:block">
                                <img src="{{ asset('assets/images/icons/withdraw.png') }}" alt="Withdraw Illustration"
                                    class="w-[30rem] drop-shadow-md">
                            </div>

                            <!-- Form -->
                            <div class="w-full lg:w-1/2 bg-gray-50 p-8 rounded-2xl shadow-lg">
                                <form action="{{ route('admin.withdraw.store') }}" method="POST" id="withdraw-form" class="space-y-6">
                                    @csrf
                                    <div>
                                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                                            Withdrawal Amount
                                        </label>
                                        <input type="number" id="amount" name="amount" min="1"
                                            max="{{ $balance }}" value="{{ old('amount') }}" required
                                            class="text-[#3525B3] block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-[#3525B3] focus:border-[#3525B3] shadow-sm">
                                        @error('amount')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Slider for Withdrawal Amount -->
                                    <div>
                                        <label for="withdrawalSlider" class="block text-sm font-medium text-gray-700 mb-2">
                                            Select Withdrawal Percentage
                                        </label>
                                        <input type="range" id="withdrawalSlider" name="withdrawalSlider" min="0"
                                            max="100" step="1" value="0"
                                            class="w-full h-2 bg-[#3525B3] rounded-full" oninput="updateWithdrawalAmount()">
                                        <p class="text-xs text-gray-500 mt-1">Drag to set how much you want to withdraw (0%
                                            - 100%)</p>
                                    </div>

                                    <div class="mt-4">
                                        <p class="text-sm font-medium text-gray-700">Amount to Withdraw: <span
                                                id="calculatedAmount">Rp 0</span></p>
                                    </div>

                                    <button type="button"
                                        class="w-full py-3 text-white font-semibold bg-[#3525B3] rounded-full shadow-lg hover:bg-[#FF6129] transition-transform transform hover:scale-105"
                                        onclick="openModal()">
                                        Request Withdrawal
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endrole
        </div>

        <!-- Section: Pending -->
        <div id="section-pending" class="section hidden">
            <!-- Add your Pending Transactions Table Here -->
            @role('owner|teacher')
                <div class="py-2">
                    <div class="max-w-7xl mx-auto">
                        <div class="bg-white overflow-hidden shadow-sm rounded-[30px] p-8">
                            <h5 class="text-xl font-bold text-gray-700 mb-6">Pending Withdrawals</h5>
                            @if ($withdrawals->isEmpty())
                                <div class="text-center">
                                    <img src="{{ asset('assets/images/background/no-data.jpg') }}" alt="No Data"
                                        class="w-[200px] mx-auto mb-4">
                                    <p class="text-gray-500">No withdrawal requests yet.</p>
                                </div>
                            @else
                                <table class="table-auto w-full">
                                    <thead>
                                        <tr class="border-b border-gray-200">
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Date</th>
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Amount</th>
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Proof Photo
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach ($withdrawals as $withdrawal)
                                            @if ($withdrawal->status === 'pending')
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-4 py-4 text-gray-700 text-sm">
                                                        {{ $withdrawal->created_at->format('d-m-Y H:i') }}
                                                    </td>
                                                    <td class="px-4 py-4 text-gray-700 text-sm">
                                                        Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        <span
                                                            class="inline-block px-3 py-1 text-sm font-medium text-[#FF6129] bg-[#FFCB94] rounded-full">
                                                            Pending
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        @if ($withdrawal->proof_file)
                                                            <img src="{{ asset('storage/' . $withdrawal->proof_file) }}"
                                                                alt="Proof Photo"
                                                                class="w-12 h-12 rounded-lg object-cover shadow">
                                                        @else
                                                            <span class="text-sm text-gray-500">No proof provided.</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            @endrole
        </div>

        <!-- Section: Rejected -->
        <div id="section-rejected" class="section hidden">
            <!-- Add your Rejected Transactions Table Here -->
            @role('owner|teacher')
                <div class="py-2">
                    <div class="max-w-7xl mx-auto">
                        <div class="bg-white overflow-hidden shadow-sm rounded-[30px] p-8">
                            <h5 class="text-xl font-bold text-gray-700 mb-6">Rejected Withdrawals</h5>
                            @if ($withdrawals->isEmpty())
                                <div class="text-center">
                                    <img src="{{ asset('assets/images/background/no-data.jpg') }}" alt="No Data"
                                        class="w-[200px] mx-auto mb-4">
                                    <p class="text-gray-500">No withdrawal requests yet.</p>
                                </div>
                            @else
                                <table class="table-auto w-full">
                                    <thead>
                                        <tr class="border-b border-gray-200">
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Date</th>
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Amount</th>
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Proof Photo
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach ($withdrawals as $withdrawal)
                                            @if ($withdrawal->status === 'rejected')
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-4 py-4 text-gray-700 text-sm">
                                                        {{ $withdrawal->created_at->format('d-m-Y H:i') }}
                                                    </td>
                                                    <td class="px-4 py-4 text-gray-700 text-sm">
                                                        Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        <span
                                                            class="inline-block px-3 py-1 text-sm font-medium text-red-600 bg-red-100 rounded-full">
                                                            Rejected
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        @if ($withdrawal->proof_file)
                                                            <img src="{{ asset('storage/' . $withdrawal->proof_file) }}"
                                                                alt="Proof Photo"
                                                                class="w-12 h-12 rounded-lg object-cover shadow">
                                                        @else
                                                            <span class="text-sm text-gray-500">No proof provided.</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            @endrole
        </div>

        <!-- Section: Approved -->
        <div id="section-approved" class="section hidden">
            <!-- Add your Approved Transactions Table Here -->
            @role('owner|teacher')
                <div class="py-2">
                    <div class="max-w-7xl mx-auto">
                        <div class="bg-white overflow-hidden shadow-sm rounded-[30px] p-8">
                            <h5 class="text-xl font-bold text-gray-700 mb-6">Approved Withdrawals</h5>
                            @if ($withdrawals->isEmpty())
                                <div class="text-center">
                                    <img src="{{ asset('assets/images/background/no-data.jpg') }}" alt="No Data"
                                        class="w-[200px] mx-auto mb-4">
                                    <p class="text-gray-500">No withdrawal requests yet.</p>
                                </div>
                            @else
                                <table class="table-auto w-full">
                                    <thead>
                                        <tr class="border-b border-gray-200">
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Date</th>
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Amount</th>
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Proof Photo
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach ($withdrawals as $withdrawal)
                                            @if ($withdrawal->status === 'approved')
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-4 py-4 text-gray-700 text-sm">
                                                        {{ $withdrawal->created_at->format('d-m-Y H:i') }}
                                                    </td>
                                                    <td class="px-4 py-4 text-gray-700 text-sm">
                                                        Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        <span
                                                            class="inline-block px-3 py-1 text-sm font-medium text-green-600 bg-green-100 rounded-full">
                                                            Approved
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        @if ($withdrawal->proof_file)
                                                            <div class="image-container">
                                                                <img src="{{ asset('storage/' . $withdrawal->proof_file) }}"
                                                                    alt="Proof Photo"
                                                                    class="preview-image w-12 h-12 rounded-lg object-cover shadow cursor-pointer">
                                                            </div>
                                                        @else
                                                            <span class="text-sm text-gray-500">No proof provided.</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @elseif ($withdrawals->isEmpty())
                                                <p>No withdrawal requests yet.</p>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            @endrole
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div id="withdrawModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex justify-center items-center">
        <div class="relative p-4 w-full max-w-md">
            <div class="relative p-4 bg-white rounded-lg shadow sm:p-5">
                <button type="button"
                    class="absolute top-2.5 right-2.5 text-gray-700 hover:text-gray-900 rounded-lg text-sm p-1.5"
                    onclick="closeModal()">
                    ✖
                </button>
                <p class="mb-4 text-gray-700">Are you sure you want to request this withdrawal?</p>
                <div class="flex justify-center space-x-4">
                    <!-- Cancel Button -->
                    <button type="button"
                        class="px-4 py-2 font-semibold bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400"
                        onclick="closeModal()">Cancel</button>
                    <!-- Confirm Button -->
                    <button type="button"
                        class="px-4 py-2 font-semibold bg-[#3525B3] text-white rounded-lg hover:bg-[#FF6129]"
                        onclick="submitForm()">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal preview image --}}
    <div id="image-modal" class="modal hidden">
        <div class="modal-content">
            <button class="close-btn">&times;</button>
            <img id="modal-image" src="" alt="Proof Photo Preview" class="rounded-lg">
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        //message with sweetalert
        @if (session('success'))
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "{{ session('success') }}",
                color: "#fff",
                background: "#3525B3",
            });
        @elseif (session('error'))
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                title: "{{ session('error') }}",
                color: "#ff0000",
                background: "#FFD9D9",
            });
        @endif
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.section-btn');
            const sections = document.querySelectorAll('.section');

            sections[0].classList.remove('hidden'); // Show the first section
            buttons[0].classList.add('active-btn'); // Mark the first button as active

            buttons.forEach((button, index) => {
                button.addEventListener('click', () => {
                    sections.forEach(section => section.classList.add('hidden'));
                    sections[index].classList.remove('hidden');

                    buttons.forEach(btn => btn.classList.remove('active-btn'));
                    button.classList.add('active-btn');
                });
            });
        });

        // modal images in approved
        const modal = document.getElementById("image-modal");
        const modalImage = document.getElementById("modal-image");
        const closeBtn = document.querySelector(".close-btn");

        // Ambil semua elemen gambar dengan class 'preview-image'
        const previewImages = document.querySelectorAll(".preview-image");

        // Tambahkan event listener ke setiap gambar
        previewImages.forEach((image) => {
            image.addEventListener("click", () => {
                modalImage.src = image.src; // Mengatur sumber gambar modal berdasarkan gambar yang diklik
                modal.classList.remove("hidden"); // Menampilkan modal
            });
        });

        // Event untuk tombol close
        closeBtn.addEventListener("click", () => {
            modal.classList.add("hidden"); // Menyembunyikan modal
        });

        // Event untuk klik di luar gambar
        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                modal.classList.add("hidden"); // Menutup modal
            }
        });

        // withdraw balance with progress  bar
        function updateWithdrawalAmount() {
            var sliderValue = document.getElementById("withdrawalSlider").value;

            var balance = {{ $balance }}; // Using PHP to pass the current balance to JS
            var withdrawalAmount = (sliderValue / 100) * balance;

            document.getElementById("calculatedAmount").textContent = "Rp " + withdrawalAmount.toLocaleString();

            document.getElementById("amount").value = withdrawalAmount;
        }

        updateWithdrawalAmount();

        function openModal() {
            document.getElementById('withdrawModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('withdrawModal').classList.add('hidden');
        }

        function submitForm() {
            document.getElementById('withdraw-form').submit();
        }
    </script>
</x-app-layout>

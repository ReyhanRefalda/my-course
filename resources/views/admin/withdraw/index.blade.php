<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Withdraw Balance') }}
            </h2>
        </div>
    </x-slot>

    {{-- button balance withdraw --}}
    <div class="flex justify-between items-center">
        <form action="{{ route('admin.withdraw.index') }}" method="GET"
            class="flex flex-col md:flex-row items-center gap-y-4 gap-x-6 bg-white p-6 rounded-lg shadow-lg">
            <!-- Dropdown Status -->
            <div class="w-full md:w-auto">
                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Filter Status</label>
                <select name="status" id="status"
                    class="w-full md:w-auto px-4 py-3 border border-gray-300 rounded-full focus:ring-[#3525B3] focus:border-[#3525B3] text-gray-700 shadow-sm">
                    <option value="">All</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
            </div>

            <!-- Date Filter -->
            <div class="w-full md:w-auto">
                <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">Filter by Date</label>
                <input type="date" id="date" name="date" value="{{ request('date') }}"
                    class="w-full md:w-auto px-4 py-3 border border-gray-300 rounded-full focus:ring-[#3525B3] focus:border-[#3525B3] text-gray-700 shadow-sm">
            </div>

            <!-- Filter Button -->
            <div class="w-full md:w-auto flex justify-center">
                <button type="submit"
                    class="flex items-center justify-center px-6 py-3 bg-[#3525B3] text-white font-semibold rounded-full shadow-md hover:bg-[#FF6129] transition-transform transform hover:scale-105">
                    Filter
                </button>
            </div>
        </form>
        <button onclick="openModal()"
            class="flex justify-start py-2 w-fit px-6 text-white font-semibold bg-[#3525B3] rounded-full shadow-md">
            Withdraw Balance
        </button>
    </div>

    @role('teacher')
        <div class="py-2">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white overflow-hidden shadow-sm rounded-[30px] p-8">
                    <h5 class="text-xl font-bold text-gray-700 mb-6">History Transactions</h5>
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
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-4 text-gray-700 text-sm">
                                            {{ $withdrawal->created_at->format('d-m-Y H:i') }}
                                        </td>
                                        <td class="px-4 py-4 text-gray-700 text-sm">
                                            Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-4">
                                            @if ($withdrawal->status === 'pending')
                                                <span
                                                    class="inline-block px-3 py-1 text-sm font-medium text-[#FF6129] bg-[#FFCB94] rounded-full">
                                                    Pending
                                                </span>
                                            @elseif ($withdrawal->status === 'approved')
                                                <span
                                                    class="inline-block px-3 py-1 text-sm font-medium text-green-600 bg-green-100 rounded-full">
                                                    Approved
                                                </span>
                                            @else
                                                <span
                                                    class="inline-block px-3 py-1 text-sm font-medium text-red-600 bg-red-100 rounded-full">
                                                    Rejected
                                                </span>
                                            @endif
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
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    @endrole

    <!-- Modal balance withdraw -->
    <div id="withdrawModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg w-11/12 md:w-1/3 p-6 shadow-lg">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Withdraw Balance</h3>
                <button onclick="closeModal()" class="text-gray-600 hover:text-red-500">
                    &times;
                </button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('admin.withdraw.store') }}" method="POST" id="withdraw-form"
                class="space-y-6 mt-4">
                @csrf
                <div>
                    <p class="text-lg text-gray-700 font-bold mb-2">
                        Current Balance: <span class="text-[#3525B3]">Rp {{ number_format($balance, 0, ',', '.') }}
                        </span>
                    </p>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                        Withdrawal Amount
                    </label>
                    <input type="number" id="amount" name="amount" min="1" max="{{ $balance }}"
                        required value="{{ old('amount') }}"
                        class="text-[#3525B3] block w-full px-4 py-3 border border-gray-300 rounded-[30px] focus:ring-[#3525B3] focus:border-[#3525B3] shadow-sm">
                    @error('amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-3 text-white font-semibold bg-[#3525B3] rounded-full shadow-lg hover:bg-[#FF6129] transition-transform transform hover:scale-105">
                    Request Withdrawal
                </button>
            </form>
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

        updateWithdrawalAmount();

        function openModal() {
            document.getElementById('withdrawModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('withdrawModal').classList.add('hidden');
        }
    </script>
</x-app-layout>

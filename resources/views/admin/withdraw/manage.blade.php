<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Withdrawal Requests') }}
            </h2>
        </div>
    </x-slot>

    <div class="flex justify-between items-center">
        <div
            class="grig [grid-template-columns:1fr_1fr] grid items-center text-gray-600 rounded-[30px] bg-[#cccccc] w-fit">
            <button id="btn-prnding" class="section-btn active-btn transition-all duration-300 ease-in-out">Pending
                withdrawal</button>
            <button id="btn-approved" class="section-btn transition-all duration-300 ease-in-out">Approved</button>
        </div>

        <form action="{{ route('admin.withdraw.manage') }}" method="GET" class="flex items-center space-x-4 mb-4">
            <!-- Search Input -->
            <div class="flex items-center space-x-2 bg-white border border-gray-300 rounded-[30px] px-4 py-[2px] shadow-sm">
                <button type="submit" class="text-gray-400">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <input type="text" name="search" placeholder="Search Name..." value="{{ request('search') }}"
                    class="block w-full px-4 text-[#898D93] bg-[#fff] border-2 border-white focus:ring-white focus:border-white sm:text-sm">
            </div>

            <!-- Filter by Date -->
            <input type="date" name="date" value="{{ request('date') }}"
                class="block px-4 py-2 bg-white border border-gray-300 rounded-[30px] text-[#898D93] shadow-sm">

            <!-- Sort Options -->
            <select name="sort" class="block px-4 py-2 bg-white border border-gray-300 rounded-[30px] text-[#898D93] shadow-sm">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest</option>
                <option value="highest" {{ request('sort') == 'highest' ? 'selected' : '' }}>Highest Amount</option>
                <option value="lowest" {{ request('sort') == 'lowest' ? 'selected' : '' }}>Lowest Amount</option>
            </select>

            <!-- Submit Button -->
            <button type="submit"
                class="px-4 py-2 bg-[#5628c2] text-white rounded-[30px] hover:bg-[#481fa7] focus:outline-none">Filter</button>
        </form>
    </div>

    <div>
        @role('owner')
            @if ($pendingWithdrawals->isEmpty() && $approvedWithdrawals->isEmpty())
                <div class="text-center">
                    <div class="col-12 text-center flex justify-center">
                        <img src="{{ asset('assets/images/background/no-data.jpg') }}" alt="No Data" class="img-fluid"
                            style="width: clamp(150px, 50vw, 300px);">
                    </div>
                    <p class="pb-4 text-gray-500">No data available</p>
                </div>
            @else
                {{-- pending section --}}
                <div id="section-pending" class="section">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($pendingWithdrawals as $pending)
                        @if ($pending->status === 'pending')
                            <div
                                class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                <!-- Card Header -->
                                <div class="bg-[#3525B3] text-white text-center py-3 font-bold">
                                    Withdrawal Request
                                </div>

                                <!-- Card Body -->
                                <div class="p-6 space-y-2">
                                    {{-- name teacher section --}}
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700 font-semibold text-md">Name:</span>
                                        <span class="text-[#3525B3] font-bold text-md">
                                            {{ $pending->user->name }}
                                        </span>
                                    </div>

                                    <!-- Amount Section -->
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700 font-semibold text-md">Amount:</span>
                                        <span class="text-[#FF6129] font-bold text-md">
                                            Rp {{ number_format($pending->amount, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <!-- Account Number Section -->
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700 font-semibold text-md">Account Number:</span>
                                        <span class="text-gray-700 font-bold text-md">
                                            {{ $pending->account_number }}
                                        </span>
                                    </div>

                                    <!-- Status Section -->
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700 font-semibold text-md">Status:</span>
                                        <span
                                            class="px-4 py-1 text-sm font-semibold rounded-full text-[#FF6129] bg-[#FFCB94]">
                                            {{ ucfirst($pending->status) }}
                                        </span>
                                    </div>

                                    <!-- Upload Proof -->
                                    <form action="{{ route('admin.withdraw.approve', $pending->id) }}" method="POST"
                                        enctype="multipart/form-data" class="space-y-4">
                                        @csrf
                                        @method('PUT')
                                        <div
                                            class="flex items-center gap-4 border border-dashed border-[#FF6129] rounded-full">
                                            <button type="button"
                                                class="upload-btn w-[100px] h-[100px] rounded-full overflow-hidden border border-gray-200"
                                                data-id="{{ $pending->id }}">
                                                <img class="file-thumbnail object-cover w-full h-full"
                                                    data-id="{{ $pending->id }}"
                                                    src="{{ asset('assets/icon/Mediamodifier-Design.svg') }}"
                                                    alt="Preview">
                                            </button>
                                            <div class="flex flex-col gap-1">
                                                <label class="font-semibold text-sm">Upload Proof</label>
                                                <p class="text-xs text-gray-500">Use a clear and professional image.</p>
                                                <button type="button"
                                                    class="replace-photo-btn font-semibold text-sm text-[#FF6129] hover:underline hidden"
                                                    data-id="{{ $pending->id }}">
                                                    Replace Photo
                                                </button>
                                            </div>
                                            <input type="file" class="proof-file hidden" name="proof_file"
                                                data-id="{{ $pending->id }}" accept="image/*">
                                        </div>
                                        <x-input-error :messages="$errors->get('proof_file')" />

                                        <button type="button"
                                            class="w-full py-3 bg-[#3525B3] hover:bg-opacity-90 text-white font-bold rounded-lg shadow-md"
                                            data-action="{{ route('admin.withdraw.approve', $pending->id) }}"
                                            data-title="Confirm Approval"
                                            data-message="Are you sure you want to approve this withdrawal?"
                                            onclick="openModal(this)">
                                            Approve Withdrawal
                                        </button>
                                    </form>

                                    <!-- Reject Button -->
                                    <form action="{{ route('admin.withdraw.reject', $pending->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <!-- Reject Button -->
                                        <button type="button"
                                            class="w-full py-3 bg-[#FF6129] hover:opacity-90 text-white font-bold rounded-lg shadow-md"
                                            data-action="{{ route('admin.withdraw.reject', $pending->id) }}"
                                            data-title="Confirm Rejection"
                                            data-message="Are you sure you want to reject this withdrawal?"
                                            onclick="openModal(this)">
                                            Reject Withdrawal
                                        </button>
                                    </form>
                                </div>

                                <!-- Card Footer -->
                                <div class="bg-gray-100 p-4 text-center text-sm text-gray-500">
                                    Secure your transactions with a trusted system.
                                </div>
                            </div>
                        @endif
                    @endforeach
                    </div>
                    <div class="mt-6 w-full flex justify-center">
                        {{ $pendingWithdrawals->links() }}
                    </div>
                </div>


                {{-- approved section --}}
                <div id="section-approved" class="section hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($approvedWithdrawals as $withdrawal)
                            @if ($withdrawal->status === 'approved')
                                <div
                                    class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                    <!-- Card Header -->
                                    <div class="bg-[#3525B3] text-white text-center py-3 font-bold">
                                        Approved Withdrawal
                                    </div>

                                    <!-- Card Body -->
                                    <div class="p-6 space-y-4">
                                        <!-- Name Section -->
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-700 font-semibold text-lg">Name:</span>
                                            <span class="text-[#3525B3] font-bold text-lg">
                                                {{ $withdrawal->user->name }}
                                            </span>
                                        </div>

                                        <!-- Amount Section -->
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-700 font-semibold text-lg">Amount:</span>
                                            <span class="text-[#FF6129] font-bold text-lg">
                                                Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <!-- Account Number Section -->
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-700 font-semibold text-md">Account Number:</span>
                                            <span class="text-gray-700 font-bold text-md">
                                                {{ $withdrawal->account_number }}
                                            </span>
                                        </div>

                                        <!-- Status Section -->
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-700 font-semibold text-lg">Status:</span>
                                            <span
                                                class="px-4 py-1 text-sm font-semibold rounded-full text-green-600 bg-green-100 shadow-md">
                                                {{ ucfirst($withdrawal->status) }}
                                            </span>
                                        </div>

                                        <!-- Proof Section -->
                                        <div class="text-center space-y-3">
                                            <strong class="block text-[#3525B3] font-semibold">Proof:</strong>
                                            @if ($withdrawal->proof_file)
                                                <img src="{{ asset('storage/' . $withdrawal->proof_file) }}"
                                                    alt="Proof Photo"
                                                    class="w-full h-[200px] object-cover rounded-lg border border-gray-200 shadow-sm">
                                            @else
                                                <p class="text-gray-500">No proof provided.</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Card Footer -->
                                    <div class="bg-gray-100 p-4 text-center text-sm text-gray-500">
                                        This withdrawal has been approved. Thank you for trusting us!
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6 w-full flex justify-center">
                        {{ $approvedWithdrawals->links() }}
                    </div>
                </div>


                <!-- Modal -->
                <div id="confirmation-modal"
                    class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
                    <div class="bg-white rounded-lg shadow-lg w-[90%] max-w-md p-6">
                        <h3 id="modal-title" class="text-lg font-bold text-gray-800">Confirm</h3>
                        <p id="modal-message" class="mt-2 text-sm text-gray-600">Are you sure you want to do this?
                        </p>

                        <div class="flex justify-end gap-4 mt-6">
                            <button id="cancel-button"
                                class="px-4 py-2 text-sm font-bold text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                                Cancel
                            </button>
                            <button id="confirm-button"
                                class="px-4 py-2 text-sm font-bold text-white bg-[#3525B3] rounded-lg hover:bg-[#FF6129]">
                                Confirm
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        @endrole

        @role('teacher')
            <div class="alert alert-warning" role="alert">
                You do not have access to manage withdrawal requests.
            </div>
        @endrole
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
        // button change section
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

        // preview image
        document.querySelectorAll('.upload-btn').forEach((btn) => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const fileInput = document.querySelector(`.proof-file[data-id="${id}"]`);
                fileInput.click();
            });
        });

        document.querySelectorAll('.proof-file').forEach((input) => {
            input.addEventListener('change', function(event) {
                const id = this.dataset.id;
                const file = event.target.files[0];
                const thumbnail = document.querySelector(`.file-thumbnail[data-id="${id}"]`);
                const replaceBtn = document.querySelector(`.replace-photo-btn[data-id="${id}"]`);

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        thumbnail.src = e.target.result;
                        replaceBtn.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

        document.querySelectorAll('.replace-photo-btn').forEach((btn) => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const fileInput = document.querySelector(`.proof-file[data-id="${id}"]`);
                fileInput.click();
            });
        });

        const modal = document.getElementById('confirmation-modal');
        const modalTitle = document.getElementById('modal-title');
        const modalMessage = document.getElementById('modal-message');
        const cancelButton = document.getElementById('cancel-button');
        const confirmButton = document.getElementById('confirm-button');

        let currentForm = null; // Variabel untuk menyimpan form yang akan disubmit

        function openModal(button) {
            const title = button.getAttribute('data-title');
            const message = button.getAttribute('data-message');

            // Set judul dan pesan modal
            modalTitle.textContent = title;
            modalMessage.textContent = message;

            // Simpan referensi form utama yang terkait dengan tombol ini
            currentForm = button.closest('form');

            // Tampilkan modal
            modal.classList.remove('hidden');
        }

        // Event listener untuk tombol "Batal"
        cancelButton.addEventListener('click', () => {
            modal.classList.add('hidden');
            currentForm = null; // Reset form yang disimpan
        });

        // Event listener untuk klik di luar modal
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.classList.add('hidden');
                currentForm = null; // Reset form yang disimpan
            }
        });

        // Event listener untuk tombol "Konfirmasi"
        confirmButton.addEventListener('click', () => {
            if (currentForm) {
                currentForm.submit(); // Submit form utama
            }
            modal.classList.add('hidden');
            currentForm = null; // Reset form yang disimpan
        });
    </script>
</x-app-layout>

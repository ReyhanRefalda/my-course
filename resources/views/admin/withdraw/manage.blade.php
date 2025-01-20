<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Withdrawal Requests') }}
            </h2>
        </div>
    </x-slot>

    {{-- Start Button for Change Section --}}
    <div class="grig [grid-template-columns:1fr_1fr] grid items-center text-white rounded-[30px] bg-[#3525B3] w-fit">
        <button id="btn-prnding" class="section-btn active-btn transition-all duration-300 ease-in-out">Pending
            withdrawal</button>
        <button id="btn-approved" class="section-btn transition-all duration-300 ease-in-out">Approved</button>
    </div>
    {{-- End Button for Change Section --}}

    <div>
        @role('owner')
            @if ($withdrawals->isEmpty())
                <div class="alert alert-info" role="alert">
                    No withdrawal requests at the moment.
                </div>
            @else
                {{-- pending section --}}
                <div id="section-pending" class="section grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($withdrawals as $withdrawal)
                        @if ($withdrawal->status === 'pending')
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

                                    <!-- Status Section -->
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700 font-semibold text-lg">Status:</span>
                                        <span
                                            class="px-4 py-1 text-sm font-semibold rounded-full text-[#FF6129] bg-[#FFCB94]">
                                            {{ ucfirst($withdrawal->status) }}
                                        </span>
                                    </div>

                                    <!-- Upload Proof -->
                                    <form action="{{ route('admin.withdraw.approve', $withdrawal->id) }}" method="POST"
                                        enctype="multipart/form-data" class="space-y-4">
                                        @csrf
                                        @method('PUT')
                                        <div
                                            class="flex items-center gap-4 border border-dashed border-[#FF6129] rounded-full">
                                            <button type="button"
                                                class="upload-btn w-[100px] h-[100px] rounded-full overflow-hidden border border-gray-200"
                                                data-id="{{ $withdrawal->id }}">
                                                <img class="file-thumbnail object-cover w-full h-full"
                                                    data-id="{{ $withdrawal->id }}"
                                                    src="{{ asset('assets/icon/Mediamodifier-Design.svg') }}"
                                                    alt="Preview">
                                            </button>
                                            <div class="flex flex-col gap-1">
                                                <label class="font-semibold text-sm">Upload Proof</label>
                                                <p class="text-xs text-gray-500">Use a clear and professional image.</p>
                                                <button type="button"
                                                    class="replace-photo-btn font-semibold text-sm text-[#FF6129] hover:underline hidden"
                                                    data-id="{{ $withdrawal->id }}">
                                                    Replace Photo
                                                </button>
                                            </div>
                                            <input type="file" class="proof-file hidden" name="proof_file"
                                                data-id="{{ $withdrawal->id }}" accept="image/*">
                                        </div>
                                        <x-input-error :messages="$errors->get('proof_file')" />

                                        <button type="submit"
                                            class="w-full py-3 bg-[#3525B3] hover:bg-opacity-90 text-white font-bold rounded-lg shadow-md transition-transform transform hover:scale-105">
                                            Approve Withdrawal
                                        </button>
                                    </form>

                                    <!-- Reject Button -->
                                    <form action="{{ route('admin.withdraw.reject', $withdrawal->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="w-full py-3 bg-[#FF6129] text-white font-bold rounded-lg shadow-md transition-transform transform hover:scale-105">
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


                {{-- approved section --}}
                <div id="section-approved" class="section hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($withdrawals as $withdrawal)
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
                                            <img src="{{ asset('storage/' . $withdrawal->proof_file) }}" alt="Proof Photo"
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

                <!-- Modal Konfirmasi -->
                <div id="approveModal" tabindex="-1" aria-hidden="true"
                    class="hidden fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex justify-center items-center">
                    <div class="relative p-4 w-full max-w-md">
                        <div class="relative p-4 bg-white rounded-lg shadow sm:p-5">
                            <button type="button"
                                class="absolute top-2.5 right-2.5 text-gray-700 hover:text-gray-900 rounded-lg text-sm p-1.5"
                                onclick="closeApproveModal()">
                                ✖
                            </button>
                            <p class="mb-4 text-gray-700">Are you sure you want to approve this withdrawal?</p>
                            <div class="flex justify-center space-x-4">
                                <!-- Cancel Button -->
                                <button type="button"
                                    class="px-4 py-2 font-semibold bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400"
                                    onclick="closeApproveModal()">Cancel</button>
                                <!-- Confirm Button -->
                                <button type="button"
                                    class="px-4 py-2 font-semibold bg-[#3525B3] text-white rounded-lg hover:bg-[#FF6129]"
                                    onclick="submitApproveForm()">Confirm</button>
                            </div>
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


        // modal approved withdrawal
        function openApproveModal() {
            document.getElementById('approveModal').classList.remove('hidden');
        }

        function closeApproveModal() {
            document.getElementById('approveModal').classList.add('hidden');
        }

        function submitApproveForm() {
            document.getElementById('approve-form').submit();
        }
    </script>
</x-app-layout>

<x-user>
    @php
        $latestApplication = auth()->user()->teachers()->latest()->first();
    @endphp

    <div class="mt-16 mx-8 overflow-hidden flex justify-center items-center">
        <div class="grid [grid-template-columns:1fr_1fr;]">
            <!-- Bagian Gambar -->
            <div class="w-full h-full flex justify-center items-center">
                <img src="{{ isset($latestApplication->rejection_reason) && $latestApplication->status === 'rejected' ? asset('assets/images/background/rejected.jpg') : asset('assets/images/background/approved.png') }}"
                    alt="status-icon" class="w-[70%] object-cover">
            </div>
            <!-- Bagian Teks -->
            <div class="h-full flex flex-col justify-center items-start">
                <h1 class="text-3xl font-extrabold text-gray-800 mb-4">
                    @if (isset($latestApplication->rejection_reason) && $latestApplication->status === 'rejected')
                        Your Account Was Rejected
                    @else
                        Waiting for Admin Approval
                    @endif
                </h1>
                <p class="text-gray-600 text-lg mb-6">
                    @if (isset($latestApplication->rejection_reason) && $latestApplication->status === 'rejected')
                        <span class="text-red-700 font-semibold">Reason for Rejection:</span>
                        {{ $latestApplication->rejection_reason }}
                    @else
                        Your account has been created, but you need to wait for admin approval to access the Teacher
                        dashboard.
                    @endif
                </p>
                <a href="/"
                    class="px-6 py-3 bg-[#3525B3] text-white rounded-[30px] shadow-md hover:shadow-lg transition-all duration-300 ease-in-out">
                    Back to Home
                </a>
            </div>
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
</x-user>

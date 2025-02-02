<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Details') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-xl overflow-hidden p-10 flex flex-col gap-y-8">

                <!-- User Info Section -->
                <div class="flex gap-x-8 items-center">
                    <div class="relative">
                        <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}"
                            class="w-40 h-40 rounded-full object-cover shadow-lg border-4 border-[#3525B3] transform hover:scale-110 transition duration-300 ease-in-out">
                    </div>

                    <div class="flex flex-col gap-y-4">
                        <div>
                            <p class="text-slate-500 text-sm">Name</p>
                            <h3 class="text-[#3525B3] text-2xl font-bold">{{ $user->name }}</h3>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm">Occupation</p>
                            <h3 class="text-[#3525B3] text-xl font-semibold">{{ $user->occupation }}</h3>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm">Email</p>
                            <h3 class="text-[#3525B3] text-xl font-semibold">{{ $user->email }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Registration Date -->
                <div class="mt-6">
                    <strong class="text-lg text-[#3525B3]">Registration Date:</strong>
                    <p class="text-gray-700">{{ $user->created_at->isoFormat('dddd, D MMMM YYYY') }}</p>
                </div>

                <!-- Subscription Status -->
                <div class="mt-4">
                    <strong class="text-lg text-[#3525B3]">Status:</strong>
                    @php
                        $subscription = $user->subscribe_transactions->first();
                        $isExpired = $subscription && \Carbon\Carbon::parse($subscription->expired_at)->isPast();
                    @endphp
                    @if ($subscription && !$isExpired)
                        <p
                            class="inline-block px-5 py-2 text-base rounded-full bg-[#009C0A] text-white font-semibold transition duration-300 ease-in-out transform hover:scale-105">
                            Active</p>
                    @else
                        <p
                            class="inline-block px-5 py-2 text-base rounded-full bg-[#FF0004] text-white font-semibold transition duration-300 ease-in-out transform hover:scale-105">
                            Non-Active</p>
                    @endif
                </div>

                <!-- Expiry Date -->
                <div class="mt-4">
                    <strong class="text-lg text-[#3525B3]">Expires On:</strong>
                    @if ($subscription)
                        <p class="text-gray-700">{{ \Carbon\Carbon::parse($subscription->expired_at)->format('d M Y') }}
                        </p>
                    @else
                        <p class="text-gray-700">Not Subscribed</p>
                    @endif
                </div>

                <!-- Remaining Days -->
                <div class="mt-4">
                    <strong class="text-lg text-[#3525B3]">Remaining Days:</strong>
                    @if ($subscription)
                        @php
                            $remainingDays = \Carbon\Carbon::now()->diffInDays($subscription->expired_at, false);
                        @endphp
                        @if ($remainingDays > 0)
                            <p class="text-gray-700">{{ (int) $remainingDays }} days</p>
                        @else
                            <p class="text-gray-700">Expired</p>
                        @endif
                    @else
                        <p class="text-gray-700">Not Subscribed</p>
                    @endif
                </div>

                <h2 class="text-2xl font-semibold mt-6 mb-4 text-[#3525B3]">Riwayat Transaksi Langganan</h2>
                <div class="bg-white shadow-md rounded-lg p-6 overflow-x-auto">
                    @if ($user->subscribe_transactions->isEmpty())
                        <p class="text-gray-600">Belum ada transaksi langganan.</p>
                    @else
                        <table class="min-w-full text-sm text-gray-500">
                            <thead>
                                <tr class="bg-[#FF6129] text-white">
                                    <th class="border px-4 py-2 rounded-tl-lg">Paket</th>
                                    <th class="border px-4 py-2">Total</th>
                                    <th class="border px-4 py-2">Status</th>
                                    <th class="border px-4 py-2">Tanggal Mulai</th>
                                    <th class="border px-4 py-2 rounded-tr-lg">Kadaluarsa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->subscribe_transactions as $transaction)
                                    <tr class="hover:bg-gray-100 transition duration-300 ease-in-out">
                                        <td class="border px-4 py-2">
                                            {{ $transaction->package->name ?? 'Paket Tidak Ditemukan' }}</td>
                                        <td class="border px-4 py-2">
                                            Rp{{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                        <td class="border px-4 py-2">
                                            {{ $transaction->is_paid ? 'Dibayar' : 'Belum Dibayar' }}</td>
                                        <td class="border px-4 py-2">
                                            {{ $transaction->subscription_start_date->format('d M Y') }}</td>
                                        <td class="border px-4 py-2">{{ $transaction->expired_at->format('d M Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                <!-- Back Button -->
                <div class="flex justify-end items-center mt-8">
                    <a href="{{ route('admin.users.index') }}"
                        class="font-semibold py-3 px-6 bg-[#FF6129] text-white rounded-full shadow-lg transition-all duration-300 ease-in-out hover:bg-[#FF4500] hover:scale-105 hover:shadow-xl">
                        ← Back
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- SweetAlert Notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
</x-app-layout>

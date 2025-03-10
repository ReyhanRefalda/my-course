<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Details') }}
            </h2>
        </div>
    </x-slot>

    <div class="w-full mx-auto bg-white rounded-3xl shadow-2xl p-10">
        <!-- User Info Section -->
        <div class="flex flex-col md:flex-row gap-8 items-center border-b border-gray-200 pb-6">
            <div class="relative">
                <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}"
                    class="w-40 h-40 rounded-full object-cover shadow-lg border-4 border-[#3525B3] transform hover:scale-110 transition duration-300 ease-in-out">
            </div>
            <div class="flex flex-col gap-y-4 text-center md:text-left">
                <h3 class="text-3xl font-bold text-[#3525B3]">Name: {{ $user->name }}</h3>
                <p class="text-lg text-gray-700">Occupation: {{ $user->occupation }}</p>
                <p class="text-md text-gray-500">Email: {{ $user->email }}</p>
            </div>
        </div>

        <!-- Subscription Status Section -->
        <div class="mt-6">
            <div class="text-center md:text-left">
                <p class="text-lg font-semibold text-[#3525B3]">Subscription Status:</p>
                @php
                    $subscription = $user->subscribe_transactions->first();
                    $isExpired = $subscription && \Carbon\Carbon::parse($subscription->expired_at)->isPast();
                @endphp
                @if ($subscription && !$isExpired)
                    <p class="inline-block mt-2 px-4 py-2 rounded-full bg-green-600 text-white text-sm">
                        Active
                    </p>
                @else
                    <p class="inline-block mt-2 px-4 py-2 rounded-full bg-red-600 text-white text-sm">
                        Non-Active
                    </p>
                @endif
            </div>

            <div class="mt-4 text-center md:text-left">
                <p class="text-gray-700">
                    <span class="font-semibold text-[#3525B3]">Expires On:</span>
                    @if ($subscription)
                        {{ \Carbon\Carbon::parse($subscription->expired_at)->format('d M Y') }}
                    @else
                        Not Subscribed
                    @endif
                </p>
            </div>

            <div class="mt-4 text-center md:text-left">
                <p class="text-gray-700">
                    <span class="font-semibold text-[#3525B3]">Remaining Days:</span>
                    @if ($subscription)
                        @php
                            $remainingDays = \Carbon\Carbon::now()->diffInDays($subscription->expired_at, false);
                        @endphp
                        @if ($remainingDays > 0)
                            {{ (int) $remainingDays }} days
                        @else
                            Expired
                        @endif
                    @else
                        Not Subscribed
                    @endif
                </p>
            </div>

            <div class="mt-4 text-center md:text-left">
                <p class="text-gray-700">
                    <span class="font-semibold text-[#3525B3]">Created at:</span>
                    {{ $user->created_at->format('d M Y') }}
                </p>
            </div>
        </div>

        <!-- History Transactions -->
        <div class="mt-8">
            <h2 class="text-2xl font-semibold text-[#3525B3] mb-4">Transaction History</h2>
            <div class="bg-white shadow-md rounded-lg overflow-x-auto">
                @if ($user->subscribe_transactions->isEmpty())
                    <p class="text-gray-600 text-center p-4">No transactions available.</p>
                @else
                    <table class="min-w-full text-sm text-gray-700">
                        <thead>
                            <tr class="bg-[#3525B3] text-white">
                                <th class="px-4 py-3 text-center">Package</th>
                                <th class="px-4 py-3 text-center">Amount</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center">Start Date</th>
                                <th class="px-4 py-3 text-center">Expired</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->subscribe_transactions as $transaction)
                                <tr class="border-b hover:bg-gray-100 transition">
                                    <td class="px-4 py-3 text-center">{{ $transaction->package->name ?? 'Unknown' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        Rp{{ number_format($transaction->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-center font-semibold {{ $transaction->status === 'approved' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->status === 'approved' ? 'IsPaid' : 'UnPaid' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        {{ $transaction->subscription_start_date ? $transaction->subscription_start_date->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        {{ $transaction->expired_at ? $transaction->expired_at->format('d M Y') : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- Back Button -->
        <div class="flex justify-center md:justify-end mt-8">
            <a href="{{ route('admin.users.index') }}"
                class="inline-block py-3 px-6 bg-[#FF6129] text-white font-semibold rounded-full shadow-lg transition-all duration-300 ease-in-out hover:bg-orange-500 hover:scale-105">
                ← Back
            </a>
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

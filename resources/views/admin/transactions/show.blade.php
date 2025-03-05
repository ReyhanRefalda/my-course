<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Details Informations') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                    <div class="flex flex-row gap-x-10">
                        <svg width="100" height="100" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.4"
                                d="M19 10.2798V17.4298C18.97 20.2798 18.19 20.9998 15.22 20.9998H5.78003C2.76003 20.9998 2 20.2498 2 17.2698V10.2798C2 7.5798 2.63 6.7098 5 6.5698C5.24 6.5598 5.50003 6.5498 5.78003 6.5498H15.22C18.24 6.5498 19 7.2998 19 10.2798Z"
                                fill="#292D32" />
                            <path
                                d="M22 6.73V13.72C22 16.42 21.37 17.29 19 17.43V10.28C19 7.3 18.24 6.55 15.22 6.55H5.78003C5.50003 6.55 5.24 6.56 5 6.57C5.03 3.72 5.81003 3 8.78003 3H18.22C21.24 3 22 3.75 22 6.73Z"
                                fill="#292D32" />
                            <path
                                d="M6.96027 18.5601H5.24023C4.83023 18.5601 4.49023 18.2201 4.49023 17.8101C4.49023 17.4001 4.83023 17.0601 5.24023 17.0601H6.96027C7.37027 17.0601 7.71027 17.4001 7.71027 17.8101C7.71027 18.2201 7.38027 18.5601 6.96027 18.5601Z"
                                fill="#292D32" />
                            <path
                                d="M12.5494 18.5601H9.10938C8.69938 18.5601 8.35938 18.2201 8.35938 17.8101C8.35938 17.4001 8.69938 17.0601 9.10938 17.0601H12.5494C12.9594 17.0601 13.2994 17.4001 13.2994 17.8101C13.2994 18.2201 12.9694 18.5601 12.5494 18.5601Z"
                                fill="#292D32" />
                            <path d="M19 11.8599H2V13.3599H19V11.8599Z" fill="#292D32" />
                        </svg>

                        <div class="flex flex-col gap-y-10">
                            <div>
                                <p class="text-slate-500 text-sm">Total Amount</p>
                                <h3 class="text-indigo-950 text-xl font-bold">Rp.
                                    {{ number_format($subscribeTransaction->total_amount) }}
                                </h3>
                            </div>

                            <!-- Status Badge -->
                            @php
                                $expiredAt = $subscribeTransaction->expired_at ? \Carbon\Carbon::parse($subscribeTransaction->expired_at) : null;
                            @endphp

                            @if ($subscribeTransaction->status === 'approved' && $expiredAt && now()->lessThanOrEqualTo($expiredAt))
                                <span class="w-fit text-sm font-bold py-2 px-3 rounded-full bg-green-500 text-white">
                                    ACTIVE
                                </span>
                            @elseif ($subscribeTransaction->status === 'pending')
                                <span class="w-fit text-sm font-bold py-2 px-3 rounded-full bg-orange-500 text-white">
                                    PENDING
                                </span>
                            @elseif ($subscribeTransaction->status === 'rejected')
                                <span class="w-fit text-sm font-bold py-2 px-3 rounded-full bg-gray-500 text-white">
                                    REJECTED
                                </span>
                            @elseif ($subscribeTransaction->status === 'approved' && $expiredAt && now()->greaterThan($expiredAt))
                                <span class="w-fit text-sm font-bold py-2 px-3 rounded-full bg-red-500 text-white">
                                    EXPIRED
                                </span>
                            @endif

                            <div>
                                <p class="text-slate-500 text-sm">Checkout Date</p>
                                <h3 class="text-indigo-950 text-xl font-bold">
                                    {{ $subscribeTransaction->created_at->isoFormat('dddd, D MMMM YYYY') }}</h3>
                            </div>

                            <div>
                                <p class="text-slate-500 text-sm">
                                    @if ($subscribeTransaction->status === 'rejected')
                                        Rejected At
                                    @else
                                        Subscription Start At
                                    @endif
                                </p>
                                @if ($subscribeTransaction->status === 'rejected')
                                    <h3 class="text-indigo-950 text-xl font-bold">
                                        {{ $subscribeTransaction->updated_at->isoFormat('dddd, D MMMM YYYY') }}
                                    </h3>
                                @elseif ($subscribeTransaction->subscription_start_date)
                                    <h3 class="text-indigo-950 text-xl font-bold">
                                        {{ $subscribeTransaction->subscription_start_date->isoFormat('dddd, D MMMM YYYY') }}
                                    </h3>
                                @else
                                    <h3 class="text-indigo-950 text-xl font-bold">Doesn't started yet</h3>
                                @endif
                            </div>

                            <!-- Reason for Rejection -->
                            @if ($subscribeTransaction->status === 'rejected' && $subscribeTransaction->rejection_reason)
                                <div>
                                    <p class="text-slate-500 text-sm">Rejection Reason</p>
                                    <h3 class="text-red-600 text-lg font-bold italic">
                                        "{{ $subscribeTransaction->reason }}"
                                    </h3>
                                </div>
                            @endif

                            <div>
                                <p class="text-slate-500 text-sm">Student</p>
                                <h3 class="text-indigo-950 text-xl font-bold">{{ $subscribeTransaction->user->name }}</h3>
                            </div>

                            <!-- Proof -->
                            <div class="mt-5">
                                <p class="text-slate-500 text-sm">Proof</p>
                                <img src="{{ Storage::url($subscribeTransaction->proof) }}"
                                    alt="{{ $subscribeTransaction->proof }}" class="rounded shadow-md">
                            </div>
                        </div>
                    </div>

                    <!-- Back Button -->
                    @if ($subscribeTransaction->status === 'approved' || $subscribeTransaction->status === 'rejected' || ($subscribeTransaction->expired_at && now()->greaterThan($subscribeTransaction->expired_at)))
                        <hr class="my-5">
                        <div class="flex justify-end items-center gap-x-4">
                            <a href="{{ route('admin.subscribe_transactions.index') }}"
                                class="font-bold py-4 px-6 bg-orange-500 text-white rounded-full hover:bg-orange-400 transition-all duration-300">
                                Back
                            </a>
                        </div>
                    @else
                    <hr class="my-5">
                    <div class="flex justify-end items-center gap-x-4">

                        <a href="{{ route('admin.subscribe_transactions.index') }}"
                            class="font-bold py-4 px-6 bg-orange-500 text-white rounded-full hover:bg-orange-400 transition-all duration-300">
                            Back
                        </a>

                        <!-- Button to trigger reject modal -->
                        <button type="button" class="font-bold py-4 px-6 bg-red-600 text-white rounded-full"
                        onclick="toggleRejectModal()">Reject Transaction</button>

                        <form id="approveForm" action="{{ route('admin.subscribe_transactions.update', $subscribeTransaction) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="approved">
                            <button type="button" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full"
                                onclick="confirmApprove()">Approve Transaction</button>
                        </form>

                        <!-- Reject Modal -->
                        <div id="rejectModal" tabindex="-1" aria-hidden="true"
                        class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full">
                        <!-- Overlay dengan efek blur -->
                        <div class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-md"></div>

                        <!-- Modal box -->
                        <div class="relative p-4 w-full max-w-md bg-white rounded-lg shadow-lg z-50">
                            <div class="relative p-4 text-center bg-white rounded-lg shadow sm:p-5">
                                <button type="button" class="absolute top-2.5 right-2.5 bg-transparent hover:text-gray-900 rounded-lg text-sm p-1.5"
                                    onclick="toggleRejectModal()">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <p class="mb-4 text-gray-500">Are you sure you want to reject this transaction?</p>

                                <form action="{{ route('admin.subscribe_transactions.update', $subscribeTransaction->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="rejected">
                                    <textarea name="reason" rows="4" placeholder="Enter rejection reason"
                                        class="w-full p-2 border rounded-lg mb-4"></textarea>
                                    <div class="flex justify-center items-center space-x-4">
                                        <button type="button" onclick="toggleRejectModal()"
                                            class="px-4 py-2 font-semibold bg-gray-300 rounded-lg">Cancel</button>
                                        <button type="submit" class="px-4 py-2 font-semibold bg-red-600 text-white rounded-lg">Reject</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Confirm before approving the transaction
        function confirmApprove() {
            Swal.fire({
                title: 'Are you sure you want to approve this transaction?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FF6129',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form if user confirms the approval
                    document.getElementById('approveForm').submit();
                }
            });
        }

        // Success and error messages using SweetAlert
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

        function toggleRejectModal() {
            document.getElementById('rejectModal').classList.toggle('hidden');
        }
    </script>
</x-app-layout>

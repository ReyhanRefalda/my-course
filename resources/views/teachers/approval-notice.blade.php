<x-user>
    <div class="flex justify-center items-center h-screen">
        <div class="text-center">
            <h1 class="text-2xl font-bold mb-4">
                @if (isset($rejection_reason) && $rejection_reason)
                    Your Account Was Rejected
                @else
                    Waiting for Admin Approval
                @endif
            </h1>
            <p class="text-gray-600">
                @if (isset($rejection_reason) && $rejection_reason)
                    Reason for Rejection: {{ $rejection_reason }}
                @else
                    Your account has been created, but you need to wait for admin approval to access the Teacher
                    dashboard.
                @endif
            </p>
        </div>
    </div>
</x-user>

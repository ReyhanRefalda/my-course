<x-user>
    <div class="flex justify-center items-center h-screen">
        <div class="text-center">
            <h1 class="text-2xl font-bold mb-4">
                @if (isset($rejection_reason) && $rejection_reason)
                    Akun Anda Ditolak
                @else
                    Menunggu Persetujuan Admin
                @endif
            </h1>
            <p class="text-gray-600">
                @if (isset($rejection_reason) && $rejection_reason)
                    Alasan Penolakan: {{ $rejection_reason }}
                @else
                    Akun Anda telah dibuat, tetapi Anda harus menunggu persetujuan dari admin untuk dapat mengakses dashboard Teacher.
                @endif
            </p>
        </div>
    </div>
</x-user>

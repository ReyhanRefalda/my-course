<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Withdrawal Requests') }}
            </h2>
        </div>
    </x-slot>

    <div class="container mt-4">
        <h2 class="mb-4">Manage Withdrawal Requests</h2>

        @role('owner') 
            @if ($withdrawals->isEmpty())
                <div class="alert alert-info" role="alert">
                    No withdrawal requests at the moment.
                </div>
            @else
                <div class="row">
                    @foreach ($withdrawals as $withdrawal)
                        <div class="col-md-6">
                            <div class="card mb-3 shadow-sm border-0">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $withdrawal->user->name }}</h5>
                                    <p class="card-text">
                                        <strong>Jumlah:</strong> Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                                    </p>
                                    <p class="card-text">
                                        <strong>Status:</strong> {{ ucfirst($withdrawal->status) }}
                                    </p>

                                    @if ($withdrawal->status == 'pending')
                                        <form action="{{ route('admin.withdraw.approve', $withdrawal->id) }}" method="POST" enctype="multipart/form-data" class="mb-2">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label for="proof_file" class="form-label">Upload Proof (PDF/JPG/PNG)</label>
                                                <input type="file" class="form-control" name="proof_file" id="proof_file" required>
                                            </div>

                                            <button type="submit" class="btn btn-success w-100">Approve Withdrawal</button>
                                        </form>

                                        <form action="{{ route('admin.withdraw.reject', $withdrawal->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <button type="submit" class="btn btn-danger w-100">Reject Withdrawal</button>
                                        </form>
                                    @else
                                        <div class="text-center">
                                            <strong>Proof:</strong>
                                            @if ($withdrawal->proof_file)
                                                <img src="{{ asset('storage/' . $withdrawal->proof_file) }}" alt="Proof" class="img-fluid mt-2" style="max-height: 300px;">
                                            @else
                                                <p class="text-muted mt-2">No proof provided.</p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endrole

        @role('teacher')
            <div class="alert alert-warning" role="alert">
                You do not have access to manage withdrawal requests.
            </div>
        @endrole
    </div>
</x-app-layout>

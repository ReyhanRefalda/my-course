<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Withdraw Balance') }}
            </h2>
        </div>
    </x-slot>

    <div class="container mt-4">
        <!-- Card for Withdrawal Form -->
        @role('teacher')
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Withdraw Your Balance</h5>
            </div>
            <div class="card-body">
                <p>Your current balance: <strong>Rp {{ number_format($balance, 0, ',', '.') }}</strong></p>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Withdrawal Form -->
                <form action="{{ route('admin.withdraw.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="amount" class="form-label">Withdrawal Amount</label>
                        <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount"
                            name="amount" value="{{ old('amount') }}" min="1" max="{{ $balance }}" required>

                        @error('amount')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Request Withdrawal</button>
                </form>
            </div>
        </div>
        @endrole

        <!-- Card for Withdrawal History -->
        @role('admin|teacher')
        <div class="card shadow-lg mt-4">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Withdrawal History</h5>
            </div>
            <div class="card-body">
                @if ($withdrawals->isEmpty())
                    <p>No withdrawal requests yet.</p>
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Proof Photo</th>
                                @role('admin')
                                <th>Actions</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($withdrawals as $withdrawal)
                                <tr>
                                    <td>{{ $withdrawal->created_at->format('d-m-Y H:i') }}</td>
                                    <td>Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($withdrawal->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif ($withdrawal->status === 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($withdrawal->proof_file)
                                            <img src="{{ asset('storage/' . $withdrawal->proof_file) }}" alt="Proof Photo" class="img-fluid" style="max-height: 100px;">
                                        @else
                                            <span class="text-muted">No proof provided.</span>
                                        @endif
                                    </td>
                                    @role('admin')
                                    <td>
                                        @if ($withdrawal->status === 'pending')
                                            <form action="{{ route('admin.withdraw.update', $withdrawal->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" name="status" value="approved" class="btn btn-success btn-sm">Approve</button>
                                                <button type="submit" name="status" value="rejected" class="btn btn-danger btn-sm">Reject</button>
                                            </form>
                                        @else
                                            <span class="text-success">Processed</span>
                                        @endif
                                    </td>
                                    @endrole
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        @endrole
    </div>
</x-app-layout>

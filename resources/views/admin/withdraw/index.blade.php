<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Withdraw Balance') }}
            </h2>
        </div>
    </x-slot>

    <div class="container mt-4">
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

                <form action="{{ route('admin.withdraw.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="amount" class="form-label">Withdrawal Amount</label>
                        <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount"
                            name="amount" value="{{ old('amount') }}" min="1" max="{{ $balance }}" >

                        @error('amount')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Withdraw</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

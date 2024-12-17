<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Product Transactions') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl p-8">

                @forelse ($transactions as $transaction)
                    <div class="item-card flex flex-row justify-between items-center pb-4 mb-6 border-b border-gray-400">
                        <img width="48" height="48" src="https://img.icons8.com/ios/50/credit-card-transfer.png"
                            alt="credit-card-transfer" />
                        <div>
                            <p class="text-slate-500 text-sm">Total Amount</p>
                            <h3 class="text-indigo-950 text-xl font-bold">Rp {{ $transaction->total_amount }}</h3>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm">Date</p>
                            <h3 class="text-indigo-950 text-xl font-bold">
                                {{ $transaction->created_at->isoFormat('ddd, D/MM/YYYY') }}</h3>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm mb-2">Status</p>
                            @if ($transaction->is_paid)
                                <span class="text-sm font-bold py-2 px-3 rounded-full bg-green-500 text-white">
                                    ACTIVE
                                </span>
                            @else
                                <span class="text-sm font-bold py-2 px-3 rounded-full bg-orange-500 text-white">
                                    PENDING
                                </span>
                            @endif
                        </div>
                        <div class="hidden md:flex flex-col">
                            <p class="text-slate-500 text-sm">Student</p>
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $transaction->user->name }}</h3>
                        </div>
                        <div class="hidden md:flex flex-row items-center gap-x-3">
                            <a href="{{ route('admin.subscribe_transactions.show', $transaction) }}"
                                class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                                View Details
                            </a>
                        </div>
                    </div>
                    <div>
                        @if (!$transaction->is_paid)
                            <p class="text-slate-500 text-sm">Date</p>
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $transaction->created_at->isoFormat('dddd, D MMMM YYYY') }}</h3>
                        @elseif ($transaction->is_paid && now()->lessThanOrEqualTo($transaction->expired_at))
                            <p class="text-slate-500 text-sm">Started at</p>
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $transaction->subscription_start_date->isoFormat('dddd, D MMMM YYYY') }}</h3>
                        @else
                            <p class="text-slate-500 text-sm">Expired at</p>
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $transaction->expired_at->isoFormat('dddd, D MMMM YYYY') }}</h3>
                        @endif
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm mb-2">Status</p>
                        @if (!$transaction->is_paid)
                            <span class="text-sm font-bold py-2 px-3 rounded-full bg-orange-500 text-white">
                                PENDING
                            </span>
                        @elseif ($transaction->is_paid && now()->lessThanOrEqualTo($transaction->expired_at))
                            <span class="text-sm font-bold py-2 px-3 rounded-full bg-green-500 text-white">
                                ACTIVE
                            </span>
                        @else
                            <span class="text-sm font-bold py-2 px-3 rounded-full bg-red-500 text-white">
                                EXPIRED
                            </span>
                        @endif
                    </div>
                    <div class="hidden md:flex flex-col">
                        <p class="text-slate-500 text-sm">Student</p>
                        <h3 class="text-indigo-950 text-xl font-bold">{{ $transaction->user->name }}</h3>
                    </div>
                    <div class="hidden md:flex flex-row items-center gap-x-3">
                        <a href="{{ route('admin.subscribe_transactions.show', $transaction) }}" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                            View Details
                        </a>
                    </div>
                </div>
                @empty
                    <p>Belum ada transaksi terbaru</p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>

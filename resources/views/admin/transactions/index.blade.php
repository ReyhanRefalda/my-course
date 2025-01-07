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
            <div class="bg-white overflow-hidden shadow-sm rounded-[30px] p-8">
                @if ($transactions->isEmpty())
                    <div class="text-center text-gray-500 py-8">
                        <div class="col-12 text-center flex justify-center">
                            <img src="{{ asset('assets/images/background/no-data.jpg') }}" alt="No Data"
                                class="img-fluid" style="width: clamp(150px, 50vw, 300px);">
                        </div>
                        <p class="pb-4 text-gray-500">No data available</p>
                    </div>
                @else
                    <table class="table-auto w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 w-96">Student</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600 w-48">Total Amount
                                </th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600 w-48">Date</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600 w-48">Status</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600 w-48"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($transactions as $transaction)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4 flex items-center gap-4">
                                        <img src="{{ Storage::url($transaction->user->avatar) }}" alt="Thumbnail"
                                            class="w-16 h-16 rounded-lg object-cover">
                                        <div>
                                            <h3 class="text-gray-900 font-semibold text-lg">{{ $transaction->user->name }}</h3>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 text-center text-sm text-gray-700">
                                        Rp. {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-2 py-2 text-center text-sm text-gray-700">
                                        {{ $transaction->created_at->isoFormat('ddd, D/MM/YYYY') }}
                                    </td>
                                    <td class="px-2 py-2 text-center text-sm">
                                        @if (!$transaction->is_paid)
                                            <span
                                                class="text-sm font-bold py-2 px-3 rounded-full bg-orange-500 text-white">
                                                PENDING
                                            </span>
                                        @elseif ($transaction->is_paid && now()->lessThanOrEqualTo($transaction->expired_at))
                                            <span
                                                class="text-sm font-bold py-2 px-3 rounded-full bg-green-500 text-white">
                                                ACTIVE
                                            </span>
                                        @else
                                            <span
                                                class="text-sm font-bold py-2 px-3 rounded-full bg-red-500 text-white">
                                                EXPIRED
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-2 py-2 text-right">
                                        <a href="{{ route('admin.subscribe_transactions.show', $transaction) }}"
                                            class="font-bold py-2 px-3 text-white rounded-full shadow bg-[#3525B3] hover:bg-[#281a8b] text-sm">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

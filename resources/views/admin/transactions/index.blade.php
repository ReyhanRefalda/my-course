<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Product Transactions') }}
            </h2>
        </div>
    </x-slot>

    <form action="{{ route('admin.subscribe_transactions.index') }}" method="GET"
        class="flex items-center space-x-4 mb-4">
        <!-- Search Input -->
        <div class="flex items-center space-x-2 bg-white border border-gray-300 rounded-[30px] px-4 py-[2px] shadow-sm">
            <button type="submit" class="text-gray-400">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
            <input type="text" name="search" placeholder="Search User..." value="{{ request('search') }}"
                class="block w-full px-4 text-[#898D93] bg-[#fff] [border:2px_solid_#fff] focus:ring-[#fff] focus:border-[#fff] sm:text-sm">
        </div>

        <!-- Filter by Package Type -->
        <select name="package_type"
            class="block px-4 py-2 bg-white border border-gray-300 rounded-[30px] text-[#898D93] shadow-sm">
            <option value="" {{ request('package_type') == '' ? 'selected' : '' }}>All Packages</option>
            <option value="daily" {{ request('package_type') == 'daily' ? 'selected' : '' }}>Daily</option>
            <option value="weekly" {{ request('package_type') == 'weekly' ? 'selected' : '' }}>Weekly</option>
            <option value="monthly" {{ request('package_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
            <option value="yearly" {{ request('package_type') == 'yearly' ? 'selected' : '' }}>Yearly</option>
        </select>

        <!-- Filter by Status -->
        <select name="status"
            class="block px-4 py-2 bg-white border border-gray-300 rounded-[30px] text-[#898D93] shadow-sm">
            <option value="" {{ request('status') == '' ? 'selected' : '' }}>All Status</option>
            <option value="PENDING" {{ request('status') == 'PENDING' ? 'selected' : '' }}>Pending</option>
            <option value="ACTIVE" {{ request('status') == 'ACTIVE' ? 'selected' : '' }}>Active</option>
            <option value="EXPIRED" {{ request('status') == 'EXPIRED' ? 'selected' : '' }}>Expired</option>
            <option value="REJECTED" {{ request('status') == 'REJECTED' ? 'selected' : '' }}>Rejected</option>
        </select>

        <!-- Submit Button -->
        <button type="submit"
            class="px-4 py-2 bg-[#5628c2] text-white rounded-[30px] hover:bg-[#481fa7] focus:outline-none">Filter</button>
    </form>

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
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600 w-48">Tipe Package
                                </th>
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
                                            <h3 class="text-gray-900 font-semibold text-lg">
                                                {{ $transaction->user->name }}</h3>
                                        </div>
                                    </td>
                                    <td class="text-center text-sm text-gray-700">{{ $transaction->package->tipe }}
                                    </td>
                                    <td class="px-2 py-2 text-center text-sm text-gray-700">
                                        Rp. {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-2 py-2 text-center text-sm text-gray-700">
                                        {{ $transaction->created_at->isoFormat('ddd, D/MM/YYYY') }}
                                    </td>
                                    <td class="px-2 py-2 text-center text-sm">
                                        @if ($transaction->status === 'pending')
                                            <span class="text-sm font-bold py-2 px-3 rounded-full bg-[#FFCB94] text-[#FF6129]">
                                                PENDING
                                            </span>
                                        @elseif ($transaction->status === 'approved' && now()->lessThanOrEqualTo($transaction->expired_at))
                                            <span class="text-sm font-bold py-2 px-3 rounded-full text-[#009C0A] bg-[#BBFFC7]">
                                                ACTIVE
                                            </span>
                                        @elseif ($transaction->status === 'approved' && now()->greaterThan($transaction->expired_at))
                                            <span class="text-sm font-bold py-2 px-3 rounded-full bg-[#fda2a2] text-red-700">
                                                EXPIRED
                                            </span>
                                        @elseif ($transaction->status === 'rejected')
                                            <span class="text-sm font-bold py-2 px-3 rounded-full bg-gray-400 text-gray-800">
                                                REJECTED
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
                    <div class="mt-6">
                        {{ $transactions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let table = document.querySelector("table tbody"); // Ambil tbody dari tabel
            let rows = Array.from(table.querySelectorAll("tr")); // Ambil semua baris dalam tabel

            rows.sort((a, b) => {
                let statusA = a.querySelector("td span").innerText.trim();
                let statusB = b.querySelector("td span").innerText.trim();

                let order = {
                    "PENDING": 1,
                    "ACTIVE": 2,
                    "EXPIRED": 3
                };

                return (order[statusA] || 4) - (order[statusB] || 4);
            });

            rows.forEach(row => table.appendChild(row)); // Reorder rows dalam tabel
        });
    </script>
</x-app-layout>

<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Payments') }}
            </h2>
        </div>
    </x-slot>
    <div class="flex justify-end items-center mb-6">
        <a href="{{ route('admin.payments.create') }}" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
            Add New
        </a>
    </div>
    <div class="py-2">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm rounded-[30px] p-8">
                <table class="table-auto w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-950">Payment Details</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-950">Created At</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-950"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($payments as $payment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4">
                                    <div>
                                        <h3 class="text-gray-900 font-semibold">{{ $payment->bank_name }}</h3>
                                        <p class="text-gray-500 text-sm">: {{ $payment->number }}</p>
                                        <p class="text-gray-500 text-sm">: {{ $payment->account_name }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-gray-700 text-sm">
                                    {{ $payment->created_at->isoFormat('ddd, D/MM/YYYY') }}
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <div class="flex justify-end gap-x-2">
                                        <a href="{{ route('admin.payments.edit', $payment) }}"
                                            class="px-4 py-2 rounded-full text-center font-semibold bg-indigo-600 hover:bg-indigo-700 text-white">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 bg-transparent hover:bg-gray-100 flex items-center justify-center w-10 h-10 rounded-md">
                                                <i class="ti ti-trash text-2xl"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-gray-500">
                                    No payments available.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

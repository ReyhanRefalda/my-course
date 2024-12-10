<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Payments') }}
            </h2>
            <a href="{{ route('admin.payments.create') }}" 
                class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                Add New
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                @forelse ($payments as $payment)
                    <div class="item-card flex flex-row justify-between items-center">
                        <div class="flex flex-row items-center gap-x-3">
                            <div class="flex flex-col">
                                <h3 class="text-indigo-950 text-xl font-bold">{{ $payment->bank_name }}</h3>
                                <p class="text-slate-500 text-sm">Account Number: {{ $payment->number }}</p>
                                <p class="text-slate-500 text-sm">Account Name: {{ $payment->account_name }}</p>
                            </div>
                        </div>
                        <div class="hidden md:flex flex-col">
                            <p class="text-slate-500 text-sm">Created At</p>
                            <h3 class="text-indigo-950 text-xl font-bold">
                                {{ $payment->created_at->isoFormat('dddd, D MMMM YYYY') }}
                            </h3>
                        </div>
                        <div class="hidden md:flex flex-row items-center gap-x-3">
                            <a href="{{ route('admin.payments.edit', $payment) }}" 
                                class="font-bold py-4 px-6 bg-blue-700 text-white rounded-full">
                                Edit
                            </a>
                            <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-bold py-4 px-6 bg-red-700 text-white rounded-full">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center">
                        <h2 class="text-gray-700 text-xl font-bold">No payments available</h2>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

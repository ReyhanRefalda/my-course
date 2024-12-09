<x-app-layout>
    <x-slot name="navbarLink">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg">

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="py-3 w-full mb-4 rounded-xl bg-red-500 text-white">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif

                <form action="{{ route('admin.payments.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="bank_name" :value="__('Bank Name')" />
                        <x-text-input id="bank_name" class="block mt-1 w-full" type="text" name="bank_name" :value="old('bank_name')" required />
                        <x-input-error :messages="$errors->get('bank_name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="number" :value="__('Account Number')" />
                        <x-text-input id="number" class="block mt-1 w-full" type="number" name="number" :value="old('number')" required />
                        <x-input-error :messages="$errors->get('number')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="account_name" :value="__('Account Name')" />
                        <x-text-input id="account_name" class="block mt-1 w-full" type="text" name="account_name" :value="old('account_name')" required />
                        <x-input-error :messages="$errors->get('account_name')" class="mt-2" />
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-indigo-700 text-white px-6 py-3 rounded-lg font-bold">
                            Save
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

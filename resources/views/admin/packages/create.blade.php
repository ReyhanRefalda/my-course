<x-app-layout>
    <x-slot name="navbarLink">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Packages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg">

                <form action="{{ route('admin.packages.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm" rows="3">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="harga" :value="__('Price')" />
                        <x-text-input id="harga" class="block mt-1 w-full" type="number" name="harga" :value="old('harga')" />
                        <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="tipe" :value="__('Type')" />
                        <select id="tipe" name="tipe" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                            <option value="" selected>{{ __('Choose a type') }}</option>
                            <option value="daily" {{ old('tipe') === 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="monthly" {{ old('tipe') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="yearly" {{ old('tipe') === 'yearly' ? 'selected' : '' }}>Yearly</option>
                        </select>
                        <x-input-error :messages="$errors->get('tipe')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <div class="flex flex-col gap-y-5">
                            <x-input-label for="package_benefits" :value="__('Package Benefits')" />
                            @for ($i = 0; $i < 4; $i++)
                                <input type="text" class="py-3 rounded-lg border-slate-300 border" 
                                    placeholder="Enter benefit" name="package_benefits[]" value="{{ old('package_benefits.' . $i) }}">
                            @endfor
                        </div>
                        <x-input-error :messages="$errors->get('package_benefits')" class="mt-2" />
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
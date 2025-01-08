<x-app-layout>
    <x-slot name="navbarLink">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Package') }}
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

                <form action="{{ route('admin.packages.update', $package->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" 
                            value="{{ old('name', $package->name) }}" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm" rows="3" required>{{ old('description', $package->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="harga" :value="__('Price')" />
                        <x-text-input id="harga" class="block mt-1 w-full" type="text" name="harga"
                            value="{{ old('harga', number_format($package->harga, 0, '', '.')) }}" 
                            required oninput="formatCurrency(this)" onblur="removeCurrencyFormat(this)" />
                        <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="tipe" :value="__('Type')" />
                        <select id="tipe" name="tipe" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                            <option value="">{{ __('Choose a type') }}</option>
                            <option value="daily" {{ old('tipe', $package->tipe) === 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="weekly" {{ old('tipe', $package->tipe) === 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ old('tipe', $package->tipe) === 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="yearly" {{ old('tipe', $package->tipe) === 'yearly' ? 'selected' : '' }}>Yearly</option>
                        </select>
                        <x-input-error :messages="$errors->get('tipe')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="package_benefits" :value="__('Package Benefits')" />
                        <div class="flex flex-col gap-y-5">
                            @foreach ($package->benefits as $benefit)
                                <input type="text" class="py-3 rounded-lg border-slate-300 border" 
                                    placeholder="Enter benefit" name="package_benefits[]" 
                                    value="{{ old('package_benefits.' . $loop->index, $benefit->name) }}">
                            @endforeach
                            @for ($i = count($package->benefits); $i < 4; $i++)
                                <input type="text" class="py-3 rounded-lg border-slate-300 border" 
                                    placeholder="Enter benefit" name="package_benefits[]" value="">
                            @endfor
                        </div>
                        <x-input-error :messages="$errors->get('package_benefits')" class="mt-2" />
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-indigo-700 text-white px-6 py-3 rounded-lg font-bold">
                            Update
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function formatCurrency(input) {
            let value = input.value.replace(/\./g, '');
            if (!isNaN(value) && value !== '') {
                input.value = new Intl.NumberFormat('id-ID').format(value);
            } else {
                input.value = '';
            }
        }

        function removeCurrencyFormat(input) {
            input.value = input.value.replace(/\./g, '');
        }
    </script>
</x-app-layout>

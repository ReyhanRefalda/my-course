<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Package') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-4">{{ $package->name }}</h1>

                <div class="mb-4">
                    <h2 class="text-lg font-semibold">Description</h2>
                    <p>{{ $package->description }}</p>
                </div>

                <div class="mb-4">
                    <h2 class="text-lg font-semibold">Harga</h2>
                    <p>Rp {{ number_format($package->harga, 0, ',', '.') }}</p>
                </div>

                <div class="mb-4">
                    <h2 class="text-lg font-semibold">Tipe</h2>
                    <p>{{ ucfirst($package->tipe) }}</p>
                </div>

                <div class="mb-4">
                    <h2 class="text-lg font-semibold">Benefits</h2>
                    @if ($package->benefits->isEmpty())
                        <p class="text-gray-500">No benefits added yet.</p>
                    @else
                        <ul class="list-disc ml-6">
                            @foreach ($package->benefits as $benefit)
                                <li>{{ $benefit->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="flex justify-end mt-6">
                    <a href="{{ route('admin.packages.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg mr-2 hover:bg-gray-600">Back</a>
                    <a href="{{ route('admin.packages.edit', $package->id) }}"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Edit</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

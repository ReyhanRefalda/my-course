<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Packages') }}
            </h2>
            <a href="{{ route('admin.packages.create') }}"
                class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                Add New
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                @forelse ($packages as $package)
                    <div class="item-card flex flex-row justify-between items-center p-5 border rounded-lg shadow hover:shadow-md">
                        <div class="flex flex-row items-center gap-x-3">
                            <div class="flex flex-col">
                                <h3 class="text-indigo-950 text-xl font-bold">{{ $package->name }}</h3>
                                <p class="text-gray-500 text-sm">{{ Str::limit($package->description, 50) }}</p>
                            </div>
                        </div>
                        <div class="hidden md:flex flex-col">
                            <p class="text-slate-500 text-sm">Harga</p>
                            <h3 class="text-indigo-950 text-xl font-bold">Rp{{ number_format($package->harga, 0, ',', '.') }}</h3>
                        </div>
                        <div class="hidden md:flex flex-row items-center gap-x-3">
                            <a href="{{ route('admin.packages.edit', $package) }}" 
                                class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                                Edit
                            </a>
                            <form action="{{ route('admin.packages.destroy', $package) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this package?');">
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
                        <h2 class="text-gray-700 text-xl font-bold">No Packages Found</h2>
                    </div>
                @endforelse
            </div>
            <div class="mt-6">
                {{ $packages->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

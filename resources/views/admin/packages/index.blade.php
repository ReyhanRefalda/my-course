<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Packages') }}
            </h2>
        </div>
    </x-slot>
    <div class="flex justify-end items-center space-x-4 mb-6">
        <a href="{{ route('admin.packages.create') }}"
            class="font-bold py-2 px-6 text-white rounded-full shadow bg-[#3525B3]">
            Add New
        </a>
    </div>


    <div class="py-2">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm rounded-[30px] p-8">
                <table class="table-auto w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 w-96">Package </th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600 w-2">Price</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($packages as $package)
                            <tr class="hover:bg-gray-50">
                                <!-- Package & Description in One Column -->
                                <td class="px-4 py-4 flex items-center gap-4">
                                    <div>
                                        <h3 class="text-gray-900 font-semibold text-xl">{{ $package->name }}</h3> <!-- Make Package Name Larger -->
                                        <p class="text-gray-500 text-sm">{{ Str::limit($package->description, 50) }}</p>
                                    </div>
                                </td>

                                <!-- Price Column -->
                                <td class="px-2 py-2 text-center text-lg text-gray-700 font-semibold"> <!-- Make Price Larger -->
                                    Rp{{ number_format($package->harga, 0, ',', '.') }}
                                </td>

                                <!-- Actions Column -->
                                <td class="px-4 py-4 text-right flex gap-2 justify-end">
                                    <a href="{{ route('admin.packages.edit', $package) }}"
                                        class="px-6 py-3 rounded-full text-center font-semibold bg-indigo-600 hover:bg-indigo-700 text-white">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 bg-transparent hover:bg-transparent flex items-center justify-center w-12 h-12 rounded-md">
                                            <i class="ti ti-trash text-3xl"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-gray-500">No Packages Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-6">
        {{ $packages->links() }}
    </div>

</x-app-layout>

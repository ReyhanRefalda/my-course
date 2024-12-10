<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Teachers') }}
            </h2>

        </div>
    </x-slot>
    <div class="flex justify-between items-center space-x-4 mb-6">
        <form action="" method="GET" class="">
            <!-- Icon Search -->
            {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-5 h-5 text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 19a8 8 0 100-16 8 8 0 000 16z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35" />
            </svg>
            <!-- Input Field -->
            <input type="text" name="query" placeholder="Search Courses"
                class="text-sm outline-none text-gray-700 placeholder-gray-400 bg-transparent w-full border-none focus:ring-0 focus:border-none"> --}}
        </form>

        <a href="{{ route('admin.teachers.create') }}" class="font-bold py-2 px-6 bg-indigo-700 text-white rounded-full shadow hover:bg-indigo-800">
            Add New
        </a>
    </div>
    <div class="py-2">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl p-8">
                   @forelse ($teachers as $teacher)
                    <div class="item-card flex flex-row justify-between items-center">
                        <div class="flex flex-row items-center gap-x-3">
                            <img src="{{ Storage::url($teacher->user->avatar) }}" alt=""
                                class="rounded-2xl object-cover w-[90px] h-[90px]">
                            <div class="flex flex-col">
                                <h3 class="text-indigo-950 text-xl font-bold">{{ $teacher->user->name }}</h3>
                                <p class="text-slate-500 text-sm">{{ $teacher->user->occupation }}</p>
                            </div>
                        </div>
                        <div class="hidden md:flex flex-col">
                            <p class="text-slate-500 text-sm">Date</p>
                            <h3 class="text-indigo-950 text-xl font-bold">
                                {{ $teacher->created_at->isoFormat('dddd, D MMMM YYYY') }}</h3>
                        </div>
                        <div class="hidden md:flex flex-row items-center gap-x-3">
                            <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST">
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
                        <h2 class="text-gray-700 text-xl font-bold">Belum ada guru tersedia</h2>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

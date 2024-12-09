<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Courses') }}
            </h2>
        </div>
    </x-slot>

    <div class="flex justify-between items-center space-x-4 mb-6">
        <form action="" method="GET" class="flex items-center bg-white shadow-lg rounded-full px-2 border border-gray-300 w-full max-w-xs">
            <!-- Icon Search -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-5 h-5 text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 19a8 8 0 100-16 8 8 0 000 16z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35" />
            </svg>
            <!-- Input Field -->
            <input type="text" name="query" placeholder="Search Courses"
                class="text-sm outline-none text-gray-700 placeholder-gray-400 bg-transparent w-full border-none focus:ring-0 focus:border-none">
        </form>

        <a href="{{ route('admin.courses.create') }}" class="font-bold py-2 px-6 bg-indigo-700 text-white rounded-full shadow hover:bg-indigo-800">
            Add New
        </a>
    </div>

    <div class="py-2">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl p-8">
                <table class="table-auto w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 w-96">Course</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600 w-2">Students</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600 w-2">Videos</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600 w-2">Teacher</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600"></th>
                        </tr>


                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($courses as $course)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 flex items-center gap-4">
                                    <img src="{{ Storage::url($course->thumbnail) }}" alt="Thumbnail"
                                        class="w-12 h-12 rounded-lg object-cover">
                                    <div>
                                        <h3 class="text-gray-900 font-semibold">{{ $course->name }}</h3>
                                    </div>
                                </td>
                                <td class="px-2 py-2 text-center text-sm text-gray-700">
                                    {{ $course->students->count() }}
                                </td>
                                <td class="px-2 py-2 text-center text-sm text-gray-700">
                                    {{ $course->course_videos->count() }}
                                </td>
                                <td class="px-2 py-2 text-center text-sm text-gray-700">
                                    {{ $course->teacher->user->name }}
                                </td>
                                <td class="px-4 py-4 text-right flex gap-2">
                                    <a href="{{ route('admin.courses.show', $course) }}"
                                        class="px-6 py-3 rounded-full text-center font-semibold bg-indigo-600 hover:bg-indigo-700 text-white">
                                        Manage
                                    </a>
                                    <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline">
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
                                <td colspan="5" class="text-center py-4 text-gray-500">No Courses Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

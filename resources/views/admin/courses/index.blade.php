<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Courses') }}
            </h2>
        </div>
    </x-slot>

    <div class="flex justify-between items-center space-x-4 mb-6">
        <form action="" method="GET"
            class="flex flex-wrap md:flex-row items-center bg-white shadow-lg rounded-full px-4 py-2 border border-gray-300 gap-4 w-full">
            <!-- Search Field -->
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5 text-gray-400 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 19a8 8 0 100-16 8 8 0 000 16z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35" />
                </svg>
                <input type="text" name="query" placeholder="Search Courses" value="{{ request('query') }}"
                    class="text-sm outline-none text-gray-700 placeholder-gray-400 bg-transparent w-full focus:ring-0"
                    aria-label="Search Courses">
            </div>

            <!-- Category Filter -->
            <div class="flex flex-col md:flex-row items-start md:items-center">
                <label for="category" class="text-sm text-gray-600 mr-2">Category:</label>
                <select name="category" id="category"
                    class="text-sm outline-none text-gray-700 bg-white border border-gray-300 rounded-md px-3 py-1 focus:ring-indigo-500">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Teacher Filter -->
            <div class="flex flex-col md:flex-row items-start md:items-center">
                <label for="teacher" class="text-sm text-gray-600 mr-2">Teacher:</label>
                <select name="teacher" id="teacher"
                    class="text-sm outline-none text-gray-700 bg-white border border-gray-300 rounded-md px-3 py-1 focus:ring-indigo-500">
                    <option value="">All Teachers</option>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ request('teacher') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-800 px-4 py-2 rounded-full shadow-md">
                Apply Filters
            </button>
        </form>

        @role('teacher')
            <a href="{{ route('admin.courses.create') }}"
                class="font-bold py-2 px-6 bg-indigo-700 text-white rounded-full shadow hover:bg-indigo-800">
                Add New
            </a>
        @endrole
    </div>

    <div class="py-2">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm rounded-[30px] p-8">
                <table class="table-auto w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 w-96">Course</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600 w-2">Students</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600 w-2">Category</th>
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
                                    @if ($course->categories->isNotEmpty())
                                        {{ $course->categories->pluck('name')->join(', ') }}
                                    @else
                                        <span class="text-gray-500">No Categories</span>
                                    @endif
                                </td>
                                
                                <td class="px-2 py-2 text-center text-sm text-gray-700">
                                    {{ $course->course_videos->count() }}
                                </td>
                                <td class="px-2 py-2 text-center text-sm text-gray-700">
                                    {{ $course->teacher->user->name }}
                                </td>
                                <td class="px-2 py-2 text-right flex gap-2 justify-end">
                                    <a href="{{ route('admin.courses.show', $course) }}"
                                        class="px-6 py-3 rounded-full text-center font-semibold bg-indigo-600 hover:bg-indigo-700 text-white">
                                        Manage
                                    </a>
                                    <form action="{{ route('admin.courses.destroy', $course) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 bg-transparent hover:bg-transparent flex items-center justify-center w-12 h-12 rounded-md">
                                            <i class="ti ti-trash text-3xl"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <div class="col-12 text-center flex justify-center">
                                        <img src="{{ asset('assets/images/background/no-data.jpg') }}" alt="No Data"
                                            class="img-fluid" style="width: clamp(150px, 50vw, 300px);">
                                    </div>
                                    <p class="pb-4 text-gray-500">No data avilable</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        //message with sweetalert
        @if (session('success'))
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "{{ session('success') }}",
                color: "#fff",
                background: "#3525B3",
            });
        @elseif (session('error'))
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                title: "{{ session('error') }}",
                color: "#ff0000",
                background: "#FFD9D9",
            });
        @endif
    </script>
</x-app-layout>

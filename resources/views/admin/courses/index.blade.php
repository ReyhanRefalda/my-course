<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Courses') }}
            </h2>
        </div>
    </x-slot>

    <div class="flex justify-between items-center space-x-4">
        <form action="" method="GET" class="flex flex-wrap md:flex-row items-center px-4 py-2 gap-x-4">
            <!-- Search Field -->
            <div class="flex items-center space-x-2 bg-white border border-gray-300 rounded-2xl px-4 py-[2px] shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5 text-gray-400 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 19a8 8 0 100-16 8 8 0 000 16z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35" />
                </svg>
                <input type="text" name="query" placeholder="Search Courses" value="{{ request('query') }}"
                    class="block w-full px-0 text-[#525252] bg-[#fff] focus:border-[#fff] sm:text-sm focus:outline-none  [border:none] focus:ring-white focus:border-none"
                    aria-label="Search Courses">
            </div>

            <!-- Category Filter -->
            <div class="flex flex-col md:flex-row items-start md:items-center">
                <select name="category" id="category"
                    class="text-sm outline-none text-gray-700 bg-white border border-gray-300 px-3 py-2 rounded-2xl focus:ring-indigo-500">
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
                <select name="teacher" id="teacher"
                    class="text-sm outline-none text-gray-700 bg-white border border-gray-300 rounded-2xl px-3 py-2 focus:ring-indigo-500">
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
                            <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600 w-44">Category</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600 w-2">Videos</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600 w-44">Teacher</th>
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
                                    <button type="button" data-modal-target="deleteModal-{{ $course->id }}"
                                        data-modal-toggle="deleteModal-{{ $course->id }}">
                                        <i class="ti ti-trash text-[25px] text-red-500"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
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

    <!-- Delete modal -->
    @foreach ($courses as $course)
        <div id="deleteModal-{{ $course->id }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-50 sm:p-5">
                    <button type="button"
                        class="text-gray-700 absolute top-2.5 right-2.5 bg-transparent hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center  dark:hover:text-gray-900"
                        data-modal-toggle="deleteModal-{{ $course->id }}">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <svg class="text-gray-400 dark:text-red-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true"
                        fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="mb-4 text-gray-500 dark:text-gray-800">Do you want to delete this article?</p>
                    <div class="flex justify-center items-center space-x-4">
                        <button data-modal-toggle="deleteModal-{{ $course->id }}" type="button"
                            class="flex items-center px-4 py-2 font-semibold bg-[#3525B3] text-white rounded-2xl focus:outline-none focus:ring-2">Cancel</button>
                        <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="flex items-center px-4 py-2 font-semibold bg-[#FFD9D9] text-red-700 rounded-2xl focus:outline-none focus:ring-none">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
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

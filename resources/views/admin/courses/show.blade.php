<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Courses Details') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                <div class="item-card flex flex-row gap-y-10 justify-between items-center">
                    <div class="flex flex-row items-center gap-x-3">
                        <img src="{{ Storage::url($course->thumbnail) }}" alt=""
                            class="rounded-2xl object-cover w-[200px] h-[150px]">
                        <div class="flex flex-col">
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $course->name }}</h3>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-slate-500 text-sm">Students</p>
                        <h3 class="text-indigo-950 text-xl font-bold">{{ $course->students->count() }}</h3>
                    </div>
                    <div class="flex flex-row items-center gap-x-3">
                        @role('teacher')
                            <a href="{{ route('admin.courses.edit', $course) }}"
                                class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                                Edit Course
                            </a>
                        @endrole
                        <form action="{{ route('admin.courses.destroy', $course) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-bold py-4 px-6 bg-red-700 text-white rounded-full">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <hr class="my-5">

                <div class="flex flex-row justify-between items-center">
                    <div class="flex flex-col">
                        <h3 class="text-indigo-950 text-xl font-bold">Course Videos</h3>
                        <p class="text-slate-500 text-sm">{{ $course->course_videos->count() }} Total Videos</p>
                    </div>

                    @role('teacher')
                        <a href="{{ route('admin.course.add_video', $course->id) }}"
                            class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                            Add New Video
                        </a>
                    @endrole
                </div>


                @foreach ($courseVideos as $video)
                    <div
                        class="item-card flex flex-row gap-y-10 justify-between items-center p-4 border rounded-lg bg-white shadow-sm">
                        <div class="flex flex-row items-center gap-x-3">
                            {{-- Tampilkan thumbnail video meskipun dihapus --}}
                            <iframe width="560" class="rounded-2xl object-cover w-[120px] h-[90px]" height="315"
                                src="https://www.youtube.com/embed/{{ $video->path_video }}"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

                            <div class="flex flex-col">
                                <h3 class="text-indigo-950 text-xl font-bold">{{ $video->name }}</h3>
                                <p class="text-slate-500 text-sm">{{ $video->course->name }}</p>
                            </div>
                        </div>

                        <div class="flex flex-col items-end">
                            {{-- Jika video sudah dihapus (soft delete) --}}
                            {{-- Jika video sudah dihapus (soft delete) --}}
                            @if ($video->trashed())
                                <span class="text-red-500 bg-red-100 rounded-lg px-3 py-1 text-sm font-medium">
                                    Deleted by: {{ $video->deleted_by_user->name ?? 'superadmin' }}
                                </span>
                            @else
                                {{-- Tampilkan tombol aksi jika video belum dihapus --}}
                                <div class="flex flex-row items-center gap-x-3">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.course_videos.edit', $video) }}"
                                        class="font-bold py-2 px-4 bg-indigo-700 text-white rounded-full hover:bg-indigo-800">
                                        Edit Video
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('admin.course_videos.destroy', $video) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        @if (auth()->user()->hasRole('teacher') && !$video->trashed())
                                            {{-- Teacher hanya dapat hard delete jika video belum dihapus --}}
                                            <button type="submit"
                                                class="font-bold py-2 px-4 bg-red-700 text-white rounded-full hover:bg-red-800">
                                                Hapus 
                                            </button>
                                        @elseif (auth()->user()->hasRole('owner') && !$video->trashed())
                                            {{-- Owner hanya dapat soft delete jika video belum dihapus --}}
                                            <button type="submit"
                                                class="font-bold py-2 px-4 bg-red-700 text-white rounded-full hover:bg-red-800">
                                                Hapus 
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            @endif

                        </div>


                    </div>
                @endforeach
















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

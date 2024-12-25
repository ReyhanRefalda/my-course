<link rel="stylesheet" href="{{ mix('css/app.css') }}">
<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Artikel') }}
            </h2>
        </div>
    </x-slot>

    <div class="flex justify-between items-center space-x-4">
        <form action="{{ route('admin.artikel.index') }}" method="GET"
            class="flex flex-wrap md:flex-row items-center gap-x-4 mb-0">
            <div class="flex items-center space-x-2 bg-white border border-gray-300 rounded-2xl px-4 py-[2px] shadow-sm">
                <!-- Pencarian -->
                <button type="submit" class="text-gray-400">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <input type="text" name="search" placeholder="Search Artikel" value="{{ request('search') }}"
                    class="block w-full px-0 text-[#525252] bg-[#fff] focus:border-[#fff] sm:text-sm focus:outline-none  [border:none] focus:ring-white focus:border-none">
            </div>

            <div class="flex gap-x-4 justify-between">
                <!-- Filter Status -->
                <select name="status"
                    class="border border-gray-300 rounded-2xl text-sm px-2 py-1 shadow-sm text-gray-700 w-full">
                    <option value="">Filter by Status</option>
                    <option value="publish" {{ request('status') == 'publish' ? 'selected' : '' }}>Publish</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>

                <!-- Filter Tanggal -->
                <input type="date" name="date"
                    class="border border-gray-300 text-sm px-2 py-1 rounded-2xl text-gray-700 w-full"
                    value="{{ request('date') }}">

                <!-- Tombol Filter -->
                <button type="submit"
                    class="px-4 py-2 text-white bg-[#3525B3] rounded-2xl font-bold hover:bg-indigo-800 transition duration-300 ease-in-out">
                    Filter
                </button>
            </div>
        </form>
        <a href="{{ route('admin.artikel.create') }}"
            class="px-6 py-2.5 font-bold text-white bg-[#3525B3] rounded-2xl
            hover:bg-indigo-800 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-800">
            Add New
        </a>
    </div>


    {{-- @if (session('success'))
        <div class="flex items-center p-4 mb-4 text-blue-800 border-t-4 border-blue-300 bg-blue-50 rounded-lg"
            role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewbox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <div class="ms-3 text-sm font-medium">
                {{ session('success') }}
            </div>
            <button type="button"
                class="ms-auto bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8"
                data-dismiss-target="#alert-border-1" aria-label="Close">
                <span class="sr-only">Dismiss</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewbox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    @endif --}}

    <div class="overflow-x-auto rounded-[30px] shadow-md bg-white">
        <table class="w-full text-left bg-white rounded-lg p-4">
            <thead>
                <tr class="border-b border-gray-300 p-4 [&>th]:px-6 [&>tb]:py4 [&>th]:pt-8">
                    <th class="px-6 py-4 text-[15px] font-semibold text-[#292D32]">Article</th>
                    <th class="px-6 py-4 text-[15px] font-semibold text-[#292D32]">Writer</th>
                    <th class="px-6 py-4 text-[15px] font-semibold text-[#292D32]">Date</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="border-b border-gray-300 divide-y divide-gray-300">
                @forelse ($artikels as $artikel)
                    <tr class="hover:bg-indigo-50">
                        <!-- Artikel -->
                        <td class="flex items-center px-6 py-4 space-x-4">
                            <img src="{{ asset(getenv('CUSTOM_TUMBNAIL_LOCATION') . '/' . $artikel->tumbnail) }}"
                                alt="Artikel Thumbnail" class="w-[90px] h-[90px] rounded-2xl object-cover shadow-md">
                            <div>
                                <h2 class="text-[16px] font-bold text-gray-900">{{ $artikel->title }}</h2>
                                <p class="trix-content mt-1 text-sm">
                                    {!! Str::limit($artikel->content, 120) !!}
                                </p>
                            </div>
                        </td>

                        <!-- Writer -->
                        <td class="px-6 py-4 font-medium text-[#6D7786] text-start">{{ $artikel->user->name }}</td>

                        <!-- Date -->
                        <td class="px-6 py-4 font-medium text-[#6D7786] text-start">
                            {{ $artikel->created_at->isoFormat('ddd, D/MM/YYYY') }}
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4">
                            <span
                                class="px-6 py-3 text-xs font-semibold rounded-full
                                {{ $artikel->status == 'publish' ? 'bg-[#BBFFC7] text-[#009C0A]' : 'bg-[#FFCB94] text-[#FF6129]' }}">
                                {{ ucfirst($artikel->status) }}
                            </span>
                        </td>

                        <!-- Action -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-x-4">
                                <a href="{{ route('admin.artikel.edit', $artikel->id) }}"
                                    class="px-6 py-2.5 text-sm text-white bg-[#3525B3] rounded-full hover:bg-indigo-800 transition duration-300 ease-in-out">
                                    Edit
                                </a>
                                <button type="button" data-modal-target="deleteModal-{{ $artikel->id }}"
                                    data-modal-toggle="deleteModal-{{ $artikel->id }}">
                                    <i class="ti ti-trash text-[25px] text-red-500"></i>
                                </button>
                            </div>
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




    <div class="py-4 px-12">
        {!! $artikels->links() !!}
    </div>


    <!-- Delete modal -->
    @foreach ($artikels as $artikel)
        <div id="deleteModal-{{ $artikel->id }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-50 sm:p-5">
                    <button type="button"
                        class="text-gray-700 absolute top-2.5 right-2.5 bg-transparent hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center  dark:hover:text-gray-900"
                        data-modal-toggle="deleteModal-{{ $artikel->id }}">
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
                        <button data-modal-toggle="deleteModal-{{ $artikel->id }}" type="button"
                            class="flex items-center px-4 py-2 font-semibold bg-[#3525B3] text-white rounded-2xl focus:outline-none focus:ring-2">Cancel</button>
                        <form action="{{ route('admin.artikel.destroy', $artikel->id) }}" method="POST"
                            class="m-0">
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
        document.addEventListener("DOMContentLoaded", function() {
            // Ambil elemen input hidden dan editor
            const hiddenInput = document.getElementById("x");
            const trixEditor = document.querySelector("trix-editor");

            // Debug nilai hidden input
            console.log("Hidden Input Value:", hiddenInput.value);

            // Isi editor dengan nilai lama
            if (hiddenInput.value) {
                trixEditor.editor.loadHTML(hiddenInput.value);
            }

            // Sinkronisasi perubahan dari editor ke hidden input
            trixEditor.addEventListener("trix-change", function() {
                hiddenInput.value = trixEditor.editor.getDocument().toString();
            });
        });
    </script>

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
                title: "{{ session('success') }}",
                color: "#fff",
                background: "#FF0000",
            });
        @endif
    </script>
</x-app-layout>

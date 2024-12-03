<x-app-layout>
    <h1 class="text-lg mb-4 text-gray-500 text-start">
        DASHBOARD ADMIN <span class="text-gray-900"><b>/ DAFTAR ARTIKEL</b></span>
    </h1>

    <div class="w-full flex justify-between items-center mb-4 space-x-4">
        <a href="{{ route('admin.artikel.create') }}"
            class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Tambah Artikel
        </a>
        <div class="w-full max-w-md">
            <form action="{{ route('admin.artikel.index') }}" method="GET">
                <div class="flex items-center space-x-2">
                    <input type="text" name="search" placeholder="Cari artikel" value="{{ request('search') }}"
                        class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-100 dark:text-gray-900 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out">
                    <button type="submit"
                        class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>


    @if (session('success'))
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
    @endif

    <div class="grid grid-cols-3 gap-4">
        @foreach ($artikels as $artikel)
            <div
                class="max-w-sm mx-auto bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="relative">
                    <img src="{{ asset(getenv('CUSTOM_TUMBNAIL_LOCATION') . '/' . $artikel->tumbnail) }}"
                        alt="Artikel Thumbnail" class="w-full h-48 object-cover">
                </div>

                <div class="p-4">
                    <h2 class="text-xl font-bold text-gray-800">{{ $artikel->title }}</h2>
                    <p class="text-gray-600 text-sm mt-1">
                        Ditulis oleh <span class="font-semibold">{{ $artikel->user->nama }}</span>
                        pada <span class="font-semibold">{{ $artikel->created_at->isoFormat('dddd, D MMMM Y') }}</span>
                    </p>
                    <p class="mt-2 text-gray-700 line-clamp-3">{{ $artikel->description }}</p>
                    <span
                        class="mt-4 inline-block px-3 py-1 text-xs font-bold rounded
                    {{ $artikel->status == 'publish' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ ucfirst($artikel->status) }}
                    </span>
                    <div class="mt-4 flex gap-4">
                        {{-- <a href="{{ route('user.artikel.show', $artikel->slug) }}"
                            class="text-blue-500 hover:underline">
                            Show
                        </a> --}}
                        <a href="{{ route('admin.artikel.edit', $artikel->id) }}"
                            class="text-yellow-500 hover:underline">
                            Edit
                        </a>
                        <button type="button" data-modal-target="deleteModal-{{ $artikel->id }}"
                            data-modal-toggle="deleteModal-{{ $artikel->id }}" class="text-red-500 hover:underline">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="py-4">
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
                    <p class="mb-4 text-gray-500 dark:text-gray-800">Apakah anda yakin untuk menghapus artikel ini?</p>
                    <div class="flex justify-center items-center space-x-4">
                        <button data-modal-toggle="deleteModal-{{ $artikel->id }}" type="button"
                            class="py-2 px-3 text-sm font-medium text-white bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-white-900 focus:z-10 dark:bg-blue-500 dark:text-white dark:border-blue-500 dark:hover:text-white dark:hover:bg-blue-800 dark:focus:ring-blue-800">Batalkan</button>
                        <form action="{{ route('admin.artikel.destroy', $artikel->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-200">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

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
</x-app-layout>

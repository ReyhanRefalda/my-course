<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Categories') }}
            </h2>
        </div>
    </x-slot>

    <div class="flex justify-between items-center space-x-4 mb-6">
        <div class="w-[300px]">
            <form action="" method="GET" class="m-0 flex items-center">
                <div
                    class="flex items-center space-x-2 bg-white border border-gray-300 rounded-[30px] px-4 py-[2px] shadow-md">
                    <button type="submit" class="text-gray-400">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <input type="text" name="search" placeholder="Search Category..."
                        value="{{ request('search') }}"
                        class="block w-full px-4 text-[#898D93] bg-[#fff] [border:2px_solid_#fff] focus:ring-[#fff] focus:border-[#fff] sm:text-sm">
                </div>
            </form>
        </div>

        <button onclick="openModal('add')" class="font-bold py-2 px-6 text-white rounded-full shadow bg-[#3525B3]">
            Add New
        </button>
    </div>

    <div class="py-2">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm rounded-[30px] p-8">
                <table class="table-auto w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Category</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Date</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 flex items-center gap-4">
                                    <img src="{{ Storage::url($category->icon) }}" alt="Icon"
                                        class="w-12 h-12 rounded-lg object-cover">
                                    <div>
                                        <h3 class="text-gray-900 font-semibold">{{ $category->name }}</h3>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-gray-700 text-sm">
                                    {{ $category->created_at->isoFormat('ddd, D/MM/YYYY') }}
                                </td>
                                <td class="p-4 flex justify-end gap-x-2">
                                    <button type="button" onclick="openModal('edit', {{ json_encode($category) }})"
                                        class="px-6 py-3 rounded-full text-center font-semibold bg-indigo-600 hover:bg-indigo-700 text-white">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Are you sure you want to delete this category?')"
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

    <!-- Modal -->
    <div id="modal"
        class="fixed inset-0 z-[999] flex items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300 opacity-0 pointer-events-none backdrop-blur-sm">
        <div id="modal-content"
            class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md transform transition-transform duration-300 translate-y-10 scale-95">
            <div class="flex justify-between items-center mb-4">
                <h2 id="modal-title" class="text-xl font-semibold text-gray-800">Add New Category</h2>
                <button type="button" onclick="closeModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>

            <form id="modal-form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                        value="{{ old('name') }}" autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="icon" :value="__('Icon')" />
                    <img id="icon-preview" src="" alt="Icon Preview"
                        class="hidden rounded-2xl object-cover w-[90px] h-[90px]">
                    <x-text-input id="icon" class="block mt-1 w-full" type="file" name="icon" />
                    <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function openModal(mode, category = null) {
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modal-content');
            const form = document.getElementById('modal-form');
            const title = document.getElementById('modal-title');
            const nameInput = document.getElementById('name');
            const iconPreview = document.getElementById('icon-preview');

            // Reset dan isi form sesuai mode
            if (mode === 'edit' && category) {
                title.textContent = 'Update Category';
                form.action = `/admin/categories/${category.id}`;
                if (!form.querySelector('input[name="_method"]')) {
                    form.innerHTML += '<input type="hidden" name="_method" value="PUT">';
                }
                nameInput.value = category.name || ''; // Pastikan nilai diisi langsung
                iconPreview.src = `/storage/${category.icon}`;
                iconPreview.classList.remove('hidden');
            } else {
                title.textContent = 'Add New Category';
                form.action = '/admin/categories';
                form.querySelector('input[name="_method"]')?.remove();
                nameInput.value = ''; // Kosongkan jika tambah baru
                iconPreview.classList.add('hidden');
            }

            // Tampilkan modal tanpa penundaan
            modal.classList.remove('pointer-events-none', 'opacity-0');
            modalContent.classList.remove('translate-y-10', 'scale-95');
            modalContent.classList.add('translate-y-0', 'scale-100');
        }



        function closeModal() {
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modal-content');

            modalContent.classList.remove('translate-y-0', 'scale-100');
            modalContent.classList.add('translate-y-10', 'scale-95');

            setTimeout(() => {
                modal.classList.add('pointer-events-none', 'opacity-0');
            }, 300);
        }

        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', () => {
                openModal('add');
            });
        @endif
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
                title: "{{ session('error') }}",
                color: "#fff",
                background: "#FF0000",
            });
        @endif
    </script>
</x-app-layout>

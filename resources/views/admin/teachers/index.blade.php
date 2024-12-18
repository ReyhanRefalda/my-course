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
            <!-- Add search form if needed -->
        </form>

        <button onclick="openModal()"
            class="font-bold py-2 px-6 bg-indigo-700 text-white rounded-full shadow hover:bg-indigo-800">
            Approval
        </button>
    </div>
    <div class="py-2">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm rounded-[30px] p-8">
                <table class="table-auto w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 w-96">Teacher</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Date</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($teachers as $teacher)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 flex items-center gap-4">
                                    <img src="{{ Storage::url($teacher->user->avatar) }}" alt="Avatar"
                                        class="w-12 h-12 rounded-lg object-cover">
                                    <div>
                                        <h3 class="text-gray-900 font-semibold">{{ $teacher->user->name }}</h3>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-gray-700 text-sm">
                                    {{ $teacher->created_at->isoFormat('dddd, D MMMM YYYY') }}
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <div class="flex gap-2 justify-end">
                                        @if ($teacher->status === 'approved')
                                            <!-- If teacher is approved, show the label instead of buttons -->
                                            <span class="text-green-600 font-semibold">Approved</span>
                                        @else
                                            <!-- Approve Button -->
                                            <form action="{{ route('admin.teachers.update', $teacher->id) }}" method="POST" class="inline" onsubmit="return confirmAction('approve')">
                                                @csrf
                                                @method('PUT')
                                                <x-primary-button type="submit">
                                                    Approve
                                                </x-primary-button>
                                            </form>
                                            <!-- Reject Button -->
                                            <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to reject this teacher?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-[#FFD9D9] text-[#ff0000] px-4 py-2 rounded-full">
                                                    Reject
                                                </button>
                                            </form>
                                        @endif
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
        </div>

    @if ($errors->any())
        <script>
            setTimeout(() => {
                openModal('edit');
            }, 500);
        </script>
    @endif

    <!-- Modal -->
    <div id="modal"
        class="fixed inset-0 z-[999] flex items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300 opacity-0 pointer-events-none backdrop-blur-sm">
        <div id="modal-content"
            class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md transform transition-transform duration-300 translate-y-10 scale-95">
            <div class="flex justify-between items-center mb-4">
                <h2 id="modal-title" class="text-xl font-semibold text-gray-800">Add New Teacher</h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>

            <form id="modal-form" method="POST" action="{{ route('admin.teachers.store') }}"
                enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="text" name="email"
                        value="{{ old('email') }}" autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modal-content');

            modal.classList.remove('pointer-events-none', 'opacity-0');
            modalContent.classList.remove('translate-y-10', 'scale-95');

            // Tambahkan animasi dengan sedikit delay
            setTimeout(() => {
                modalContent.classList.add('translate-y-0', 'scale-100');
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modal-content');

            modalContent.classList.remove('translate-y-0', 'scale-100');
            modalContent.classList.add('translate-y-10', 'scale-95');

            // Setelah animasi selesai, sembunyikan modal
            setTimeout(() => {
                modal.classList.add('pointer-events-none', 'opacity-0');
            }, 300); // Durasi sesuai dengan `transition-duration`
        }

        function confirmAction(action) {
            if (action === 'approve') {
                return confirm('Are you sure you want to approve this teacher?');
            } else if (action === 'reject') {
                return confirm('Are you sure you want to reject this teacher?');
            }
            return false; // Return false if no action matched
        }
    </script>

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
                background: "#FF6129",
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

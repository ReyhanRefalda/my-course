<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Users') }}
            </h2>
        </div>
    </x-slot>

    <div class="w-full overflow-hidden">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex justify-between w-[40%] space-x-4">
            <div class="flex items-center space-x-2 bg-white border border-gray-300 rounded-2xl px-4 py-[2px] shadow-sm">
                <button type="submit" class="text-gray-400">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <input type="text" name="search" placeholder="Search by name or email"
                    class="block w-full px-2 text-[#525252] bg-[#fff] focus:border-[#fff] sm:text-sm focus:outline-none  [border:none] focus:ring-white focus:border-none"
                    value="{{ request('search') }}" />
            </div>

            <select name="subscription"
                class="border-gray-300 rounded-2xl text-gray-600 shadow-sm focus:ring focus:ring-indigo-200">
                <option value="">All Users</option>
                <option value="subscribed" {{ request('subscription') == 'subscribed' ? 'selected' : '' }}>
                    Subscribed
                </option>
            </select>

            <button type="submit"
                class="px-4 py-2 text-white bg-[#3525B3] rounded-2xl font-bold hover:bg-indigo-800 transition duration-300 ease-in-out">
                Filter
            </button>
        </form>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm rounded-[30px] p-8">
                <table class="table-auto w-full border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 text-center">
                            <th></th>
                            <th class="py-3 text-sm font-semibold text-gray-600 text-left">Name</th>
                            <th class="py-3 text-sm font-semibold text-gray-600 text-left pl-12">Email</th>
                            <th class="py-3 text-sm font-semibold text-gray-600 text-left">Status</th>
                            <th class="py-3 text-sm font-semibold text-gray-600 text-left pl-12">Expires On</th>
                            <th class="py-3 text-sm font-semibold text-gray-600 text-left pl-8">Remaining Days</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50 text-center">
                                <td class="py-4 flex justify-center items-center">
                                    <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}"
                                        class="w-16 h-16 rounded-xl object-cover">
                                </td>
                                <td class="py-4 text-gray-900 text-lg font-semibold text-left">
                                    {{ $user->name }}
                                </td>
                                <td class="py-4 pl-12 text-gray-500 text-sm font-semibold text-left">
                                    {{ $user->email }}
                                </td>
                                <td class="font-semibold">
                                    @php
                                        $subscription = $user->subscribe_transactions->first();
                                        $isExpired =
                                            $subscription && \Carbon\Carbon::parse($subscription->expired_at)->isPast();
                                    @endphp
                                    @if ($subscription && !$isExpired)
                                        <p class="text-sm py-2 rounded-full bg-[#009C0A] text-white">
                                            Active
                                        </p>
                                    @else
                                        <p class="text-sm py-2 rounded-full bg-[#FF0004] text-white">
                                            Non-Active
                                        </p>
                                    @endif
                                </td>

                                <td class="py-4 text-gray-500 text-sm font-semibold text-left pl-12">
                                    @if ($subscription)
                                        {{ \Carbon\Carbon::parse($subscription->expired_at)->format('d M Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="py-4 text-gray-500 text-sm font-semibold text-left pl-8">
                                    @if ($subscription)
                                        @php
                                            $remainingDays = \Carbon\Carbon::now()->diffInDays(
                                                $subscription->expired_at,
                                                false,
                                            );
                                        @endphp
                                        @if ($remainingDays > 0)
                                            {{ (int) $remainingDays }} days
                                        @else
                                            Expired
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>


                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="openEditModal({{ $user }})"
                                            class="bg-indigo-600 text-white px-4 py-2 rounded-2xl">
                                            Edit
                                        </button>
                                        <button type="button" data-modal-target="deleteModal-{{ $user->id }}"
                                            data-modal-toggle="deleteModal-{{ $user->id }}">
                                            <i class="ti ti-trash text-[25px] text-red-500"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8">
                                    <div class="flex justify-center">
                                        <img src="{{ asset('assets/images/background/no-data.jpg') }}" alt="No Data"
                                            class="w-40 h-auto">
                                    </div>
                                    <p class="text-gray-500 mt-4">No data available</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div id="editModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden transition-opacity duration-300 ease-out">
        <div
            class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md transform scale-95 transition-transform duration-300 ease-out">
            <div class="flex justify-between items-center mb-4 border-b pb-4">
                <h2 class="text-xl font-semibold text-gray-800">Edit User</h2>
                <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>

            <form id="editForm" method="POST" action="" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <x-input-label for="name" :value="'Name'" />
                    <x-text-input id="name" name="name" type="text" required class="block w-full mt-1" />
                </div>

                <div class="mb-4">
                    <x-input-label for="avatar" :value="'Avatar'" />
                    <!-- Current Image Preview -->
                    <div class="mb-2">
                        <img id="currentAvatarPreview" src="" alt="Current Avatar"
                            class="w-32 h-32 rounded-xl object-cover">
                    </div>
                    <!-- Input for New Image -->
                    <input id="avatar" name="avatar" type="file" class="block w-full mt-1 rounded-full"
                        onchange="previewImage(event)">
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-2xl font-semibold">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete modal -->
    @foreach ($users as $user)
        <div id="deleteModal-{{ $user->id }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-50 sm:p-5">
                    <button type="button"
                        class="text-gray-700 absolute top-2.5 right-2.5 bg-transparent hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center  dark:hover:text-gray-900"
                        data-modal-toggle="deleteModal-{{ $user->id }}">
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
                        <button data-modal-toggle="deleteModal-{{ $user->id }}" type="button"
                            class="flex items-center px-4 py-2 font-semibold bg-[#3525B3] text-white rounded-2xl focus:outline-none focus:ring-2">Cancel</button>
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
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

    <script>
        function openEditModal(user) {
            // Atur action form
            document.getElementById('editForm').action = `/admin/users/${user.id}`;
            document.getElementById('name').value = user.name;

            // Tampilkan current avatar
            const currentAvatarPreview = document.getElementById('currentAvatarPreview');
            currentAvatarPreview.src = user.avatar ? `/storage/${user.avatar}` : '/path/to/default/avatar.jpg';

            // Tampilkan modal
            const modal = document.getElementById('editModal');
            modal.classList.remove('hidden');
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
        }

        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('currentAvatarPreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>

</x-app-layout>

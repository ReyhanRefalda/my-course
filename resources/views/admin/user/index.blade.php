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
                            <th class="py-3 text-sm font-semibold text-gray-600 text-left">Expires On</th>
                            <th class="py-3 text-sm font-semibold text-gray-600 text-left">Remaining Days</th>
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
                                        $subscription = $user->subscribe_transactions->first(); // Ambil langganan terbaru
                                        $isExpired =
                                            $subscription && \Carbon\Carbon::parse($subscription->expired_at)->isPast();
                                    @endphp
                                    @if ($subscription && !$isExpired)
                                        <p class="text-sm py-3 rounded-full bg-[#009C0A] text-white">
                                            Active
                                        </p>
                                    @else
                                        <p class="text-sm py-3 rounded-full bg-[#FF0004] text-white">
                                            Non-Active
                                        </p>
                                    @endif
                                </td>

                                <td class="py-4 text-gray-500 text-sm font-semibold text-left">
                                    @if ($subscription)
                                        {{ \Carbon\Carbon::parse($subscription->expired_at)->format('d M Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="py-4 text-gray-500 text-sm font-semibold text-left">
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
                                        <a href="{{ route('admin.users.show', $user->id) }}"
                                            class="bg-indigo-600 text-white px-4 py-2 rounded-2xl">
                                             View Detail
                                         </a>


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


    <!-- Delete modal -->


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

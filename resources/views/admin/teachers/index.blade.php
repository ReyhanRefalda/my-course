<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Teachers') }}
            </h2>
        </div>
    </x-slot>

    <div class="flex justify-between items-center space-x-4">
        <form action="{{ route('admin.teachers.index') }}" method="GET" class="flex items-center gap-2">
            <!-- Search Input -->
            <div
                class="flex items-center space-x-2 bg-white border border-gray-300 rounded-[30px] px-4 py-[2px] shadow-md">
                <button type="submit" class="text-gray-400">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <input type="text" name="search" placeholder="Search Teacher..." value="{{ request('search') }}"
                    class="block w-full px-4 text-[#898D93] bg-[#fff] [border:2px_solid_#fff] focus:ring-[#fff] focus:border-[#fff] sm:text-sm">
            </div>

            <!-- Status Filter -->
            <select name="status" class="block px-4 py-2 bg-white border border-gray-300 rounded-[30px] shadow-sm text-[#898D93]">
                <option value="" {{ request('status') == '' ? 'selected' : '' }}>All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>

            <button type="submit"
                class="px-4 py-2 bg-[#3525B3] text-white rounded-[30px] hover:bg-[#3122a1] focus:outline-none">Filter</button>
        </form>

        {{--
        <button onclick="openModal()"
            class="font-bold py-2 px-6 bg-indigo-700 text-white rounded-full shadow hover:bg-indigo-800">
            Add New
        </button> --}}
    </div>
    <div class="py-2">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm rounded-[30px] p-8">
                <table class="table-auto w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 w-96">Teacher</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Email</th>
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
                                    {{ $teacher->user->email }}
                                </td>
                                <td class="px-4 py-4 text-gray-700 text-sm">
                                    {{ $teacher->created_at->isoFormat('dddd, D MMMM YYYY') }}
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <div class="flex gap-2 justify-end">
                                        @if ($teacher->status === 'approved')
                                            <span class="text-green-600 font-semibold">Approved</span>
                                        @else
                                            <button type="button" data-modal-target="approveModal-{{ $teacher->id }}"
                                                data-modal-toggle="approveModal-{{ $teacher->id }}"
                                                class="px-4 py-2 bg-[#3525B3] text-white rounded-[30px]">
                                                Approve
                                            </button>
                                            <button type="button" data-modal-target="rejectModal-{{ $teacher->id }}"
                                                data-modal-toggle="rejectModal-{{ $teacher->id }}"
                                                class="px-4 py-2 bg-red-600 text-white rounded-[30px]">
                                                Reject
                                            </button>
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
                                    <p class="pb-4 text-gray-500">No data available</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

        @foreach ($teachers as $teacher)
            <!-- Modal Approve -->
            <div id="approveModal-{{ $teacher->id }}" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-50 sm:p-5">
                        <button type="button"
                            class="absolute top-2.5 right-2.5 bg-transparent hover:text-gray-900 rounded-lg text-sm p-1.5"
                            data-modal-toggle="approveModal-{{ $teacher->id }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <p class="mb-4 text-gray-500">Are you sure you want to approve this teacher?</p>
                        <div class="flex justify-center items-center space-x-4">
                            <button type="button" data-modal-toggle="approveModal-{{ $teacher->id }}"
                                class="px-4 py-2 font-semibold bg-gray-300 rounded-lg">
                                Cancel
                            </button>
                            <form action="{{ route('admin.teachers.update', $teacher->id) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="px-4 py-2 font-semibold bg-[#3525B3] text-white rounded-lg">
                                    Approve
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Reject -->
            <div id="rejectModal-{{ $teacher->id }}" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-50 sm:p-5">
                        <button type="button"
                            class="absolute top-2.5 right-2.5 bg-transparent hover:text-gray-900 rounded-lg text-sm p-1.5"
                            data-modal-toggle="rejectModal-{{ $teacher->id }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <p class="mb-4 text-gray-500">Are you sure you want to reject this teacher?</p>
                        <div class="flex justify-center items-center space-x-4">
                            <button type="button" data-modal-toggle="rejectModal-{{ $teacher->id }}"
                                class="px-4 py-2 font-semibold bg-gray-300 rounded-lg">
                                Cancel
                            </button>
                            <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 font-semibold bg-red-500 text-white rounded-lg">
                                    Reject
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        {{-- <script> --}}
        @if (session('success') || session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
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
                        icon: "{{ session('success') ? 'success' : 'error' }}",
                        title: "{{ session('success') ?? session('error') }}",
                        color: "{{ session('success') ? '#fff' : '#ff0000' }}",
                        background: "{{ session('success') ? '#3525B3' : '#FFD9D9' }}",
                    });
                });
            </script>
        @endif
</x-app-layout>

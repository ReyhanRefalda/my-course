<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Payments') }}
            </h2>
        </div>
    </x-slot>

    @if (!$paymentExists)
        <div class="flex justify-end items-center space-x-4">
            <button onclick="openModal('create')" class="font-bold py-2 px-6 text-white rounded-full shadow bg-[#3525B3]">
                Add New
            </button>
        </div>
    @endif

    <div class="py-2">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm rounded-[30px] p-8">
                <table class="table-auto w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-950">Payment Details</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-950">Date</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-950"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($payments as $payment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 flex items-center gap-4">
                                    <div>
                                        <h3 class="text-gray-900 font-bold">{{ $payment->bank_name }}</h3>
                                        <p class="text-slate-900">Account Number: {{ $payment->number }}</p>
                                        <p class="text-slate-900">Account Name: {{ $payment->account_name }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-gray-900  font-bold">
                                    {{ $payment->created_at->isoFormat('ddd, D/MM/YYYY') }}
                                </td>
                                <td class="p-4 flex justify-end gap-x-2">
                                    <button type="button" onclick="openModal('edit', {{ json_encode($payment) }})"
                                        class="px-6 py-3 rounded-full text-center font-semibold bg-indigo-600 hover:bg-indigo-700 text-white">
                                        Edit
                                    </button>
                                    <button type="button" data-modal-target="deleteModal-{{ $payment->id }}"
                                        data-modal-toggle="deleteModal-{{ $payment->id }}">
                                        <i class="ti ti-trash text-[25px] text-red-500"></i>
                                    </button>
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
        class="fixed inset-0 z-[1050] flex items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300 opacity-0 pointer-events-none backdrop-blur-sm">
        <div id="modal-content"
            class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md transform transition-transform duration-300 translate-y-10 scale-95">
            <div class="flex justify-between items-center mb-4 border-b pb-4">
                <h2 id="modal-title" class="text-xl font-semibold text-gray-800"></h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>

            @if ($errors->any())
                <script>
                    setTimeout(() => {
                        openModal('create');
                    }, 500);
                </script>
            @endif

            <form id="modal-form" method="POST" action="" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="_method" name="_method" value="">

                <div class="mb-4">
                    <x-input-label for="bank_name" :value="'Bank Name'" />
                    <x-text-input id="bank_name"
                        class="block mt-1 w-full border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        type="text" name="bank_name" value="{{ old('bank_name') }}" />
                    <x-input-error :messages="$errors->get('bank_name')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="number" :value="'Account Number'" />
                    <x-text-input id="number"
                        class="block mt-1 w-full border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        type="number" name="number" value="{{ old('number') }}" />
                    <x-input-error :messages="$errors->get('number')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="account_name" :value="'Account Name'" />
                    <x-text-input id="account_name"
                        class="block mt-1 w-full border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        type="text" name="account_name" value="{{ old('account_name') }}" />
                    <x-input-error :messages="$errors->get('account_name')" class="mt-2" />
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="bg-gradient-to-r from-indigo-700 to-blue-600 text-white px-6 py-3 rounded-full font-bold hover:from-indigo-800 hover:to-blue-700">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete modal -->
    @foreach ($payments as $payment)
        <div id="deleteModal-{{ $payment->id }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-50 sm:p-5">
                    <button type="button"
                        class="text-gray-700 absolute top-2.5 right-2.5 bg-transparent hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center  dark:hover:text-gray-900"
                        data-modal-toggle="deleteModal-{{ $payment->id }}">
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
                    <p class="mb-4 text-gray-500 dark:text-gray-800">Do you really want to delete this payment?</p>
                    <div class="flex justify-center items-center space-x-4">
                        <button data-modal-toggle="deleteModal-{{ $payment->id }}" type="button"
                            class="flex items-center px-4 py-2 font-semibold bg-[#3525B3] text-white rounded-2xl focus:outline-none focus:ring-2">Cancel</button>
                        <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST"
                            class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded-2xl focus:outline-none focus:ring-2">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        function openModal(mode, data = null) {
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modal-content');
            const modalTitle = document.getElementById('modal-title');
            const modalForm = document.getElementById('modal-form');
            const methodInput = document.getElementById('_method');

            if (mode === 'create') {
                modalTitle.textContent = 'Create Payment';
                modalForm.action = "{{ route('admin.payments.store') }}";
                methodInput.value = '';
                modalForm.reset();
            } else if (mode === 'edit' && data) {
                modalTitle.textContent = 'Edit Payment';
                modalForm.action = `/admin/payments/${data.id}`;
                methodInput.value = 'PUT';
                document.getElementById('bank_name').value = data.bank_name;
                document.getElementById('number').value = data.number;
                document.getElementById('account_name').value = data.account_name;
            }

            modal.classList.remove('pointer-events-none', 'opacity-0');
            modalContent.classList.remove('translate-y-10', 'scale-95');
            setTimeout(() => {
                modalContent.classList.add('translate-y-0', 'scale-100');
            }, 10);
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

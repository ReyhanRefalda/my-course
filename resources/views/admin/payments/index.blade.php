<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Payments') }}
            </h2>

        </div>
    </x-slot>

    <div class="flex justify-end items-center space-x-4 mb-6">
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
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-950">Bank Information</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-950">Date</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-950"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($payments as $payment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 flex flex-col gap-2">
                                <h3 class="text-gray-900 font-semibold">{{ $payment->bank_name }}</h3>
                                <p class="text-gray-950 text-sm">: {{ $payment->number }}</p>
                                <p class="text-gray-950 text-sm">: {{ $payment->account_name }}</p>
                            </td>
                            <td class="px-4 py-4 text-gray-950 font-bold text-sm">
                                {{ $payment->created_at->isoFormat('ddd, D/MM/YYYY') }}
                            </td>
                            <td class="p-4 flex justify-end gap-x-2">
                                <button onclick="openModal('edit', @json($payment))"
                                    class="px-6 py-3 rounded-full text-center font-semibold bg-indigo-600 hover:bg-indigo-700 text-white">
                                    Edit
                                </button>
                                <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 bg-transparent hover:bg-transparent flex items-center justify-center w-12 h-12 rounded-md">
                                        <i class="ti ti-trash text-3xl"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-gray-500">No payments available</td>
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
                    <x-input-label for="bank_name" :value="__('Bank Name')" />
                    <x-text-input id="bank_name"
                        class="block mt-1 w-full border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        type="text" name="bank_name"  value="{{ old('bank_name') }}" />
                    <x-input-error :messages="$errors->get('bank_name')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="number" :value="__('Account Number')" />
                    <x-text-input id="number"
                        class="block mt-1 w-full border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        type="number" name="number" value="{{ old('number') }}" />
                    <x-input-error :messages="$errors->get('number')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="account_name" :value="__('Account Name')" />
                    <x-text-input id="account_name"
                        class="block mt-1 w-full border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        type="text" name="account_name" value="{{ old('account_name') }}"  />
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

</x-app-layout>

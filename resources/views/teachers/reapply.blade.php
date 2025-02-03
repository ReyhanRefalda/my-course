<x-user>
    <div class="flex justify-center items-center mt-16">
        <!-- Container Form -->
        <div class="shadow-lg rounded-lg p-8 w-full max-w-md relative bg-gray-100">
            <!-- Judul -->
            <h2 class="text-3xl font-bold text-[#3525B3] mb-6 text-center">Apply as Teacher</h2>

            <!-- Alert Konfirmasi -->
            <div id="alert-box" class="hidden bg-[#FF6129] text-white px-4 py-2 rounded-lg mb-4 text-center">
                Please confirm your decision before reapplying.
            </div>

            <!-- Form -->
            <form id="reapply-form" action="{{ route('teacher.reapply.submit') }}" method="POST">
                @csrf
                <p class="text-gray-600 text-lg mb-4">
                    Are you sure you want to reapply as a teacher? You will need to wait for admin approval again.
                </p>

                <!-- Checkbox -->
                <div class="flex items-center gap-2 mb-6">
                    <input id="confirm-checkbox" type="checkbox"
                        class="w-5 h-5 text-[#3525B3] border-gray-300 rounded focus:ring-[#3525B3]">
                    <label for="confirm-checkbox" class="text-gray-700">I understand and want to proceed.</label>
                </div>

                <!-- Submit Button -->
                <button type="button" id="submit-btn"
                    class="w-full px-6 py-3 bg-[#3525B3] text-white font-semibold rounded-lg shadow-md hover:bg-[#2b1e99] hover:shadow-lg disabled:bg-gray-300 disabled:cursor-not-allowed transition-all duration-300"
                    disabled>
                    Submit
                </button>
            </form>

            <!-- Footer -->
            <div class="mt-6 text-center">
                <a href="/" class="text-[#FF6129] hover:underline">Cancel and go back to homepage</a>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Confirm Reapply</h3>
            <p class="text-gray-600 mb-6">
                Are you sure you want to reapply? Once submitted, you cannot undo this action.
            </p>
            <div class="flex justify-end gap-4">
                <button id="cancel-btn"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition">
                    Cancel
                </button>
                <button id="confirm-submit"
                    class="px-4 py-2 bg-[#3525B3] text-white rounded-lg hover:bg-[#2b1e99] transition">
                    Confirm
                </button>
            </div>
        </div>
    </div>

    <script>
        const checkbox = document.getElementById('confirm-checkbox');
        const submitButton = document.getElementById('submit-btn');
        const modal = document.getElementById('confirmation-modal');
        const cancelButton = document.getElementById('cancel-btn');
        const confirmSubmitButton = document.getElementById('confirm-submit');
        const form = document.getElementById('reapply-form');

        // Enable/disable submit button based on checkbox
        checkbox.addEventListener('change', () => {
            submitButton.disabled = !checkbox.checked;
        });

        // Show modal when "Submit" button is clicked
        submitButton.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        // Hide modal when "Cancel" button is clicked
        cancelButton.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        // Submit form when "Confirm" button is clicked
        confirmSubmitButton.addEventListener('click', () => {
            form.submit();
        });
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
</x-user>

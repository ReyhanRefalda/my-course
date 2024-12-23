<x-app-layout>
    <x-slot name="navbarLink">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-white px-8 rounded-[30px] shadow-md">
        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data"
            class="w-full grid [grid-template-columns:1fr_2fr] gap-x-6 gap-y-3 ">
            @csrf
            @method('patch')
            {{-- Section: Change Profile --}}

            <div
                class="h-full flex flex-col justify-center items-center shadow-md border border-gray-300 rounded-[30px]">
                <div class="w-full px-6 text-start mb-4">
                    <h3 class="text-xl font-semibold text-gray-900">Change Profile</h3>
                    <p class="text-sm text-gray-500">Change your profile picture from here</p>
                </div>

                <!-- Avatar Image -->
                <label for="avatar" class="relative cursor-pointer">
                    <img src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : asset('images/avatar-default.png') }}"
                        alt="Profile Picture" class="object-cover w-32 h-32 mb-4 rounded-full">
                </label>

                <div class="space-x-4 flex justify-center items-center mt-4">
                    <button type="button" onclick="document.getElementById('avatar').click()"
                        class="bg-[#3525B3] text-white px-6 py-2 rounded-[30px] font-semibold">Upload</button>
                </div>

                <label for="avatar" class="text-sm text-gray-500 mt-4">Allowed: JPG or PNG. Max size of
                    10mb.</label>

                <!-- Hidden File Input -->
                <input type="file" name="avatar" id="avatar" class="hidden" />

                <!-- Error Message -->
                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            </div>

            {{-- Section: Personal Details and Change Password --}}
            <div class="p-6 bg-white shadow-md rounded-[30px]  border border-gray-300">
                <div class="w-full text-start mb-4">
                    <h3 class="text-xl font-semibold text-gray-900">Personal Details</h3>
                    <p class="text-sm text-gray-500">To change your personal detail , edit and save from here</p>
                </div>
                <div class="grid gap-4">
                    <div>
                        <label for="name" class="block text-md text-gray-900 mb-1">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                            class="w-full border rounded-[15px] py-2 px-4">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div>
                        <label for="occupation" class="block text-md text-gray-900 mb-1">Occupation</label>
                        <input type="text" name="occupation" id="occupation"
                            value="{{ old('occupation', $user->occupation ?? '') }}"
                            class="w-full border rounded-[15px] py-2 px-4">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div>
                        <label for="email" class="block text-md text-gray-900 mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            class="w-full border rounded-[15px] py-2 px-4" autocomplete="username">
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>
                </div>
            </div>

            <div class="grid col-span-full text-center justify-end items-center">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
            </div>
        </form>

        <section class="mt-6">
            <form method="post" action="{{ route('password.update') }}"
                class="w-full grid [grid-template-columns:1fr_2fr] gap-x-6 gap-y-3">
                @csrf
                @method('put')
                <div></div>

                <div class="bg-white px-6 pb-6  rounded-[30px] shadow-md border border-gray-300 grid gap-4">
                    <div class="w-full text-start mb-4 mt-6">
                        <h2 class="text-xl font-semibold text-gray-900">Change Password</h2>
                        <p class="text-sm text-gray-500">To change your password please confirm here</p>
                    </div>

                    <!-- Current Password -->
                    <div>
                        <x-input-label class="block text-md text-gray-900 mb-1" for="update_password_current_password"
                            :value="__('Current Password')" />
                        <div class="relative">
                            <input class="w-full border rounded-[15px] py-2 px-4" id="update_password_current_password"
                                name="current_password" type="password" autocomplete="current-password" />
                            <button type="button" id="toggleCurrentPassword"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2">
                                <i id="showCurrentPasswordIcon" class="ti ti-eye text-[#0E0140] text-2xl"></i>
                                <i id="hideCurrentPasswordIcon"
                                    class="ti ti-eye-off text-[#0E0140] text-2xl hidden"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    </div>

                    <!-- New Password -->
                    <div>
                        <x-input-label class="block text-md text-gray-900 mb-1" for="update_password_password"
                            :value="__('New Password')" />
                        <div class="relative">
                            <input class="w-full border rounded-[15px] py-2 px-4" id="update_password_password"
                                name="password" type="password" autocomplete="new-password" />
                            <button type="button" id="toggleNewPassword"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2">
                                <i id="showNewPasswordIcon" class="ti ti-eye text-[#0E0140] text-2xl"></i>
                                <i id="hideNewPasswordIcon" class="ti ti-eye-off text-[#0E0140] text-2xl hidden"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label class="block text-md text-gray-900 mb-1"
                            for="update_password_password_confirmation" :value="__('Confirm Password')" />
                        <div class="relative">
                            <input class="w-full border rounded-[15px] py-2 px-4"
                                id="update_password_password_confirmation" name="password_confirmation"
                                type="password" autocomplete="new-password" />
                            <button type="button" id="toggleConfirmPassword"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2">
                                <i id="showConfirmPasswordIcon" class="ti ti-eye text-[#0E0140] text-2xl"></i>
                                <i id="hideConfirmPasswordIcon"
                                    class="ti ti-eye-off text-[#0E0140] text-2xl hidden"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <div class="grid col-span-full text-center justify-end items-center">
                    <div class="flex gap-x-4">
                        <div class="">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                        <button
                            class="bg-[#FFD9D9] text-[#FF0000] px-6 py-2 rounded-[30px] font-semibold hover:bg-[#FFD9D9] hover:shadow-[0_0_.5rem_#FFD9D9] transition ease-in-out duration-150"
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Delete Account') }}</button>
                    </div>
                </div>
            </form>
        </section>


        <section class="space-y-6">
            <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                <form method="post" action="{{ route('profile.destroy') }}"
                    class="p-6 rounded-[30px] bg-white shadow-md border border-gray-300">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Are you sure you want to delete your account?') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>

                    <div class="mt-6">
                        <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                        <x-text-input id="password" name="password" type="password"
                            class="block text-md text-gray-900 mb-1 w-full rounded-[30px]"
                            placeholder="{{ __('Password') }}" />

                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end gap-x-4">
                        <x-primary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-primary-button>

                        <button
                            class="bg-[#FFD9D9] text-[#FF0000] px-6 py-2 rounded-[30px] font-semibold hover:bg-[#FFD9D9] hover:shadow-[0_0_.5rem_#FFD9D9] transition ease-in-out duration-150">
                            {{ __('Delete Account') }}
                        </button>
                    </div>
                </form>
            </x-modal>
        </section>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('avatar').addEventListener('change', function(event) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('label img').src = e.target.result;
            };
            reader.readAsDataURL(event.target.files[0]);
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
                title: "{{ session('error') }}",
                color: "#ff0000",
                background: "#FFD9D9",
            });
        @endif
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements for toggling current password visibility
            const currentPasswordInput = document.getElementById('update_password_current_password');
            const showCurrentPasswordIcon = document.getElementById('showCurrentPasswordIcon');
            const hideCurrentPasswordIcon = document.getElementById('hideCurrentPasswordIcon');
            const toggleCurrentPasswordButton = document.getElementById('toggleCurrentPassword');

            // Elements for toggling new password visibility
            const newPasswordInput = document.getElementById('update_password_password');
            const showNewPasswordIcon = document.getElementById('showNewPasswordIcon');
            const hideNewPasswordIcon = document.getElementById('hideNewPasswordIcon');
            const toggleNewPasswordButton = document.getElementById('toggleNewPassword');

            // Elements for toggling confirm password visibility
            const confirmPasswordInput = document.getElementById('update_password_password_confirmation');
            const showConfirmPasswordIcon = document.getElementById('showConfirmPasswordIcon');
            const hideConfirmPasswordIcon = document.getElementById('hideConfirmPasswordIcon');
            const toggleConfirmPasswordButton = document.getElementById('toggleConfirmPassword');

            // Toggle visibility for current password field
            toggleCurrentPasswordButton.addEventListener('click', function() {
                togglePasswordVisibility(currentPasswordInput, showCurrentPasswordIcon,
                    hideCurrentPasswordIcon);
            });

            // Toggle visibility for new password field
            toggleNewPasswordButton.addEventListener('click', function() {
                togglePasswordVisibility(newPasswordInput, showNewPasswordIcon, hideNewPasswordIcon);
            });

            // Toggle visibility for confirm password field
            toggleConfirmPasswordButton.addEventListener('click', function() {
                togglePasswordVisibility(confirmPasswordInput, showConfirmPasswordIcon,
                    hideConfirmPasswordIcon);
            });

            // Function to toggle password visibility
            function togglePasswordVisibility(input, showIcon, hideIcon) {
                const currentType = input.getAttribute('type');
                if (currentType === 'password') {
                    input.setAttribute('type', 'text');
                    showIcon.classList.add('hidden');
                    hideIcon.classList.remove('hidden');
                } else {
                    input.setAttribute('type', 'password');
                    showIcon.classList.remove('hidden');
                    hideIcon.classList.add('hidden');
                }
            }
        });
    </script>
</x-app-layout>

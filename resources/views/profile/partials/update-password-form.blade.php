<section class="mt-6">
    <form method="post" action="{{ route('password.update') }}"
        class="w-full grid [grid-template-columns:1fr_2fr] gap-x-6 gap-y-2">
        @csrf
        @method('put')
        <div></div>

        <div class="bg-white px-6 pb-6  rounded-[30px] shadow-xl border border-gray-300 grid gap-4">
            <div class="w-full text-start mb-4 mt-6">
                <h2 class="text-xl font-semibold text-gray-900">Change Password</h2>
                <p class="text-sm text-gray-500">To change your password please confirm here</p>
            </div>
            <div>
                <x-input-label class="block text-md text-gray-900 mb-1" for="update_password_current_password" :value="__('Current Password')" />
                <input class="w-full border rounded-[15px] py-2 px-4" id="update_password_current_password" name="current_password" type="password"
                    class="mt-1 block w-full" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div>
                <x-input-label class="block text-md text-gray-900 mb-1" for="update_password_password" :value="__('New Password')" />
                <input class="w-full border rounded-[15px] py-2 px-4" id="update_password_password" name="password" type="password" class="mt-1 block w-full"
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label class="block text-md text-gray-900 mb-1" for="update_password_password_confirmation" :value="__('Confirm Password')" />
                <input class="w-full border rounded-[15px] py-2 px-4" id="update_password_password_confirmation" name="password_confirmation" type="password"
                    class="mt-1 block w-full" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>
        <div class="grid col-span-full text-center justify-end items-center">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-[#FF6129]">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

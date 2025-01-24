<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Details') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                <div class="flex flex-row gap-x-10">
                    <img src="{{Storage::url($user->avatar)}}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full object-cover shadow-md">

                    <div class="flex flex-col gap-y-5">
                        <div>
                            <p class="text-slate-500 text-sm">Name</p>
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $user->name }}</h3>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm">Occupation</p>
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $user->occupation }}</h3>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm">Email</p>
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $user->email }}</h3>
                        </div>
                    </div>
                </div>

                <hr class="my-5">
                <div class="flex justify-end items-center gap-x-4">
                    <a href="{{ route('admin.users.index') }}"
                        class="font-bold py-4 px-6 bg-orange-500 text-white rounded-full hover:bg-orange-400 transition-all duration-300">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>

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

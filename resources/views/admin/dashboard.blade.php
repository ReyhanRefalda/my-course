<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ Auth::user()->hasRole('owner') ? __('Owner Dashboard') : __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    {{-- <div class="py-12"> --}}
    <div class="">
        <div class="overflow-hidden sm:rounded-xl flex flex-col">

            @role('owner')
                <div class="flex flex-col gap-10 md:flex-row justify-between items-center">
                    <div
                        class="w-[350px] flex justify-between gap-14 rounded-[35px] card px-12 py-5 bg-[rgba(53,37,179,.3)]">
                        <div>
                            <h3 class="text-indigo-950 text-xl font-semibold">Transactions</h3>
                            <p class="text-slate-500 text-lg">{{ $transactions }}</p>
                        </div>
                        <div class="py-2 px-4 rounded-[20px] bg-indigo-600">
                            <img src="{{ asset('assets/images/icons/transaction.png ') }}" alt="transaction"
                                class="w-[40px] h-[40px]">
                        </div>
                    </div>
                    <div
                        class="w-[350px] flex justify-between gap-14 rounded-[35px] card px-12 py-5 bg-[rgba(255,97,41,.3)]">
                        <div>
                            <h3 class="text-indigo-950 text-xl font-semibold">Students</h3>
                            <p class="text-slate-500 text-lg">{{ $students }}</p>
                        </div>
                        <div class="py-2 px-4 rounded-[20px] bg-[#FF6129]">
                            <img src="{{ asset('assets/images/icons/student.png ') }}" alt="transaction"
                                class="w-[40px] h-[40px]">
                        </div>
                    </div>
                    <div
                        class="w-[350px] flex justify-between gap-14 rounded-[35px] card px-12 py-5 bg-[rgba(53,37,179,.3)]">
                        <div>
                            <h3 class="text-indigo-950 text-xl font-semibold">Teachers</h3>
                            <p class="text-slate-500 text-lg">{{ $teachers }}</p>
                        </div>
                        <div class="py-2 px-4 rounded-[20px] bg-indigo-600">
                            <img src="{{ asset('assets/images/icons/teacher.png ') }}" alt="transaction"
                                class="w-[40px] h-[40px] object-contain">
                        </div>
                    </div>
                </div>

                <div class="card mt-10">
                    <div class="card-body w-full">
                        <div class="flex  justify-between">
                            <h4 class="text-gray-500 text-lg font-semibold sm:mb-0 mb-2">Transactions</h4>
                            <div class="hs-dropdown relative inline-flex [--placement:bottom-right] sm:[--trigger:hover]">
                                <a class="relative hs-dropdown-toggle cursor-pointer align-middle rounded-full">
                                    <i class="ti ti-dots-vertical text-2xl text-gray-400"></i>
                                </a>
                                <div class="card hs-dropdown-menu transition-[opacity,margin] rounded-md duration hs-dropdown-open:opacity-100 opacity-0 mt-2 min-w-max  w-[150px] hidden z-[12]"
                                    aria-labelledby="hs-dropdown-custom-icon-trigger">
                                    <div class="card-body p-0 py-2">
                                        <a href="javscript:void(0)"
                                            class="flex gap-2 items-center font-medium px-4 py-2.5 hover:bg-gray-200 text-gray-400">
                                            <p class="text-sm ">Action</p>
                                        </a>
                                        <a href="javscript:void(0)"
                                            class="flex gap-2 items-center font-medium px-4 py-2.5 hover:bg-gray-200 text-gray-400">
                                            <p class="text-sm ">Another Action</p>
                                        </a>
                                        <a href="javscript:void(0)"
                                            class="flex gap-2 items-center font-medium px-4 py-2.5 hover:bg-gray-200 text-gray-400">
                                            <p class="text-sm ">Something else here</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="profit"></div>
                    </div>
                </div>
            @endrole

</x-app-layout>

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

            @role('teacher')
                <div class="flex flex-col gap-y-10 md:flex-row justify-between items-center">
                    <div class="flex flex-col gap-y-3">
                        <svg width="46" height="46" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.4"
                                d="M22 7.81V16.19C22 19.83 19.83 22 16.19 22H7.81C4.17 22 2 19.83 2 16.19V7.81C2 7.3 2.04 6.81 2.13 6.36C2.64 3.61 4.67 2.01 7.77 2H16.23C19.33 2.01 21.36 3.61 21.87 6.36C21.96 6.81 22 7.3 22 7.81Z"
                                fill="#292D32" />
                            <path
                                d="M22 7.81V7.86H2V7.81C2 7.3 2.04 6.81 2.13 6.36H7.77V2H9.27V6.36H14.73V2H16.23V6.36H21.87C21.96 6.81 22 7.3 22 7.81Z"
                                fill="#292D32" />
                            <path
                                d="M14.4391 12.7198L12.3591 11.5198C11.5891 11.0798 10.8491 11.0198 10.2691 11.3498C9.68914 11.6798 9.36914 12.3598 9.36914 13.2398V15.6398C9.36914 16.5198 9.68914 17.1998 10.2691 17.5298C10.5191 17.6698 10.7991 17.7398 11.0891 17.7398C11.4891 17.7398 11.9191 17.6098 12.3591 17.3598L14.4391 16.1598C15.2091 15.7198 15.6291 15.0998 15.6291 14.4298C15.6291 13.7598 15.1991 13.1698 14.4391 12.7198Z"
                                fill="#292D32" />
                        </svg>

                        <div>
                            <p class="text-slate-500 text-sm">Courses</p>
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $courses }}</h3>
                        </div>
                    </div>
                    <div class="flex flex-col gap-y-3">
                        <svg width="46" height="46" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.4"
                                d="M9 2C6.38 2 4.25 4.13 4.25 6.75C4.25 9.32 6.26 11.4 8.88 11.49C8.96 11.48 9.04 11.48 9.1 11.49C9.12 11.49 9.13 11.49 9.15 11.49C9.16 11.49 9.16 11.49 9.17 11.49C11.73 11.4 13.74 9.32 13.75 6.75C13.75 4.13 11.62 2 9 2Z"
                                fill="#292D32" />
                            <path
                                d="M14.0809 14.1499C11.2909 12.2899 6.74094 12.2899 3.93094 14.1499C2.66094 14.9999 1.96094 16.1499 1.96094 17.3799C1.96094 18.6099 2.66094 19.7499 3.92094 20.5899C5.32094 21.5299 7.16094 21.9999 9.00094 21.9999C10.8409 21.9999 12.6809 21.5299 14.0809 20.5899C15.3409 19.7399 16.0409 18.5999 16.0409 17.3599C16.0309 16.1299 15.3409 14.9899 14.0809 14.1499Z"
                                fill="#292D32" />
                            <path opacity="0.4"
                                d="M19.9894 7.3401C20.1494 9.2801 18.7694 10.9801 16.8594 11.2101C16.8494 11.2101 16.8494 11.2101 16.8394 11.2101H16.8094C16.7494 11.2101 16.6894 11.2101 16.6394 11.2301C15.6694 11.2801 14.7794 10.9701 14.1094 10.4001C15.1394 9.4801 15.7294 8.1001 15.6094 6.6001C15.5394 5.7901 15.2594 5.0501 14.8394 4.4201C15.2194 4.2301 15.6594 4.1101 16.1094 4.0701C18.0694 3.9001 19.8194 5.3601 19.9894 7.3401Z"
                                fill="#292D32" />
                            <path
                                d="M21.9902 16.5899C21.9102 17.5599 21.2902 18.3999 20.2502 18.9699C19.2502 19.5199 17.9902 19.7799 16.7402 19.7499C17.4602 19.0999 17.8802 18.2899 17.9602 17.4299C18.0602 16.1899 17.4702 14.9999 16.2902 14.0499C15.6202 13.5199 14.8402 13.0999 13.9902 12.7899C16.2002 12.1499 18.9802 12.5799 20.6902 13.9599C21.6102 14.6999 22.0802 15.6299 21.9902 16.5899Z"
                                fill="#292D32" />
                        </svg>
                        <div>
                            <p class="text-slate-500 text-sm">Students</p>
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $students }}</h3>
                        </div>
                    </div>
                    <a href="{{ route('admin.courses.create') }}"
                        class="w-fit font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                        Create New Course
                    </a>
                </div>
            @endrole

            @role('student')
                {{-- <div class="container mx-auto p-6">
                    <h3 class="text-2xl font-semibold mb-4">Course History</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-white border rounded-[30px] shadow-md transition p-6 flex">
                            <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="Course Image"
                                class="w-20 h-20 object-cover rounded-lg mr-4">
                            <div class="flex flex-col justify-center">
                                <h4 class="text-lg font-bold">Membuat Laporan Keuangan</h4>
                                <p class="text-sm text-gray-500">Data Analyst</p>
                            </div>
                        </div>
                        <div class="bg-white border rounded-[30px] shadow-md transition p-6 flex">
                            <img src="course2.jpg" alt="Course Image" class="w-20 h-20 object-cover rounded-lg mr-4">
                            <div class="flex flex-col justify-center">
                                <h4 class="text-lg font-bold">Tutorial Blockchain</h4>
                                <p class="text-sm text-gray-500">Web 3 Developer</p>
                            </div>
                        </div>
                        <div class="bg-white border rounded-[30px] shadow-md transition p-6 flex">
                            <img src="course3.jpg" alt="Course Image" class="w-20 h-20 object-cover rounded-lg mr-4">
                            <div class="flex flex-col justify-center">
                                <h4 class="text-lg font-bold">Membuat Laporan Keuangan</h4>
                                <p class="text-sm text-gray-500">Data Analyst</p>
                            </div>
                        </div>
                        <div class="bg-white border rounded-[30px] shadow-md transition p-6 flex">
                            <img src="course4.jpg" alt="Course Image" class="w-20 h-20 object-cover rounded-lg mr-4">
                            <div class="flex flex-col justify-center">
                                <h4 class="text-lg font-bold">Tutorial Blockchain</h4>
                                <p class="text-sm text-gray-500">Web 3 Developer</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container mx-auto p-6">
                    <h3 class="text-2xl font-semibold mb-4">Latest Article</h3>
                    <div class="flex space-x-9">
                        <div class="bg-white border rounded-[30px] transition overflow-hidden relative w-[350px]">
                            <img src="article1.jpg" alt="Article Image" class="w-full h-40 object-cover">
                            <div class="p-4">
                                <h4 class="text-lg font-bold mt-4">Manta Terbang Menuju Jurang</h4>
                                <p class="text-sm text-gray-500 mt-2">Deskripsi untuk cara menjadi seorang programmer web 3
                                </p>
                                <div class="flex justify-between items-center text-xs text-gray-400 mt-4">
                                    <span>Author: Sarada</span>
                                    <span>Wed, 4/12/2024</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white border rounded-[30px] transition overflow-hidden relative w-[350px]">
                            <img src="article2.jpg" alt="Article Image" class="w-full h-40 object-cover">
                            <div class="p-4">
                                <h4 class="text-lg font-bold mt-4">Manta Terbang Menuju Jurang</h4>
                                <p class="text-sm text-gray-500 mt-2">Deskripsi untuk cara menjadi seorang programmer web 3
                                </p>
                                <div class="flex justify-between items-center text-xs text-gray-400 mt-4">
                                    <span>Author: Sarada</span>
                                    <span>Wed, 4/12/2024</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white border rounded-[30px] transition overflow-hidden relative w-[350px]">
                            <img src="article3.jpg" alt="Article Image" class="w-full h-40 object-cover">
                            <div class="p-4">
                                <h4 class="text-lg font-bold mt-4">Manta Terbang Menuju Jurang</h4>
                                <p class="text-sm text-gray-500 mt-2">Deskripsi untuk cara menjadi seorang programmer web 3
                                </p>
                                <div class="flex justify-between items-center text-xs text-gray-400 mt-4">
                                    <span>Author: Sarada</span>
                                    <span>Wed, 4/12/2024</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            @endrole

            <!--  Header End -->

            {{-- @role('owner')
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
            @endrole --}}
</x-app-layout>

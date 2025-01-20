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
                <div class="space-y-10">
                    <!-- Cards Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="p-6 rounded-2xl bg-gradient-to-br from-orange-200 to-orange-400 text-white shadow-md">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold">Balance</h3>
                                    <p class="text-2xl font-bold">Rp{{ number_format($balanceOwner, 0, ',', '.') }}</p>
                                </div>
                                <div class="p-3 bg-orange-500 rounded-full">
                                    <img src="{{ asset('assets/images/icons/balance.png') }}" alt="Balance Icon"
                                        class="w-10 h-10">
                                </div>
                            </div>
                        </div>

                        <div class="p-6 rounded-2xl bg-gradient-to-br from-blue-200 to-blue-400 text-white shadow-md">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold">Transactions</h3>
                                    <p class="text-2xl font-bold">{{ $transactions }}</p>
                                </div>
                                <div class="p-3 bg-blue-500 rounded-full">
                                    <img src="{{ asset('assets/images/icons/transaction.png') }}" alt="Transactions Icon"
                                        class="w-10 h-10">
                                </div>
                            </div>
                        </div>

                        <div class="p-6 rounded-2xl bg-gradient-to-br from-green-200 to-green-400 text-white shadow-md">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold">Students</h3>
                                    <p class="text-2xl font-bold">{{ $students }}</p>
                                </div>
                                <div class="p-3 bg-green-500 rounded-full">
                                    <img src="{{ asset('assets/images/icons/student.png') }}" alt="Students Icon"
                                        class="w-10 h-10">
                                </div>
                            </div>
                        </div>

                        <div class="p-6 rounded-2xl bg-gradient-to-br from-purple-200 to-purple-400 text-white shadow-md">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold">Teachers</h3>
                                    <p class="text-2xl font-bold">{{ $teachers }}</p>
                                </div>
                                <div class="p-3 bg-purple-500 rounded-full">
                                    <img src="{{ asset('assets/images/icons/teacher.png') }}" alt="Teachers Icon"
                                        class="w-10 h-10">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Section -->
                    <div class="grid [grid-template-columns:2.5fr_1fr] gap-x-4">
                        <div class="p-6 bg-white rounded-lg shadow-lg">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-lg font-bold text-gray-700">Transactions</h4>
                            </div>
                            <div id="profit" data-transactions="{{ json_encode($transactionData) }}" class="h-72">
                            </div>
                        </div>
                        <div class="p-6 bg-white rounded-lg shadow-lg">
                            {{-- list latest transactions --}}
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-lg font-bold text-gray-700">Latest Transactions</h4>
                            </div>

                            <div class="flex flex-col gap-y-4">
                                @foreach ($latestTransactions as $transaction)
                                    @if ($transaction->user->hasActiveSubscription())
                                        <div class="flex gap-x-4 items-center border-b border-gray-300 pb-2">
                                            <div class="flex-shrink-0">
                                                <img src="{{ Storage::url($transaction->user->avatar) }}" alt=""
                                                    class="w-12 h-12 rounded-full">
                                            </div>
                                            <div class="flex-1 text-sm">
                                                <p class="text-xl font-bold text-[#5628c2]">
                                                    {{ $transaction->user->name }}
                                                </p>
                                                <p class="text-orange-500 text-sm">
                                                    {{ $transaction->package->tipe }} Subscriptions
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-10 p-6 bg-white rounded-lg shadow-lg">
                        <h3 class="text-xl font-bold text-indigo-950 mb-4">Balance Tracking</h3>
                        <div id="balance-chart" data-balance="{{ json_encode($balancePerMonth) }}"></div>
                    </div>

                    <div class="py-2">
                        <div class="max-w-7xl mx-auto">
                            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-8">
                                <h3 class="text-lg font-semibold mb-6">Top Performers Teacher</h3>
                                <table class="table-auto w-full">
                                    <thead>
                                        <tr class="border-b border-gray-200">
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">#</th>
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Email</th>
                                            <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Total
                                                Courses</th>
                                            <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Total
                                                Viewers</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach ($topPerformingTeachers as $index => $teacher)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-4 text-sm text-gray-700">{{ $index + 1 }}</td>
                                                <td class="px-4 py-4 flex items-center gap-4">
                                                    <img src="{{ Storage::url($teacher['teacher_avatar']) }}"
                                                        alt="Thumbnail" class="w-12 h-12 rounded-full object-cover">
                                                    <span
                                                        class="text-gray-900 font-medium">{{ $teacher['teacher_name'] }}</span>
                                                </td>
                                                <td class="px-4 py-4 text-sm text-gray-700">{{ $teacher['teacher_email'] }}
                                                </td>
                                                <td class="px-4 py-4 text-center text-sm text-gray-700">
                                                    {{ $teacher['total_courses'] }}</td>
                                                <td class="px-4 py-4 text-center text-sm text-gray-700">
                                                    {{ $teacher['total_viewers'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endrole

            @role('teacher')
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Balance -->
                    <div class="p-6 rounded-2xl bg-gradient-to-br from-orange-200 to-orange-400 text-white shadow-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold">Balance</h3>
                                <p class="text-2xl font-bold">Rp{{ number_format($balance, 0, ',', '.') }}</p>
                            </div>
                            <div class="p-3 bg-orange-500 rounded-full">
                                <img src="{{ asset('assets/images/icons/balance.png') }}" alt="Balance Icon"
                                    class="w-10 h-10">
                            </div>
                        </div>
                    </div>

                    <!-- Total Viewers -->
                    <div class="p-6 rounded-2xl bg-gradient-to-br from-blue-200 to-blue-400 text-white shadow-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold">Total Viewers</h3>
                                <p class="text-2xl font-bold">{{ $totalViewers }}</p>
                            </div>
                            <div class="p-3 bg-blue-500 rounded-full">
                                <img src="{{ asset('assets/images/icons/viewers.png') }}" alt="Viewers Icon"
                                    class="w-10 h-10">
                            </div>
                        </div>
                    </div>

                    <!-- Total Courses -->
                    <div class="p-6 rounded-2xl bg-gradient-to-br from-green-200 to-green-400 text-white shadow-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold">Total Courses</h3>
                                <p class="text-2xl font-bold">{{ $totalCourses }}</p>
                            </div>
                            <div class="p-3 bg-green-500 rounded-full">
                                <img src="{{ asset('assets/images/icons/courses.png') }}" alt="Courses Icon"
                                    class="w-10 h-10">
                            </div>
                        </div>
                    </div>

                    <!-- Total Students -->
                    <div class="p-6 rounded-2xl bg-gradient-to-br from-purple-200 to-purple-400 text-white shadow-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold">Total Students</h3>
                                <p class="text-2xl font-bold">{{ $students }}</p>
                            </div>
                            <div class="p-3 bg-purple-500 rounded-full">
                                <img src="{{ asset('assets/images/icons/student.png') }}" alt="Students Icon"
                                    class="w-10 h-10">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-lg font-bold mb-4">Total Viewers (6 Bulan Terakhir)</h2>
                    <div id="viewersChart" data-viewers='@json($totalViewersPerMonth)'></div>
                </div>

                <div class="mt-4 py-2">
                    <div class="max-w-7xl mx-auto">
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg p-8">
                            <h3 class="text-lg font-semibold mb-6">Top Performers Teacher</h3>
                            <table class="table-auto w-full">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">#</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Email</th>
                                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Total
                                            Courses</th>
                                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Total
                                            Viewers</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($topPerformingTeachers as $index => $teacher)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-4 text-sm text-gray-700">{{ $index + 1 }}</td>
                                            <td class="px-4 py-4 flex items-center gap-4">
                                                <img src="{{ Storage::url($teacher['teacher_avatar']) }}" alt="Thumbnail"
                                                    class="w-12 h-12 rounded-full object-cover">
                                                <span
                                                    class="text-gray-900 font-medium">{{ $teacher['teacher_name'] }}</span>
                                            </td>
                                            <td class="px-4 py-4 text-sm text-gray-700">{{ $teacher['teacher_email'] }}
                                            </td>
                                            <td class="px-4 py-4 text-center text-sm text-gray-700">
                                                {{ $teacher['total_courses'] }}</td>
                                            <td class="px-4 py-4 text-center text-sm text-gray-700">
                                                {{ $teacher['total_viewers'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endrole
        </div>
    </div>
</x-app-layout>

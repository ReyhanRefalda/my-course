@extends('../layouts.master')

@section('content')

    <body class="text-black font-poppins pt-12 pb-10 bg-gray-100">
        <!-- Hero Section -->
        <div id="hero-section"
            class="max-w-[1200px] mx-auto w-full flex flex-col gap-12 bg-[url('{{ asset('assets/background/Hero-Banner.png') }}')] bg-center bg-no-repeat bg-cover rounded-[32px] overflow-hidden shadow-lg">
            <x-navcat />
        </div>

        <!-- Notification Container -->
        <div class="container max-w-3xl mx-auto p-6 bg-white rounded-2xl shadow-lg mt-10">
            <h2 class="font-semibold text-3xl mb-6 text-[#3525B3] text-center">
                <i class="fas fa-bell text-[#3525B3]"></i> Notifications
            </h2>

            <!-- No Notifications Message -->
            @if ($notifications->isEmpty())
                <div class="text-center py-8">
                    <i class="fas fa-inbox text-gray-400 text-5xl"></i>
                    <p class="text-gray-500 text-lg mt-3">You have no new notifications.</p>
                </div>
            @else
                <div
                    class="space-y-4 max-h-[500px] overflow-y-auto px-2 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                    <!-- Loop Through Notifications -->
                    @foreach ($notifications as $notification)
                        <div
                            class="relative flex flex-col gap-2 p-5 border-l-8 
                        @if ($notification->read_at) border-gray-300 bg-gray-50 
                        @else border-[#FF6129] bg-[#FFF3E0] @endif 
                        rounded-lg shadow-md transition-all duration-300 hover:shadow-xl hover:scale-[1.02]">

                            <!-- Status Icon & Message -->
                            <div class="flex items-start gap-4">
                                <div
                                    class="text-2xl 
                                @if ($notification->read_at) text-gray-400 
                                @else text-[#FF6129] @endif">
                                    @if ($notification->read_at)
                                        <i class="fas fa-check-circle"></i> <!-- Read -->
                                    @else
                                        <i class="fas fa-bell"></i> <!-- Unread -->
                                    @endif
                                </div>

                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900 text-lg">
                                        <i class="fas fa-info-circle text-[#3525B3]"></i>
                                        {{ $notification->data['message'] }}
                                    </p>

                                    <!-- Display Reason if Rejected -->
                                    @if (isset($notification->data['status']) && $notification->data['status'] === 'rejected')
                                        <p class="text-red-500 text-sm mt-1">
                                            <i class="fas fa-times-circle"></i> Rejected:
                                            {{ $notification->data['reason'] }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Footer: Timestamp & Mark as Read -->
                            <div class="flex justify-between items-center mt-2 text-sm text-gray-500">
                                <span>
                                    <i class="fas fa-clock"></i> {{ $notification->created_at->diffForHumans() }}
                                </span>

                                @if (!$notification->read_at)
                                    <a href="{{ route('notifications.markAsRead', $notification->id) }}"
                                        class="text-[#3525B3] font-semibold hover:underline flex items-center gap-1">
                                        <i class="fas fa-check"></i> Mark as Read
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex justify-center">
                    {{ $notifications->links() }}
                </div>
            @endif

            <!-- Back Button -->
            <!-- Back Button -->
            <div class="mt-6 flex justify-center">
                <a href="{{ route('front.index') }}"
                    class="p-[14px_28px] bg-[#FF6129] text-white rounded-full font-semibold text-lg transition-all duration-300 hover:bg-[#E55320] flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>

        </div>
    </body>
@endsection

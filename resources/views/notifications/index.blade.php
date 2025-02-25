<x-user>
    <div class="container max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-lg">
        <h2 class="font-semibold text-2xl mb-6 text-gray-800">📩 Notifications</h2>

        @if ($notifications->isEmpty())
            <div class="text-center py-6">
                <p class="text-gray-500 text-lg">No notifications found.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($notifications as $notification)
                    <div class="p-4 border border-gray-300 rounded-lg flex justify-between items-start bg-gray-50 hover:bg-gray-100 transition">
                        <div>
                            <p class="font-medium text-gray-800">{{ $notification->data['message'] }}</p>
                            <span class="text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="text-sm px-3 py-1 rounded-full 
                                @if ($notification->read_at) bg-green-100 text-green-700 @else bg-red-100 text-red-700 @endif">
                                @if ($notification->read_at)
                                    ✅ Read
                                @else
                                    🔴 Unread
                                @endif
                            </span>
                            @if (!$notification->read_at)
                                <a href="{{ route('notifications.markAsRead', $notification->id) }}" 
                                    class="mt-2 text-blue-600 text-sm font-semibold hover:underline">
                                    Mark as Read
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-user>

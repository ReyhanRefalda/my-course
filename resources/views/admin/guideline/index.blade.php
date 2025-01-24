<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('How to Add a Video to Your Online Course') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto bg-white shadow-sm rounded-lg p-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Guide to Adding a Video to Your Online Course</h1>

            <ol class="list-decimal list-inside text-gray-800 space-y-4">
                <li>
                    <span class="font-semibold">Upload Your Video to YouTube:</span> Log in to your YouTube account, click the "Create" button (camera icon with a "+" sign) on the top-right corner, and select "Upload video." Choose your video file and complete the upload process by filling out the required details (title, description, etc.).
                </li>

                <li>
                    <span class="font-semibold">Copy the Unique Code from the YouTube URL:</span> Once your video is uploaded, go to the video on YouTube and copy the unique code from the URL. For example, if your video URL is <code>https://www.youtube.com/watch?v=abc123xyz</code>, the unique code is <code>abc123xyz</code>.
                </li>

                <li>
                    <span class="font-semibold">Navigate to the Create Course Page:</span> Log in to your online course platform and go to the "Create Course" page. You should see a field to add a video.
                </li>

                <li>
                    <span class="font-semibold">Paste the Unique Code:</span> In the "Video URL" or "Video Code" field, paste the unique code you copied from the YouTube URL.
                </li>

                <li>
                    <span class="font-semibold">Save Your Course:</span> After pasting the code, complete any other required fields on the form (e.g., course title, description) and click the "Save" or "Publish" button to finalize the process.
                </li>
            </ol>

            <p class="mt-6 text-gray-700">
                By using YouTube to host your videos, you ensure fast playback for students and reduce server load on your platform. For further assistance, visit the <a href="https://support.google.com/youtube/" target="_blank" class="text-blue-600 hover:underline">YouTube Help Center</a> or consult your course platform's documentation.
            </p>
        </div>
    </div>
</x-app-layout>

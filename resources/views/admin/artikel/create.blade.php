<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Artikel') }}
            </h2>
        </div>
    </x-slot>
    <div class="min-h-screen bg-gray-100 w-full">
        <div class="bg-white rounded-[30px] shadow-xl w-full p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Add Article</h2>
            <p class="text-sm text-gray-500 mb-6">Fill in all the required columns</p>

            <form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-6 w-full">
                @csrf

                <!-- Judul -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none"
                        placeholder="Article Title">
                    <x-input-error :messages="$errors->get('title')" />
                </div>

                <div>
                    <label for="tumbnail" class="block text-sm font-medium text-gray-700 mb-1">Thumbnail</label>
                    <input type="file" name="tumbnail" id="tumbnail"
                        class="w-full border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-purple-500"
                        onchange="previewImage(event)">
                    <x-input-error :messages="$errors->get('tumbnail')" />
                </div>

                <!-- Isi Artikel -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Isi Artikel</label>
                    <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                    <trix-editor input="content"
                        class="trix-content border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-purple-500 min-h-[200px]"></trix-editor>
                    <x-input-error :messages="$errors->get('content')" />
                </div>

                <!-- Status dan Thumbnail -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-purple-500">
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="publish" {{ old('status') == 'publish' ? 'selected' : '' }}>Publish</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" />
                </div>

                <!-- Tombol Simpan -->
                <div class="text-right flex justify-end gap-x-2">
                    <a href="{{ route('admin.artikel.index') }}"
                        class="px-6 py-2 bg-gray-600 text-white font-semibold rounded-[30px] shadow hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-purple-600 text-white font-semibold rounded-[30px] shadow hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>

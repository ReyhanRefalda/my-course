<x-app-layout>
    <x-slot name="navbarLink">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Artikel') }}
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-100 w-full">
        <div class="bg-white rounded-[30px] shadow-xl w-full p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Edit Article</h2>
            <p class="text-sm text-gray-500 mb-6">Update the necessary fields</p>

            <form action="{{ route('admin.artikel.update', $artikel->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 w-full">
                @csrf
                @method('PUT')

                <!-- Judul -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $artikel->title) }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:outline-none"
                        placeholder="Article Title">
                    <x-input-error :messages="$errors->get('title')" />
                </div>

                <!-- Thumbnail -->
                <div>
                    <label for="tumbnail" class="block text-sm font-medium text-gray-700 mb-1">Thumbnail</label>
                    <input type="file" name="tumbnail" id="tumbnail"
                        class="w-full border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-purple-500"
                        onchange="previewImage(event)">
                    <x-input-error :messages="$errors->get('tumbnail')" />
                    @if ($artikel->tumbnail)
                        <img src="{{ asset(getenv('CUSTOM_TUMBNAIL_LOCATION') . '/' . $artikel->tumbnail) }}"
                            alt="Thumbnail" class="mt-4 h-20 w-36 object-cover rounded-lg">
                    @endif
                </div>

                <!-- Isi Artikel -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Isi Artikel</label>
                    <input id="content" type="hidden" name="content" value="{!! old('content', $artikel->content) !!}">
                    <trix-editor input="content"
                        class="trix-content border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-purple-500 min-h-[150px]"></trix-editor>
                    <x-input-error :messages="$errors->get('content')" />
                </div>

                <!-- Kategori -->
                <div>
                    <label for="kategoriart" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="kategoriart[]" id="kategoriart"
                        class="select2 form-control select2-bootstrap-5 shadow-sm w-full" multiple>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ in_array($category->id, old('kategoriarts', $artikel->kategoriarts->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('kategoriart')" />
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-purple-500">
                        <option value="draft" {{ old('status', $artikel->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="publish" {{ old('status', $artikel->status) == 'publish' ? 'selected' : '' }}>Publish</option>
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
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

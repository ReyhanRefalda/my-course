<x-app-layout>
    <div class="min-h-screen p-6 bg-gray-100 flex items-center justify-center">
        <div class="container max-w-screen-lg mx-auto">
            <h2 class="font-semibold text-xl text-gray-600">Edit Artikel</h2>
            <p class="text-gray-500 mb-6">Silakan perbarui data artikel di bawah ini.</p>

            <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                <form action="{{ route('admin.artikel.update', $artikel->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Detail Artikel</p>
                            <p>Perbarui kolom yang diperlukan.</p>
                        </div>

                        <div class="lg:col-span-2">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <label for="title" class="font-medium">Judul</label>
                                    <input type="text" name="title" id="title"
                                        value="{{ old('title', $artikel->title) }}"
                                        class="h-10 border mt-1 rounded px-4 w-full bg-gray-50">
                                    <x-input-error :messages="$errors->get('title')" />
                                </div>

                                <div class="md:col-span-2">
                                    <label for="content" class="font-medium">Isi Artikel</label>
                                    <input id="content" type="hidden" name="content"
                                        value="{{ old('content', $artikel->content) }}">
                                    <trix-editor input="content"
                                        class="trix-content border-gray-300 rounded-lg shadow-sm min-h-80">{!! old('content', $artikel->content) !!}</trix-editor>
                                    <x-input-error :messages="$errors->get('content')" />
                                </div>

                                <div class="md:col-span-1">
                                    <label for="status" class="font-medium">Status</label>
                                    <select name="status" id="status"
                                        class="h-10 border mt-1 rounded px-4 w-full bg-gray-50">
                                        <option value="draft"
                                            {{ old('status', $artikel->status) == 'draft' ? 'selected' : '' }}>Draft
                                        </option>
                                        <option value="publish"
                                            {{ old('status', $artikel->status) == 'publish' ? 'selected' : '' }}>Publish
                                        </option>
                                    </select>
                                    <x-input-error :messages="$errors->get('status')" />
                                </div>

                                <div class="md:col-span-1">
                                    <label for="tumbnail" class="font-medium">Thumbnail</label>
                                    <input type="file" name="tumbnail" id="tumbnail"
                                        class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                        onchange="previewImage(event)">
                                    <x-input-error :messages="$errors->get('tumbnail')" />
                                    @if ($artikel->tumbnail)
                                        <img src="{{ asset(getenv('CUSTOM_TUMBNAIL_LOCATION') . '/' . $artikel->tumbnail) }}""
                                            alt="Thumbnail" class="mt-2 h-20 w-36 object-cover rounded-lg">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-right">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>

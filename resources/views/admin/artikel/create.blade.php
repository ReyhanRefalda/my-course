<x-app-layout>
    <div class="min-h-screen p-6 bg-gray-100 flex items-center justify-center">
        <div class="container max-w-screen-lg mx-auto">
            <h2 class="font-semibold text-xl text-gray-600">Tambah Artikel</h2>
            <p class="text-gray-500 mb-6">Silakan lengkapi form di bawah ini.</p>

            <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                <form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Detail Artikel</p>
                            <p>Isi semua kolom yang diperlukan.</p>
                        </div>

                        <div class="lg:col-span-2">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <label for="title" class="font-medium">Judul</label>
                                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                                        class="h-10 border mt-1 rounded px-4 w-full bg-gray-50">
                                    <x-input-error :messages="$errors->get('title')" />
                                </div>

                                <div class="md:col-span-2">
                                    <label for="content" class="font-medium">Isi Artikel</label>
                                    <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                                    <trix-editor input="content"
                                        class="trix-content border-gray-300 rounded-lg shadow-sm min-h-80"></trix-editor>
                                    <x-input-error :messages="$errors->get('content')" />
                                </div>

                                <div class="md:col-span-1">
                                    <label for="status" class="font-medium">Status</label>
                                    <select name="status" id="status"
                                        class="h-10 border mt-1 rounded px-4 w-full bg-gray-50">
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft
                                        </option>
                                        <option value="publish" {{ old('status') == 'publish' ? 'selected' : '' }}>
                                            Publish</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('status')" />
                                </div>

                                <div class="md:col-span-1">
                                    <label for="tumbnail" class="font-medium">Thumbnail</label>
                                    <input type="file" name="tumbnail" id="tumbnail"
                                        class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                        onchange="previewImage(event)">
                                    <x-input-error :messages="$errors->get('tumbnail')" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-right">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="navbarLink">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg">

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="py-3 w-full rounded-3xl bg-red-500 text-white">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif

                <form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name', $course->name)" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="thumbnail" :value="__('Thumbnail')" />
                        <img src="{{ Storage::url($course->thumbnail) }}" alt=""
                            class="rounded-2xl object-cover w-[120px] h-[90px]">
                        <x-text-input id="thumbnail" class="block mt-1 w-full" type="file" name="thumbnail" autofocus
                            autocomplete="thumbnail" />
                        <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="path_trailer" :value="__('Path Trailer')" />
                        <x-text-input id="path_trailer" class="block mt-1 w-full" type="text" name="path_trailer"
                            :value="old('path_trailer', $course->path_trailer)" required autofocus autocomplete="path_trailer" />
                        <x-input-error :messages="$errors->get('path_trailer')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="resource" :value="__('Path Resource')" />
                        <x-text-input id="resource" class="block mt-1 w-full" type="text" name="resource"
                            :value="old('resource', $course->resource)" required autofocus autocomplete="resource" />
                        <x-input-error :messages="$errors->get('resource')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="category_ids" :value="__('Categories')" />
                        <select name="category_ids[]" id="category_ids"
                            class="select2 form-control select2-bootstrap-5 shadow-sm w-full" multiple>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ in_array($category->id, old('category_ids', $course->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_ids')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="about" :value="__('About')" />
                        <!-- Hidden Input with Old or Existing Value -->
                        <input id="about" type="hidden" name="about" value="{!! old('about', $course->about) !!}">
                        <!-- Trix Editor -->
                        <trix-editor input="about"
                            class="trix-content border border-slate-300 rounded-xl shadow-sm focus:ring-2 focus:ring-purple-500 min-h-[150px]"></trix-editor>
                        <x-input-error :messages="$errors->get('about')" class="mt-2" />
                    </div>

                    <hr class="my-5">

                    <div class="mt-4">
                        <div class="flex flex-col gap-y-5">
                            <x-input-label for="keypoints" :value="__('Keypoints')" />

                            @foreach ($course->course_keypoints as $index => $keypoint)
                                <input type="text" class="py-3 rounded-lg border-slate-300 border"
                                    placeholder="Write your keypoint" name="course_keypoints[{{ $index }}]"
                                    value="{{ old('course_keypoints.' . $index, $keypoint->name) }}">
                            @endforeach
                        </div>

                        <x-input-error :messages="$errors->get('course_keypoints')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                            Update Course
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.select2').select2();
            });
        </script>
    @endpush

</x-app-layout>

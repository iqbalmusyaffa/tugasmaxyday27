<!-- create.blade.php or edit.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{-- Use 'Edit' for edit mode and create for non-edit/create mode --}}
            {{ isset($post) ? 'Edit' : 'Create' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- don't forget to add multipart/form-data so we can accept file in our form --}}
                    <form method="post" action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        {{-- add @method('put') for edit mode --}}
                        @isset($post)
                            @method('put')
                        @endisset

                        <div>
                            <x-input-label for="title" value="Title" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="$post->title ?? old('title')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>
                        <div>
                            <x-input-label for="category" value="Category" />
                            <select id="category" name="category[]" multiple class="mt-1 block w-full">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if(isset($post) && $post->categories->contains($category->id)) selected @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('category')" />
                        </div>
                        <div>
                            <x-input-label for="tags" value="Tags" />
                            @foreach($tags as $tag)
                                <label class="inline-flex items-center mt-2">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" @if(isset($post) && $post->tags->contains($tag->id)) checked @endif class="form-checkbox h-5 w-5 text-indigo-600"><span class="ml-2 text-gray-700">{{ $tag->name }}</span>
                                </label>
                            @endforeach
                            <x-input-error class="mt-2" :messages="$errors->get('tags')" />
                        </div>

                        <div>
                            <x-input-label for="content" value="Content" />
                            {{-- use textarea-input component that we will create after this --}}
                            <x-textarea-input id="content" name="content" class="mt-1 block w-full" required autofocus>{{ $post->content ?? old('content') }}</x-textarea-input>
                            <x-input-error class="mt-2" :messages="$errors->get('content')" />
                        </div>

                        <div>
                            <x-input-label for="featured_image" value="Featured Image" />
                            <label class="block mt-2">
                                <span class="sr-only">Choose image</span>
                                <input type="file" id="featured_image" name="featured_image" class="block w-full text-sm text-slate-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-violet-50 file:text-violet-700
                                    hover:file:bg-violet-100
                                "/>
                            </label>
                            <div class="shrink-0 my-2">
                                <img id="featured_image_preview" class="h-64 w-128 object-cover rounded-md" src="{{ isset($post) ? Storage::url($post->featured_image) : '' }}" alt="Featured image preview" />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('featured_image')" />
                        </div>

                        <div>
                            <x-input-label for="comment" value="Add Comment" />
                            <textarea id="comment" name="comment" class="mt-1 block w-full" rows="3"></textarea>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button type="submit">{{ __('Save') }}</x-primary-button>
                            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md">{{ __('Add Comment') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // create onchange event listener for featured_image input
        document.getElementById('featured_image').onchange = function(evt) {
            const [file] = this.files
            if (file) {
                // if there is an image, create a preview in featured_image_preview
                document.getElementById('featured_image_preview').src = URL.createObjectURL(file)
            }
        }
    </script>
</x-app-layout>

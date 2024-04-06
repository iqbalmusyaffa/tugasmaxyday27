<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Show') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Title') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $post->title }}
                        </p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Content') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $post->content }}
                        </p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Featured Image') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            <img class="h-64 w-128" src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" srcset="">
                        </p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Categories') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            @foreach($post->categories as $category)
                                {{ $category->name }}{{ $loop->last ? '' : ', ' }}
                            @endforeach
                        </p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Tags') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            @foreach($post->tags as $tag)
                                {{ $tag->name }}{{ $loop->last ? '' : ', ' }}
                            @endforeach
                        </p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Comments') }}
                        </h2>
                        <ul>
                            @foreach($post->comments as $comment)
                                <li>{{ $comment->content }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Created At') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $post->created_at }}
                        </p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Updated At') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $post->updated_at }}
                        </p>
                    </div>
                    <a href="{{ route('posts.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">{{ __('BACK') }}</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

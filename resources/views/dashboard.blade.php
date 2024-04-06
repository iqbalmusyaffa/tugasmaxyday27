<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-bold mb-2">Latest Blog Posts</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($posts as $post)
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $post->title }}</h3>
                    <p class="text-gray-600">{{ $post->created_at->format('M d, Y') }}</p>
                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="mt-2 w-50 h-50">
                    <p class="mt-2 text-gray-700">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 100) }}</p>
                    <a href="{{ route('posts.show', $post->id) }}" class="text-blue-500 hover:text-blue-700">Read more</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</x-app-layout>

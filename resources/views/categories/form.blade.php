<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{-- Use 'Edit' for edit mode and 'Create' for non-edit/create mode --}}
            {{ isset($category) ? 'Edit' : 'Create' }} Category
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Don't forget to add multipart/form-data so we can accept file in our form --}}
                    <form method="post" action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        {{-- Add @method('put') for edit mode --}}
                        @isset($category)
                            @method('put')
                        @endisset

                        <div>
                            <x-input-label for="name" value="Category Name" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="$category->name ?? old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

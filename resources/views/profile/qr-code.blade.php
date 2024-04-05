<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Two-Factor Authentication') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Scan this QR code with your authenticator app</h3>
                <div class="flex justify-center">
                    <img src="{{ $qrCodeUrl }}" alt="QR Code">
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

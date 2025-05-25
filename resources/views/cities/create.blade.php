<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <i class="fas fa-city text-2xl text-indigo-600 dark:text-indigo-400"></i>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100">
                {{ __('Crear Ciudad') }}
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen py-12 bg-gray-50 dark:bg-gray-900 transition-colors">
        <div class="max-w-lg mx-auto bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-lg p-8 rounded-2xl">
            <!-- Sin pasar $city, se asumirá create en la directiva de php -->
            @include('cities._form')
        </div>
    </div>
</x-app-layout>

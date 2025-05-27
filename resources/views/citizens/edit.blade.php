<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <i class="fas fa-user-edit text-2xl text-indigo-600 dark:text-indigo-400"></i>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100">
                {{ __('Edit Citizen') }}
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen py-12 bg-gray-50 dark:bg-gray-900 transition-colors">
        <div class="max-w-lg mx-auto bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-lg p-8 rounded-2xl">
            <!-- Se pasan ambos $citizen (para permitir su edición) y $cities -->
            @include('citizens._form', ['citizen' => $citizen,'cities'  => $cities])
        </div>
    </div>
</x-app-layout>
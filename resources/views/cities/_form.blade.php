<!--
    Este formulario es utilizado tanto para crear como para editar una ciudad.
    La variable $isEdit se utiliza para determinar si estamos en el modo de edición o creación.
    Si $isEdit es verdadero, se mostrará el formulario de edición, de lo contrario, se mostrará el formulario de creación.
-->
@php
    $isEdit = isset($city);  // Aquí se detecta si se está en la vista de edit (es decir, si nos pasan $city)
@endphp

<form action="{{ $isEdit ? route('cities.update', $city->id) : route('cities.store') }}" method="POST" class="space-y-6" novalidate>
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <!-- Campo de nombre de ciudad -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
            {{ __('Nombre de la Ciudad') }}
        </label>
        <input type="text" name="name" id="name" value="{{ old('name', $city->name ?? '') }}" placeholder="e.g.: Managua" class="block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700  border border-gray-300 dark:border-gray-600  rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"/>
        @error('name')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>

    <!-- Campo de descripción de ciudad -->
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
            {{ __('Descripción') }}
        </label>
        <textarea name="description" id="description" rows="4" placeholder="Describe la ciudad..." class="block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition resize-none">{{ old('description', $city->description ?? '') }}</textarea>
        @error('description')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>

    <!-- Botón de enviar/cancelar -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
        <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-all">
            <i class="fas {{ $isEdit ? 'fa-rotate' : 'fa-user-plus' }}"></i>
            {{ $isEdit ? __('Actualizar Ciudad') : __('Crear Ciudad') }}
        </button>
        <a href="{{ route('cities.index') }}" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
            <i class="fas fa-arrow-left"></i>
            {{ __('Cancelar') }}
        </a>
    </div>
</form>

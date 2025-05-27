<!--
    Este formulario es utilizado tanto para crear como para editar un ciudadano.
    La variable $isEdit se utiliza para determinar si estamos en el modo de edición o creación.
    Si $isEdit es verdadero, se mostrará el formulario de edición, de lo contrario, se mostrará el formulario de creación.
-->
@php
    $isEdit = isset($citizen);  // Aquí se detecta si se está en la vista de edit (es decir, si nos pasan $citizen)
@endphp

<form action="{{ $isEdit ? route('citizens.update', $citizen->id) : route('citizens.store') }}" method="POST" class="space-y-6" novalidate>
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <!-- Campo de nombres del ciudadano -->
    <div>
        <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
            {{ __('Nombres') }}
        </label>
        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $citizen->first_name ?? '') }}" placeholder="e.g. Juan" class="block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"/>
        @error('first_name')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Campo de apellidos del ciudadano -->
    <div>
        <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
            {{ __('Apellidos') }}
        </label>
        <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $citizen->last_name ?? '') }}" placeholder="e.g. Pérez" class="block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"/>
        @error('last_name')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Campo de fecha de nacimiento del ciudadano -->
    <div>
        <label for="birth_date" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
            {{ __('Fecha de nacimiento') }}
        </label>
        <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $citizen->birth_date ?? '') }}" class="block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition filter [&::-webkit-calendar-picker-indicator]:invert"/>
        @error('birth_date')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>
    <!-- Campo de ciudad del ciudadano -->
    <div>
        <label for="city_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
            {{ __('Ciudad') }}
        </label>
        <select name="city_id" id="city_id" class="block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
            <option value="">{{ __('Seleccione una ciudad') }}</option>
            @foreach($cities as $city)
                <option value="{{ $city->id }}" {{ old('city_id', $citizen->city_id ?? '') == $city->id ? 'selected' : '' }}>
                    {{ $city->name }}
                </option>
            @endforeach
        </select>
        @error('city_id')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Campo de dirección del ciudadano -->
    <div>
        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
            {{ __('Dirección') }}
        </label>
        <input type="text" name="address" id="address" value="{{ old('address', $citizen->address ?? '') }}" placeholder="Ejemplo: Calle 123" class="block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"/>
        @error('address')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Campo de teléfono del ciudadano -->
    <div>
        <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
            {{ __('Número de teléfono') }}
        </label>
        <input type="text"
            name="phone_number"
            id="phone_number"
            value="{{ old('phone_number', $citizen->phone_number ?? '') }}"
            placeholder="Ejemplo: +505 1234-5678"
            class="block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" />
        @error('phone_number')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Botón de enviar/cancelar -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
        <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-all">
            <i class="fas {{ $isEdit ? 'fa-rotate' : 'fa-user-plus' }}"></i>
            {{ $isEdit ? __('Actualizar Ciudadano') : __('Crear Ciudadano') }}
        </button>
        <a href="{{ route('citizens.index') }}" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
            <i class="fas fa-arrow-left"></i>
            {{ __('Cancelar') }}
        </a>
    </div>
</form>

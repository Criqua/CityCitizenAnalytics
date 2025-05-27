<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fas fa-users text-2xl text-indigo-600 dark:text-indigo-400"></i>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100">
                    {{ __('Ciudadanos') }}
                </h2>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('citizens.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white font-semibold rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition">
                    <i class="fas fa-plus"></i>
                    {{ __('Crear Ciudadano') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen py-8 bg-gray-50 dark:bg-gray-900 transition-colors">
        <div class="max-w-4xl mx-auto px-4 space-y-6">
            
            {{-- Barra de búsqueda --}}
            <form method="GET" action="{{ route('citizens.index') }}" class="flex">
                <input
                    type="text"
                    name="search"
                    value="{{ old('search', $search) }}"
                    placeholder="Buscar ciudad o ciudadano…"
                    class="flex-grow px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 rounded-l focus:outline-none focus:ring-2 focus:ring-indigo-400 dark:focus:ring-indigo-600 transition-colors"
                />
                <button type="submit"
                        class="px-6 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-r focus:outline-none focus:ring-2 focus:ring-indigo-400 dark:focus:ring-indigo-600 transition">
                    {{ __('Buscar') }}
                </button>
            </form>

            {{-- Acordeón de ciudades --}}
            @forelse ($cities as $city)
                <details class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm hover:shadow-lg transition">
                    <summary
                        class="px-6 py-3 cursor-pointer flex justify-between items-center text-gray-800 dark:text-gray-100">
                        <span class="font-semibold">{{ $city->name }}</span>
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $city->citizens->count() }} ciudadano{{ $city->citizens->count() === 1 ? '' : 's' }}
                        </span>
                    </summary>
                    <div class="px-6 pb-4">
                        @if ($city->citizens->isEmpty())
                            <p class="text-gray-500 dark:text-gray-400">
                                — No hay ciudadanos en esta ciudad —
                            </p>
                        @else
                            <div class="overflow-x-auto mt-2">
                                <table class="min-w-full text-left">
                                    <thead class="bg-gray-100 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ __('Nombre') }}</th>
                                            <th class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ __('Edad') }}</th>
                                            <th class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ __('Dirección') }}</th>
                                            <th class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ __('Teléfono') }}</th>
                                            <th class="px-4 py-2 text-right text-gray-700 dark:text-gray-200">{{ __('Acciones') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($city->citizens as $citizen)
                                            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                                <td class="px-4 py-2 text-gray-800 dark:text-gray-100">
                                                    {{ $citizen->getFullName() }}
                                                </td>
                                                <td class="px-4 py-2 text-gray-800 dark:text-gray-100">
                                                    {{ $citizen->getAge() }}
                                                </td>
                                                <td class="px-4 py-2 text-gray-800 dark:text-gray-100">
                                                    {{ $citizen->address }}
                                                </td>
                                                <td class="px-4 py-2 text-gray-800 dark:text-gray-100">
                                                    {{ $citizen->phone_number ?? '—' }}
                                                </td>
                                                <td class="px-4 py-2 text-right">
                                                    <div class="flex flex-wrap gap-2 justify-end">
                                                        <a href="{{ route('citizens.edit', $citizen->id) }}"
                                                           class="inline-flex items-center gap-1 px-3 py-1 bg-indigo-100 hover:bg-indigo-200 dark:bg-indigo-700 dark:hover:bg-indigo-600 text-indigo-600 dark:text-indigo-200 font-medium rounded-lg transition">
                                                            <i class="fas fa-edit"></i>
                                                            {{ __('Editar') }}
                                                        </a>

                                                        <form action="{{ route('citizens.destroy', $citizen->id) }}" method="POST"
                                                              onsubmit="return confirm('¿Estás seguro de eliminar este ciudadano?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="inline-flex items-center gap-1 px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-900 transition">
                                                                <i class="fas fa-trash-alt"></i>
                                                                {{ __('Eliminar') }}
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </details>
            @empty
                <p class="text-center text-gray-500 dark:text-gray-400">
                    {{ __('No se encontraron ciudades.') }}
                </p>
            @endforelse

        </div>
    </div>
</x-app-layout>

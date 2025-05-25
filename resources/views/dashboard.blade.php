<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-chart-simple text-2xl text-indigo-600 dark:text-indigo-400"></i>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100">
                    {{ __('Dashboard') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 gap-6 py-8 px-4">
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-gray-100 dark:bg-gray-700 rounded-md">
                    <i class="fa-regular fa-map text-gray-600 dark:text-gray-300 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total de ciudades') }}</p>
                    <p class="mt-1 text-4xl md:text-4xl font-extrabold text-gray-900 dark:text-white">{{ number_format($totalCities) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-gray-100 dark:bg-gray-700 rounded-md">
                    <i class="fas fa-users text-gray-600 dark:text-gray-300 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total de ciudadanos') }}</p>
                    <p class="mt-1 text-4xl md:text-4xl font-extrabold text-gray-900 dark:text-white">{{ number_format($totalCitizens) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4">
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow p-6 col-span-1 sm:col-span-2 lg:col-span-3">
            <h3 class="text-lg font-semibold text-center text-gray-700 dark:text-gray-200 mb-4">
                {{ __('Ciudadanos por ciudad') }}
            </h3>
            <canvas id="citizensChart"></canvas>
        </div>
    </div>

@push('scripts')
    <script>
        const labels = @json($citizensPerCity->pluck('name'));
        const dataCounts = @json($citizensPerCity->pluck('citizens_count'));

        const config = {
            type: 'bar',
            data: {
            labels: labels,
            datasets: [{
                label: 'Ciudadanos',
                data: dataCounts,
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 2
            }]
            },
            options: {
                indexAxis: 'y', // El grafico se dibujará en horizontal
                elements: {
                    bar: {
                        borderWidth: 2,
                        borderRadius: 2
                    }
                },
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        };

        // Aquí se obtiene el contexto del canvas y se crea el gráfico
        const ctx = document.getElementById('citizensChart').getContext('2d');
        new Chart(ctx, config);
    </script>
@endpush
</x-app-layout>

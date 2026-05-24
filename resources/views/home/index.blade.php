@extends('layouts.theme')

@section('title', 'Dashboard | Sistema')

@section('section')
    <div class="container mx-auto px-4 py-6">
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
                    <p class="text-gray-600 mt-2">Bienvenido al panel de control del sistema</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-1"></i> {{ now()->format('d/m/Y H:i') }}
                    </span>
                </div>
            </div>
        </div>

        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('admin.home') }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <span class="ml-2 text-gray-500">Dashboard</span>
                </li>
            </ol>
        </nav>

        @if (session('flash'))
            <div
                class="bg-{{ session('flash')['icon'] == 'success' ? 'green' : (session('flash')['icon'] == 'warning' ? 'yellow' : 'red') }}-50 border-l-4 border-{{ session('flash')['icon'] == 'success' ? 'green' : (session('flash')['icon'] == 'warning' ? 'yellow' : 'red') }}-500 p-4 mb-6 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i
                            class="fas fa-{{ session('flash')['icon'] == 'success' ? 'check-circle' : (session('flash')['icon'] == 'warning' ? 'exclamation-triangle' : 'times-circle') }} text-{{ session('flash')['icon'] == 'success' ? 'green' : (session('flash')['icon'] == 'warning' ? 'yellow' : 'red') }}-400"></i>
                    </div>
                    <div class="ml-3">
                        <p
                            class="text-sm text-{{ session('flash')['icon'] == 'success' ? 'green' : (session('flash')['icon'] == 'warning' ? 'yellow' : 'red') }}-700 font-medium">
                            {{ session('flash')['title'] }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Facturas</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalFacturas ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-chart-line mr-1"></i>
                            {{ $invoicesGrowth ?? 0 }}% vs mes anterior
                        </p>
                    </div>
                    <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-invoice text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1"> Total Facturado</p>
                        <p class="text-3xl font-bold text-green-600">€ {{ number_format($totalAmount ?? 0, 2) }}</p>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-euro-sign mr-1"></i>
                            {{ $amountGrowth ?? 0 }}% vs mes anterior
                        </p>
                    </div>
                    <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Clientes Activos</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $activosCount ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-users mr-1"></i>
                            {{ $nuevosEsteMes ?? 0 }} nuevos este mes
                        </p>
                    </div>
                    <div class="h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-check text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Equipo Staff</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalStaff ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-user-tie mr-1"></i>
                            {{ $activeStaff ?? 0 }} activos
                        </p>
                    </div>
                    <div class="h-12 w-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users-cog text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Facturas Pendientes</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $pendientesCount ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-clock mr-1"></i>
                            € {{ number_format($pendientesAmount ?? 0, 2) }} por cobrar
                        </p>
                    </div>
                    <div class="h-12 w-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-hourglass-half text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Facturas Pagadas</p>
                        <p class="text-3xl font-bold text-green-600">{{ $pagadasCount ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-check-circle mr-1"></i>
                            {{ $conversionRate ?? 0 }}% del total
                        </p>
                    </div>
                    <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-handshake-angle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Facturas Anuladas</p>
                        <p class="text-3xl font-bold text-red-600">{{ $anuladasCount ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-ban mr-1"></i>
                            € {{ number_format(abs($anuladasAmount ?? 0), 2) }} anulados
                        </p>
                    </div>
                    <div class="h-12 w-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-ban text-red-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Tasa de Conversión</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $conversionRate ?? 0 }}%</p>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-percent mr-1"></i>
                            Facturas pagadas / total
                        </p>
                    </div>
                    <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-pie text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-chart-bar mr-2 text-blue-600"></i>
                        Facturación Mensual
                    </h2>
                </div>
                <div class="p-6">
                    <canvas id="monthlyChart" height="250"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-chart-pie mr-2 text-blue-600"></i>
                        Distribución de Facturas
                    </h2>
                </div>
                <div class="p-6">
                    <canvas id="statusChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <h2 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-history mr-2 text-blue-600"></i>
                        Últimas Facturas Emitidas
                    </h2>
                    <a href="{{ route('admin.facturacion.index') }}"
                        class="text-sm text-blue-600 hover:text-blue-800 mt-2 md:mt-0">
                        Ver todas <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#
                                Factura</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fecha</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentInvoices ?? [] as $invoice)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $invoice->number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $invoice->client->bussiness_name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($invoice->date)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-medium">
                                    € {{ number_format($invoice->total / 100, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $badgeClass = match ($invoice->status) {
                                            'Pendiente' => 'bg-yellow-100 text-yellow-800',
                                            'Pagada' => 'bg-green-100 text-green-800',
                                            'Anulada' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                        {{ $invoice->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-inbox text-3xl mb-2"></i>
                                    <p>No hay facturas registradas</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-trophy mr-2 text-yellow-600"></i>
                        Top Clientes por Facturación
                    </h2>
                </div>
                <div class="p-6">
                    @forelse($topClients ?? [] as $client)
                        <div class="mb-4 last:mb-0">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">{{ $client->bussiness_name }}</span>
                                <span class="text-sm font-semibold text-gray-900">€
                                    {{ number_format(($client->total_invoiced ?? 0) / 100, 2) }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $client->percentage ?? 0 }}%">
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4">No hay datos disponibles</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-user-friends mr-2 text-green-600"></i>
                        Últimos Miembros del Staff
                    </h2>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($recentStaff ?? [] as $staff)
                        <div class="p-4 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-500"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $staff->fullname }}
                                        {{ $staff->lastname }}</p>
                                    <p class="text-xs text-gray-500">
                                        <i class="fas fa-envelope mr-1"></i> {{ $staff->user->email ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>
                            <div>
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $staff->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $staff->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-500">
                            <i class="fas fa-users-slash text-3xl mb-2"></i>
                            <p>No hay miembros del staff registrados</p>
                        </div>
                    @endforelse
                </div>
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <a href="{{ route('admin.staff.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                        Ver todo el equipo <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .transition-shadow {
            transition: box-shadow 0.3s ease;
        }

        .hover\:shadow-md:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const monthlyCtx = document.getElementById('monthlyChart');
            if (monthlyCtx) {
                new Chart(monthlyCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($monthlyLabels ?? []),
                        datasets: [{
                            label: 'Facturación (€)',
                            data: @json($monthlyData ?? []),
                            backgroundColor: 'rgba(59, 130, 246, 0.5)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 2,
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return '€ ' + context.raw.toFixed(2);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return '€ ' + value;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            const statusCtx = document.getElementById('statusChart');
            if (statusCtx) {
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pagadas', 'Pendientes', 'Anuladas'],
                        datasets: [{
                            data: [
                                {{ $pagadasCount ?? 0 }},
                                {{ $pendientesCount ?? 0 }},
                                {{ $anuladasCount ?? 0 }}
                            ],
                            backgroundColor: [
                                'rgba(34, 197, 94, 0.7)',
                                'rgba(234, 179, 8, 0.7)',
                                'rgba(239, 68, 68, 0.7)'
                            ],
                            borderColor: [
                                'rgb(34, 197, 94)',
                                'rgb(234, 179, 8)',
                                'rgb(239, 68, 68)'
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const total = {{ $totalFacturas ?? 0 }};
                                        const percentage = total > 0 ? ((context.raw / total) * 100)
                                            .toFixed(1) : 0;
                                        return ${context.label}: ${context.raw} (${percentage}%);
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush
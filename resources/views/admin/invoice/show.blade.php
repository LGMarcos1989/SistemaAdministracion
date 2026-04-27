{{-- resources/views/admin/facturacion/show.blade.php --}}
@extends('layouts.theme')

@section('title', 'Facturación | Ver Factura #' . ($facturacion->invoice_number ?? ''))

@section('section')
    <div class="container mx-auto px-4 py-6">
        <!-- Header de la página -->
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Facturación</h1>
                    <p class="text-gray-600 mt-2">Detalles de la factura #{{ $facturacion->invoice_number ?? 'N/A' }}</p>
                </div>
                <div class="mt-4 md:mt-0 flex space-x-3 no-print">
                    <a href="{{ route('admin.facturacion.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 font-medium">
                        <i class="fas fa-arrow-left mr-2"></i> Volver
                    </a>
                    <a href="{{ route('admin.facturacion.edit', $facturacion->id) }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                        <i class="fas fa-edit mr-2"></i> Editar
                    </a>
                    <button onclick="window.print()"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">
                        <i class="fas fa-print mr-2"></i> Imprimir
                    </button>
                </div>
            </div>
        </div>

        <!-- Breadcrumb -->
        <nav class="mb-6 no-print">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('admin.home.index') }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <a href="{{ route('admin.facturacion.index') }}"
                        class="ml-2 text-blue-600 hover:text-blue-800">Facturas</a>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <span class="ml-2 text-gray-500">Factura #{{ $facturacion->invoice_number ?? 'N/A' }}</span>
                </li>
            </ol>
        </nav>

        <!-- Alertas -->
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Contenido Principal -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Columna Izquierda - Información de la Factura -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Tarjeta de Información General -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-file-invoice mr-2 text-blue-600"></i>
                            Información de la Factura
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Número de Factura</label>
                                    <div class="text-lg font-bold text-gray-900">{{ $facturacion->invoice_number ?? 'N/A' }}</div>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Emisión</label>
                                    <div class="text-gray-900">
                                        {{-- {{ $facturacion->date ? getFecha($facturacion->date) : 'N/A' }} --}}
                                        {{ $facturacion->invoice_date ? getFecha($facturacion->invoice_date) : 'N/A' }}
                                       
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                                    <div>
                                        @php
                                            $estadoClase = match ($facturacion->status) {
                                                'Pendiente' => 'bg-yellow-100 text-yellow-800',
                                                'Pagada' => 'bg-green-100 text-green-800',
                                                'Anulada' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-800',
                                            };
                                            $estadoIcono = match ($facturacion->status) {
                                                'Pendiente' => 'fa-hourglass-half',
                                                'Pagada' => 'fa-check-circle',
                                                'Anulada' => 'fa-ban',
                                                default => 'fa-question-circle',
                                            };
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $estadoClase }}">
                                            <i class="fas {{ $estadoIcono }} mr-2"></i>
                                            {{ $facturacion->status ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Total</label>
                                    <div class="text-2xl font-bold text-blue-600">
                                        {{ getMoney($facturacion->total) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($facturacion->description)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                                <div class="text-gray-900 bg-gray-50 p-3 rounded-lg">
                                    {{ $facturacion->description }}
                                </div>
                            </div>
                        @endif

                        @if ($facturacion->nota)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nota</label>
                                <div class="text-gray-900 bg-gray-50 p-3 rounded-lg">
                                    {{ $facturacion->nota }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Detalles de Cálculo -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-calculator mr-2 text-blue-600"></i>
                            Detalles de la Factura
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">Base Imponible:</span>
                                <span
                                    class="font-medium text-gray-900">${{ number_format($facturacion->tax_base / 100, 2) }}</span>
                            </div>

                            @if ($facturacion->type_rate_id)
                                <div class="flex justify-between py-2 border-b border-gray-100">
                                    <span class="text-gray-600">Tipo de Impuesto:</span>
                                    <span class="font-medium text-gray-900">
                                        {{ $facturacion->typeRate->name ?? 'N/A' }}
                                        ({{ $facturacion->typeRate->rate ?? 0 }}%)
                                    </span>
                                </div>

                                <div class="flex justify-between py-2 border-b border-gray-100">
                                    <span class="text-gray-600">Monto del Impuesto:</span>
                                    <span class="font-medium text-gray-900">
                                        ${{ number_format(($facturacion->tax_base / 100) * (($facturacion->typeRate->rate ?? 0) / 100), 2) }}
                                    </span>
                                </div>
                            @endif

                            <div class="flex justify-between py-2 pt-4 border-t-2 border-gray-200">
                                <span class="text-lg font-bold text-gray-800">Total:</span>
                                <span
                                    class="text-2xl font-bold text-blue-600">{{getMoney($facturacion->total) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha - Información Adicional -->
            <div class="space-y-6">
                <!-- Información del Cliente -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-user mr-2 text-blue-600"></i>
                            Cliente
                        </h2>
                    </div>
                    <div class="p-6">
                        @if ($facturacion->client)
                            <div class="mb-4">
                                <div class="text-lg font-semibold text-gray-900">{{ $facturacion->client->bussiness_name ?? 'N/A' }}
                                </div>
                                @if ($facturacion->client->email)
                                    <div class="text-sm text-gray-600 mt-1">
                                        <i class="fas fa-envelope mr-1"></i> {{ $facturacion->client->email }}
                                    </div>
                                @endif
                                @if ($facturacion->client->phone)
                                    <div class="text-sm text-gray-600 mt-1">
                                        <i class="fas fa-phone mr-1"></i> {{ $facturacion->client->phone }}
                                    </div>
                                @endif
                                @if ($facturacion->client->address)
                                    <div class="text-sm text-gray-600 mt-1">
                                        <i class="fas fa-map-marker-alt mr-1"></i> {{ $facturacion->client->address }}
                                    </div>
                                @endif
                                @if ($facturacion->client->document)
                                    <div class="text-sm text-gray-600 mt-1">
                                        <i class="fas fa-id-card mr-1"></i> {{ $facturacion->client->document }}
                                    </div>
                                @endif
                            </div>
                            <div class="pt-4 border-t border-gray-200 no-print">
                                <a href="{{ route('admin.clientes.show', $facturacion->client->id) }}"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <i class="fas fa-arrow-right mr-1"></i> Ver detalles del cliente
                                </a>
                            </div>
                        @else
                            <div class="text-center text-gray-500 py-4">
                                <i class="fas fa-user-slash text-3xl mb-2"></i>
                                <p>Cliente no especificado</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Resumen de Totales -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-chart-line mr-2 text-blue-600"></i>
                            Resumen
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Base Imponible:</span>
                                <span class="font-medium">${{ number_format($facturacion->tax_base / 100, 2) }}</span>
                            </div>
                            @if ($facturacion->type_rate_id)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Impuesto:</span>
                                    <span class="font-medium">
                                        ${{ number_format(($facturacion->tax_base / 100) * (($facturacion->typeRate->rate ?? 0) / 100), 2) }}
                                    </span>
                                </div>
                            @endif
                            <div class="flex justify-between pt-3 border-t border-gray-200">
                                <span class="font-bold text-gray-800">Total Factura:</span>
                                <span
                                    class="font-bold text-blue-600 text-lg">{{ getMoney($facturacion->total) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden no-print">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-bolt mr-2 text-blue-600"></i>
                            Acciones Rápidas
                        </h2>
                    </div>
                    <div class="p-6 space-y-2">
                        <a href="#"
                            class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <i class="fas fa-envelope text-blue-600 w-6"></i>
                            <span class="ml-3 text-gray-700">Enviar por correo electrónico</span>
                        </a>
                        <a href="#"
                            class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <i class="fas fa-download text-blue-600 w-6"></i>
                            <span class="ml-3 text-gray-700">Descargar PDF</span>
                        </a>
                        @if ($facturacion->status !== 'Anulada')
                            <button type="button"
                                onclick="if(confirm('¿Está seguro de que desea anular esta factura? Esta acción no se puede deshacer.')) { document.getElementById('cancel-form').submit(); }"
                                class="w-full text-left flex items-center p-3 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                <i class="fas fa-ban text-red-600 w-6"></i>
                                <span class="ml-3 text-red-700">Anular Factura</span>
                            </button>
                            {{-- <form id="cancel-form" action="{{ route('admin.facturacion.cancel', $facturacion->id) }}"
                                method="POST" style="display: none;">
                                @csrf
                                @method('PATCH')
                            </form> --}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        /* Estilos para impresión */
        @media print {
            .container {
                max-width: 100%;
                padding: 0;
                margin: 0;
            }

            .no-print {
                display: none !important;
            }

            .bg-white {
                background-color: white !important;
                border: 1px solid #e5e7eb !important;
            }

            button,
            a:not([href*="show"]),
            .btn,
            .no-print {
                display: none !important;
            }

            .rounded-lg {
                border-radius: 0 !important;
            }

            .shadow-sm {
                box-shadow: none !important;
            }

            body {
                background: white !important;
                font-size: 12pt;
            }

            .text-blue-600 {
                color: black !important;
            }

            .text-2xl {
                font-size: 18pt !important;
            }

            /* Mejoras para impresión */
            .border {
                border: 1px solid #ddd !important;
            }

            .grid {
                display: block !important;
            }

            .lg\\:col-span-2 {
                width: 100% !important;
            }

            .space-y-6>+ {
                margin-top: 1rem !important;
            }
        }

        /* Efectos hover */
        .transition-colors {
            transition: all 0.2s ease;
        }

        /* Mejoras para tablas responsivas */
        @media (max-width: 768px) {
            .overflow-x-auto {
                -webkit-overflow-scrolling: touch;
            }
        }

        /* Estilos para la información del cliente */
        .client-info p {
            margin-bottom: 0.5rem;
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configurar confirmación para anular factura
            const cancelButton = document.querySelector('button[onclick*="cancel-form"]');
            if (cancelButton) {
                // Remover onclick y agregar event listener
                cancelButton.removeAttribute('onclick');
                cancelButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm(
                            '¿Está seguro de que desea anular esta factura? Esta acción no se puede deshacer.'
                        )) {
                        document.getElementById('cancel-form').submit();
                    }
                });
            }
        });
    </script>
@endpush
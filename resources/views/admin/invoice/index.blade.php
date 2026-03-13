@extends('layouts.theme')

@section('title', 'Facturación | Sistema')

@section('section')
    <div class="container mx-auto px-4 py-6">
        <!-- Header de la página -->
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Facturación</h1>
                    <p class="text-gray-600 mt-2">Gestión de facturación del sistema</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.facturacion.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                        <i class="fas fa-plus mr-2"></i> Nueva factura
                    </a>
                </div>
            </div>
        </div>

        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('admin.home.index') }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <span class="ml-2 text-gray-500">Facturas</span>
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

        <!-- Filtros y Búsqueda -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-4">
                <form action="{{ route('admin.facturacion.index') }}" method="GET"
                    class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0">
                    <!-- Búsqueda -->
                    <div class="flex-1">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Buscar por numero de factura...">
                        </div>
                    </div>

                    <!-- Filtro de Estado -->
                    <div>
                        <select name="status"
                            class="w-full md:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Todos los estados</option>
                            <option value="Pendiente" {{ request('status') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="Pagada" {{ request('status') == 'Pagada' ? 'selected' : '' }}>Pagada</option>
                            <option value="Anulada" {{ request('status') == 'Anulada' ? 'selected' : '' }}>Anulada</option>
                        </select>
                    </div>

                    <!-- Botones -->
                    <div class="flex space-x-2">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                            <i class="fas fa-filter mr-2"></i>Filtrar
                        </button>
                        <a href="{{ route('admin.clientes.index') }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">
                            <i class="fas fa-redo mr-2"></i>Limpiar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de Facturas-->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header de la tabla -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Lista de Facturas</h2>
                        {{-- <p class="text-sm text-gray-600 mt-1">
                            Mostrando {{ $facturas->firstItem() ?? 0 }} - {{ $facturas->lastItem() ?? 0 }} de
                            {{ $facturas->total() ?? 0 }} facturas
                        </p> --}}
                    </div>

                    <!-- Exportar -->
                    <div class="mt-2 md:mt-0">
                        <button type="button"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-sm">
                            <i class="fas fa-download mr-2"></i>Exportar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tabla -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre Cliente
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Número de factura
                            </th>
                             <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($facturas as $f)
                            <tr class="hover:bg-gray-50">
                                <!-- ID -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900 font-medium">#{{ $f->id }}</span>
                                </td>

                                <!-- Nombre cliente -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                       
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $f->client_id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>


                                   <!-- Numero de factura -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        
                                        @if ($f->invoice_number)
                                            <div class="flex items-center mt-1">
                                                <span class="truncate max-w-xs">{{ $f->invoice_number }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                   <!-- Total Factura-->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        
                                        @if ($f->total)
                                            <div class="flex items-center mt-1">
                                                <span class="truncate max-w-xs">{{ $f->total }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                               

                                <!-- Estado -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $clase = match ($f->status) {
                                            'Pendiente' => 'fa-solid fa-hourglass-end text-red-600 bont-bold text-1xl',
                                            'Pagada' => 'fa-solid fa-handshake-angle text-green-600 bont-bold text-1xl',
                                            'Anulada' => 'fa-solid fa-ban  text-gray-600 bont-bold text-1xl',
                                            'default' => 'fa-solid fa-slash  text-black-600 bont-bold text-1xl',
                                        };
                                    @endphp
                                    <span> <i class = "{{ $clase }}"></i> {{ $f->status }}</span>
                                </td>
                                <!-- Acciones -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.facturacion.edit', $f->id) }}"
                                            class="text-blue-600 hover:text-blue-900" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="{{ route('admin.facturacion.show', $f->id) }}"
                                            class="text-green-600 hover:text-green-900" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- <form action="{{ route('admin.facturacion.destroy', $facturas) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('¿Está seguro de que desea eliminar esta factura?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form> --}}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No hay facturas registrados</h3>
                                        <p class="text-gray-500 mb-4">Comience agregando su primera factura</p>
                                        <a href="{{ route('admin.clientes.create') }}"
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                                            <i class="fas fa-plus mr-2"></i> Crear Primera Factura
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            {{-- @if ($facturas->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="text-sm text-gray-700 mb-4 md:mb-0">
                            Mostrando {{ $facturas->firstItem() }} a {{ $facturas->lastItem() }} de
                            {{ $facturas->total() }} resultados
                        </div>
                        <div>
                            {{ $facturas->links() }}
                        </div>
                    </div>
                </div>
            @endif --}}
        </div>

        <!-- Estadísticas Rápidas -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Resumen</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Total Facturas -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Facturas</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $totalFacturas ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Facturas Pagadas -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-check text-green-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Pagadas</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $activosCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Facturas Pendientes -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-times text-gray-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Pendientes</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $activosCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Anuladas -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-plus text-red-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-red-600">Anuladas</p>
                            <p class="text-2xl font-semibold text-red-900">{{ $nuevosEsteMes ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection

@push('css')
    <style>
        /* Estilos mínimos para la paginación de Laravel */
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            margin: 0 2px;
        }

        .pagination li a,
        .pagination li span {
            display: inline-block;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            color: #374151;
            text-decoration: none;
            font-size: 14px;
        }

        .pagination li.active span {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        .pagination li a:hover {
            background-color: #f3f4f6;
        }

        .pagination li.disabled span {
            color: #9ca3af;
            cursor: not-allowed;
        }

        /* Estilos para truncar texto */
        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
@endpush

{{-- @push('js')
    <script>
        // Confirmación para eliminación
        document.addEventListener('DOMContentLoaded', function() {
            // Buscar todos los formularios de eliminación
            const deleteForms = document.querySelectorAll('form[onsubmit*="confirm"]');

            deleteForms.forEach(form => {
                // Reemplazar el onsubmit original
                form.onsubmit = null;
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (confirm(
                            '¿Está seguro de que desea eliminar este cliente? Esta acción no se puede deshacer.'
                        )) {
                        this.submit();
                    }
                });
            });

            // Enfocar el campo de búsqueda si hay un parámetro de búsqueda
            @if (request()->has('search'))
                document.querySelector('input[name="search"]').focus();
            @endif
        });
    </script>
@endpush --}}

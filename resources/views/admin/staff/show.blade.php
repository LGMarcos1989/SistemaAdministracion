{{-- resources/views/admin/staff/show.blade.php --}}
@extends('layouts.theme')

@section('title', 'Usuarios | Ver Usuario #' . ($staff->id ?? ''))

@section('section')
    <div class="container mx-auto px-4 py-6">
        <!-- Header de la página -->
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Usuarios</h1>
                    <p class="text-gray-600 mt-2">Detalles del usuario: {{ $staff->fullname ?? 'N/A' }} {{ $staff->lastname ?? '' }}</p>
                </div>
                <div class="mt-4 md:mt-0 flex space-x-3 no-print">
                    <a href="{{ route('admin.staff.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 font-medium">
                        <i class="fas fa-arrow-left mr-2"></i> Volver
                    </a>
                    <a href="{{ route('admin.staff.edit', $staff->id) }}"
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
                    <a href="{{ route('admin.staff.index') }}" class="ml-2 text-blue-600 hover:text-blue-800">Usuarios</a>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <span class="ml-2 text-gray-500">{{ $staff->fullname ?? 'N/A' }} {{ $staff->lastname ?? '' }}</span>
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
            <!-- Columna Izquierda - Información Personal -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Tarjeta de Información Personal -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-user mr-2 text-blue-600"></i>
                            Información Personal
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                                    <div class="text-gray-900 font-medium">{{ $staff->fullname ?? 'N/A' }}</div>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Apellidos</label>
                                    <div class="text-gray-900">{{ $staff->lastname ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">DNI</label>
                                    <div class="text-gray-900 font-mono uppercase">{{ $staff->dni ?? 'N/A' }}</div>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
                                    <div class="text-gray-900">{{ $staff->fullname ?? '' }} {{ $staff->lastname ?? '' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta de Información de Contacto -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-address-book mr-2 text-blue-600"></i>
                            Información de Contacto
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-map-marker-alt mr-1 text-gray-500"></i> Ciudad
                                    </label>
                                    <div class="text-gray-900">{{ $staff->city ?? 'No especificada' }}</div>
                                </div>
                            </div>
                            <div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-phone mr-1 text-gray-500"></i> Teléfono
                                    </label>
                                    <div class="text-gray-900">{{ $staff->phone ?? 'No especificado' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha - Credenciales y Tipo de Usuario -->
            <div class="space-y-6">
                <!-- Tarjeta de Credenciales de Acceso -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-key mr-2 text-blue-600"></i>
                            Credenciales de Acceso
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-envelope mr-1 text-gray-500"></i> Email
                            </label>
                            <div class="text-gray-900">{{ $staff->user->email ?? 'N/A' }}</div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-tag mr-1 text-gray-500"></i> Tipo de Usuario
                            </label>
                            <div>
                                @php
                                    $tipoClase = match($staff->user->userType->name ?? '') {
                                        'Administrador' => 'bg-purple-100 text-purple-800',
                                        'Gestor' => 'bg-blue-100 text-blue-800',
                                        'Consultor' => 'bg-green-100 text-green-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $tipoClase }}">
                                    <i class="fas fa-user-shield mr-2"></i>
                                    {{ $staff->user->userType->name ?? 'No asignado' }}
                                </span>
                            </div>
                        </div>
                        @if($staff->created_at)
                            <div class="pt-4 mt-2 border-t border-gray-200">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-calendar-alt mr-1 text-gray-500"></i> Fecha de Registro
                                </label>
                                <div class="text-sm text-gray-600">{{ $staff->created_at ? \Carbon\Carbon::parse($staff->created_at)->format('d/m/Y H:i') : 'N/A' }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Resumen Rápido -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-chart-simple mr-2 text-blue-600"></i>
                            Resumen
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">ID de Usuario:</span>
                                <span class="font-mono text-gray-900">#{{ $staff->id ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nombre Completo:</span>
                                <span class="font-medium text-gray-900">{{ $staff->fullname ?? '' }} {{ $staff->lastname ?? '' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">DNI:</span>
                                <span class="font-mono uppercase">{{ $staff->dni ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between pt-3 border-t border-gray-200">
                                <span class="font-bold text-gray-800">Email:</span>
                                <span class="text-blue-600">{{ $staff->email ?? 'N/A' }}</span>
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
                        <a href="{{ route('admin.staff.edit', $staff->id) }}"
                            class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <i class="fas fa-pen text-blue-600 w-6"></i>
                            <span class="ml-3 text-gray-700">Editar Usuario</span>
                        </a>
                        @if(($staff->userType->name ?? '') !== 'Administrador')
                            <button type="button"
                                onclick="if(confirm('¿Está seguro de que desea deshabilitar este usuario? Esta acción se puede revertir.')) { document.getElementById('disable-form').submit(); }"
                                class="w-full text-left flex items-center p-3 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                                <i class="fas fa-user-slash text-yellow-600 w-6"></i>
                                <span class="ml-3 text-yellow-700">Deshabilitar Usuario</span>
                            </button>
                        @endif
                        @if(($staff->userType->name ?? '') !== 'Administrador')
                            <button type="button"
                                onclick="if(confirm('¿Está seguro de que desea eliminar este usuario? Esta acción no se puede deshacer.')) { document.getElementById('delete-form').submit(); }"
                                class="w-full text-left flex items-center p-3 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                <i class="fas fa-trash-alt text-red-600 w-6"></i>
                                <span class="ml-3 text-red-700">Eliminar Usuario</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formularios ocultos para acciones -->
    {{-- <form id="disable-form" action="{{ route('admin.staff.disable', $staff->id) }}" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
    </form>
    <form id="delete-form" action="{{ route('admin.staff.destroy', $staff->id) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form> --}}
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

            button, a:not([href*="show"]), .btn, .no-print {
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

            .grid {
                display: block !important;
            }

            .lg\:col-span-2 {
                width: 100% !important;
            }
        }

        .transition-colors {
            transition: all 0.2s ease;
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Aquí puedes agregar JavaScript adicional si es necesario
            console.log('Vista de detalle de usuario cargada');
        });
    </script>
@endpush
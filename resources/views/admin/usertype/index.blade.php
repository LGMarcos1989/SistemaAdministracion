@extends('layouts.theme')

@section('title', 'Tipos de Usuario | Sistema')

@section('section')
    <div class="container mx-auto px-4 py-6">
        <!-- Header de la página -->
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Tipos de Usuario</h1>
                    <p class="text-gray-600 mt-2">Gestión de roles del sistema</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.usertype.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                        <i class="fas fa-plus mr-2"></i> Nuevo Rol
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
                    <span class="ml-2 text-gray-500">Roles de Usuario</span>
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

      

        <!-- Tabla de Roles -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
           

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
                                Nombre del Rol
                            </th>
                            
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($roles as $rol)
                            <tr class="hover:bg-gray-50">
                                <!-- ID -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="text-sm text-gray-900 font-medium">#{{ $rol->id }}</span>
                                </td>

                                <!-- Razón Social -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                       
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $rol->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>


                                <!-- Acciones -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.usertype.edit', $rol) }}"
                                            class="text-blue-600 hover:text-blue-900" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.usertype.destroy', $rol) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('¿Está seguro de que desea eliminar este impuesto?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No hay roles registrados</h3>
                                        <p class="text-gray-500 mb-4">Comience agregando su primer rol</p>
                                        <a href="{{ route('admin.usertype.create') }}"
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                                            <i class="fas fa-plus mr-2"></i> Crear Primer Rol
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $roles->links() }}

            
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

@push('js')
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
@endpush

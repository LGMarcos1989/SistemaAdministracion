@extends('layouts.theme')

@section('title', 'Actualizar cliente | Sistema')

@section('section')
    <div class="container mx-auto px-4 py-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Actualizar cliente</h1>
            <p class="text-gray-600 mt-2">Módulo de actualización de datos</p>
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
                    <a href="{{ route('admin.clientes.index') }}"
                        class="ml-2 text-blue-600 hover:text-blue-800">Clientes</a>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <span class="ml-2 text-gray-500">Actualizar Cliente</span>
                </li>
            </ol>
        </nav>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 font-medium">Hay errores en el formulario</p>
                        <ul class="mt-2 text-sm text-red-600 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

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

        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-user-plus text-blue-500 mr-2"></i> Información del Cliente
                </h2>
            </div>

            <div class="p-6">
                <form novalidate action="{{ route('admin.clientes.update', $cliente) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-8">
                        <h3 class="text-md font-semibold text-gray-700 mb-4 pb-2 border-b border-gray-100">
                            <i class="fas fa-id-card text-blue-500 mr-2"></i> Información Básica
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="bussiness_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Razón Social <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="bussiness_name" name="bussiness_name"
                                    value="{{ old('bussiness_name', $cliente->bussiness_name) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Ej: Juan Carlos" required>
                                @error('bussiness_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="cif" class="block text-sm font-medium text-gray-700 mb-2">
                                    CIF/NIF <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="cif" name="cif" value="{{ old('cif', $cliente->cif) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent uppercase"
                                    placeholder="Ej: A12345678" required>
                                @error('cif')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-md font-semibold text-gray-700 mb-4 pb-2 border-b border-gray-100">
                            <i class="fas fa-address-book text-blue-500 mr-2"></i> Información de Contacto
                        </h3>

                        <div class="space-y-6">
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                    Dirección
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    </div>
                                    <input type="text" id="address" name="address"
                                        value="{{ old('address', $cliente->address) }}"
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Calle, número, ciudad, código postal">
                                </div>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        Teléfono
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-phone text-gray-400"></i>
                                        </div>
                                        <input type="tel" id="phone" name="phone"
                                            value="{{ old('phone', $cliente->phone) }}"
                                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="+34 600 123 456">
                                    </div>
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        Email
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-envelope text-gray-400"></i>
                                        </div>
                                        <input type="email" id="email" name="email"
                                            value="{{ old('email', $cliente->email) }}"
                                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="cliente@email.com">
                                    </div>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="grid sm:grid-cols-2 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        Estado
                                    </label>
                                    <div class="relative">
                                        <select id="status" name="status"
                                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="Abierto"
                                                {{ $cliente->status === 'Abierto' ? 'selected' : null }}>
                                                Abierto
                                            </option>
                                            <option value="Cerrado"
                                                {{ $cliente->status === 'Cerrado' ? 'selected' : null }}>
                                                Cerrado
                                            </option>
                                        </select>
                                    </div>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-200">
                        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                            <div>
                                <a href="{{ route('admin.clientes.index') }}"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <i class="fas fa-arrow-left mr-2"></i>Volver a la lista de clientes
                                </a>
                            </div>
                            <div class="flex space-x-4">
                                <button type="submit" name="submit"
                                    class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                                    <i class="fas fa-save mr-2"></i>Guardar Cliente
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
        }

        .uppercase {
            text-transform: uppercase;
        }
    </style>
@endpush

@push('js')
    <script>
        document.getElementById('cif')?.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('fullname').focus();
        });
    </script>
@endpush
@extends('layouts.theme')

@section('title', 'Nueva Factura | Sistema')

@section('section')

    <div class="container mx-auto px-4 py-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Nuevo Factura</h1>
            <p class="text-gray-600 mt-2">Complete el formulario para registrar una nueva factura</p>
        </div>

        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('admin.home.index') }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <a href="{{ route('admin.facturacion.index') }}"
                        class="ml-2 text-blue-600 hover:text-blue-800">Facturación</a>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <span class="ml-2 text-gray-500">Nueva Factura</span>
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
                    <i class="fa-solid fa-file-invoice text-blue-500 mr-2"></i> Información de la factura
                </h2>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.facturacion.store') }}" method="POST">
                    @csrf

                    <div class="mb-8">
                        <h3 class="text-md font-semibold text-gray-700 mb-4 pb-2 border-b border-gray-100">
                            <i class="fas fa-id-card text-blue-500 mr-2"></i> Información Básica
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Seleccione el Cliente <span class="text-red-500">*</span>
                                </label>
                                <select id="client_id" name="client_id" value="{{ old('client_id') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option selected disabled>Seleccione un cliente  </option>
                                    @foreach ($clientes as $c)
                                        <option value="{{ $c->id }}">{{ $c->bussiness_name.' '.$c->cif }}</option>
                                    @endforeach
                               
                                </select>
                                @error('id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                           

                            {{-- <div>
                                <label for="bussiness_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nombre Cliente <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="bussiness_name" name="bussiness_name" value="{{ old('bussiness_name') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent uppercase"
                                    placeholder="Ej: Madison" required>
                                @error('bussiness_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div> --}}
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-md font-semibold text-gray-700 mb-4 pb-2 border-b border-gray-100">
                            <i class="fas fa-file-lines text-blue-500 mr-2"></i> Información de la factura
                        </h3>

                        <div class="space-y-6">
                            {{-- Fecha factura y numero de factura --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="invoice_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        Fecha de la factura
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-calendar-day text-gray-400"></i>
                                        </div>
                                        <input type="date" id="invoice_date" name="invoice_date" value="{{ old('invoice_date') }}"
                                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            >
                                    </div>
                                    @error('invoice_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="invoice_number" class="block text-sm font-medium text-gray-700 mb-2">
                                       Número de factura
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-file-invoice-dollar text-gray-400"></i>
                                        </div>
                                        <input type="text" id="invoice_number" name="invoice_number" value="{{ old('invoice_number') }}"
                                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="81260000">
                                    </div>
                                    @error('invoice_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            {{-- Concepto y Base Imponible --}}
                            <div class="grid grid-cols-4  gap-6">
                                <div class="col-span-3">
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                        Concepto de la factura
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-file-waveform text-gray-400"></i>
                                        </div>
                                        <textarea id="description" name="description" 
                                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Alquiler de instalaciones"></textarea>
                                    </div>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-span-1">
                                    <label for="tax_base" class="block text-sm font-medium text-gray-700 mb-2">
                                       Base Imponible
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-file-invoice-dollar text-gray-400"></i>
                                        </div>
                                        <input type="number" step="0.01" id="tax_base" name="tax_base" value="{{ old('tax_base') }}"
                                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="1000">
                                    </div>
                                    @error('tax_base')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            {{-- Estado y Nota --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="tax_rate_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Código Impositivo
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-percent text-gray-400"></i>
                                        </div>
                                        <select id="type_rate_id" name="type_rate_id" value="{{ old('type_rate_id') }}"
                                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           ><option selected disabled>Seleccione un Código</option>
                                             @foreach ($codigos as $c)
                                               <option value="{{ $c->id }}">{{ $c->name.' '.$c->value.' %' }}</option>
                                           @endforeach
                                        </select>
                                         
                                    </div>
                                    @error('type_rate_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="total" class="block text-sm font-medium text-gray-700 mb-2">
                                        Precio Total
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-euro-sign text-gray-400"></i>
                                        </div>
                                        <input type="number" step="0.01" id="total" name="total" value="{{ old('total') }}"
                                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="1270">
                                    </div>
                                    @error('total')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                        Estado de factura
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="text-gray-400"></i>
                                        </div>
                                        <select id="status" name="status" 
                                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           >
                                          <option selected disabled value="Seleccione un estado">Seleccione un estado</option>
                                           <option value="Pendiente">Pendiente</option>
                                           <option value="Pagada">Pagada</option>
                                           <option value="Anulada">Anulada</option>
                                           </select>
                                    </div>
                                    @error('type_rate_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="Nota" class="block text-sm font-medium text-gray-700 mb-2">
                                        Observaciones
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class=" text-gray-400"></i>
                                        </div>
                                        <textarea type="number" step="0.01" id="nota" name="nota" value="{{ old('nota') }}"
                                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Ponga las observaciones que crea necesarias si cambia de estado o algun hecho relevante"></textarea>
                                    </div>
                                    @error('total')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-200">
                        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                            <div>
                                <a href="{{ route('admin.facturacion.index') }}"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <i class="fas fa-arrow-left mr-2"></i>Volver a la lista de facturas
                                </a>
                            </div>
                            <div class="flex space-x-4">
                                <button type="submit" name="submit"
                                    class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                                    <i class="fas fa-save mr-2"></i>Guardar factura
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
        document.getElementById('bussiness_name')?.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });

        document.getElementById('description')?.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('id').focus();
        });
    </script>
@endpush

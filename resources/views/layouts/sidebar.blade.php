<aside id="sidebar" class="bg-gray-900 text-white w-64 flex-shrink-0 overflow-y-auto transition-all duration-300">
    <div class="p-4 border-b border-gray-700">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-chart-line text-blue-400 text-xl mr-3"></i>
                <h1 class="text-lg font-bold">Loren<span class="text-blue-400">Admin</span></h1>
            </div>
            <button id="sidebar-toggle" class="text-gray-400 hover:text-white md:hidden">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <nav class="p-4">
        <ul class="space-y-1">
            @if (Auth::user()->userType->name === 'Administrador')
                <li>
                    <button type="button"
                        class="menu-toggle w-full flex items-center justify-between p-3 rounded-lg hover:bg-gray-800">
                        <div class="flex items-center">
                            <i class="fas fa-users mr-3 text-blue-400"></i>
                            <span>Clientes</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <ul class="submenu pl-9 hidden space-y-1">
                        <li>
                            <a href="{{ route('admin.clientes.index') }}"
                                class="block p-2 rounded hover:bg-gray-800 text-sm">
                                <i class="fas fa-search mr-2"></i>Consultar
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.clientes.create') }}"
                                class="block p-2 rounded hover:bg-gray-800 text-sm">
                                <i class="fas fa-plus-circle mr-2"></i>Nuevo
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <button type="button"
                        class="menu-toggle w-full flex items-center justify-between p-3 rounded-lg hover:bg-gray-800">
                        <div class="flex items-center">
                            <i class="fas fa-landmark mr-3 text-red-400"></i>
                            <span>Tipos Impositivos</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <ul class="submenu pl-9 hidden space-y-1">
                        <li>
                            <a href="{{ route('admin.impuestos.index') }}"
                                class="block p-2 rounded hover:bg-gray-800 text-sm">
                                <i class="fas fa-search mr-2"></i>Consultar
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.impuestos.create') }}"
                                class="block p-2 rounded hover:bg-gray-800 text-sm">
                                <i class="fas fa-search mr-2"></i>Nuevo
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <button type="button"
                        class="menu-toggle w-full flex items-center justify-between p-3 rounded-lg hover:bg-gray-800">
                        <div class="flex items-center">
                            <i class="fas fa-user-tie mr-3 text-green-400"></i>
                            <span>Equipo Staff</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <ul class="submenu pl-9 hidden space-y-1">
                        <li>
                            <a href="{{ route('admin.staff.index') }}"
                                class="block p-2 rounded hover:bg-gray-800 text-sm">
                                <i class="fas fa-search mr-2"></i>Consultar
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block p-2 rounded hover:bg-gray-800 text-sm">
                                <i class="fas fa-plus-circle mr-2"></i>Nuevo
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (Auth::user()->userType->name === 'Consultor' || Auth::user()->userType->name === 'Administrador')
                <li>
                    <button type="button"
                        class="menu-toggle w-full flex items-center justify-between p-3 rounded-lg hover:bg-gray-800">
                        <div class="flex items-center">
                            <i class="fas fa-file-invoice-dollar mr-3 text-yellow-400"></i>
                            <span>Facturación</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <ul class="submenu pl-9 hidden space-y-1">
                        <li>
                            <a href="{{ route('admin.facturacion.index') }}"
                                class="block p-2 rounded hover:bg-gray-800 text-sm">
                                <i class="fas fa-search mr-2"></i>Consultar
                            </a>
                        </li>
                        @if (Auth::user()->userType->name === 'Administrador')
                            <li>
                                <a href="{{ route('admin.facturacion.create') }}"
                                    class="block p-2 rounded hover:bg-gray-800 text-sm">
                                    <i class="fas fa-plus-circle mr-2"></i>Nuevo
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (Auth::user()->userType->name === 'Administrador')
                <li>
                    <button type="button"
                        class="menu-toggle w-full flex items-center justify-between p-3 rounded-lg hover:bg-gray-800">
                        <div class="flex items-center">
                            <i class="fas fa-user-shield mr-3 text-purple-400"></i>
                            <span>Roles de usuario</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <ul class="submenu pl-9 hidden space-y-1">
                        <li>
                            <a href="{{ route('admin.usertype.index') }}"
                                class="block p-2 rounded hover:bg-gray-800 text-sm">
                                <i class="fas fa-search mr-2"></i>Consultar
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.usertype.create') }}"
                                class="block p-2 rounded hover:bg-gray-800 text-sm">
                                <i class="fas fa-plus-circle mr-2"></i>Nuevo
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            <li class="mt-6 pt-6 border-t border-gray-700">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center p-3 rounded-lg hover:bg-gray-800 text-red-400 hover:text-red-300">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        <span>Salir</span>
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside>
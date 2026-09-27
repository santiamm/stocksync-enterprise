<x-app-layout>
    <x-slot name="header">
        <nav class="flex text-sm font-medium text-slate-500 mb-2">
            <a href="{{ route('products.index') }}" class="hover:text-indigo-600 transition">Inventario</a>
            <span class="mx-2">/</span>
            <span class="text-slate-900">Nuevo Producto</span>
        </nav>
        <h2 class="font-extrabold text-3xl text-slate-900 tracking-tight">
            Añadir Producto
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <!-- SECCIÓN 1: DETALLES PRINCIPALES -->
                <div class="md:grid md:grid-cols-3 md:gap-6 mb-10">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-bold leading-6 text-slate-900">Detalles del Producto</h3>
                        <p class="mt-2 text-sm text-slate-500">
                            Información pública y de clasificación. Asegúrate de que el SKU coincida con el código de barras físico.
                        </p>
                    </div>
                    <div class="mt-5 md:col-span-2 md:mt-0">
                        <div class="shadow-sm ring-1 ring-slate-200 sm:rounded-2xl bg-white p-6 sm:p-8">
                            <div class="grid grid-cols-6 gap-6">
                                
                                <div class="col-span-6 sm:col-span-4">
                                    <label class="block text-sm font-semibold text-slate-900">Nombre del Producto</label>
                                    <input type="text" name="name" required placeholder="Ej. Teclado Mecánico RGB" class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-colors">
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-900">SKU</label>
                                    <div class="relative mt-2">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                            </svg>
                                        </div>
                                        <input type="text" name="sku" required placeholder="PRD-001" class="block w-full pl-10 rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-mono text-slate-700">
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-semibold text-slate-900">Categoría</label>
                                    <select name="category_id" required class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-slate-50">
                                        <option value="" disabled selected>Selecciona una categoría...</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-semibold text-slate-900">Precio de Venta</label>
                                    <div class="relative mt-2">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <span class="text-slate-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" name="price" required placeholder="0.00" class="block w-full pl-8 rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 2: INVENTARIO -->
                <div class="md:grid md:grid-cols-3 md:gap-6 mb-10 border-t border-slate-200 pt-10">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-bold leading-6 text-slate-900">Control de Stock</h3>
                        <p class="mt-2 text-sm text-slate-500">
                            Configura el inventario inicial y los umbrales de alerta para evitar desabastecimiento.
                        </p>
                    </div>
                    <div class="mt-5 md:col-span-2 md:mt-0">
                        <div class="shadow-sm ring-1 ring-slate-200 sm:rounded-2xl bg-white p-6 sm:p-8 grid grid-cols-2 gap-6">
                            
                            <div>
                                <label class="block text-sm font-semibold text-slate-900">Stock Inicial</label>
                                <input type="number" name="stock" value="0" required class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-900 text-red-600">Alerta de Stock Crítico</label>
                                <input type="number" name="min_stock_alert" value="10" required class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                                <p class="mt-2 text-xs text-slate-500">Notificar al administrador cuando el stock llegue a esta cantidad.</p>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- BOTONES DE ACCIÓN -->
                <div class="flex justify-end gap-3 bg-white p-6 shadow-sm ring-1 ring-slate-200 sm:rounded-2xl items-center sticky bottom-6 z-10">
                    <button type="button" onclick="window.history.back()" class="text-sm font-bold text-slate-600 hover:text-slate-900 px-4 py-2 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-200 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Guardar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
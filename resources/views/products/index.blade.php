<x-app-layout>
    <div class="flex flex-col gap-space-lg pb-space-xl pt-6">
        
        <!-- CABECERA: Título y Estadísticas -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-space-md mb-4">
            <div class="flex flex-col gap-space-xs">
                <div class="flex items-center gap-space-sm">
                    <span class="px-2 py-0.5 rounded-lg bg-primary/10 text-primary font-label-sm text-label-sm uppercase tracking-wider font-semibold">Módulo Logístico</span>
                </div>
                <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight">Inventario Central</h1>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-3xl">Gestión de existencias y sincronización con hojas de cálculo.</p>
            </div>
            
            <div class="flex items-center gap-space-md bg-surface-container-low px-space-md py-space-sm rounded-xl">
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Total SKUs</span>
                    <span class="font-headline-sm text-headline-sm text-on-surface">{{ collect($products ?? [])->count() }}</span>
                </div>
            </div>
        </div>

        <!-- Alertas de éxito/error -->
        @if(session('success'))
            <div class="bg-primary-container border-l-4 border-primary text-on-primary-container p-4 mb-4 rounded-r-lg" role="alert">
                <p class="font-bold">¡Éxito!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-r-lg" role="alert">
                <p class="font-bold">Atención</p>
                <p>{{ $errors->first() }}</p>
            </div>
        @endif

        <!-- BLOQUE DE BOTONES (AQUÍ DEBEN APARECER) -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
            <div class="flex flex-wrap items-center gap-3">
                
                <!-- 1. Formulario para Importar: la categoría se asigna a los productos nuevos -->
                <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" id="importForm" class="flex items-center gap-2">
                    @csrf
                    <label for="importCategory" class="text-sm font-semibold text-gray-600">Categoría para nuevos:</label>
                    <select name="category_id" id="importCategory" required class="rounded-lg border-gray-300 text-sm">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <input type="file" name="file" id="fileInput" accept=".xlsx, .xls, .csv" class="hidden" onchange="document.getElementById('importForm').submit()">
                </form>

                <!-- 2. Botón Importar (Verde/Primario) -->
                <button type="button" onclick="document.getElementById('fileInput').click()" class="bg-primary hover:bg-primary-container text-white px-6 py-2.5 rounded-lg font-semibold flex items-center gap-2 shadow-md transition-all">
                    <span class="material-symbols-outlined text-[20px]">upload_file</span>
                    Importar Excel
                </button>

                <!-- 3. Botón Exportar (Azul/Secundario) -->
                <a href="{{ route('products.export') }}" class="bg-surface-container-low hover:bg-surface-container text-on-surface px-6 py-2.5 rounded-lg font-semibold flex items-center gap-2 border border-gray-200 transition-all">
                    <span class="material-symbols-outlined text-[20px] text-secondary">download</span>
                    Exportar Datos
                </a>
                
                <!-- 4. Botón Nuevo Manual -->
                <a href="{{ route('products.create') }}" class="bg-transparent hover:bg-gray-50 text-gray-700 px-6 py-2.5 rounded-lg font-semibold flex items-center gap-2 border border-gray-300 transition-all">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    Añadir Manual
                </a>

            </div>
        </div>

        <!-- TABLA DE DATOS -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="py-4 px-6 text-sm font-semibold text-gray-600">SKU</th>
                            <th class="py-4 px-6 text-sm font-semibold text-gray-600">Nombre del Producto</th>
                            <th class="py-4 px-6 text-sm font-semibold text-gray-600">Categoría</th>
                            <th class="py-4 px-6 text-sm font-semibold text-gray-600 text-right">Stock</th>
                            <th class="py-4 px-6 text-sm font-semibold text-gray-600 text-right">Precio</th>
                            <th class="py-4 px-6 text-sm font-semibold text-gray-600 text-center">Estado</th>
                            <th class="py-4 px-6 text-sm font-semibold text-gray-600 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-6 font-mono text-sm text-gray-500 whitespace-nowrap">{{ $product->sku }}</td>
                                <td class="py-4 px-6 font-medium text-gray-900">{{ $product->name }}</td>
                                <td class="py-4 px-6 text-sm text-gray-600">{{ $product->category->name ?? '—' }}</td>
                                <td class="py-4 px-6 text-right font-bold {{ $product->stock <= $product->min_stock_alert ? 'text-red-600' : 'text-gray-900' }}">
                                    {{ $product->stock }}
                                </td>
                                <td class="py-4 px-6 text-right font-medium text-gray-900">${{ number_format($product->price, 2) }}</td>
                                <td class="py-4 px-6 text-center">
                                    @if($product->stock <= $product->min_stock_alert)
                                        <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full">Crítico</span>
                                    @else
                                        <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full">OK</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <a href="{{ route('products.edit', $product) }}" class="text-sm font-semibold text-primary hover:underline">Editar</a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('¿Eliminar el producto {{ $product->name }}?');" class="inline-block ml-3">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-semibold text-red-600 hover:underline">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-gray-500">No hay productos. Usa el botón "Importar Excel" arriba.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
<x-app-layout>
    <x-slot:title>Inventario</x-slot>

    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-5">
        <div>
            <h1 class="page-title">Inventario</h1>
            <p class="page-lead">{{ $products->count() }} productos. El stock cambia solo con movimientos, para que todo quede registrado.</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn-primary">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Nuevo producto
        </a>
    </div>

    <div class="mt-6 space-y-3">
        @if (session('success'))
            <div class="notice-ok" role="status"><span class="material-symbols-outlined">check_circle</span>{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="notice-error" role="alert"><span class="material-symbols-outlined">error</span>{{ $errors->first() }}</div>
        @endif
    </div>

    <!-- Excel: importar y exportar -->
    <section class="panel mt-6 p-4 sm:p-5">
        <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" id="importForm"
              class="flex flex-col lg:flex-row lg:items-end gap-4">
            @csrf
            <div class="lg:max-w-xs w-full">
                <label for="importCategory" class="field-label">Categoría para productos nuevos</label>
                <select name="category_id" id="importCategory" required class="field">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <input type="file" name="file" id="fileInput" accept=".xlsx,.xls,.csv" class="hidden" onchange="this.form.submit()">
            <div class="flex flex-wrap gap-3 shrink-0">
                <button type="button" onclick="document.getElementById('fileInput').click()" class="btn-secondary">
                    <span class="material-symbols-outlined text-[20px]">upload</span>
                    Importar Excel
                </button>
                <a href="{{ route('products.export') }}" class="btn-secondary">
                    <span class="material-symbols-outlined text-[20px]">download</span>
                    Exportar Excel
                </a>
            </div>
            <p class="text-sm text-gris lg:ml-auto lg:max-w-xs">Si el SKU ya existe se actualizan sus datos; si es nuevo, se crea en la categoría elegida.</p>
        </form>
    </section>

    <!-- Tabla con búsqueda dentro de la página -->
    <section class="mt-8" x-data="{ q: '' }">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h2 class="section-title">Productos</h2>
            <label class="relative sm:w-72">
                <span class="sr-only">Buscar por nombre, SKU o categoría</span>
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-petroleo-300 text-[20px]">search</span>
                <input type="search" x-model="q" placeholder="Buscar por nombre o SKU" class="field mt-0 pl-10">
            </label>
        </div>

        <div class="panel mt-3 overflow-x-auto">
            <table class="w-full sm:min-w-[640px]">
                <thead>
                    <tr>
                        <th class="table-head hidden sm:table-cell">SKU</th>
                        <th class="table-head">Producto</th>
                        <th class="table-head text-right">Stock</th>
                        <th class="table-head text-right hidden sm:table-cell">Precio</th>
                        <th class="table-head text-right"><span class="sr-only">Acciones</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        @php $low = $product->stock <= $product->min_stock_alert; @endphp
                        <tr x-show="q === '' || $el.dataset.search.includes(q.toLowerCase())"
                            data-search="{{ mb_strtolower($product->sku . ' ' . $product->name . ' ' . ($product->category->name ?? '')) }}"
                            class="hover:bg-concreto/50">
                            <td class="table-cell hidden sm:table-cell"><span class="rack">{{ $product->sku }}</span></td>
                            <td class="table-cell">
                                <span class="rack mb-1 sm:hidden">{{ $product->sku }}</span>
                                <p class="font-semibold">{{ $product->name }}</p>
                                <p class="text-sm text-gris">{{ $product->category->name ?? 'Sin categoría' }}<span class="sm:hidden"> · ${{ number_format($product->price, 0, ',', '.') }}</span></p>
                            </td>
                            <td class="table-cell text-right whitespace-nowrap">
                                <span class="font-display font-bold text-xl {{ $low ? 'text-senal-700' : '' }}">{{ $product->stock }}</span>
                                <span class="block text-xs {{ $low ? 'text-senal-700 font-semibold' : 'text-gris' }}">
                                    {{ $low ? 'Reponer · ' : '' }}mín. {{ $product->min_stock_alert }}
                                </span>
                            </td>
                            <td class="table-cell text-right whitespace-nowrap hidden sm:table-cell">${{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="table-cell text-right whitespace-nowrap px-2 sm:px-4">
                                <a href="{{ route('products.edit', $product) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-md text-petroleo hover:bg-petroleo-50" title="Editar {{ $product->name }}">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                    <span class="sr-only">Editar {{ $product->name }}</span>
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline"
                                      onsubmit="return confirm('¿Eliminar {{ $product->name }}? Solo se puede si no tiene movimientos.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-md text-salida hover:bg-salida-50" title="Eliminar {{ $product->name }}">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                        <span class="sr-only">Eliminar {{ $product->name }}</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center">
                                <p class="font-semibold">Todavía no hay productos.</p>
                                <p class="mt-1 text-gris">Crea uno con “Nuevo producto” o importa tu Excel.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>

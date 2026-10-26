<x-app-layout>
    @php $editing = isset($product); @endphp
    <x-slot:title>{{ $editing ? 'Editar producto' : 'Nuevo producto' }}</x-slot>

    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-gris hover:text-petroleo">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Inventario
    </a>
    <h1 class="page-title mt-3">{{ $editing ? 'Editar producto' : 'Nuevo producto' }}</h1>
    @if ($editing)
        <p class="page-lead"><span class="rack align-middle">{{ $product->sku }}</span> {{ $product->name }}</p>
    @else
        <p class="page-lead">El SKU debe ser igual al código que tiene la etiqueta del producto.</p>
    @endif

    @if ($errors->any())
        <div class="notice-error mt-6 max-w-3xl" role="alert"><span class="material-symbols-outlined">error</span>{{ $errors->first() }}</div>
    @endif

    <!-- El mismo formulario sirve para crear y para editar -->
    <form action="{{ $editing ? route('products.update', $product) : route('products.store') }}" method="POST" class="mt-8 max-w-3xl space-y-6">
        @csrf
        @if ($editing)
            @method('PUT')
        @endif

        <fieldset class="panel p-5 sm:p-8">
            <legend class="sr-only">Datos del producto</legend>
            <h2 class="section-title">Datos del producto</h2>
            <div class="mt-5 grid sm:grid-cols-6 gap-5">
                <div class="sm:col-span-4">
                    <label for="name" class="field-label">Nombre</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required placeholder="Ej. Cinta métrica 5 m" class="field">
                </div>
                <div class="sm:col-span-2">
                    <label for="sku" class="field-label">SKU</label>
                    <input id="sku" type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}" required placeholder="FER-003" class="field font-display text-lg tracking-wide uppercase">
                </div>
                <div class="sm:col-span-3">
                    <label for="category_id" class="field-label">Categoría</label>
                    <select id="category_id" name="category_id" required class="field">
                        <option value="" disabled @selected(! old('category_id', $product->category_id ?? null))>Elige una categoría</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? null) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-3">
                    <label for="price" class="field-label">Precio de venta</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 mt-[3px] -translate-y-1/2 text-gris">$</span>
                        <input id="price" type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price ?? '') }}" required placeholder="0" class="field pl-7">
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset class="panel p-5 sm:p-8">
            <legend class="sr-only">Stock</legend>
            <h2 class="section-title">Stock</h2>
            <div class="mt-5 grid sm:grid-cols-2 gap-5">
                <div>
                    @if ($editing)
                        <label for="stock" class="field-label">Stock actual</label>
                        <input id="stock" type="number" value="{{ $product->stock }}" disabled class="field bg-concreto text-gris">
                        <p class="field-hint">Para cambiarlo, <a href="{{ route('movements.create') }}" class="link-action">registra un movimiento</a>.</p>
                    @else
                        <label for="stock" class="field-label">Stock inicial</label>
                        <input id="stock" type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required class="field">
                        <p class="field-hint">Unidades que hay hoy en la bodega.</p>
                    @endif
                </div>
                <div>
                    <label for="min_stock_alert" class="field-label">Stock mínimo</label>
                    <input id="min_stock_alert" type="number" name="min_stock_alert" value="{{ old('min_stock_alert', $product->min_stock_alert ?? 10) }}" min="0" required class="field">
                    <p class="field-hint">Al llegar a este número, el producto aparece en “Por reponer”.</p>
                </div>
            </div>
        </fieldset>

        <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
            <a href="{{ route('products.index') }}" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">{{ $editing ? 'Guardar cambios' : 'Crear producto' }}</button>
        </div>
    </form>
</x-app-layout>

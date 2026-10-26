<x-app-layout>
    <x-slot:title>Resumen</x-slot>

    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-5">
        <div>
            <h1 class="page-title">Resumen de bodega</h1>
            <p class="page-lead">Cómo está el inventario hoy, {{ now()->translatedFormat('j \d\e F') }}.</p>
        </div>
        <a href="{{ route('movements.create') }}" class="btn-primary">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Registrar movimiento
        </a>
    </div>

    <!-- Cifras principales: una sola franja, como el tablero de una bodega -->
    <section class="panel mt-8 grid grid-cols-2 lg:grid-cols-4 divide-linea [&>*]:border-linea">
        <div class="col-span-2 lg:col-span-1 p-5 sm:p-6 border-b lg:border-b-0 lg:border-r">
            <p class="text-sm font-semibold text-gris">Valor del inventario</p>
            <p class="mt-1 font-display font-bold text-4xl leading-none">${{ number_format($totalValue, 0, ',', '.') }}</p>
            <p class="mt-2 text-xs text-gris">Stock × precio de venta</p>
        </div>
        <div class="p-5 sm:p-6 border-r">
            <p class="text-sm font-semibold text-gris">Productos</p>
            <p class="mt-1 font-display font-bold text-4xl leading-none">{{ number_format($totalProducts, 0, ',', '.') }}</p>
        </div>
        <div class="p-5 sm:p-6 lg:border-r">
            <p class="text-sm font-semibold text-gris">Unidades en bodega</p>
            <p class="mt-1 font-display font-bold text-4xl leading-none">{{ number_format($totalStock, 0, ',', '.') }}</p>
        </div>
        <div class="col-span-2 lg:col-span-1 p-5 sm:p-6 border-t lg:border-t-0 {{ $criticalProducts->count() ? 'bg-senal-50' : '' }}">
            <p class="text-sm font-semibold {{ $criticalProducts->count() ? 'text-senal-700' : 'text-gris' }}">Por reponer</p>
            <p class="mt-1 font-display font-bold text-4xl leading-none">{{ $criticalProducts->count() }}</p>
            <p class="mt-2 text-xs {{ $criticalProducts->count() ? 'text-senal-700' : 'text-gris' }}">En su stock mínimo o por debajo</p>
        </div>
    </section>

    <div class="mt-10 grid lg:grid-cols-5 gap-8">

        <!-- Productos por reponer, con barra de stock contra el mínimo -->
        <section class="lg:col-span-3">
            <div class="flex items-baseline justify-between gap-4">
                <h2 class="section-title">Por reponer</h2>
                <a href="{{ route('products.index') }}" class="link-action">Ver inventario</a>
            </div>

            <div class="panel mt-3">
                @forelse ($criticalProducts as $product)
                    @php $fill = $product->min_stock_alert > 0 ? min(100, round($product->stock / $product->min_stock_alert * 100)) : 100; @endphp
                    <div class="p-4 {{ ! $loop->last ? 'border-b border-linea' : '' }}">
                        <div class="flex items-center justify-between gap-3">
                            <div class="min-w-0 flex items-center gap-3">
                                <span class="rack">{{ $product->sku }}</span>
                                <span class="font-semibold truncate">{{ $product->name }}</span>
                            </div>
                            <span class="shrink-0 text-sm text-gris"><strong class="text-petroleo text-base">{{ $product->stock }}</strong> de {{ $product->min_stock_alert }} mín.</span>
                        </div>
                        <div class="mt-3 h-2 rounded-full bg-concreto overflow-hidden" role="img" aria-label="{{ $product->stock }} de {{ $product->min_stock_alert }} unidades mínimas">
                            <div class="h-full rounded-full {{ $product->stock == 0 ? 'bg-salida' : 'bg-senal' }}" style="width: {{ max($fill, 3) }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <span class="material-symbols-outlined text-4xl text-entrada">check_circle</span>
                        <p class="mt-2 font-semibold">Ningún producto está por debajo de su mínimo.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Últimos movimientos -->
        <section class="lg:col-span-2">
            <div class="flex items-baseline justify-between gap-4">
                <h2 class="section-title">Últimos movimientos</h2>
                <a href="{{ route('movements.index') }}" class="link-action">Ver historial</a>
            </div>

            <ol class="panel mt-3">
                @forelse ($recentMovements as $movement)
                    <li class="flex items-center gap-3 p-4 {{ ! $loop->last ? 'border-b border-linea' : '' }}">
                        <div class="min-w-0 flex-1">
                            <p class="font-semibold truncate">{{ $movement->product->name }}</p>
                            <p class="text-sm text-gris">{{ $movement->created_at->translatedFormat('j M, g:i a') }} · {{ $movement->user->name ?? 'Sistema' }}</p>
                        </div>
                        @include('movements.partials.quantity', ['movement' => $movement])
                    </li>
                @empty
                    <li class="p-8 text-center text-gris">
                        Aún no hay movimientos.
                        <a href="{{ route('movements.create') }}" class="link-action">Registra el primero</a>
                    </li>
                @endforelse
            </ol>
        </section>
    </div>
</x-app-layout>

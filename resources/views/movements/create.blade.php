<x-app-layout>
    <x-slot:title>Registrar movimiento</x-slot>

    @php
        $types = [
            'in' => ['label' => 'Entrada', 'icon' => 'south', 'help' => 'Llegó mercancía. Suma al stock.', 'qty' => 'Unidades que entran', 'color' => 'peer-checked:border-entrada peer-checked:bg-entrada-50', 'icolor' => 'text-entrada'],
            'out' => ['label' => 'Salida', 'icon' => 'north', 'help' => 'Se despachó o se perdió. Resta del stock.', 'qty' => 'Unidades que salen', 'color' => 'peer-checked:border-salida peer-checked:bg-salida-50', 'icolor' => 'text-salida'],
            'adjustment' => ['label' => 'Conteo físico', 'icon' => 'fact_check', 'help' => 'Contaste el estante. El stock queda en lo contado.', 'qty' => 'Unidades contadas', 'color' => 'peer-checked:border-senal peer-checked:bg-senal-50', 'icolor' => 'text-senal-700'],
        ];
        $stockById = $products->pluck('stock', 'id');
    @endphp

    <a href="{{ route('movements.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-gris hover:text-petroleo">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Movimientos
    </a>
    <h1 class="page-title mt-3">Registrar movimiento</h1>
    <p class="page-lead">Queda guardado con tu nombre y la hora.</p>

    @if ($errors->any())
        <div class="notice-error mt-6 max-w-3xl" role="alert"><span class="material-symbols-outlined">error</span>{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('movements.store') }}" method="POST" class="mt-8 max-w-3xl space-y-6"
          x-data="{ type: '{{ old('type', 'in') }}', product: '{{ old('product_id') }}', stock: @js($stockById) }">
        @csrf

        <!-- Tipo de movimiento: tres opciones grandes, fáciles de tocar en celular -->
        <fieldset>
            <legend class="field-label">¿Qué pasó?</legend>
            <div class="mt-2 grid sm:grid-cols-3 gap-3">
                @foreach ($types as $value => $t)
                    <label class="relative cursor-pointer">
                        <input type="radio" name="type" value="{{ $value }}" x-model="type" aria-label="{{ $t['label'] }}" class="peer sr-only" @checked(old('type', 'in') === $value)>
                        <span class="flex h-full flex-col gap-1 p-4 rounded-md border-2 border-linea bg-white transition-colors hover:border-petroleo-300 peer-focus-visible:ring-2 peer-focus-visible:ring-senal {{ $t['color'] }}">
                            <span class="flex items-center gap-2 font-display font-bold text-xl">
                                <span class="material-symbols-outlined {{ $t['icolor'] }}">{{ $t['icon'] }}</span>
                                {{ $t['label'] }}
                            </span>
                            <span class="text-sm text-gris">{{ $t['help'] }}</span>
                        </span>
                    </label>
                @endforeach
            </div>
        </fieldset>

        <div class="panel p-5 sm:p-8 grid sm:grid-cols-2 gap-5">
            <div class="sm:col-span-2">
                <label for="product_id" class="field-label">Producto</label>
                <select id="product_id" name="product_id" x-model="product" required class="field">
                    <option value="" disabled @selected(! old('product_id'))>Elige un producto</option>
                    @foreach ($products as $p)
                        <option value="{{ $p->id }}" @selected(old('product_id') == $p->id)>{{ $p->sku }} · {{ $p->name }}</option>
                    @endforeach
                </select>
                <p class="field-hint" x-show="product" x-cloak>
                    Hay <strong class="text-petroleo" x-text="stock[product]"></strong> unidades en bodega.
                </p>
            </div>

            <div>
                <label for="quantity" class="field-label">
                    @foreach ($types as $value => $t)
                        <span x-show="type === '{{ $value }}'" @if ($value !== old('type', 'in')) x-cloak @endif>{{ $t['qty'] }}</span>
                    @endforeach
                </label>
                <input id="quantity" type="number" name="quantity" value="{{ old('quantity') }}" required
                       :min="type === 'adjustment' ? 0 : 1" :max="type === 'out' && product ? stock[product] : null" min="0" inputmode="numeric"
                       class="field font-display text-2xl">
                <p class="field-hint" x-show="type === 'out' && product" x-cloak>
                    Máximo <span x-text="stock[product]"></span>.
                </p>
            </div>

            <div>
                <label for="reference_note" class="field-label">Nota <span class="font-normal text-gris">(opcional)</span></label>
                <input id="reference_note" type="text" name="reference_note" value="{{ old('reference_note') }}" placeholder="Ej. Factura 1042, despacho sede norte" class="field">
            </div>
        </div>

        <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
            <a href="{{ route('movements.index') }}" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">Registrar movimiento</button>
        </div>
    </form>
</x-app-layout>

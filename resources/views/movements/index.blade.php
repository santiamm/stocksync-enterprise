<x-app-layout>
    <x-slot:title>Movimientos</x-slot>

    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-5">
        <div>
            <h1 class="page-title">Movimientos</h1>
            <p class="page-lead">Historial de entradas, salidas y conteos físicos, con quién los registró.</p>
        </div>
        <a href="{{ route('movements.create') }}" class="btn-primary">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Registrar movimiento
        </a>
    </div>

    @if (session('success'))
        <div class="notice-ok mt-6" role="status"><span class="material-symbols-outlined">check_circle</span>{{ session('success') }}</div>
    @endif

    <div class="mt-6 flex flex-wrap gap-x-6 gap-y-2 text-sm text-gris">
        <span><span class="font-display font-bold text-lg text-entrada">+</span> entrada: suma al stock</span>
        <span><span class="font-display font-bold text-lg text-salida">−</span> salida: resta del stock</span>
        <span><span class="font-display font-bold text-lg text-senal-700">=</span> conteo: el stock queda en ese número</span>
    </div>

    <div class="panel mt-3 overflow-x-auto">
        <table class="w-full min-w-[720px]">
            <thead>
                <tr>
                    <th class="table-head">Fecha</th>
                    <th class="table-head">Producto</th>
                    <th class="table-head">Tipo</th>
                    <th class="table-head text-right">Cantidad</th>
                    <th class="table-head">Registró</th>
                    <th class="table-head">Nota</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($movements as $movement)
                    <tr class="hover:bg-concreto/50">
                        <td class="table-cell whitespace-nowrap">
                            <p class="font-semibold">{{ $movement->created_at->format('d/m/Y') }}</p>
                            <p class="text-sm text-gris">{{ $movement->created_at->format('g:i a') }}</p>
                        </td>
                        <td class="table-cell">
                            <p class="font-semibold">{{ $movement->product->name }}</p>
                            <span class="rack mt-1">{{ $movement->product->sku }}</span>
                        </td>
                        <td class="table-cell">
                            @if ($movement->type === 'in')
                                <span class="tag-in">Entrada</span>
                            @elseif ($movement->type === 'out')
                                <span class="tag-out">Salida</span>
                            @else
                                <span class="tag-adjust">Conteo físico</span>
                            @endif
                        </td>
                        <td class="table-cell text-right">@include('movements.partials.quantity', ['movement' => $movement])</td>
                        <td class="table-cell whitespace-nowrap">{{ $movement->user->name ?? 'Sistema' }}</td>
                        <td class="table-cell text-gris">{{ $movement->reference_note ?: '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-10 text-center">
                            <p class="font-semibold">Aún no hay movimientos.</p>
                            <p class="mt-1 text-gris">Cuando llegue o salga mercancía, regístrala aquí.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>

{{-- Cantidad de un movimiento con su signo: + entra, − sale, = conteo físico --}}
@if ($movement->type === 'in')
    <span class="shrink-0 font-display font-bold text-xl text-entrada" title="Entrada">+{{ $movement->quantity }}</span>
@elseif ($movement->type === 'out')
    <span class="shrink-0 font-display font-bold text-xl text-salida" title="Salida">−{{ $movement->quantity }}</span>
@else
    <span class="shrink-0 font-display font-bold text-xl text-senal-700" title="Ajuste por conteo: quedó en {{ $movement->quantity }}">={{ $movement->quantity }}</span>
@endif

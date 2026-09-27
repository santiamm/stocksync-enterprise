<x-app-layout>
    <div class="flex flex-col gap-space-lg pb-space-xl pt-6">
        
        <!-- CABECERA: Auditoría y Conciliación -->
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-space-md mb-6">
            <div class="flex flex-col gap-space-xs max-w-2xl">
                <div class="flex items-center gap-space-xs">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-semibold">Módulo de Control de Existencias</span>
                </div>
                <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight leading-tight">Auditoría y Movimientos</h1>
                <p class="font-body-md text-body-md text-on-surface-variant">
                    Supervisión de conteos físicos, detección de mermas y registro de entradas y salidas.
                </p>
            </div>
            
            <div class="flex flex-wrap items-center gap-space-xs">
                <!-- Botón Principal: Registrar Movimiento -->
                <a href="{{ route('movements.create') }}" class="h-10 px-space-md bg-primary hover:bg-primary-container text-white font-label-md text-label-md rounded-lg flex items-center gap-space-xs transition-colors shadow-sm font-semibold">
                    <span class="material-symbols-outlined text-[18px]">add_circle</span>
                    <span>Registrar Nuevo Movimiento</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- TARJETAS DE MÉTRICAS RÁPIDAS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-semibold uppercase tracking-wider mb-1">Total Registros</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $movements->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                    <span class="material-symbols-outlined text-[24px]">receipt_long</span>
                </div>
            </div>
        </div>

        <!-- TABLA PRINCIPAL DE MOVIMIENTOS -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="py-4 px-6 text-sm font-semibold text-gray-600">Fecha</th>
                            <th class="py-4 px-6 text-sm font-semibold text-gray-600">Operario</th>
                            <th class="py-4 px-6 text-sm font-semibold text-gray-600">Producto</th>
                            <th class="py-4 px-6 text-sm font-semibold text-gray-600 text-center">Tipo</th>
                            <th class="py-4 px-6 text-sm font-semibold text-gray-600 text-right">Cantidad</th>
                            <th class="py-4 px-6 text-sm font-semibold text-gray-600">Nota/Referencia</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($movements as $movement)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-6 text-sm text-gray-500">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                                <td class="py-4 px-6 text-sm font-medium text-gray-900">{{ $movement->user->name ?? 'Sistema' }}</td>
                                <td class="py-4 px-6 text-sm text-gray-900">{{ $movement->product->name }}</td>
                                <td class="py-4 px-6 text-center">
                                    @if($movement->type === 'in')
                                        <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full">Entrada</span>
                                    @elseif($movement->type === 'out')
                                        <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full">Salida</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full">Ajuste / Conteo</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right font-bold text-gray-900">{{ $movement->quantity }}</td>
                                <td class="py-4 px-6 text-sm text-gray-500">{{ $movement->reference_note ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-gray-500">No hay movimientos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
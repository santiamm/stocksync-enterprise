<x-app-layout>
    <div class="w-full max-w-7xl mx-auto flex flex-col gap-8 pb-12 pt-6">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div>
                <div class="flex items-center gap-2 text-primary font-bold text-xs tracking-widest uppercase mb-1">
                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    {{ __('messages.real_time_monitor') }}
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">{{ __('messages.op_summary') }}</h1>
                <p class="text-sm text-gray-500 mt-1">{{ __('messages.op_desc') }}</p>
            </div>
            
            <a href="{{ route('products.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary hover:bg-primary-container text-white rounded-lg font-semibold whitespace-nowrap transition-colors shadow-sm w-full sm:w-auto">
                <span class="material-symbols-outlined text-[20px]">add_box</span>
                {{ __('messages.quick_load') }}
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col gap-3 overflow-hidden">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">monetization_on</span>
                    </div>
                    <span class="font-bold text-gray-500 text-xs uppercase tracking-wider truncate">{{ __('messages.capital') }}</span>
                </div>
                <div class="text-2xl font-black text-gray-900 truncate" title="${{ number_format($totalValue, 2) }}">
                    ${{ number_format($totalValue, 2) }}
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col gap-3 overflow-hidden">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">inventory</span>
                    </div>
                    <span class="font-bold text-gray-500 text-xs uppercase tracking-wider truncate">{{ __('messages.catalog') }}</span>
                </div>
                <div class="flex items-baseline gap-1 truncate text-gray-900">
                    <span class="text-2xl font-black">{{ number_format($totalProducts) }}</span>
                    <span class="text-xs text-gray-400 font-medium">{{ __('messages.items') }}</span>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col gap-3 overflow-hidden">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">layers</span>
                    </div>
                    <span class="font-bold text-gray-500 text-xs uppercase tracking-wider truncate">{{ __('messages.volume') }}</span>
                </div>
                <div class="flex items-baseline gap-1 truncate text-gray-900">
                    <span class="text-2xl font-black">{{ number_format($totalStock) }}</span>
                    <span class="text-xs text-gray-400 font-medium">{{ __('messages.units') }}</span>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col gap-3 overflow-hidden">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">error_outline</span>
                    </div>
                    <span class="font-bold text-gray-500 text-xs uppercase tracking-wider truncate">{{ __('messages.alerts') }}</span>
                </div>
                <div class="flex items-baseline gap-1 truncate {{ $criticalProducts->count() > 0 ? 'text-red-600' : 'text-gray-900' }}">
                    <span class="text-2xl font-black">{{ $criticalProducts->count() }}</span>
                    <span class="text-xs {{ $criticalProducts->count() > 0 ? 'text-red-500' : 'text-gray-400' }} font-medium">{{ __('messages.in_risk') }}</span>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-2">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col overflow-hidden min-w-0">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h2 class="font-bold text-gray-900 flex items-center gap-2 text-sm sm:text-base">
                        <span class="material-symbols-outlined text-red-500 text-[20px]">warning</span>
                        {{ __('messages.stockout_risk') }}
                    </h2>
                    <a href="{{ route('products.index') }}" class="text-sm font-semibold text-primary hover:underline">{{ __('messages.view_all') }}</a>
                </div>
                <div class="w-full overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead class="bg-gray-50 text-xs uppercase font-bold text-gray-500">
                            <tr>
                                <th class="px-6 py-3">{{ __('messages.product') }}</th>
                                <th class="px-6 py-3 text-right">{{ __('messages.stock') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($criticalProducts as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-3 font-medium text-gray-900">{{ $product->name }} <span class="block text-xs text-gray-400 font-mono">{{ $product->sku }}</span></td>
                                    <td class="px-6 py-3 text-right">
                                        <span class="font-bold text-red-600">{{ $product->stock }}</span> 
                                        <span class="text-gray-400 text-xs">/ {{ __('messages.min') }}: {{ $product->min_stock_alert }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-8 text-center text-gray-500">{{ __('messages.healthy_inv') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col overflow-hidden min-w-0">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h2 class="font-bold text-gray-900 flex items-center gap-2 text-sm sm:text-base">
                        <span class="material-symbols-outlined text-blue-500 text-[20px]">history</span>
                        {{ __('messages.recent_audit') }}
                    </h2>
                    <a href="{{ route('movements.index') }}" class="text-sm font-semibold text-primary hover:underline">{{ __('messages.go_history') }}</a>
                </div>
                <div class="w-full overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead class="bg-gray-50 text-xs uppercase font-bold text-gray-500">
                            <tr>
                                <th class="px-6 py-3">{{ __('messages.date') }}</th>
                                <th class="px-6 py-3">{{ __('messages.product') }}</th>
                                <th class="px-6 py-3 text-right">{{ __('messages.qty') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($recentMovements as $movement)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-3 text-gray-500">{{ $movement->created_at->format('d/m/Y') }}</td>
                                    <td class="px-6 py-3 font-medium text-gray-900">{{ $movement->product->name }}</td>
                                    <td class="px-6 py-3 text-right font-bold {{ $movement->type === 'in' ? 'text-green-600' : ($movement->type === 'out' ? 'text-red-600' : 'text-gray-900') }}">
                                        {{ $movement->type === 'in' ? '+' : ($movement->type === 'out' ? '-' : '') }}{{ $movement->quantity }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-gray-500">{{ __('messages.no_movements') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
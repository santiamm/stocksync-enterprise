<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Movimiento de Inventario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200 p-8">
                @if($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                        <p class="font-bold">Atención</p>
                        <p>{{ $errors->first() }}</p>
                    </div>
                @endif

                <form action="{{ route('movements.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Producto</label>
                            <select name="product_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="" disabled selected>Selecciona un producto...</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>{{ $product->name }} (Stock: {{ $product->stock }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipo de Movimiento</label>
                            <select name="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="in" @selected(old('type') === 'in')>Entrada (Llegada de mercancía)</option>
                                <option value="out" @selected(old('type') === 'out')>Salida (Venta/Merma)</option>
                                <option value="adjustment" @selected(old('type') === 'adjustment')>Ajuste Físico (cantidad contada)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cantidad</label>
                            <input type="number" name="quantity" value="{{ old('quantity') }}" required min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Nota de Referencia</label>
                            <input type="text" name="reference_note" value="{{ old('reference_note') }}" placeholder="Ej: Factura #123, Ajuste de inventario Q3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                         <button type="button" onclick="window.history.back()" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700 px-4 py-2">
                            Cancelar
                        </button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow">
                            Registrar Movimiento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
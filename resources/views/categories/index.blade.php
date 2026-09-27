<x-app-layout>
    <div class="flex flex-col gap-space-lg pb-space-xl pt-6">
        
        <!-- CABECERA: Jerarquía de Categorías -->
        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-space-md mb-6">
            <div class="flex flex-col gap-space-xs">
                <div class="flex items-center gap-space-xs">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-semibold bg-primary/10 px-2 py-0.5 rounded-full">Taxonomía de Suministros</span>
                </div>
                <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight">Estructura y Categorías</h1>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-3xl">
                    Organización taxonómica y agrupación de familias de productos en bodega.
                </p>
            </div>
            
            <div class="flex flex-wrap items-center gap-space-sm">
                <a href="{{ route('categories.create') }}" class="h-10 px-space-md bg-primary hover:bg-primary-container text-white font-label-md text-label-md rounded-lg flex items-center gap-space-xs shadow-md transition-all font-semibold">
                    <span class="material-symbols-outlined text-[18px]">add_circle</span>
                    <span>Nueva Categoría</span>
                </a>
            </div>
        </div>

        <!-- ALERTAS -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm" role="alert">
                <p class="font-bold">¡Hecho!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded shadow-sm" role="alert">
                <p class="font-bold">Atención</p>
                <p>{{ $errors->first() }}</p>
            </div>
        @endif

        <!-- TABLA -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="py-4 px-6 text-sm font-semibold text-gray-600">Nombre de la Categoría</th>
                            <th class="py-4 px-6 text-sm font-semibold text-gray-600">Descripción / Detalles</th>
                            <th class="py-4 px-6 text-sm font-semibold text-gray-600 text-center">Productos Asignados</th>
                            <th class="py-4 px-6 text-sm font-semibold text-gray-600 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500">
                                            <span class="material-symbols-outlined text-[18px]">folder</span>
                                        </div>
                                        <span class="font-semibold text-gray-900">{{ $category->name }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-500">
                                    {{ $category->description ?? 'Sin descripción adicional' }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold font-mono">
                                        {{ $category->products_count }} SKUs
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar la categoría {{ $category->name }}?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors" title="Eliminar">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-gray-500">No hay categorías. Crea una usando el botón de arriba.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
<x-app-layout>
    <x-slot:title>Categorías</x-slot>

    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-5">
        <div>
            <h1 class="page-title">Categorías</h1>
            <p class="page-lead">Agrupan los productos por tipo. Una categoría con productos no se puede eliminar.</p>
        </div>
        <a href="{{ route('categories.create') }}" class="btn-primary">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Nueva categoría
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

    <ul class="mt-6 grid sm:grid-cols-2 gap-4">
        @forelse ($categories as $category)
            <li class="panel p-5 flex gap-4">
                <div class="min-w-0 flex-1">
                    <h2 class="font-display font-semibold text-2xl leading-tight">{{ $category->name }}</h2>
                    <p class="mt-1 text-gris">{{ $category->description ?: 'Sin descripción.' }}</p>
                    <p class="mt-3 text-sm font-semibold">
                        {{ $category->products_count }} {{ $category->products_count === 1 ? 'producto' : 'productos' }}
                    </p>
                </div>
                @if ($category->products_count === 0)
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="shrink-0"
                          onsubmit="return confirm('¿Eliminar la categoría {{ $category->name }}?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-md text-salida hover:bg-salida-50" title="Eliminar {{ $category->name }}">
                            <span class="material-symbols-outlined text-[20px]">delete</span>
                            <span class="sr-only">Eliminar {{ $category->name }}</span>
                        </button>
                    </form>
                @endif
            </li>
        @empty
            <li class="panel p-10 text-center sm:col-span-2">
                <p class="font-semibold">Todavía no hay categorías.</p>
                <p class="mt-1 text-gris">Crea la primera antes de agregar productos.</p>
            </li>
        @endforelse
    </ul>
</x-app-layout>

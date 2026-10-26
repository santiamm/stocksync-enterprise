<x-app-layout>
    <x-slot:title>Nueva categoría</x-slot>

    <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-gris hover:text-petroleo">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Categorías
    </a>
    <h1 class="page-title mt-3">Nueva categoría</h1>
    <p class="page-lead">Por ejemplo: Ferretería, Electrónica o Insumos médicos.</p>

    @if ($errors->any())
        <div class="notice-error mt-6 max-w-2xl" role="alert"><span class="material-symbols-outlined">error</span>{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST" class="mt-8 max-w-2xl space-y-6">
        @csrf
        <div class="panel p-5 sm:p-8 space-y-5">
            <div>
                <label for="name" class="field-label">Nombre</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required placeholder="Ej. Electrónica" class="field">
            </div>
            <div>
                <label for="description" class="field-label">Descripción <span class="font-normal text-gris">(opcional)</span></label>
                <textarea id="description" name="description" rows="3" placeholder="Qué tipo de productos van aquí" class="field h-auto">{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
            <a href="{{ route('categories.index') }}" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">Crear categoría</button>
        </div>
    </form>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-slate-900 leading-tight tracking-tight">
                Añadir Categoría
            </h2>
            <a href="{{ route('categories.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700 transition">
                &larr; Volver
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="shadow-sm ring-1 ring-slate-200 sm:rounded-2xl bg-white p-6 sm:p-8">
                    <div class="grid grid-cols-1 gap-6">
                        
                        <div>
                            <label class="block text-sm font-semibold text-slate-900">Nombre de la Categoría</label>
                            <input type="text" name="name" required placeholder="Ej. Electrónica" class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-colors">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-900">Descripción (Opcional)</label>
                            <textarea name="description" rows="3" placeholder="Breve descripción de los artículos en esta categoría..." class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-colors"></textarea>
                        </div>

                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" onclick="window.history.back()" class="text-sm font-bold text-slate-600 hover:text-slate-900 px-4 py-2 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-200 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all">
                            Guardar Categoría
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
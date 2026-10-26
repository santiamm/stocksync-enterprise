<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' · ' : '' }}StockSync</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600;700&family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..24,400,0,0&display=block" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ menu: false }" @keydown.escape.window="menu = false">
    @php
        $links = [
            ['route' => 'dashboard', 'match' => 'dashboard', 'icon' => 'space_dashboard', 'label' => 'Resumen'],
            ['route' => 'products.index', 'match' => 'products.*', 'icon' => 'inventory_2', 'label' => 'Inventario'],
            ['route' => 'movements.index', 'match' => 'movements.*', 'icon' => 'swap_vert', 'label' => 'Movimientos'],
            ['route' => 'categories.index', 'match' => 'categories.*', 'icon' => 'category', 'label' => 'Categorías'],
        ];
    @endphp

    <!-- Barra superior en celular -->
    <header class="lg:hidden sticky top-0 z-30 flex items-center justify-between h-14 px-4 bg-petroleo text-white">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <x-application-logo class="w-7 h-7 text-senal" />
            <span class="font-display font-bold text-2xl tracking-tight">StockSync</span>
        </a>
        <button type="button" @click="menu = true" class="flex items-center gap-1 h-10 px-3 rounded-md hover:bg-petroleo-600" aria-label="Abrir menú">
            <span class="material-symbols-outlined">menu</span>
        </button>
    </header>

    <!-- Fondo oscuro detrás del menú en celular -->
    <div x-cloak x-show="menu" x-transition.opacity @click="menu = false" class="lg:hidden fixed inset-0 z-40 bg-petroleo/60"></div>

    <!-- Menú lateral: fijo en PC, desplegable en celular -->
    <aside :class="menu ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-50 w-64 flex flex-col bg-petroleo text-white transition-transform duration-200 lg:translate-x-0">
        <div class="flex items-center justify-between h-16 px-5">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                <x-application-logo class="w-8 h-8 text-senal" />
                <span class="font-display font-bold text-[1.75rem] tracking-tight">StockSync</span>
            </a>
            <button type="button" @click="menu = false" class="lg:hidden h-10 w-10 flex items-center justify-center rounded-md hover:bg-petroleo-600" aria-label="Cerrar menú">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <nav class="flex-1 mt-4 px-3 space-y-1">
            @foreach ($links as $link)
                @php $active = request()->routeIs($link['match']); @endphp
                <a href="{{ route($link['route']) }}"
                   @if ($active) aria-current="page" @endif
                   class="relative flex items-center gap-3 h-11 pl-4 pr-3 rounded-md font-semibold transition-colors {{ $active ? 'bg-petroleo-600 text-white' : 'text-petroleo-300 hover:text-white hover:bg-petroleo-600/60' }}">
                    @if ($active)
                        <span class="absolute left-0 top-2 bottom-2 w-1 rounded-r bg-senal"></span>
                    @endif
                    <span class="material-symbols-outlined text-[22px]">{{ $link['icon'] }}</span>
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="m-3 p-3 rounded-md bg-petroleo-600/60">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 shrink-0 rounded-full bg-senal text-petroleo font-display font-bold text-lg flex items-center justify-center">
                    {{ mb_substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="min-w-0 flex-1">
                    <a href="{{ route('profile.edit') }}" class="block text-sm font-semibold truncate hover:underline">{{ Auth::user()->name }}</a>
                    <span class="block text-xs text-petroleo-300 truncate">{{ Auth::user()->email }}</span>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 h-9 rounded-md text-sm font-semibold text-petroleo-300 hover:text-white hover:bg-petroleo">
                    <span class="material-symbols-outlined text-[20px]">logout</span>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    <main class="lg:pl-64">
        <div class="max-w-6xl mx-auto px-4 sm:px-8 py-8 sm:py-10">
            {{ $slot }}
        </div>
    </main>
</body>
</html>

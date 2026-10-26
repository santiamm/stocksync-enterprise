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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="min-h-screen lg:grid lg:grid-cols-[minmax(0,5fr)_minmax(0,6fr)]">

        <!-- Lado de marca -->
        <section class="relative overflow-hidden bg-petroleo text-white px-6 py-8 sm:px-10 lg:py-14 lg:flex lg:flex-col lg:justify-between">
            <!-- Franjas de estantería al fondo -->
            <div class="hidden lg:block absolute inset-x-0 bottom-0 h-1/2 opacity-[0.07]"
                 style="background-image: repeating-linear-gradient(to bottom, transparent 0 86px, #fff 86px 92px);"></div>

            <a href="{{ route('login') }}" class="relative flex items-center gap-3">
                <x-application-logo class="w-10 h-10 text-senal" />
                <span class="font-display font-bold text-4xl tracking-tight">StockSync</span>
            </a>

            <div class="relative hidden lg:block max-w-md">
                <p class="font-display font-semibold text-5xl leading-[1.05]">
                    Cada caja que entra o sale queda anotada.
                </p>
                <p class="mt-5 text-lg text-petroleo-300">
                    Inventario de bodega con entradas, salidas, conteos físicos y alertas de stock mínimo.
                </p>
            </div>

            <p class="relative hidden lg:block text-sm text-petroleo-300">Proyecto académico · UTS</p>
        </section>

        <!-- Formulario -->
        <section class="flex items-start lg:items-center justify-center px-4 py-10 sm:px-10">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </section>
    </div>
</body>
</html>

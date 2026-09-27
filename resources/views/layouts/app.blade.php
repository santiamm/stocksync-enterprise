<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'StockSync Enterprise') }}</title>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600&family=Hanken+Grotesk:wght@500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <style>
        html, body { margin: 0; padding: 0; height: 100%; overflow: hidden; background-color: #f4f7fb; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body-md text-gray-700 antialiased flex h-screen w-full overflow-hidden">
    
    <aside class="w-72 bg-white flex flex-col shadow-[1px_0_10px_rgba(0,0,0,0.03)] z-50 shrink-0 border-r border-gray-200">
        <div class="h-20 flex items-center gap-3 px-6 border-b border-gray-100 shrink-0">
            <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center text-white shadow-md">
                <span class="material-symbols-outlined">inventory</span>
            </div>
            <div class="flex flex-col">
                <span class="text-xl text-gray-900 font-extrabold tracking-tight">StockSync</span>
                <span class="text-[10px] text-primary tracking-widest uppercase font-bold">{{ __('messages.enterprise') }}</span>
            </div>
        </div>
        
        <div class="px-6 mt-6 mb-2 shrink-0">
            <span class="text-xs uppercase tracking-widest text-gray-400 font-bold">{{ __('messages.main_menu') }}</span>
        </div>
        
        <nav class="flex-1 overflow-y-auto flex flex-col gap-2 px-4 py-2">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg font-semibold transition-colors {{ request()->routeIs('dashboard') ? 'bg-primary/10 text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <span class="material-symbols-outlined">dashboard</span>
                {{ __('messages.dashboard') }}
            </a>
            
            <a href="{{ route('products.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg font-semibold transition-colors {{ request()->routeIs('products.*') ? 'bg-primary/10 text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <span class="material-symbols-outlined">inventory_2</span>
                {{ __('messages.inventory') }}
            </a>
            
            <a href="{{ route('movements.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg font-semibold transition-colors {{ request()->routeIs('movements.*') ? 'bg-primary/10 text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <span class="material-symbols-outlined">fact_check</span>
                {{ __('messages.audit') }}
            </a>
            
            <a href="{{ route('categories.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg font-semibold transition-colors {{ request()->routeIs('categories.*') ? 'bg-primary/10 text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <span class="material-symbols-outlined">account_tree</span>
                {{ __('messages.categories') }}
            </a>
        </nav>
        
        <div class="p-4 border-t border-gray-100 shrink-0">
            <div class="flex items-center gap-3 px-3 py-2">
                <div class="w-9 h-9 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 font-bold shrink-0">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="flex flex-col flex-1 overflow-hidden">
                    <span class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name ?? __('messages.admin') }}</span>
                    <span class="text-xs text-gray-500 truncate">{{ __('messages.operator') }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors" title="{{ __('messages.logout') }}">
                        <span class="material-symbols-outlined text-[20px]">logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div class="flex-1 flex flex-col h-full min-w-0 bg-[#f4f7fb]">
        <header class="h-20 bg-white shadow-sm z-40 px-8 flex items-center justify-between shrink-0 border-b border-gray-200">
            <div class="flex-1 max-w-xl">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">search</span>
                    <input class="w-full h-10 pl-10 pr-4 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary transition-all" placeholder="{{ __('messages.search') }}" type="text"/>
                </div>
            </div>
            
            <div class="flex items-center gap-6 ml-4">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                    <span class="text-xs font-bold text-gray-500 tracking-wider uppercase hidden md:block">{{ __('messages.online_system') }}</span>
                </div>
                <div class="w-[1px] h-8 bg-gray-200"></div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('lang.switch', 'es') }}" class="font-bold text-sm {{ app()->getLocale() == 'es' || !session()->has('locale') ? 'text-primary' : 'text-gray-400 hover:text-gray-600' }}">ES</a>
                    <span class="text-gray-300">|</span>
                    <a href="{{ route('lang.switch', 'en') }}" class="font-bold text-sm {{ app()->getLocale() == 'en' ? 'text-primary' : 'text-gray-400 hover:text-gray-600' }}">EN</a>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto flex flex-col">
            <div class="flex-1 p-6 sm:p-8 w-full">
                {{ $slot }}
            </div>
            
            <footer class="w-full px-8 py-6 border-t border-gray-200 bg-white shrink-0 mt-auto">
                <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-500">
                    <div class="font-medium">
                        &copy; {{ date('Y') }} StockSync Enterprise. {{ __('messages.rights') }}
                    </div>
                    <div class="flex flex-wrap gap-4 md:gap-6">
                        <a href="#" class="hover:text-primary transition-colors font-medium">{{ __('messages.support') }}</a>
                        <a href="#" class="hover:text-primary transition-colors font-medium">{{ __('messages.terms') }}</a>
                        <a href="#" class="hover:text-primary transition-colors font-medium">{{ __('messages.privacy') }}</a>
                    </div>
                </div>
            </footer>
        </main>
    </div>
</body>
</html>
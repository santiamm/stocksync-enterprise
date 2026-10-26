<x-guest-layout>
    <x-slot:title>Iniciar sesión</x-slot>

    <h1 class="page-title">Iniciar sesión</h1>
    <p class="page-lead">Entra con tu correo para registrar movimientos de bodega.</p>

    <x-auth-session-status class="mt-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="Correo" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <div class="flex items-baseline justify-between">
                <x-input-label for="password" value="Contraseña" />
                @if (Route::has('password.request'))
                    <a class="text-sm text-gris hover:text-petroleo underline underline-offset-4" href="{{ route('password.request') }}">¿La olvidaste?</a>
                @endif
            </div>
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <label for="remember_me" class="flex items-center gap-2 text-sm text-gris">
            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-linea text-petroleo focus:ring-petroleo">
            Mantener la sesión abierta
        </label>

        <x-primary-button class="w-full">Entrar</x-primary-button>
    </form>

    @if (Route::has('register'))
        <p class="mt-8 pt-6 border-t border-linea text-sm text-gris">
            ¿No tienes cuenta? <a href="{{ route('register') }}" class="link-action">Crear una cuenta</a>
        </p>
    @endif
</x-guest-layout>

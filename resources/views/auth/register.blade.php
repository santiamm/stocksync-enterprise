<x-guest-layout>
    <x-slot:title>Crear cuenta</x-slot>

    <h1 class="page-title">Crear cuenta</h1>
    <p class="page-lead">Tu nombre aparecerá en cada movimiento que registres.</p>

    <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
        @csrf

        <div>
            <x-input-label for="name" value="Nombre" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="Correo" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="password" value="Contraseña" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />
            <p class="field-hint">Mínimo 8 caracteres.</p>
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Repite la contraseña" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <x-primary-button class="w-full">Crear cuenta</x-primary-button>
    </form>

    <p class="mt-8 pt-6 border-t border-linea text-sm text-gris">
        ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="link-action">Iniciar sesión</a>
    </p>
</x-guest-layout>

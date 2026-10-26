<x-app-layout>
    <x-slot:title>Mi cuenta</x-slot>

    <h1 class="page-title">Mi cuenta</h1>
    <p class="page-lead">Tus datos de acceso. El nombre es el que aparece en el historial de movimientos.</p>

    <div class="mt-8 space-y-6 max-w-3xl">
        <div class="panel p-5 sm:p-8">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="panel p-5 sm:p-8">
            @include('profile.partials.update-password-form')
        </div>

        <div class="panel p-5 sm:p-8 border-salida/30">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>

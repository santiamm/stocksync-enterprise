@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'notice-ok text-sm']) }}>
        {{ $status }}
    </div>
@endif

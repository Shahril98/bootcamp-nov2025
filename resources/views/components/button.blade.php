@props([
    'variant' => 'primary',
    'buttonType' => 'submit',
    'type' => 'button',
])

@php
    $styleClasses = \Illuminate\Support\Arr::toCssClasses([
        'inline-flex items-center justify-center font-medium rounded-lg px-4 py-2
         focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors',
        match ($variant) {
            'primary' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
            'success' => 'bg-green-600 hover:bg-green-700 focus:ring-green-500',
            'danger' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500',
            'default' => 'bg-gray-600 hover:bg-gray-700 focus:ring-gray-500',
        },
    ]);
@endphp

<button type="{{ $type }}" {{ $attributes->class($styleClasses) }}>
    {{ $slot }}
</button>

{{-- <{{ $tag }} {{ $attributes->merge(['class' => $styleClasses]) }}>
    {{ $slot }}
    </{{ $tag }}> --}}

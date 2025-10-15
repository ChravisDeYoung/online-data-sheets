@props(['variant' => 'primary'])

@php
    $baseClasses = 'focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center';

    $variantClasses = [
        'primary' => 'text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800',
        'secondary' => 'text-gray-900 bg-white hover:bg-gray-100 focus:ring-gray-300 border border-gray-300 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-600',
    ];

    $classes = $baseClasses . ' ' . ($variantClasses[$variant] ?? $variantClasses['primary']);
@endphp

@if ($attributes->has('href'))
    {{-- this is a link --}}
    <a href="{{ $attributes->get('href') }}"
        {{ $attributes->except('href')->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    {{-- this is a button --}}
    <button type="submit"
        {{ $attributes->merge(['class' => $classes]) }}
    >
        {{ $slot }}
    </button>
@endif


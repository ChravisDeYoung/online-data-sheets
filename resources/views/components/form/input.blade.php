@props(['name', 'label' => $name, 'errorName' => $name])
<div>
    <x-form.label name="{{ $label }}"/>

    @if ($attributes['type'] === 'checkbox')
        <input
            class="w-6 h-6 text-blue-600 bg-gray-50 border-gray-300 rounded-md focus:ring-blue-600 dark:focus:ring-blue-500 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
            name="{{ $name }}"
            id="{{ $name }}"
            {{ $attributes }}
        >
    @else
        <input
            class="bg-gray-50 border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            name="{{ $name }}"
            id="{{ $name }}"
            {{ $attributes(['value' => old($name)]) }}
        >
    @endif

    <x-form.error name="{{ $errorName }}"/>
</div>

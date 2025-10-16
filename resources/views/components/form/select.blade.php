@props(['name'])

<div>
    <x-form.label name="{{ $name }}"/>

    <select id="{{ $name }}" name="{{ $name }}"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" {{ $attributes(['value' => old($name)]) }}>
        {{ $slot }}
    </select>

    {{--    <input--}}
    {{--        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"--}}
    {{--        name="{{ $name }}"--}}
    {{--        id="{{ $name }}"--}}
    {{--        {{ $attributes(['value' => old($name)]) }}--}}
    {{--    >--}}

    <x-form.error name="{{ $name }}"/>
</div>

@props(['title'])

<section class="p-3 mx-auto max-w-2xl sm:p-5">
    <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">{{ $title }}</h2>

    {{ $slot }}
</section>

@props(['title' => null])

<section {{ $attributes->merge(['class' => 'bg-gray-50 dark:bg-gray-900 p-3 sm:p-5']) }}>
    <div class="mx-auto max-w-screen-xl">
        @if (! empty($title))
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
                {{ $title }}
            </h2>
        @endif

        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
            {{ $slot }}
        </div>
    </div>
</section>


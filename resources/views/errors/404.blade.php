<x-layout>
    <x-form.wrapper>
        <x-slot name="title">
            404
        </x-slot>

        <p class="text-sm font-medium text-gray-900 dark:text-white">
            {{ optional($exception ?? null)->getMessage() ?: 'The page you are looking for does not exist.' }}
        </p>

        <div class="mt-4 sm:mt-6">
            <x-form.button :href="route('dashboards.index')" variant="secondary">Take me back</x-form.button>
        </div>
    </x-form.wrapper>
</x-layout>

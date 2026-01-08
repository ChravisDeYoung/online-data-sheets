<x-layout>
    <section class="p-3 mx-auto max-w-2xl sm:p-5">
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
            Field Data Out of Range Notification
        </h2>

        <div class="grid grid-col-1 gap-4 md:grid-cols-2 sm:gap-6">
            <p class="block mb-2 text-sm font-medium text-gray-900 col-span-2 dark:text-white">
                {{ $notification->data['message'] }}
            </p>

            <p class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Date: <span
                    class="text-blue-600 dark:text-blue-600 font-bold">{{ $notification->data['page_date'] }}</span>
            </p>

            <p class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Page: <a href="{{ route('pages.show', [$page, 'date' => $notification->data['page_date']]) }}"
                         class="text-blue-600 dark:text-blue-600 font-bold underline">{{ $page->name }}</a>
            </p>

            <p class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Subsection: <span
                    class="text-blue-600 dark:text-blue-600 font-bold">{{ $field->subsection }}</span>
            </p>

            <p class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Field: <span
                    class="text-blue-600 dark:text-blue-600 font-bold">{{ $field->name }}</span>
            </p>

            <p class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Minimum: <span
                    class="text-blue-600 dark:text-blue-600 font-bold">{{ $notification->data['minimum'] ?? 'N/A' }}</span>
            </p>

            <p class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Maximum: <span
                    class="text-blue-600 dark:text-blue-600 font-bold">{{ $notification->data['maximum'] ?? 'N/A' }}</span>
            </p>

            <p class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Value: <span
                    class="text-blue-600 dark:text-blue-600 font-bold">{{ $notification->data['value'] }}</span>
            </p>
        </div>
    </section>
</x-layout>


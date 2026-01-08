@props(['modalId' => 'default-modal', 'title'])

<div id="{{ $modalId }}" tabindex="-1" aria-hidden="true"
     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div
        class="relative w-full max-w-4xl max-h-full bg-white shadow dark:border dark:bg-gray-800 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white">
        <div class="relative">
            <div
                class="flex items-center justify-between p-4">
                <h3 class="text-xl font-semibold">
                    {{ $title }}
                </h3>

                <button type="button"
                        class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group"
                        data-modal-hide="{{ $modalId }}">
                    <svg
                        class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18 17.94 6M18 18 6.06 6"/>
                    </svg>

                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <div class="bg-gray-50 dark:bg-gray-900 rounded-b-lg p-4" id="modal-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

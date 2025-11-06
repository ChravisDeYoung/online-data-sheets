<x-layout>
    <div class="p-4">
        <div class="grid grid-cols-2 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @foreach ($dashboardTiles as $tile)
                <a href="{{ $tile->page ? '/pages/'.$tile->page->slug : '/dashboard/'. $tile->id }}"
                   class="flex items-center justify-center h-24 rounded-xl bg-white shadow hover:bg-gray-100 dark:border border-gray-400 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <p class="text-2xl p-5 overflow-hidden whitespace-nowrap overflow-ellipsis dark:text-white">
                        {{ $tile->title }}
                    </p>
                </a>
            @endforeach
        </div>
    </div>
</x-layout>

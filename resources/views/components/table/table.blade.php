@props(['headers' => [], 'center' => false])

<div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            @foreach ($headers as $header)
                <th scope="col" class="px-4 py-3 {{ $center ? 'text-center' : '' }}">{{ $header }}</th>
            @endforeach
        </tr>
        </thead>

        <tbody>
        {{ $slot }}
        </tbody>
    </table>
</div>

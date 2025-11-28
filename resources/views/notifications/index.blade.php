<x-layout>
    <x-table.wrapper>
        <x-slot name="title">Notifications</x-slot>

        <x-table.header></x-table.header>

        <x-table.table :headers="['', '', '', '']">
            @foreach ($notifications as $notification)
                <x-table.row :dropdown-id="'notification-' . $notification->id . '-dropdown'">
                    <x-table.cell colspan="3"
                                  class="overflow-hidden text-ellipsis"
                                  :header="$notification->read_at === null">{{ $notification->data['message'] }}</x-table.cell>
                    <x-slot name="actions">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                            <li>
                                <a href="{{ route('notifications.show', $notification) }}"
                                   class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    View
                                </a>
                            </li>
                        </ul>
                    </x-slot>
                </x-table.row>
            @endforeach
        </x-table.table>

        <x-table.pagination :paginator="$notifications"/>
    </x-table.wrapper>
</x-layout>

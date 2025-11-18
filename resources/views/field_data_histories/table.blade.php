<x-table.wrapper>
    <x-table.table :headers="['Value', 'Date', 'User']">
        @foreach($fieldDataHistories as $fieldDataHistory)
            <x-table.row>
                <x-table.cell>{{ $fieldDataHistory->new_value }}</x-table.cell>
                <x-table.cell>{{ $fieldDataHistory->created_at }}</x-table.cell>
                <x-table.cell>{{ $fieldDataHistory->user->full_name }}</x-table.cell>
            </x-table.row>
        @endforeach
    </x-table.table>

    <x-table.pagination :paginator="$fieldDataHistories"/>
</x-table.wrapper>

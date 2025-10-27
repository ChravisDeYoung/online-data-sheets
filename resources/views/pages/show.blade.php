@php use App\Models\Field; @endphp

<x-layout>
    <x-table.wrapper>
        <x-slot name="title">{{ $page->name }} - 2001-01-01</x-slot>

        @php
            $headers = array_merge(['Name'], array_map(fn($i) => "Round $i", range(1, $page->column_count)));
        @endphp

        <x-table.table :headers="$headers" :center="true">
            @php $currentSubsection = null; @endphp

            @foreach ($page->fields as $field)
                @if ($currentSubsection !== $field->subsection)
                    @php $currentSubsection = $field->subsection; @endphp
                    <x-table.row class="bg-gray-200 dark:bg-gray-700">
                        <x-table.cell :header="true" colspan="2" class="p-2 font-semibold text-xl">
                            {{ $currentSubsection ?? 'General' }}
                        </x-table.cell>
                    </x-table.row>
                @endif

                <x-table.row>
                    <x-table.row>
                        <x-table.cell class="p-0 flex justify-between items-center text-gray-700 dark:text-gray-400">
                            {{ $field->name }}

                            @if (!is_null($field->minimum) && !is_null($field->maximum))
                                <span class="italic text-xs text-gray-700 dark:text-gray-400"> > {{ $field->minimum }} and < {{ $field->maximum }}</span>
                            @elseif (!is_null($field->minimum))
                                <span
                                    class="italic text-xs text-gray-700 dark:text-gray-400"> > {{ $field->minimum }}</span>
                            @elseif (!is_null($field->maximum))
                                <span
                                    class="italic text-xs text-gray-700 dark:text-gray-400"> < {{ $field->maximum }}</span>
                            @endif
                        </x-table.cell>

                        @for ($i = 1; $i <= $page->column_count; $i++)
                            <x-table.cell class="!py-1 !px-1 text-center">
                                @if (in_array($i, $field->required_columns_array, false))
                                    <x-data.input :field="$field"/>
                                @endif
                            </x-table.cell>
                        @endfor
                    </x-table.row>
                </x-table.row>
            @endforeach
        </x-table.table>
    </x-table.wrapper>
</x-layout>

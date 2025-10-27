@php use App\Models\Field; @endphp

<x-layout>
    <x-table.wrapper>
        <x-slot name="title">List of fields</x-slot>

        <x-table.table :headers="['Name', 'Round 1',]">
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

                        <x-table.cell class="!py-1 !px-1">
                            <x-data.input required :type="$field->type" :field-id="$field->id"
                                          :value="optional($field->fieldData)->value"
                                          :is-out-of-range="optional($field->fieldData)->is_out_of_range"/>
                        </x-table.cell>
                    </x-table.row>
                </x-table.row>
            @endforeach
        </x-table.table>
    </x-table.wrapper>
</x-layout>

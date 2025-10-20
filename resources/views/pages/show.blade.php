@php use App\Models\Field; @endphp

{{--<x-layout>--}}
{{--    <h1>Welcome to the {{ $page->name }} page!</h1>--}}

{{--    @foreach ($page->fields as $field)--}}
{{--        @switch ($field->type)--}}
{{--            @case(Field::TYPE_NUMBER)--}}
{{--                @break--}}
{{--            @case(Field::TYPE_DATE)--}}
{{--                @break--}}
{{--            @case(Field::TYPE_SELECT)--}}
{{--                @break--}}
{{--            @case(Field::TYPE_CHECKBOX)--}}
{{--                @break--}}
{{--            @case(Field::TYPE_TEXTAREA)--}}
{{--                @break--}}
{{--            @case(Field::TYPE_TEXT)--}}
{{--            @default--}}
{{--                <div>--}}
{{--                    <label for="{{ $field->name }}">{{ $field->name }}</label>--}}
{{--                    <input type="text" id="{{ $field->name }}" name="{{ $field->name }}">--}}
{{--                </div>--}}
{{--                @break--}}
{{--        @endswitch--}}
{{--    @endforeach--}}
{{--</x-layout>--}}

<x-layout>
    <x-table.wrapper>
        <x-slot name="title">List of fields</x-slot>

        <x-table.table :headers="['Name', 'Round 1', 'Round 2', 'Round 3']">
            <x-table.row>
                <x-table.cell :header="true">Protein %</x-table.cell>
                <x-table.cell>
                    {{--                    cursor-not-allowed text-gray-900 dark:text-gray-400--}}
                    <input
                        class="bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed text-gray-900 dark:text-gray-400"
                        value="test 1" disabled readonly/>
                </x-table.cell>
                <x-table.cell><input
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="test 2"/>
                </x-table.cell>
                <x-table.cell><input
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="test 3"/>
                </x-table.cell>
            </x-table.row>

            <x-table.row>
                <x-table.cell :header="true">Moisture %</x-table.cell>
                <x-table.cell>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                </x-table.cell>
                <x-table.cell><input
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                </x-table.cell>
                <x-table.cell><input
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                </x-table.cell>
            </x-table.row>

            <x-table.row>
                <x-table.cell :header="true">pH</x-table.cell>
                <x-table.cell>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                </x-table.cell>
                <x-table.cell><input
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                </x-table.cell>
                <x-table.cell><input
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                </x-table.cell>
            </x-table.row>

            <x-table.row>
                <x-table.cell :header="true">Colour</x-table.cell>
                <x-table.cell>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                </x-table.cell>
                <x-table.cell><input
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                </x-table.cell>
                <x-table.cell><input
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                </x-table.cell>
            </x-table.row>
        </x-table.table>

        {{--        <x-table.pagination :paginator="$users"/>--}}
    </x-table.wrapper>
</x-layout>

<x-layout>
    <x-table.wrapper>
        <x-slot name="title">
            List of fields
        </x-slot>

        <x-table.header>
            <x-form.button :href="route('fields.create')" class="inline-flex items-center">
                <svg class="h-3.5 w-3.5 mr-2 fill-current" viewbox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd"
                          d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/>
                </svg>
                Add field
            </x-form.button>
        </x-table.header>

        <x-table.table :headers="['Name', 'Page', 'Subsection', 'Type', '']">
            @foreach($fields as $field)
                <x-table.row :dropdown-id="'field-' . $field->id . '-dropdown'">
                    <x-table.cell header>{{ $field->name }}</x-table.cell>
                    <x-table.cell>{{ $field->page->name }}</x-table.cell>
                    <x-table.cell>{{ $field->subsection }}</x-table.cell>
                    <x-table.cell>{{ App\Models\Field::getTypes()[$field->type] }}</x-table.cell>

                    <x-slot name="actions">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                            <li>
                                <a href="{{ route('fields.edit', $field) }}"
                                   class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    Edit
                                </a>
                            </li>
                        </ul>
                    </x-slot>
                </x-table.row>
            @endforeach
        </x-table.table>

        <x-table.pagination :paginator="$fields"/>
    </x-table.wrapper>
</x-layout>

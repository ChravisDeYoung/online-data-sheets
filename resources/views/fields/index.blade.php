<h1>Fields</h1>

<x-layout>
    <h1>Here is a list of all the fields.</h1>


    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Subreport
                </th>
                <th scope="col" class="px-6 py-3">
                    Subsection
                </th>
                <th scope="col" class="px-6 py-3">
                    Type
                </th>
            </tr>
            </thead>

            <tbody>
            @foreach ($fields as $field)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $field->name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $field->subreport }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $field->subsection }}
                    </td>
                    <td class="px-6 py-4">
                        {{ App\Models\Field::getTypes()[$field->type] }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-layout>

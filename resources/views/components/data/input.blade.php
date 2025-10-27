@php use App\Models\Field; @endphp
{{--@props(['type' => 1, 'fieldId', 'isOutOfRange' => false])--}}
@props(['field'])

@switch ($field->type)
    @case(Field::TYPE_TEXT)
        <input type="text" onblur="saveFieldData(this, {{ $field->id }})"
               value="{{ optional($field->fieldData)->value }}"
               class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        />
        @break
    @case(Field::TYPE_NUMBER)
        <input type="number" onblur="saveFieldData(this, {{ $field->id }})"
               value="{{ optional($field->fieldData)->value }}"
               class=" {{ optional($field->fieldData)->is_out_of_range ? 'out-of-range' : '' }} bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        />
        @break
    @case(Field::TYPE_DATE)
        <input type="date" onblur="saveFieldData(this, {{ $field->id }})"
               value="{{ optional($field->fieldData)->value }}"
               class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        />
        @break
    @case(Field::TYPE_SELECT)
        <select id="test-select" onblur="saveFieldData(this, {{ $field->id }})"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="">Select an option</option>
            @foreach(explode(',', $field->select_options) as $option)
                <option value="{{ $option }}" {{ optional($field->fieldData)->value === $option ? 'selected' : '' }}>
                    {{ $option }}
                </option>
            @endforeach
        </select>
        @break
    @case(Field::TYPE_CHECKBOX)
        <input type="checkbox" value="" onclick="saveFieldData(this, {{ $field->id }})"
               {{ filter_var(optional($field->fieldData)->value, FILTER_VALIDATE_BOOLEAN) ? 'checked' : '' }}
               class="w-6 h-6 text-blue-600 bg-gray-50 border-gray-300 rounded-md focus:ring-blue-600 dark:focus:ring-blue-500 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
        @break
    @case(Field::TYPE_TEXTAREA)
        <textarea onblur="saveFieldData(this, {{ $field->id }})"
                  class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ optional($field->fieldData)->value }}</textarea>
        @break
@endswitch

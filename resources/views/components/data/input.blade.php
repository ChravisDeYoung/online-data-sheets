@php use App\Models\Field; @endphp
@props(['field', 'column', 'date'])

@php
    $fieldData = $field->fieldData->firstWhere('column', $column);
    $hasHistory = $fieldData && $fieldData->fieldDataHistories->isNotEmpty();
    $value = optional($fieldData)->value;
@endphp

<div class="relative">
    @switch ($field->type)
        @case(Field::TYPE_TEXT)
            <input type="text" onblur="saveFieldData(this, {{ $field->id }}, {{ $column }}, '{{ $date }}')"
                   value="{{ $value }}"
                   class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            />
            @break
        @case(Field::TYPE_NUMBER)
            <input type="number" onblur="saveFieldData(this, {{ $field->id }}, {{ $column }}, '{{ $date }}')"
                   value="{{ $value }}"
                   class=" {{ optional($fieldData)->is_out_of_range ? 'out-of-range' : '' }} bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            />
            @break
        @case(Field::TYPE_DATE)
            <input type="date" onblur="saveFieldData(this, {{ $field->id }}, {{ $column }}, '{{ $date }}')"
                   value="{{ $value }}"
                   class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            />
            @break
        @case(Field::TYPE_SELECT)
            <select onblur="saveFieldData(this, {{ $field->id }}, {{ $column }}, '{{ $date }}')"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">Select an option</option>
                @foreach(explode(',', $field->select_options) as $option)
                    <option value="{{ $option }}" {{ $value === $option ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
            </select>
            @break
        @case(Field::TYPE_CHECKBOX)
            <input type="checkbox" value=""
                   onclick="saveFieldData(this, {{ $field->id }}, {{ $column }}, '{{ $date }}')"
                   {{ filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 'checked' : '' }}
                   class="w-6 h-6 text-blue-600 bg-gray-50 border-gray-300 rounded-md focus:ring-blue-600 dark:focus:ring-blue-500 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            @break
        @case(Field::TYPE_TEXTAREA)
            <textarea onblur="saveFieldData(this, {{ $field->id }}, {{ $column }}, '{{ $date }}')"
                      class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $value }}</textarea>
            @break
    @endswitch

    @if (Auth::user()->hasAnyRole(['admin']))
        <button data-modal-target="field-data-history-modal" data-modal-toggle="field-data-history-modal" type="button"
                onclick="getFieldDataHistory({{ $field->id }}, '{{ $date }}', {{ $column }}, 'modal-body')"
                class="absolute bottom-0 right-0 m-1"
                style="display: {{ $hasHistory ? 'block' : 'none' }};">
            <svg class="text-gray-900 dark:text-white h-2.5"
                 xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 640 640"
                 fill="currentColor">
                <path
                    d="M320 128C426 128 512 214 512 320C512 426 426 512 320 512C254.8 512 197.1 479.5 162.4 429.7C152.3 415.2 132.3 411.7 117.8 421.8C103.3 431.9 99.8 451.9 109.9 466.4C156.1 532.6 233 576 320 576C461.4 576 576 461.4 576 320C576 178.6 461.4 64 320 64C234.3 64 158.5 106.1 112 170.7L112 144C112 126.3 97.7 112 80 112C62.3 112 48 126.3 48 144L48 256C48 273.7 62.3 288 80 288L104.6 288C105.1 288 105.6 288 106.1 288L192.1 288C209.8 288 224.1 273.7 224.1 256C224.1 238.3 209.8 224 192.1 224L153.8 224C186.9 166.6 249 128 320 128zM344 216C344 202.7 333.3 192 320 192C306.7 192 296 202.7 296 216L296 320C296 326.4 298.5 332.5 303 337L375 409C384.4 418.4 399.6 418.4 408.9 409C418.2 399.6 418.3 384.4 408.9 375.1L343.9 310.1L343.9 216z"/>
            </svg>
        </button>
    @endif
</div>

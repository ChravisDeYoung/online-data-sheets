@php use App\Models\Field; @endphp

<h1>Welcome to the {{ $page->name }} page!</h1>

@foreach ($page->fields as $field)
    @switch ($field->type)
        @case(Field::TYPE_NUMBER)
            @break
        @case(Field::TYPE_DATE)
            @break
        @case(Field::TYPE_SELECT)
            @break
        @case(Field::TYPE_CHECKBOX)
            @break
        @case(Field::TYPE_TEXTAREA)
            @break
        @case(Field::TYPE_TEXT)
        @default
            <div>
                <label for="{{ $field->name }}">{{ $field->name }}</label>
                <input type="text" id="{{ $field->name }}" name="{{ $field->name }}">
            </div>
            @break
    @endswitch
@endforeach

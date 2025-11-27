@php
    use App\Models\Field;
@endphp

<x-layout>
    <x-form.wrapper>
        <x-slot name="title">
            Update field: <span
                class=" text-blue-600 dark:text-blue-600">{{ $field->name }}</span>
        </x-slot>

        <form action="{{ route('fields.update', $field) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="w-full">
                    <x-form.select name="page_id" required>
                        <option value="" disabled selected>Select a page</option>

                        @foreach ($pages as $page)
                            <option value="{{ $page->id }}"
                                    @if(old('page_id', $field->page_id) == $page->id) selected @endif>
                                {{ $page->name }}
                            </option>
                        @endforeach
                    </x-form.select>
                </div>

                <div class="w-full">
                    <x-form.input name="name" type="text" :value="old('name', $field->name)" required/>
                </div>

                <div class="w-full">
                    <x-form.select name="type">
                        <option value="" disabled selected>Select a type</option>

                        @foreach ($fieldTypes as $typeValue => $typeName)
                            <option value="{{ $typeValue }}"
                                    @if(old('type', $field->type) == $typeValue) selected @endif>
                                {{ ucfirst($typeName) }}
                            </option>
                        @endforeach
                    </x-form.select>
                </div>

                <div class="w-full">
                    <x-form.input name="subsection" type="text" :value="old('subsection', $field->subsection)"
                                  required/>
                </div>

                <div class="w-full">
                    <x-form.input name="subsection_sort_order" type="number"
                                  :value="old('subsection_sort_order', $field->subsection_sort_order)" required/>
                </div>

                <div class="w-full">
                    <x-form.input name="sort_order" type="number" :value="old('sort_order', $field->sort_order)"
                                  required/>
                </div>

                <div class="w-full">
                    <x-form.input name="required_columns" type="text" required
                                  :value="old('required_columns', $field->required_columns)"/>
                </div>

                <div class="w-full">
                    <x-form.input name="minimum" type="number"
                                  :value="old('minimum', $field->minimum)"/>
                </div>

                <div class="w-full">
                    <x-form.input name="maximum" type="number"
                                  :value="old('maximum', $field->maximum)"/>
                </div>

                <div class="w-full">
                    <x-form.input name="select_options" type="text"
                                  :value="old('select_options', $field->select_options)"/>
                </div>
            </div>

            <div class="mt-4 sm:mt-6 text-right">
                <x-form.button :href="route('fields.index')" variant="secondary">Cancel
                </x-form.button>
                <x-form.button class="ml-2 sm:ml-3">Update field</x-form.button>
            </div>
        </form>
    </x-form.wrapper>
</x-layout>


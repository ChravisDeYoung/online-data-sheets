@php
    $pages = \App\Models\Page::all();
@endphp

<x-layout>
    <x-form.wrapper>
        <x-slot name="title">Add a new field</x-slot>
        <form action="/fields" method="POST">
            @csrf

            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="w-full">
                    <x-form.select name="page_id">
                        <option value="" disabled selected>Select a page</option>

                        @foreach ($pages as $page)
                            <option value="{{ $page->id }}" @if(old('page_id') == $page->id) selected @endif>
                                {{ $page->name }}
                            </option>
                        @endforeach
                    </x-form.select>
                </div>

                <div class="w-full">
                    <x-form.input name="name" type="text" required/>
                </div>

                <div class="w-full">
                    <x-form.select name="type">
                        <option value="" disabled selected>Select a type</option>

                        @foreach (\App\Models\Field::getTypes() as $typeValue => $typeName)
                            <option value="{{ $typeValue }}" @if(old('type') == $typeValue) selected @endif>
                                {{ ucfirst($typeName) }}
                            </option>
                        @endforeach
                    </x-form.select>
                </div>

                <div class="w-full">
                    <x-form.input name="subsection" type="text" required/>
                </div>

                <div class="w-full">
                    <x-form.input name="subsection_sort_order" type="number" required/>
                </div>

                <div class="w-full">
                    <x-form.input name="sort_order" type="number" required/>
                </div>

                <div class="w-full">
                    <x-form.input name="required_columns" type="text" required/>
                </div>
            </div>

            <div class="mt-4 sm:mt-6 text-right">
                <x-form.button href="/fields" variant="secondary">Cancel
                </x-form.button>
                <x-form.button class="ml-2 sm:ml-3">Add field</x-form.button>
            </div>
        </form>
    </x-form.wrapper>
</x-layout>


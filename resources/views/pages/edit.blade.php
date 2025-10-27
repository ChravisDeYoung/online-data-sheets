<x-layout>
    <x-form.wrapper>
        <x-slot name="title">
            Update Page: <span
                class=" text-blue-600 dark:text-blue-600">{{ $page->name }}</span>
        </x-slot>

        <form action="/pages/{{ $page->id }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="w-full">
                    <x-form.input name="name" type="text" :value="old('name', $page->name)" required/>
                </div>

                <div class="w-full">
                    <x-form.input name="slug" type="text" :value="old('slug', $page->slug)"
                                  required/>
                </div>

                <div class="w-full">
                    <x-form.input name="column_count" type="number" required min="1" max="12"
                                  :value="old('column_count', $page->column_count)"/>
                </div>
            </div>

            <div class="mt-4 sm:mt-6 text-right">
                <x-form.button href="/pages" variant="secondary">Cancel
                </x-form.button>
                <x-form.button class="ml-2 sm:ml-3">Update page</x-form.button>
            </div>
        </form>
    </x-form.wrapper>
</x-layout>


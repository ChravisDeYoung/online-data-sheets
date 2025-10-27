<x-layout>
    <x-form.wrapper>
        <x-slot name="title">Add a new page</x-slot>
        <form action="/pages" method="POST">
            @csrf

            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="w-full">
                    <x-form.input name="name" type="text" required/>
                </div>

                <div class="w-full">
                    <x-form.input name="slug" type="text" required/>
                </div>

                <div class="w-full">
                    <x-form.input name="column_count" type="number" required min="1" max="12"/>
                </div>
            </div>

            <div class="mt-4 sm:mt-6 text-right">
                <x-form.button href="/pages" variant="secondary">Cancel
                </x-form.button>
                <x-form.button class="ml-2 sm:ml-3">Add page</x-form.button>
            </div>
        </form>
    </x-form.wrapper>
</x-layout>


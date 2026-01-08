<x-layout>
    <x-form.wrapper>
        <x-slot name="title">
            Update Page: <span
                class=" text-blue-600 dark:text-blue-600">{{ $page->name }}</span>
        </x-slot>

        <form action="{{ route('pages.update', $page) }}" method="POST">
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

                <div class="col-span-2">
                    <x-form.label name="Field Order"/>
                    <x-table.wrapper class="!p-0">
                        <x-table.table :headers="['Order', 'Subsection', 'Name', '']">
                            @foreach($page->fields as $field)
                                <x-table.row>
                                    <x-table.cell>{{ $loop->iteration }}</x-table.cell>
                                    <x-table.cell>{{ $field->subsection }}</x-table.cell>
                                    <x-table.cell>{{ $field->name }}</x-table.cell>
                                    <x-table.cell class="flex justify-end">
                                        <button type="button"
                                                class="cursor-pointer rounded-md p-1 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <svg
                                                class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"
                                                fill="currentColor">
                                                <!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                                                <path
                                                    d="M342.6 81.4C330.1 68.9 309.8 68.9 297.3 81.4L137.3 241.4C124.8 253.9 124.8 274.2 137.3 286.7C149.8 299.2 170.1 299.2 182.6 286.7L288 181.3L288 552C288 569.7 302.3 584 320 584C337.7 584 352 569.7 352 552L352 181.3L457.4 286.7C469.9 299.2 490.2 299.2 502.7 286.7C515.2 274.2 515.2 253.9 502.7 241.4L342.7 81.4z"/>
                                            </svg>
                                        </button>

                                        <button type="button"
                                                class="cursor-pointer rounded-md p-1 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <svg
                                                class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"
                                                fill="currentColor">
                                                <!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                                                <path
                                                    d="M297.4 566.6C309.9 579.1 330.2 579.1 342.7 566.6L502.7 406.6C515.2 394.1 515.2 373.8 502.7 361.3C490.2 348.8 469.9 348.8 457.4 361.3L352 466.7L352 96C352 78.3 337.7 64 320 64C302.3 64 288 78.3 288 96L288 466.7L182.6 361.3C170.1 348.8 149.8 348.8 137.3 361.3C124.8 373.8 124.8 394.1 137.3 406.6L297.3 566.6z"/>
                                            </svg>
                                        </button>
                                    </x-table.cell>
                                </x-table.row>
                            @endforeach
                        </x-table.table>
                    </x-table.wrapper>
                </div>
            </div>

            <div class="mt-4 sm:mt-6 text-right">
                <x-form.button href="{{ route('pages.index') }}" variant="secondary">Cancel</x-form.button>
                <x-form.button class="ml-2 sm:ml-3">Update page</x-form.button>
            </div>
        </form>
    </x-form.wrapper>
</x-layout>


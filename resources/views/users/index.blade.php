<x-layout>
    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Add a new user</h2>
            <x-table.wrapper>

                <x-table.header/>

                <x-table.table :headers="['Name', 'Email', '']">
                    @foreach($users as $user)
                        <x-table.row :dropdown-id="'user-' . $user->id . '-dropdown'">
                            <x-table.cell :header="true">{{ $user->name }}</x-table.cell>
                            <x-table.cell>{{ $user->email }}</x-table.cell>

                            <x-slot name="actions">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                                    <li>
                                        <a href="/users/{{ $user->id }}"
                                           class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            Edit
                                        </a>
                                    </li>
                                </ul>

                                {{--                        <div class="py-1">--}}
                                {{--                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">--}}
                                {{--                                @csrf--}}
                                {{--                                @method('DELETE')--}}
                                {{--                                --}}
                                {{--                                <button type="submit"--}}
                                {{--                                        class="block w-full text-left py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">--}}
                                {{--                                    Delete--}}
                                {{--                                </button>--}}
                                {{--                            </form>--}}
                                {{--                        </div>--}}
                            </x-slot>
                        </x-table.row>
                    @endforeach
                </x-table.table>

                <x-table.pagination :paginator="$users"/>
            </x-table.wrapper>
        </div>
    </section>
</x-layout>

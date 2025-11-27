<x-layout>
    <x-form.wrapper>
        <x-slot name="title">Add a new user</x-slot>
        <form action="/users" method="POST">
            @csrf

            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="w-full">
                    <x-form.input name="first_name" type="text" required/>
                </div>

                <div class="w-full">
                    <x-form.input name="last_name" required/>
                </div>

                <div class="w-full">
                    <x-form.input name="email" type="email" autocomplete="email" required/>
                </div>

                <div class="w-full">
                    <x-form.input name="phone_number" type="tel" autocomplete="tel" required/>
                </div>

                <div class="w-full">
                    <x-form.input name="password" type="password" autocomplete="new-password" required/>
                </div>

                <div class="w-full">
                    <x-form.input name="password_confirmation" type="password" autocomplete="new-password" required/>
                </div>

                <div class="text-xl font-bold text-gray-900 dark:text-white col-span-2">Roles</div>

                @foreach ($roles as $role)
                    <div class="w-full">
                        <x-form.input :label="$role->description" name="roles[]" type="checkbox" error-Name="roles"
                                      value="{{ $role->id }}"
                                      :checked="in_array($role->id, old('roles', []))"/>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 sm:mt-6 text-right">
                <x-form.button :href="route('users.index')" variant="secondary">Cancel
                </x-form.button>
                <x-form.button class="ml-2 sm:ml-3">Add user</x-form.button>
            </div>
        </form>
    </x-form.wrapper>
</x-layout>



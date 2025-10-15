<x-layout>
    <x-form.wrapper>
        <x-slot name="title">
            Update user: <span
                class=" text-blue-600 dark:text-blue-600">{{ $user->first_name }} {{ $user->last_name }}</span>
        </x-slot>

        <form action="/users/{{ $user->id }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="w-full">
                    <x-form.input name="first_name" type="text" :value="old('first_name', $user->first_name)" required/>
                </div>

                <div class="w-full">
                    <x-form.input name="last_name" type="text" :value="old('last_name', $user->last_name)" required/>
                </div>

                <div class="w-full">
                    <x-form.input name="email" type="email" autocomplete="email" :value="old('email', $user->email)"
                                  required/>
                </div>

                <div class="w-full">
                    <x-form.input name="phone_number" type="tel" autocomplete="tel"
                                  :value="old('phone_number', $user->phone_number)" required/>
                </div>

                <div class="w-full">
                    <x-form.input name="password" type="password" autocomplete="new-password"/>
                </div>

                <div class="w-full">
                    <x-form.input name="password_confirmation" type="password" autocomplete="new-password"/>
                </div>
            </div>

            <div class="mt-4 sm:mt-6 text-right">
                <x-form.button href="/users" variant="secondary">Cancel
                </x-form.button>
                <x-form.button class="ml-2 sm:ml-3">Update user</x-form.button>
            </div>
        </form>
    </x-form.wrapper>
</x-layout>


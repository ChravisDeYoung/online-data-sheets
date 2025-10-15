<x-layout>
    <section class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Update
            user: {{ $user->first_name }} {{ $user->last_name }}</h2>

        <form action="/users" method="POST">
            @csrf

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
                    <x-form.input name="password" type="password" autocomplete="new-password" required/>
                </div>

                <div class="w-full">
                    <x-form.input name="password-confirmation" type="password" autocomplete="new-password" required/>
                </div>
            </div>

            <div class="mt-4 sm:mt-6 text-right">
                <x-form.button href="/users" variant="secondary">Cancel
                </x-form.button>
                <x-form.button class="ml-2 sm:ml-3">Add user</x-form.button>
            </div>
        </form>
    </section>
</x-layout>


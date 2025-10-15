<x-layout>
    <section class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Add a new user</h2>

        <form action="/users" method="POST">
            @csrf

            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="sm:col-span-2">
                    <x-form.input name="name" type="text" required/>
                </div>

                <div class="sm:col-span-2">
                    <x-form.input name="email" type="email" autocomplete="email" required/>
                </div>

                <div class="w-full">
                    <x-form.input name="password" type="password" autocomplete="new-password" required/>
                </div>

                <div class="w-full">
                    <x-form.input name="password-confirmation" type="password" autocomplete="new-password" required/>
                </div>
            </div>
            
            <x-form.button class="inline-flex items-center mt-4 sm:mt-6">Add user</x-form.button>
        </form>
    </section>
</x-layout>


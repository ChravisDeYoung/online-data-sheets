<x-layout>
    <section class="px-6 py-8">
        <main class="max-w-lg mx-auto mt-10">
            <h1 class="text-center font-bold text-xl">Create new user</h1>

            <form method="POST" action="/users" class="mt-10">
                @csrf

                <x-form.input name="name" type="text" required/>
                <x-form.input name="email" type="email" autocomplete="username" required/>
                <x-form.input name="password" type="password" autocomplete="new-password" required/>
                <x-form.input name="password-confirmation" type="password" autocomplete="new-password" required/>

                <x-form.button>Create new user</x-form.button>
            </form>
        </main>
    </section>
</x-layout>


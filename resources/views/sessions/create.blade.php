<x-layout>
    <section class="flex flex-col items-center justify-center px-6 py-8 mx-auto h-[80vh] lg:py-0">
        {{--            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">--}}
        {{--                <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg"--}}
        {{--                     alt="logo">--}}
        {{--                Flowbite--}}
        {{--            </a>--}}

        <div
            class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Sign in to your account
                </h1>

                <form class="space-y-4 md:space-y-6" action="/login" method="POST">
                    @csrf

                    <x-form.input name="email" type="email" autocomplete="email" required/>

                    <x-form.input name="password" type="password" autocomplete="current-password" required/>

                    <div class="flex items-center justify-between">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="remember" aria-describedby="remember" type="checkbox"
                                       class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
                            </div>

                            <div class="ml-3 text-sm">
                                <label for="remember" class="text-gray-500 dark:text-gray-300">Remember me</label>
                            </div>
                        </div>

                        <a href="#"
                           class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">Forgot
                            password?</a>
                    </div>

                    <x-form.button class="w-full">Sign in</x-form.button>


                    {{--                        TODO: email admin to create account for you--}}
                    {{--                        <p class="text-sm font-light text-gray-500 dark:text-gray-400">--}}
                    {{--                            Don’t have an account yet? <a href="#"--}}
                    {{--                                                          class="font-medium text-blue-600 hover:underline dark:text-blue-500">Sign--}}
                    {{--                                up</a>--}}
                    {{--                        </p>--}}
                </form>
            </div>
        </div>
    </section>
</x-layout>


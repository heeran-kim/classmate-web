<x-master-layout title="| Login">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="container d-flex justify-content-center">
        <div class="w-100 bg-light p-3 border rounded shadow-sm m-3" style="max-width: 500px;">
            <h5 class="text-center m-3">Login</h5>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Student Number -->
                <div>
                    <x-input-label for="snumber" :value="__('Student Number')" />
                    <x-text-input id="snumber" class="block mt-1 w-full" type="text" name="snumber" :value="old('snumber')" autofocus/>
                    <x-input-error :messages="$errors->get('snumber')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="d-flex align-items-center justify-content-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
                            {{ __('Don’t have an account?') }}
                    </a>
                    <x-primary-button class="ms-3">
                        {{ __('Log in') }}
                    </x-primary-button>
                    
                </div>
            </form>
        </div>
    </div>
</x-master-layout>

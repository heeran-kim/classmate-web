<section>
    <header>
        <h6 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h6>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6">
        @csrf
        @method('put')

        <div class="mt-4">
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password" class="block mt-1 w-full" name="current_password" type="password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input id="update_password_password" class="block mt-1 w-full" name="password" type="password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="update_password_password_confirmation" class="block mt-1 w-full" name="password_confirmation" type="password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="mt-4">
            {{ __('Update') }}
        </x-primary-button>
    </form>
</section>

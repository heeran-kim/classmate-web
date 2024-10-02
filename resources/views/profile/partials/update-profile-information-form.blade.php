<section>
    <header>
        <h6 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h6>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6">
        @csrf
        @method('put')

        <!-- Student Number -->
        <div class="mt-4">
            <x-input-label for="snumber" :value="__('Student Number')" />
            <x-text-input id="snumber" class="block mt-1 w-full disabled" type="text" name="snumber" :value="old('snumber', Auth::user()->snumber)" disabled />
            <x-input-error :messages="$errors->get('snumber')" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', Auth::user()->name)" autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', Auth::user()->email)" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button class="mt-4">
            {{ __('Update') }}
        </x-primary-button>
    </form>
</section>

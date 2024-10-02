<x-master-layout title="| Profile">
    <div class="container d-flex justify-content-center">
        <div class="w-100 bg-light p-3 border rounded shadow-sm m-3" style="max-width: 700px;">
            <h5 class="text-center m-3">Edit Profile</h5>
            <div class="bg-white p-3 border rounded m-3">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="bg-white p-3 border rounded m-3">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
</x-app-layout>

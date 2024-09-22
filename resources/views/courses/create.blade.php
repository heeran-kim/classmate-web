<x-master-layout title="| Create Course">
    <div class="container">
        <div class="bg-light p-3 border rounded shadow-sm m-3">

            <h5 class="text-center m-3">Create Course</h5>
            <form method="POST" action="{{ route('course.store') }}" enctype ="multipart/form-data">
                @csrf
                <x-input-label for="jsonFile" class="mt-2" :value="__('Input Course File:')"  />
                <input type="file" class="form-control" name="jsonFile">
                <x-input-error :messages="$errors->get('jsonFile')" class="mt-2" />

                <x-input-label for="image" class="mt-2" :value="__('Input Course Image File:')" />
                <input type="file" class="form-control" name="image">
                <x-input-error :messages="$errors->get('image')" class="mt-2" />

                <button type="submit" class="btn btn-primary mt-3">Create</button>
                
            </form>
        </div>
    </div>
</x-master-layout>

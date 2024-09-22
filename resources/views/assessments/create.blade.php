<x-master-layout title="| Create Assessment">
    <x-course-header :course="$course">
        <div class="bg-light p-3 border rounded shadow-sm m-3">
            <h4 class="text-center m-3">Create Assessment</h4>
            <form method="POST" action="{{ route('assessment.store') }}" class="row g-3">
                @csrf
                <input type="hidden" name="course_id" value="{{$course->id}}">
                <div class="col-12">
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" class="d-block mt-1 w-100" name="title" :value="old('title')" autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                <div class="col-12">
                    <x-input-label for="instruction" :value="__('Instruction')" />
                    <textarea name="instruction" class="form-control shadow-sm rounded d-block mt-1 w-100" rows="3">{{old('instruction')}}</textarea>
                    <x-input-error :messages="$errors->get('instruction')" class="mt-2" />
                </div>
                <div class="col-12 col-md-6">
                    <x-input-label for="num_required_reviews" :value="__('The number of reviews required')" />
                    <x-text-input id="num_required_reviews" class="d-block mt-1 w-100" name="num_required_reviews" :value="old('num_required_reviews')" />
                    <x-input-error :messages="$errors->get('num_required_reviews')" class="mt-2" />
                </div>
                <div class="col-12 col-md-6">
                    <x-input-label for="max_score" :value="__('Maximum Score')" />
                    <x-text-input id="max_score" class="d-block mt-1 w-100" name="max_score" :value="old('max_score')" />
                    <x-input-error :messages="$errors->get('max_score')" class="mt-2" />
                </div>
                <div class="col-12 col-md-6">
                    <x-input-label for="due_date" :value="__('Due Date')" />
                    <x-text-input id="due_date" class="d-block mt-1 w-100" type="datetime-local" name="due_date" :value="old('due_date')" />
                    <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                </div>
                <div class="col-12 col-md-6">
                    <x-input-label for="type" :value="__('Type')" />
                    <select name="type" class="form-select shadow-sm rounded d-block mt-1 w-100">
                        <option value="student-select" {{old('type') == "student-select" ? 'selected' : ''}}>Student Select</option>
                        <option value="teacher-assign" {{old('type') == "teacher-assign" ? 'selected' : ''}}>Teacher Assign</option>
                    </select>
                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary mt-3">Create</button>
                </div>
            </form>
        </div>
    </x-course-header>
</x-master-layout>

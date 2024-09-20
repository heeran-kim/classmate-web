<x-master title="| Create Assessment">
    <div class="container">
        <a
            href="{{ route('course.show', ['course' => $course->id]) }}"
            class="text-decoration-none text-reset"
        >
            <h3 class="ms-1 mb-3">{{$course->name}} ({{$course->code}})</h3>
        </a>
        <hr>    
        <h4>Create Assessment</h4>
        <div class="bg-light p-3 border rounded shadow-sm m-3">
            <form method="POST" action="{{ route('assessment.store') }}" class="row g-3">
                @csrf
                <div class="col-12">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" value="{{old('title')}}">
                    @if ($errors->has('title'))
                        <small class="text-danger">{{ $errors->first('title') }}</small>
                    @endif
                </div>
                <div class="col-12">
                    <label class="form-label">Instruction</label>
                    <textarea name="instruction" class="form-control" rows="3">{{old('instruction')}}</textarea>
                    @if ($errors->has('instruction'))
                        <small class="text-danger">{{ $errors->first('instruction') }}</small>
                    @endif
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label">The number of reviews required</label>
                    <input type="number" class="form-control" name="num_required_reviews" value="{{old('num_required_reviews')}}">
                    @if ($errors->has('num_required_reviews'))
                        <small class="text-danger">{{ $errors->first('num_required_reviews') }}</small>
                    @endif
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label">Maximum Score</label>
                    <input type="number" class="form-control" name="max_score" value="{{old('max_score')}}">
                    @if ($errors->has('max_score'))
                        <small class="text-danger">{{ $errors->first('max_score') }}</small>
                    @endif
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label">Due Date</label>
                    <input type="datetime-local" class="form-control" name="due_date" value="{{old('due_date')}}">
                    @if ($errors->has('due_date'))
                        <small class="text-danger">{{ $errors->first('due_date') }}</small>
                    @endif
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select">
                        <option value="student-select" {{old('type') == "student-select" ? 'selected' : ''}}>Student Select</option>
                        <option value="teacher-assign" {{old('type') == "teacher-assign" ? 'selected' : ''}}>Teacher Assign</option>
                    </select>
                    @if ($errors->has('type'))
                        <small class="text-danger">{{ $errors->first('type') }}</small>
                    @endif
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary mt-3">Create</button>
                </div>
            </form>
        </div>
    </div>
</x-master>

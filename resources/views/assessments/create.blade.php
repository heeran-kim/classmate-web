<x-master title="| Create Assessment">
    <div class="container">
        <h3 class="ms-1 mb-3">{{$course->name}} ({{$course->code}})</h3>
        <hr>    
        <h4>Create Assessment</h4>
        @if (count($errors) > 0)
            <div class="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="bg-light p-3 border rounded shadow-sm m-3">
            <form method="POST" action="{{ route('assessment.store') }}" class="row g-3">
                @csrf
                <div class="col-12">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" value="{{old('title')}}">
                </div>
                <div class="col-12">
                    <label class="form-label">Instruction</label>
                    <textarea name="instruction" class="form-control" rows="3">{{old('instruction')}}</textarea>
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label">The number of reviews required</label>
                    <input type="number" class="form-control" name="num_required_reviews" value="{{old('num_required_reviews')}}">
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label">Maximum Score</label>
                    <input type="number" class="form-control" name="max_score" value="{{old('max_score')}}">
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label">Due Date</label>
                    <input type="datetime-local" class="form-control" name="due_date" value="{{old('due_date')}}">
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-control">
                        <option value="student-select" {{old('type') == "student-select" ? 'selected' : ''}}>Student Select</option>
                        <option value="teacher-assign" {{old('type') == "teacher-assign" ? 'selected' : ''}}>Teacher Assign</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary mt-3">Create</button>
                </div>
            </form>
        </div>
        <a href="{{ route('course.show', ['course' => $course->id]) }}">Back</button>
    </div>
</x-master>

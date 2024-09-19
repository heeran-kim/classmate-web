<x-master>
    <h1>Create a new Assessment</h1>
    @if (count($errors) > 0)
    <div class="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('assessment.store') }}">
        @csrf
        <input type="hidden" name="courseId" value={{$courseId}}>
        <p><label>Title: </label><input type="text" name="title" value="{{old('title')}}"></p>
        <p><label>Instruction: </label><textarea name="instruction" rows="10">{{old('instruction')}}</textarea></p>
        <p><label>The number of reviews required: </label><input type="number" name="num_required_reviews" value="{{old('num_required_reviews')}}"></p>
        <p><label>Maximum Score: </label><input type="number" name="max_score" value="{{old('max_score')}}"></p>
        <p><label>Due Date: </label><input type="datetime-local" name="due_date" value="{{old('due_date')}}"></p>
        <p><label>Type: </label><select name="type">
            <option value="student-select" {{old('type') == "student-select" ? 'selected' : ''}}>Student Select</option>
            <option value="teacher-assign" {{old('type') == "teacher-assign" ? 'selected' : ''}}>Teacher Assign</option>
        </select></p>

        <button type="submit">Create</button>
    </form>
    <a href="{{ route('course.show', ['course' => $courseId]) }}">Back</button>
</x-master>

<x-master>
<h1>Edit an Assessment</h1>
    @if (count($errors) > 0)
    <div class="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif

<form method="POST" action="{{ route('course.assessment.update', ['course' => $course->id, 'assessment' => $assessment->id]) }}">
    @csrf
    @method('PUT')

    <p><label>Title: </label><input type="text" name="title" value="{{old('title', $assessment->title)}}"></p>
    <p><label>Instruction: </label><textarea name="instruction" rows="10">{{old('instruction', $assessment->instruction)}}</textarea></p>
    <p><label>The number of reviews required: </label><input type="number" name="num_required_reviews" value="{{old('num_required_reviews', $assessment->num_required_reviews)}}"></p>
    <p><label>Maximum Score: </label><input type="number" name="max_score" value="{{old('max_score', $assessment->max_score)}}"></p>
    <p><label>Dute Date: </label><input type="date" name="due_date" value="{{old('due_date', $assessment->due_date)}}"></p>
    <p><label>Type: </label><select name="type">
        <option value="student-select" {{old('type', $assessment->type) == "student-select" ? 'selected' : ''}}>Student Select</option>
        <option value="teacher-assign" {{old('type', $assessment->type) == "teacher-assign" ? 'selected' : ''}}>Teacher Assign</option>
    </select></p>

    <button type="submit">Edit</button>
</form>
</x-master>
<x-master>
<form method="POST" action="{{ route('course.assessment.update', ['course' => $course->id, 'assessment' => $assessment->id]) }}">
    @csrf
    @method('PUT')

    <p><label>Title: </label><input type="text" name="title" value="{{$assessment->title}}"></p>
    <p><label>Instruction: </label><textarea name="instruction" rows="10">{{$assessment->instruction}}</textarea></p>
    <p><label>The number of reviews required: </label><input type="number" name="num_required_reviews" value="{{$assessment->num_required_reviews}}"></p>
    <p><label>Maximum Score: </label><input type="number" name="max_score" value="{{$assessment->max_score}}"></p>
    <p><label>Dute Date: </label><input type="date" name="due_date" value="{{$assessment->due_date}}"></p>
    <p><label>Type: </label><select name="type" value="{{$assessment->title}}">
        <option value="student-select" {{$assessment->type == "student-select" ? 'selected' : ''}}>Student Select</option>
        <option value="teacher-assign" {{$assessment->type == "teacher-assign" ? 'selected' : ''}}>Teacher Assign</option>
    </select></p>

    <button type="submit">Edit</button>
</form>
</x-master>
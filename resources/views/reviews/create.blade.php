<x-master>
<form method="POST" action="{{ route('course.assessment.store', ['course' => $course->id]) }}">
    @csrf
    <p><label>Title: </label><input type="text" name="title"></p>
    <p><label>Instruction: </label><textarea name="instruction" rows="10"></textarea></p>
    <p><label>The number of reviews required: </label><input type="number" name="num_required_reviews"></p>
    <p><label>Maximum Score: </label><input type="number" name="max_score"></p>
    <p><label>Dute Date: </label><input type="date" name="due_date"></p>
    <p><label>Type: </label><select name="type">
        <option value="student-select">Student Select</option>
        <option value="teacher-assign">Teacher Assign</option>
    </select></p>

    <button type="submit">Create</button>
</form>
</x-master>

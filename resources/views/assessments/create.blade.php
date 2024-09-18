<x-master>
<form method="POST" action="{{ route('assessment.store') }}">
    @csrf
    <input type="hidden" name="courseId" value={{$courseId}}>
    <p><label>Title: </label><input type="text" name="title"></p>
    <p><label>Instruction: </label><textarea name="instruction" rows="10"></textarea></p>
    <p><label>The number of reviews required: </label><input type="number" name="num_required_reviews"></p>
    <p><label>Maximum Score: </label><input type="number" name="max_score"></p>
    <p><label>Due Date: </label><input type="datetime-local" name="due_date"></p>
    <p><label>Type: </label><select name="type">
        <option value="student-select">Student Select</option>
        <option value="teacher-assign">Teacher Assign</option>
    </select></p>

    <button type="submit">Create</button>
</form>
</x-master>

<x-master>
<form method="POST" action="{{ route('course.enroll', ['id' => $course->id]) }}">
    @csrf

    <p><select name="student">
        @foreach ($students as $student)
        <option value="{{$student->id}}">{{$student->name}}</option>
        @endforeach
    </select></p>
    <button type="submit">Enroll</button>
</form>
</x-master>

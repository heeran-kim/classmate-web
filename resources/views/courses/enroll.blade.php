<x-master>
<form method="POST" action="{{ route('course.enroll', ['course' => $course->id]) }}">
    @csrf

    <p><select name="student">
        @foreach ($students as $student)
        <option value="{{$student->id}}">{{$student->name}}</option>
        @endforeach
    </select></p>
    <button type="submit">Enroll</button>
</form>
<a href="{{ route('course.show', ['course' => $course->id]) }}">Back</button>
</x-master>

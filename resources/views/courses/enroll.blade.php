<x-master title="| Enroll Student">
<h1>Enroll a Student</h1>

@if (count($errors) > 0)
    <div class="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('course.enroll', ['course' => $course->id]) }}">
    @csrf

    <p><select name="student">
        @foreach ($students as $student)
        <option value="{{$student->id}}" {{old('student') == $student->id ? 'selected' : ''}}>{{$student->name}}</option>
        @endforeach
    </select></p>
    <button type="submit">Enroll</button>
</form>
<a href="{{ route('course.show', ['course' => $course->id]) }}">Back</button>
</x-master>

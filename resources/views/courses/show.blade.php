<x-master>
<ul>
    @foreach ($teachers as $teacher)
    <a href="{{ route('user.show', ['user' => $teacher->id]) }}"><li>{{$teacher->name}} {{$teacher->s_number}} {{$teacher->email}}</li></a>
    @endforeach
</ul>
<ul>
    @foreach ($assessments as $assessment)
    <a href="{{ route('course.assessment.show', ['course' => $course->id, 'assessment' => $assessment->id]) }}"><li>{{$assessment->title}} {{$assessment->due_date}}</li></a>
    @endforeach
</ul>

<a href="{{ route('course.enrollPage', ['id' => $course->id]) }}">Enroll Student</a>
<a href="{{ route('course.assessment.create', ['course' => $course->id]) }}">Create Assessment</a>

</x-master>
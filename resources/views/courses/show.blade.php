<x-master>
<ul>
    @foreach ($teachers as $teacher)
    <li>{{$teacher->name}} {{$teacher->s_number}} {{$teacher->email}}</li>
    @endforeach
</ul>
<ul>
    @foreach ($assessments as $assessment)
    <a href="{{ route('assessment.show', ['assessment' => $assessment->id]) }}"><li>{{$assessment->title}} {{$assessment->due_date}}</li></a>
    @endforeach
</ul>

<a href="{{ route('course.enrollPage', ['id' => $course->id]) }}">Enroll Student</a>
<a href="{{ route('assessment.create', ['courseId' => $course->id]) }}">Create Assessment</a>

</x-master>
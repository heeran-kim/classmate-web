<x-master>
<ul>
    @foreach ($courses as $course)
    <a href="{{ route('course.show', ['course' => $course->id]) }}"><li>{{$course->code}} {{$course->name}}</li></a>
    @endforeach
</ul>
</x-master>
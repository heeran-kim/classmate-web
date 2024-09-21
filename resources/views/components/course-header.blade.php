<div class="container">
    <a href="{{ route('course.show', ['course' => $course->id]) }}" class="text-decoration-none text-reset">
        <h3 class="ms-1 mb-3">{{ $course->name }} ({{ $course->code }})</h3>
    </a>
    <hr>
    {{$slot}}
</div>
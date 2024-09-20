<x-master title="| {{$course->code}}">
    <div class="container">
        <h3 class="ms-1 mb-3">{{$course->name}} ({{$course->code}})</h3>
        <hr>
        <h4>Teaching Staff</h4>
        <ul>
            @foreach ($teachers as $teacher)
                <li>{{$teacher->name}} {{$teacher->s_number}} ({{$teacher->email}})</li>
            @endforeach
        </ul>
        <hr>
        <h4>Assessment</h4>
        @if (count($assessments))
            @foreach ($assessments as $assessment)
                <div class="card shadow-sm m-3">
                    <a
                        href="{{ route('assessment.show', ['assessment' => $assessment->id]) }}"
                        class="text-decoration-none text-reset"
                    >
                    {{-- <img src="{{ asset('images/course' . $course->id . '.png') }}" class="card-img-top border"> --}}
                        <div class="card-body">
                            <h5 class="card-title">{{$assessment->title}}</h5>
                            <p class="card-title"><i class="bi bi-calendar"></i> {{$assessment->due_date}}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        @else
            <div class="text-center">No Assessments Created Yet</div>
        @endif
        
        @if (Auth::user()->type == 'teacher')
        <a href="{{ route('course.enrollPage', ['course' => $course->id]) }}"><button type="button" class="btn btn-outline-primary me-2">Enroll Student</button></a>
        <a href="{{ route('assessment.create', ['courseId' => $course->id]) }}"><button type="button" class="btn btn-outline-primary">Create Assessment</button></a>
        @endif
    </div>
</x-master>
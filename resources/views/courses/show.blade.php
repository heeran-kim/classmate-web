<x-master-layout title="| {{$course->code}}">
    <x-course-header :course="$course">
        <h4>Teaching Staff</h4>
        <ul>
            @foreach ($teachers as $teacher)
                <li>{{$teacher->name}} {{$teacher->s_number}} ({{$teacher->email}})</li>
            @endforeach
        </ul>
        <hr>
        <h4>Assessment</h4>
        @if (count($assessments))
            <ul class="list-group m-3">
            @foreach ($assessments as $assessment)
                <a
                    href="{{ route('assessment.show', ['assessment' => $assessment->id]) }}"
                    class="text-decoration-none text-reset"
                >
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">{{$assessment->title}}</div>
                            <i class="bi bi-calendar"></i> {{ (new DateTime($assessment->due_date))->format('D j/m/Y, g:i a') }}
                        </div>
                        <div>
                            <div class="badge text-bg-primary rounded-pill">
                                {{$assessment->max_score}} points
                            </div>
                            <div class="text-center">
                                @if (Auth::user()->type == 'student')
                                    {{ $assessment->students->first()->pivot->score ?? 0 }} / {{ $assessment->max_score }}
                                @endif
                            </div>
                        </div>
                    </li>
                </a>
            @endforeach
            </ul>
        @else
            <div class="text-center">No Assessments Created Yet</div>
        @endif
        
        @if (Auth::user()->type == 'teacher')
            <x-primary-button route="course.enrollPage" :routeParams="['course' => $course->id]" class="me-2">
                {{ __('Enroll Student') }}
            </x-primary-button>
            <x-primary-button route="assessment.create" :routeParams="['courseId' => $course->id]">
                {{ __('Create Assessment') }}
            </x-primary-button>
        @endif
    </x-course-header>
</x-master-layout>

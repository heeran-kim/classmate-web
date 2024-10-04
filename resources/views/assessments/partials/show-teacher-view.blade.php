<div class="d-flex justify-content-between">
    <h4 class="ms-2">{{$assessment->title}}</h4>
    <div>
        <x-primary-button route="assessment.assignStudentForm" :routeParams="['assessment' => $assessment->id]">
            {{ __('Assign') }}
        </x-primary-button>
        @if(!$reviewCount)
            <x-primary-button route="assessment.edit" :routeParams="['assessment' => $assessment->id]">
                {{ __('Edit') }}
            </x-primary-button>
        @else
            <x-primary-button disabled>
                {{ __('Edit') }}
            </x-primary-button>
        @endif
    </div>
</div>

@if (count($studentsData))
    <ul class="list-group m-3">
    @foreach ($studentsData as $studentData)
        <a
            href="{{ route('student.reviews', ['assessment' => $assessment->id, 'student' => $studentData['id']])}}"
            class="text-decoration-none text-reset"
        >
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="ms-2 me-auto">
                    <div class="fw-bold">{{$studentData['name']}}</div>
                    Submitted: {{$studentData['submitted']}} Received: {{$studentData['received']}}
                </div>
                <div class="badge rounded-pill {{is_null($studentData['score']) ? 'text-bg-primary' : 'text-bg-secondary'}}">
                    {{$studentData['score'] ?? 0}} / {{$assessment->max_score}}
                </div>
            </li>
        </a>
    @endforeach
    </ul>
@else
    <div class="text-center">No Students Assigned Yet</div>
@endif
{{$students->links()}}
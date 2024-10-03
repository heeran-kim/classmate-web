<x-master-layout title="| {{$assessment->title}}">
    <x-course-header :course="$assessment->course">
        @if (Auth::user()->type == 'student')
            <h4 class="ms-2">{{$assessment->title}}</h4>
            <div class="bg-light p-3 border rounded m-3">
                <h5>Details</h5>
                <div class="bg-white p-3 border rounded m-3">
                    <p><div class="fw-bold">Instructions: </div>{{$assessment->instruction}}</p>
                    <p><span class="fw-bold">The number of reviews required: </span>{{$assessment->num_required_reviews}}</p>
                    <p><span class="fw-bold">Max score: </span>{{$assessment->max_score}}</p>
                    <p><span class="fw-bold">Due date: </span>{{ (new DateTime($assessment->due_date))->format('D j/m/Y, g:i a') }}</p>
                    <p><span class="fw-bold">Type: </span>{{$assessment->type}}</p>
                </div>
                <h5>Peer Review Submitted: {{count($reviewsSubmitted)}}/{{$assessment->num_required_reviews}}</h5>
                <div class="bg-white p-3 border rounded m-3">
                    @if (count($reviewsSubmitted))
                        <ul>
                            @foreach ($reviewsSubmitted as $review)
                                <li><span class="fw-bold">{{$review->reviewee->name}}: </span>{{$review->text}}</li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center">No Reviews Submitted Yet</div>
                    @endif
                </div>
                @include('assessments.partials.received-review-rating-form')
                @include('assessments.partials.write-peer-review-form')
            </div>
        @else
        <div class="d-flex justify-content-between">
            <h4>{{$assessment->title}}</h4>
            @if($reviewCount === 0)
                <a
                    href="{{ route('assessment.edit', ['assessment' => $assessment->id]) }}"
                    class="text-decoration-none text-reset"
                >
                    <button class="btn btn-primary mt-3">Edit</button>
                </a>
            @else
                <button class="btn btn-primary mt-3" disabled>Edit</button>
            @endif
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
        @endif
    </x-course-header>
</x-master-layout>
<x-master-layout title="| {{$assessment->title}}">
    <x-course-header :course="$assessment->course">
        @if (Auth::user()->type == 'student')
            <h4>{{$assessment->title}}</h4>
            <div class="bg-light p-3 border rounded m-3">
                <h5>Details</h5>
                <div class="bg-white p-3 border rounded m-3">
                    <p><div class="fw-bold">Instructions: </div>{{$assessment->instruction}}</p>
                    <p><span class="fw-bold">The number of reviews required: </span>{{$assessment->num_required_reviews}}</p>
                    <p><span class="fw-bold">Max score: </span>{{$assessment->max_score}}</p>
                    <p><span class="fw-bold">Due date: </span>{{$assessment->due_date}}</p>
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
                <h5>Peer Review Received: {{count($reviewsReceived)}}</h5>
                <div class="bg-white p-3 border rounded m-3">
                    @if (count($reviewsReceived))
                        <ul>
                            @foreach ($reviewsReceived as $review)
                                <li><span class="fw-bold">{{$review->reviewer->name}}: </span>{{$review->text}}</li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center">No Reviews Received Yet</div>
                    @endif
                </div>
                <h5>Write Peer Review</h5>
                <form method="POST" action="{{ route('assessment.review.store', ['assessment' => $assessment->id]) }}">
                    @csrf
                    <div class="row m-2">
                        <div class="col-12 col-sm-6">
                            <label class="form-label">Reviewee</label>
                            <select name="reviewee" class="form-select">
                                @foreach ($potentialReviewees as $potentialReviewee)
                                <option value="{{$potentialReviewee->id}}" {{old('reviewee') == $potentialReviewee->id ? 'selected' : ''}}>{{$potentialReviewee->snumber}} {{$potentialReviewee->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('reviewee'))
                            <small class="text-danger">{{ $errors->first('reviewee') }}</small>
                            @endif
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label">Review</label>
                            <input type="text" class="form-control" name="text" value="{{old('text')}}"></input>
                            @if ($errors->has('text'))
                            <small class="text-danger">{{ $errors->first('text') }}</small>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mx-3">Submit</button>
                </form>
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
                        <div class="badge rounded-pill {{$studentData['score'] ? 'text-bg-secondary' : 'text-bg-primary'}}">
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
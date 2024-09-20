<x-master title="| {{$assessment->title}}">
    <div class="container">
        <a
            href="{{ route('course.show', ['course' => $assessment->course->id]) }}"
            class="text-decoration-none text-reset"
        >
            <h3 class="ms-1 mb-3">{{$assessment->course->name}} ({{$assessment->course->code}})</h3>
        </a>
        <hr>
        @if (Auth::user()->type == 'student')
            <p>{{$assessment->instruction}}</p>
            <p>{{$assessment->num_required_reviews}}</p>
            <p>{{$assessment->max_score}}</p>
            <p>{{$assessment->due_date}}</p>
            <p>{{$assessment->type}}</p>

            <h3>Peer Review Submitted</h3>
            <p>{{count($reviewsSubmitted)}}</p>

            <h3>Peer Review Received</h3>
            <ul>
                @foreach ($reviewsReceived as $review)
                    <li>{{$review->rating}} {{$review->text}} {{$review->reviewer->name}} -> {{$review->reviewee->name}}</li>
                @endforeach
            </ul>

            <h3>Write Peer Review</h3>

            @if (count($errors) > 0)
            <div class="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('assessment.review.store', ['assessment' => $assessment->id]) }}">
                @csrf
                
                <p><label>Reviewee: </label><select name="reviewee">
                    @foreach ($potentialReviewees as $potentialReviewee)
                    <option value="{{$potentialReviewee->id}}" {{old('reviewee') == $potentialReviewee->id ? 'selected' : ''}}>{{$potentialReviewee->snumber}} {{$potentialReviewee->name}}</option>
                    @endforeach
                </select></p>
                <p><label>Review: </label><input type="text" name="text" value="{{old('text')}}"></p>
                <button type="submit">Submit</button>
            </form>

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
    </div>
</x-master>
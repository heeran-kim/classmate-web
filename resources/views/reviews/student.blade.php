<x-master title="| {{$student->name}}">
    <x-course-header :course="$assessment->course">
        <a
            href="{{ route('assessment.show', ['assessment' => $assessment->id]) }}"
            class="text-decoration-none text-reset"
        >
            <h4>{{$assessment->title}}</h4>
        </a>
        <div class="bg-light p-3 border rounded shadow-sm m-3">
            <h5>{{$student->name}}</h5>
            <h6>Peer Review Submitted: {{count($reviewsSubmitted)}}/{{$assessment->num_required_reviews}}</h6>
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
            <h6>Peer Review Received: {{count($reviewsReceived)}}</h6>
            <div class="bg-white p-3 border rounded m-3">
                @if (count($reviewsSubmitted))
                    <ul>
                        @foreach ($reviewsReceived as $review)
                            <li><span class="fw-bold">{{$review->reviewer->name}}: </span>{{$review->text}}</li>
                        @endforeach
                    </ul>
                @else
                <div class="text-center">No Reviews Received Yet</div>
                @endif
            </div>
            <h6>Assign Score</h6>
            <form method="POST" action=" {{ route('assessment.assignScore', ['assessment' => $assessment->id, 'student' => $student->id]) }} ">
                @csrf
                <div>
                    <input type="number" class="bg-white p-2 border rounded my-3 ms-3 text-center" name="score" value="{{old('score', $score)}}" style="width: 70px;"></input>
                    / {{$assessment->max_score}}
                    @if ($errors->has('score'))
                        <small class="text-danger"> {{ $errors->first('score') }}</small>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary mx-3">Submit</button>
            </form>
        </div>
    </x-course-header>
</x-master>

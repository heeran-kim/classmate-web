<x-master>
@if (Auth::user()->type == 'student')
    <p>{{$assessment->title}}</p>
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

@if($reviewCount === 0)
<a href="{{ route('assessment.edit', ['assessment' => $assessment->id]) }}">Edit</a>
@endif

<ul>
@foreach ($studentsData as $studentData)
    <a href="{{ route('student.reviews', ['assessment' => $assessment->id, 'student' => $studentData['id']])}}">
        <li>{{$studentData['name']}} {{$studentData['submitted']}} {{$studentData['received']}} {{$studentData['score']}}</li>
    </a>
@endforeach
</ul>
@endif
<a href="{{ route('course.show', ['course' => $assessment->course->id]) }}">Back</button>
</x-master>
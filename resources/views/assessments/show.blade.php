<x-master>
@if (1)

    <h2>{{$reviewer->name}}</h2>
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
            <a href=""><li>{{$review->rating}} {{$review->text}} {{$review->reviewer->name}} -> {{$review->reviewee->name}}</li></a>
        @endforeach
    </ul>

    <h3>Write Peer Review</h3>
    <form method="POST" action="{{ route('assessment.review.store', ['assessment' => $assessment->id]) }}">
        @csrf
        
        <p><label>Reviewee: </label><select name="reviewee">
            @foreach ($potentialReviewees as $potentialReviewee)
            <option value="{{$potentialReviewee->id}}">{{$potentialReviewee->snumber}} {{$potentialReviewee->name}}</option>
            @endforeach
        </select></p>
        <p><label>Rating: </label><input type="number" name="rating"></p>
        <p><label>Review: </label><input type="text" name="text"></p>
        <button type="submit">Submit</button>
    </form>

@else

@if($reviewCount === 0)
<a href="{{ route('assessment.edit', ['assessment' => $assessment->id]) }}">Edit</a>
@endif

<ul>
@foreach ($studentsData as $studentData)
    <a href=""><li>{{$studentData['name']}} {{$studentData['received']}} {{$studentData['submitted']}} {{$studentData['score']}}</li></a>
@endforeach
</ul>
@endif
</x-master>
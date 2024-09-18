<x-master>
@if (0)

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
<form method="POST" action="{{ route('course.assessment.review.store', ['course' => $course->id, 'assessment' => $assessment->id]) }}">
    @csrf
    
    <p><label>Reviewee: </label><select name="reviewee">
        @foreach ($students as $student)
        <option value="{{$student->id}}">{{$student->snumber}} {{$student->name}}</option>
        @endforeach
    </select></p>
    <p><label>Rating: </label><input type="number" name="rating"></p>
    <p><label>Review: </label><input type="text" name="text"></p>
    <button type="submit">Submit</button>
</form>

@else

@if($reviewCount === 0)
<a href="{{ route('course.assessment.edit', ['course' => $course->id, 'assessment' => $assessment->id]) }}">Edit</a>
@endif

@foreach ($studentsData as $studentData)
    <a href=""> {{$studentData->name}} {{$studentData->received}} {{$studentData->submitted}} {{$studentData->score}} </a>
@endforeach

@endif
</x-master>
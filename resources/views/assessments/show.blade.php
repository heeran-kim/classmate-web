<x-master>
<p>{{$assessment->title}}</p>
<p>{{$assessment->instruction}}</p>
<p>{{$assessment->num_required_reviews}}</p>
<p>{{$assessment->max_score}}</p>
<p>{{$assessment->due_date}}</p>
<p>{{$assessment->type}}</p>

<ul>
    @foreach ($reviews as $review)
        <a href=""><li>{{$review->rating}} {{$review->text}} {{$review->reviewer->name}} -> {{$review->reviewee->name}}</li></a>
    @endforeach
</ul>
@if(!count($reviews))
<a href="{{ route('course.assessment.edit', ['course' => $course->id, 'assessment' => $assessment->id]) }}">Edit</a>
@endif

<a href="{{ route('course.assessment.review.create', ['course' => $course->id, 'assessment' => $assessment->id]) }}">Submit Review</a>
</x-master>
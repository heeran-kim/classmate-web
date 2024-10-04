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
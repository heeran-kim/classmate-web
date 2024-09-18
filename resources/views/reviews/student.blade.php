<x-master>
    <h2>{{$student->name}}</h2>
    <h3>Peer Review Submitted</h3>
    <ul>
        @foreach ($reviewsSubmitted as $review)
            <li>{{$review->reviewee->name}} {{$review->rating}} {{$review->text}}</li>
        @endforeach
    </ul>
    <h3>Peer Review Received</h3>
    <ul>
        @foreach ($reviewsReceived as $review)
            <li>{{$review->reviewer->name}} {{$review->rating}} {{$review->text}}</li>
        @endforeach
    </ul>
    <a href="{{ route('assessment.show', ['assessment' => $assessment->id]) }}">Back</button>
</x-master>
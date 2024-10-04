<x-master-layout title="| Review Ranking">
    <div class="bg-light p-3 border rounded shadow-sm m-3">
        <h5>Top5 Reviewers</h5>
        @if (count($top5))
            @foreach ($top5 as $reviewer)
                <div class="bg-white p-3 border rounded m-3">
                    <span class="fw-bold"><x-rating :rating="$reviewer['avg_rating']" /> {{$reviewer['user']->name}}: </span>{{$reviewer['user']->snumber}}</li>
                    @foreach ($reviewer['reviews'] as $review)
                        <li>{{$review->text}}</li>
                    @endforeach
                </div>
            @endforeach
        @else
            <div class="text-center">No Ratings Given Yet</div>
        @endif
        <div class="d-flex justify-content-center">
        </div>
    </div>
</x-master-layout>
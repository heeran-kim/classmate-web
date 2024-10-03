<x-master-layout title="| Review Ranking">
    <div class="bg-light p-3 border rounded shadow-sm m-3">
        <h5>All Reviewers</h5>
        @if (count($reviewers))
            @foreach ($reviewers as $reviewer)
                <div class="bg-white p-3 border rounded m-3">
                    <span class="fw-bold"><x-rating :rating="$reviewer->rating" /> {{$reviewer->name}}: </span>{{$reviewer->snumber}}</li>
                </div>
            @endforeach
        @else
            <div class="text-center">No Ratings Given Yet</div>
        @endif
        <div class="d-flex justify-content-center">
            {{$reviewers->links()}}
        </div>
    </div>
</x-master-layout>
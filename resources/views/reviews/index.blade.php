<x-master-layout title="| {{$assessment->title}}">
    <x-course-header :course="$assessment->course">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('assessment.show', ['assessment' => $assessment->id]) }}" class="text-decoration-none text-reset">
                <h4 class="ms-2">{{$assessment->title}}</h4>
            </a>
            <div class="d-flex">
                <input type="radio" class="btn-check" name="review-option" id="review" checked>
                <label class="btn" for="review">Review</label>
                <input type="radio" class="btn-check" name="review-option" id="reviewer">
                <label class="btn" for="reviewer">Reviewer</label>
            </div>
        </div>
        
        <div class="bg-light p-3 border rounded shadow-sm m-3">
            <div id="review-content" class="content">
                <div class="d-flex justify-content-between">
                    <h5>All Reviews</h5>
                    <x-sort-form :assessment="$assessment" :sort="$sort"/>
                </div>
                @if (count($reviews))
                    @foreach ($reviews as $review)
                        <div class="bg-white p-3 border rounded m-3">
                            <span class="fw-bold"><x-rating :rating="$review->rating" /> {{$review->reviewee->name}}: </span>{{$review->text}}</li>
                        </div>
                    @endforeach
                @else
                    <div class="text-center">No Reviews Submitted Yet</div>
                @endif
                <div class="d-flex justify-content-center">
                    {{$reviews->links()}}
                </div>
            </div>
            <div id="reviewer-content" class="content">
                <div class="d-flex justify-content-between">
                    <h5>All Reviewers</h5>
                    <x-sort-form :assessment="$assessment" :sort="$sort"/>
                </div>
                @if (count($reviewers))
                    @foreach ($reviewers as $reviewer)
                        <div class="bg-white p-3 border rounded m-3">
                            <span class="fw-bold"><x-rating :rating="$reviewer->rating" /> {{$reviewer->name}}: </span>{{$reviewer->snumber}}</li>
                        </div>
                    @endforeach
                @else
                    <div class="text-center">No Reviewers Submitted Yet</div>
                @endif
                <div class="d-flex justify-content-center">
                    {{$reviewers->links()}}
                </div>
            </div>
        </div>
    </x-course-header>

    <script>
        document.querySelectorAll('input[name="review-option"]').forEach((radio) => {
            radio.addEventListener('change', function() {
                if (this.value === 'review') {
                    document.getElementById('review-content').style.display = 'block';
                    document.getElementById('reviewer-content').style.display = 'none';
                } else if (this.value === 'reviewer') {
                    document.getElementById('review-content').style.display = 'none';
                    document.getElementById('reviewer-content').style.display = 'block';
                }
            });
        });
    </script>
</x-master-layout>
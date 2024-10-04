<div class="d-flex align-items-center justify-content-between mt-4">
    <h5>Write Peer Review</h5>
    <a class="underline text-sm text-gray-600" href="{{ route('user.rank') }}">
        {{ __('Check Out the Best Reviewers') }}
    </a>
</div>
<form method="POST" action="{{ route('assessment.review.store', ['assessment' => $assessment->id]) }}" class="bg-white p-3 border rounded m-3">
    @csrf
    {{-- REVIEWEE --}}
    <div class="mt-2">
        <x-input-label for="reviewee" :value="__('Reviewee')" />
        <select name="reviewee" class="form-select d-block mt-1 w-100 shadow-sm">
            @foreach ($potentialReviewees as $potentialReviewee)
            <option value="{{$potentialReviewee->id}}" {{old('reviewee') == $potentialReviewee->id ? 'selected' : ''}}>
                {{$potentialReviewee->snumber}} {{$potentialReviewee->name}} {{ $reviewedStudentIds->contains($potentialReviewee->id) ? '(reviewed)' : '' }}
            </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('reviewee')" class="mt-2" />
    </div>

    {{-- REVIEW TEXT --}}
    <div class="mt-2">
        <x-input-label for="review" :value="__('Review')" />
        <textarea id="review" class="form-control shadow-sm rounded d-block mt-1 w-100" rows="3" name="review">{{old('review')}}</textarea>
        <x-input-error :messages="$errors->get('review')" class="mt-2" />
    </div>
    <button type="submit" class="btn btn-primary my-3">Submit</button>
</form>
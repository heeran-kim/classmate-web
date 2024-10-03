<h6>Assign Score</h6>
<form method="POST" action=" {{ route('assessment.assignScore', ['assessment' => $assessment->id, 'student' => $student->id]) }} ">
    @csrf
    <div>
        <input class="bg-white p-2 border rounded my-3 ms-3 text-center" name="score" value="{{old('score', $score)}}" style="width: 70px;"></input>
        / {{$assessment->max_score}}
        @if ($errors->has('score'))
            <small class="text-danger"> {{ $errors->first('score') }}</small>
        @endif
    </div>
    <button type="submit" class="btn btn-primary mx-3">Submit</button>
</form>
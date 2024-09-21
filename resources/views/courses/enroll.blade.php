<x-master-layout title="| Enroll Student">
    <x-course-header :course="$course">
        <h4>Enroll Student</h4>
        @if (count($errors) > 0)
            <div class="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="bg-light p-3 border rounded shadow-sm m-3">
            <form method="POST" action="{{ route('course.enroll', ['course' => $course->id]) }}">
                @csrf
                <ul class="list-group" style="max-height: 300px; overflow-y: auto;">
                    @foreach ($students as $student)
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" value="{{$student->id}}" name="students[]"
                            {{ is_array(old('student')) && in_array($student->id, old('student')) ? 'checked' : '' }}>
                            <label class="form-check-label">{{$student->name}}</label>
                        </li>
                    @endforeach
                </ul>
                <button type="submit" class="btn btn-primary mt-3">Enroll</button>
            </form>
        </div>
    </x-course-header>
</x-master-layout>

<x-master-layout title="| Courses">
    <div class="container">

        <div class="d-flex justify-content-between mb-3">
            <h3 class="ms-1">Courses ({{count($courses)}})</h3>
            @if (Auth::user()->type == 'teacher')
                <a href="{{ route('course.create') }}" class="text-decoration-none text-reset">
                    <button class="btn btn-primary">Create</button>
                </a>
            @endif
        </div>

        @if (count($courses))
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($courses as $course)
                <div class="col">
                    <div class="card shadow-sm">
                        <a
                            href="{{ route('course.show', ['course' => $course->id]) }}"
                            class="text-decoration-none text-reset"
                        >
                        
                        <img src="{{ $course->image ? asset('storage/' . $course->image) : asset('storage/courses_images/default.png') }}" class="card-img-top border">
                            <div class="card-body">
                                <h5 class="card-title text-truncate">{{$course->name}}</h5>
                                <p class="card-title">{{$course->code}}</p>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center">No Courses Enrolled Yet</div>
        @endif


    </div>
</x-master-layout>

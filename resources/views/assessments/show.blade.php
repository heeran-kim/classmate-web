<x-master-layout title="| {{$assessment->title}}">
    <x-course-header :course="$assessment->course">
        @if (Auth::user()->type == 'student')
            @include('assessments.partials.show-student-view')
        @else
            @include('assessments.partials.show-teacher-view')
        @endif
    </x-course-header>
</x-master-layout>
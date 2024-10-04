@props(['route' => null, 'routeParams' => [], 'disabled' => false])

@if(isset($route))
    <a href="{{ route($route, $routeParams ?? []) }}" class="text-decoration-none text-reset">
        <button type="{{ $type ?? 'button' }}" class="btn btn-primary" {{ $disabled ? 'disabled' : '' }}>{{ $slot }}</button>
    </a>
@else
    <button type="{{ $type ?? 'submit' }}" class="btn btn-primary" {{ $disabled ? 'disabled' : '' }}>{{ $slot }}</button>
@endif
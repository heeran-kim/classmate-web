@auth
    {{Auth::user()->name}}
    <form method="POST" action "{{url('/logout')}}">
        @csrf
        <input type="submit" value="Logout">
    </form>
@else
    <a href="{{route('login')}}">Log in</a>
    <a href="{{route('register')}}">Register</a>
@endauth
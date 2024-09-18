<x-master>
<form method="POST" action="{{route('user.store')}}">
    @csrf
    <p><label>s-number: </label><input type="text" name="snumber"></p>
    <p><label>Password: </label><input type="password" name="password"></p>
    <button type="submit">Login</button>
</form>
<a href="{{route('user.create')}}">Register</a>
</x-master>
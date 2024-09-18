<x-master>
<form method="POST" action="{{route('user.store')}}">
    @csrf
    <p><label>Name: </label><input type="text" name="name"></p>
    <p><label>e-mail: </label><input type="text" name="email"></p>
    <p><label>s-number: </label><input type="text" name="snumber"></p>
    <p><label>Password: </label><input type="password" name="password"></p>
    <button type="submit">Register</button>
</form>
<a href="{{url('/')}}">Login</a>
</x-master>
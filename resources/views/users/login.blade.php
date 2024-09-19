<x-master>
<h1>Login</h1>

@if (count($errors) > 0)
    <div class="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{route('user.store')}}">
    @csrf
    <p><label>s-number: </label><input type="text" name="snumber" value="{{old('snumber')}}"></p>
    <p><label>Password: </label><input type="password" name="password" value="{{old('password')}}"></p>
    <button type="submit">Login</button>
</form>
<a href="{{route('user.create')}}">Register</a>
</x-master>
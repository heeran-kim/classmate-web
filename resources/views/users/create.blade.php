<x-master>
<h1>Register</h1>

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
    <p><label>Name: </label><input type="text" name="name" value="{{old('name')}}"></p>
    <p><label>e-mail: </label><input type="text" name="email" value="{{old('email')}}"></p>
    <p><label>s-number: </label><input type="text" name="snumber" value="{{old('snumber')}}"></p>
    <p><label>Password: </label><input type="password" name="password" value="{{old('password')}}"></p>
    <button type="submit">Register</button>
</form>
<a href="{{url('/')}}">Login</a>
</x-master>
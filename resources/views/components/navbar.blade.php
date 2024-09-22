<!-- Navbar for navigating through the app (Listings, Owners, and Create page) -->
<nav class="shadow-sm">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between py-3 mb-4 border-bottom">
            <!-- Logo and Home Link -->
            <div>
                <a href="{{route("dashboard")}}" class="d-flex align-items-center text-decoration-none">
                    <img src="{{asset('/images/logo.png')}}" class="me-2" height="32">
                    <div class="d-none d-sm-block fs-4">ClassMate</div>
                </a>
            </div>
    
            <div class="d-flex algin-items-center">
                @auth
                    <div class="row text-end me-2">
                        <div class="fw-bold text-uppercase">{{ Auth::user()->type }}</div>
                        <div class=>{{ Auth::user()->name }}</div>
                    </div>
                    <form method="POST" action="{{route('logout')}}">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary">Logout</button>
                    </form>
                @else
                    <a href="{{route('login')}}"><button type="button" class="btn btn-outline-primary me-2">Log in</button></a>
                    <a href="{{route('register')}}"><button type="button" class="btn btn-outline-primary">Register</button></a>
                @endauth
            </div>
        </div>
    </div>
</nav>


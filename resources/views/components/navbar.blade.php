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
    
            <div class="d-flex align-items-center gap-2">
                @auth
                    <div class="row text-end">
                        <div class="fw-bold text-uppercase">{{ Auth::user()->type }}</div>
                        <div class=>{{ Auth::user()->name }}</div>
                    </div>
                    <x-primary-button route="profile.edit">
                        {{ __('Edit') }}
                    </x-primary-button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-primary-button>
                            {{ __('Logout') }}
                        </x-primary-button>
                    </form>
                @else
                    <x-primary-button route="login">
                        {{ __('Log in') }}
                    </x-primary-button>
                    <x-primary-button route="register">
                        {{ __('Register') }}
                    </x-primary-button>
                @endauth
            </div>
        </div>
    </div>
</nav>


<nav class="navbar navbar-expand-lg navbar-light  bg-transparent @yield('border')">
    <div class="container">
        <a class="navbar-brand" style="color: @yield('logo'); font-family: 'Comfortaa'; font-weight: 500" href="/">ITMove</a>
        <button style="--bs-focus-ring-color: none" class="navbar-toggler bg-light text-light border-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto fw-normal">
                <li class="nav-item ">
                    <a class="nav-link @yield('navHome') hover-underline-animation" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @yield('navTour') hover-underline-animation" href="/tour">Tour</a>
                </li>
                @if(!Auth::user() || Auth::user()->is_admin == false)
                <li class="nav-item">
                    <a class="nav-link @yield('navReq') hover-underline-animation" href="/requestTrip">Request Trip</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link @yield('navGuide') hover-underline-animation" href="/guide">Guide</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @yield('navAbout') hover-underline-animation" href="/about">About Us</a>
                </li>
            </ul>
            @guest
            <ul class="navbar-nav">
                <!-- Conditional logic for displaying login and register should be handled server-side -->
                <li class="nav-item">
                    <a class="nav-link @yield('login') hover-underline-animation" href="/login">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @yield('register') border border-1 border-light w-100 text-center" href="/register">Register</a>
                </li>
            </ul>
            @else
            <ul class="navbar-nav" style="font-size: 20px;">
                @if(Auth::user()->is_admin == false)
                <li class="nav-item">
                    <a href="/cart/{{Auth::user()->id}}" class="nav-link" style="color: @yield('cart'); text-decoration:none">
                        <i class="bi bi-cart3"></i> <span style="font-size: 16px;"> Cart </span>
                    </a>
                </li>
                @else
                <li class="nav-item dropdown">
                    <a class="nav-link bg-transparent border-0" style="color: @yield('add')" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" v-pre>
                        <i class="bi bi-clipboard2-data"></i><span style="font-size: 16px;"> Management </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('manage.province') }}">Manage Province</a></li>
                        <hr class="dropdown-divider">
                        <li><a class="dropdown-item" href="{{ route('manage.destination') }}">Manage Destination</a></li>
                        <hr class="dropdown-divider">
                        <li><a class="dropdown-item" href="{{ route('manage.tour') }}">Manage Tour</a></li>
                        <hr class="dropdown-divider">
                        <li><a class="dropdown-item" href="{{ route('manage.user') }}">Manage User</a></li>
                    </ul>
                </li>
                @endif
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link"  style="color: @yield('profile');" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" v-pre>
                        <i class="bi bi-person-circle"></i> <span style="font-size: 16px;">Profile</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        @if(!Auth::user() || Auth::user()->is_admin == false)
                        <a class="dropdown-item" href="/inbox">
                            Inbox
                        </a>
                        <hr class="dropdown-divider">
                        @else
                        <a class="dropdown-item" href="/admin/inbox">
                            Inbox
                        </a>
                        <hr class="dropdown-divider">
                        @endif
                        {{-- @if(Auth::user()->is_admin == false) --}}
                        <a class="dropdown-item" href="/payment">
                            Payment History
                        </a>
                        <hr class="dropdown-divider">
                        {{-- @endif --}}
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                           Settings
                        </a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
            @endguest
        </div>
    </div>
</nav>

<nav class="navbar navbar-expand-lg navbar-dark site-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <span class="brand-mark"><i class="bi bi-lightning-charge-fill"></i></span>
            <span>RedStride</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products') ? 'active' : '' }}" href="{{ route('products') }}">
                        Produk
                    </a>
                </li>
            </ul>

            <div class="navbar-actions">
                <button class="btn btn-outline-light btn-sm" data-bs-toggle="modal"
                    data-bs-target="#wishlistModal" onclick="tampilkanWishlist()">
                    <i class="bi bi-star-fill me-1"></i> Wishlist (<span id="wishlist-count">0</span>)
                </button>

                <button id="btn-theme" class="btn btn-ghost btn-sm" type="button">
                    <i class="bi bi-moon-stars me-1"></i> Mode Gelap
                </button>

                @auth
                    <span class="user-pill">
                        <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST" class="d-inline m-0 p-0">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="btn btn-danger btn-sm">
                        Login
                    </a>

                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">
                        Register
                    </a>
                @endguest
            </div>
        </div>
    </div>
</nav>

@extends('layouts.main')

@section('content')
    <section class="hero text-white">
        <div class="container hero-inner">
            <div class="hero-copy">
                <span class="hero-kicker">Premium shoe management</span>
                <h1>RedStride</h1>
                <p>Kelola koleksi sepatu, stok, dan wishlist dalam dashboard yang cepat, tegas, dan rapi.</p>
                <div class="hero-actions">
                    <a href="{{ route('products') }}" class="btn btn-danger btn-lg">
                        <i class="bi bi-grid-3x3-gap-fill me-2"></i>Lihat Produk
                    </a>
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                            Login
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <section class="container section-block">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="dashboard-card">
                    <div class="metric-icon"><i class="bi bi-box-seam"></i></div>
                    <h5>Total Produk</h5>
                    <h2 id="total-produk">3</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-card">
                    <div class="metric-icon"><i class="bi bi-stack"></i></div>
                    <h5>Stok Tersedia</h5>
                    <h2 id="total-stok">27</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-card">
                    <div class="metric-icon"><i class="bi bi-tags"></i></div>
                    <h5>Kategori</h5>
                    <h2>3</h2>
                </div>
            </div>
        </div>
    </section>

    <section class="container section-block">
        <div class="section-heading">
            <div>
                <span class="section-kicker">Featured stock</span>
                <h3>Daftar Sepatu</h3>
            </div>
            <a href="{{ route('products') }}" class="btn btn-outline-danger">
                Lihat Semua Produk
            </a>
        </div>

        <div class="row g-4" id="container-barang">
            <div class="col-md-4">
                <div class="card product-card h-100">
                    <img src="{{ asset('assets/NIKE_P_6000.jpg') }}" class="card-img-top" alt="Nike P-6000">
                    <div class="card-body">
                        <h5 class="card-title">Nike P-6000</h5>
                        <p class="card-text harga-text">Harga: Rp 1.429.000</p>
                        <p class="card-text stok-text">Stok: 10</p>

                        <div class="d-flex gap-2">
                            <button class="btn btn-danger btn-detail flex-fill">Beli</button>
                            <button class="btn btn-outline-danger btn-wishlist flex-fill">
                                <i class="bi bi-star me-1"></i> Wishlist
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card product-card h-100">
                    <img src="{{ asset('assets/AIR_FORCE_1.jpg') }}" class="card-img-top" alt="Nike Air Force 1">
                    <div class="card-body">
                        <h5 class="card-title">Nike Air Force 1</h5>
                        <p class="card-text harga-text">Harga: Rp 1.529.000</p>
                        <p class="card-text stok-text">Stok: 7</p>

                        <div class="d-flex gap-2">
                            <button class="btn btn-danger btn-detail flex-fill">Beli</button>
                            <button class="btn btn-outline-danger btn-wishlist flex-fill">
                                <i class="bi bi-star me-1"></i> Wishlist
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card product-card h-100">
                    <img src="{{ asset('assets/AIR_JORDAN_1_LOW.jpg') }}" class="card-img-top" alt="Nike Air Jordan 1 Low">
                    <div class="card-body">
                        <h5 class="card-title">Nike Air Jordan 1 Low</h5>
                        <p class="card-text harga-text">Harga: Rp 1.729.000</p>
                        <p class="card-text stok-text">Stok: 10</p>

                        <div class="d-flex gap-2">
                            <button class="btn btn-danger btn-detail flex-fill">Beli</button>
                            <button class="btn btn-outline-danger btn-wishlist flex-fill">
                                <i class="bi bi-star me-1"></i> Wishlist
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('modal.wishlist')
@endsection

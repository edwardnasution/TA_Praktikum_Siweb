<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ThreadStock | Warehouse Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#"><i class="bi bi-intersect me-2"></i>THREADSTOCK</a>

            <form action="{{ url('/logout') }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
                @csrf
                <button type="submit" class="nav-link text-danger border-0 bg-transparent fw-bold">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>

            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="#">Inventory</a>
                <a class="nav-link" href="#form-input">Add Stock</a>
                <button id="dark-mode-toggle" class="btn btn-outline-light btn-sm ms-2"><i class="bi bi-moon"></i></button>
            </div>
        </div>
    </nav>

    <header class="hero-section text-center py-5 mb-5">
        <div class="hero-overlay">
            <div class="container py-5">
                <h1 class="display-5 fw-bold text-white">THREADSTOCK</h1>
                <p class="lead text-light">Manage and shop the trendiest clothing items.</p>
                <a href="#form-input" class="btn-add-new">+ Tambah Produk Baru</a>
            </div>
        </div>
    </header>

    <section class="container mb-5">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3 stat-card">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-box-seam fs-1 text-primary"></i>
                        <div>
                            <h6 class="opacity-75 mb-0">Total Produk</h6>
                            <h2 class="fw-bold">{{ $products->sum('stok') }} Pcs</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3 stat-card">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-hat fs-1 text-success"></i>
                        <div>
                            <h6 class="opacity-75 mb-0">Total Model</h6>
                            <h2 class="fw-bold">{{ $products->count() }} Model</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3 stat-card">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-tags fs-1 text-warning"></i>
                        <div>
                            <h6 class="opacity-75 mb-0">Kategori</h6>
                            <h2 class="fw-bold">{{ $categories->count() }} Jenis</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <h3 class="fw-bold mb-4 border-start border-4 border-primary ps-3">Daftar Katalog Kaos</h3>
        <div class="row g-4" id="product-list">
            @forelse($products as $p)
            <div class="col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm h-100">
                    <img src="{{ asset('assets/' . $p->foto) }}" class="card-img-top" onerror="this.src='https://via.placeholder.com/300?text=No+Image'">
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="badge bg-primary">{{ $p->category->nama_category }}</span>
                            <span class="badge bg-secondary">{{ $p->brand->nama_brand ?? 'No Brand' }}</span>
                        </div>
                        <h5 class="fw-bold text-dark">{{ $p->nama_product }}</h5>
                        <p class="text-primary fw-bold mb-1">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                        <p class="small text-muted">Stok: {{ $p->stok }} | {{ $p->ukuran }}</p>
                        <div class="d-flex gap-2 mt-3">
                            <button class="btn btn-sm btn-outline-dark w-100">Detail</button>
                            <form action="{{ route('product.destroy', $p->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus produk ini?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Belum ada produk di database.</p>
            </div>
            @endforelse
        </div>
    </section>

    <section id="form-input" class="container mb-5 py-5">
        <div class="section-title">
            <i class="bi bi-plus-circle"></i>
            <h3>Management Center</h3>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow p-4">
                    <h4 class="fw-bold mb-4">Registrasi Produk Baru</h4>

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form action="{{ route('product.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Model</label>
                                <input type="text" name="nama_product" class="form-control" placeholder="e.g. Noir Oversize" required />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Kategori</label>
                                <select name="category_id" class="form-select" required>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nama_category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Brand</label>
                                <select name="brand_id" class="form-select" required>
                                    @foreach($brands as $brand)
                                    <option value="{{ $brand->brand_id }}">{{ $brand->nama_brand }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Harga (IDR)</label>
                                <input type="number" name="harga" class="form-control" required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jumlah Stok</label>
                                <input type="number" name="stok" class="form-control" required />
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Nama File Foto</label>
                                <input type="text" name="foto" class="form-control" placeholder="kaos-hitam.jpg" required />
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Ukuran</label>
                                <input type="text" name="ukuran" class="form-control" placeholder="S,M,L,XL" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Material</label>
                                <input type="text" name="material" class="form-control" placeholder="Cotton Combed 30s" />
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-dark w-100 py-2 fw-bold">SIMPAN PRODUK KE DATABASE</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card p-3 mb-4 shadow-sm border-0">
                    <label class="form-label fw-bold">Tambah Kategori Baru</label>
                    <form action="{{ route('category.store') }}" method="POST" class="d-flex gap-2">
                        @csrf
                        <input name="nama_category" type="text" class="form-control" placeholder="Nama Kategori" required />
                        <button type="submit" class="btn btn-primary"><i class="bi bi-plus"></i></button>
                    </form>
                </div>

                <div class="card p-3 shadow-sm border-0">
                    <label class="form-label fw-bold">Tambah Brand Baru</label>
                    <form action="{{ route('brand.store') }}" method="POST" class="d-flex gap-2">
                        @csrf
                        <input name="nama_brand" type="text" class="form-control" placeholder="Nama Brand" required />
                        <button type="submit" class="btn btn-primary"><i class="bi bi-plus"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <p class="mb-0 small">© 2026 THREADSTOCK SYSTEM | Built for Siweb Final Project</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
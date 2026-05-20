@extends('layouts.main')

@section('content')
    <section class="container section-block">
        <div class="section-heading">
            <div>
                <span class="section-kicker">Inventory</span>
                <h3>Daftar Sepatu RedStride</h3>
            </div>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#createProduct">
                <i class="bi bi-plus-lg me-1"></i> Tambah Produk
            </button>
        </div>

        <div class="row g-4" id="container-barang">
            @forelse ($products as $item)
                <div class="col-md-4">
                    <div class="card product-card inventory-card h-100">
                        <img src="{{ $item->product_image
                            ? asset('storage/' . $item->product_image)
                            : asset('assets/default.jpg') }}"
                            class="card-img-top"
                            alt="{{ $item->product_name }}">

                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <span class="product-category">
                                    {{ $item->category->category_name ?? 'Tanpa kategori' }}
                                </span>
                                <h5 class="card-title mt-2">{{ $item->product_name }}</h5>
                            </div>

                            <p class="card-text harga-text mb-1">
                                Harga: Rp {{ number_format($item->product_price, 0, ',', '.') }}
                            </p>

                            <p class="card-text stok-text mb-3">Stok: {{ $item->product_stock }}</p>

                            <div class="d-flex gap-2 mt-auto">
                                <button class="btn btn-warning btn-sm flex-fill"
                                    data-bs-toggle="modal"
                                    data-bs-target="#updateProduct{{ $item->product_id }}">
                                    Update
                                </button>

                                <form action="{{ route('products.destroy', $item->product_id) }}"
                                    method="POST"
                                    class="flex-fill m-0"
                                    onsubmit="return confirm('Yakin ingin menghapus produk {{ $item->product_name }}?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm w-100">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @include('modal.updateProduct')
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="bi bi-box2"></i>
                        <h5>Belum ada produk</h5>
                        <p>Tambahkan produk pertama untuk mulai mengelola stok RedStride.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    @include('modal.createProduct')
    @include('modal.wishlist')
@endsection

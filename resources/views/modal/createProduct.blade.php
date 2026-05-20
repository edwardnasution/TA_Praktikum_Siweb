<div class="modal fade" id="createProduct" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="modal-content">
                
                <!-- Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Produk RedStride</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">

                    <!-- Nama Produk -->
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Nama Produk</label>
                        <input type="text" 
                               class="form-control" 
                               id="product_name" 
                               name="product_name" 
                               required>
                    </div>

                    <!-- Kategori -->
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->category_id }}">
                                    {{ $cat->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Harga -->
                    <div class="mb-3">
                        <label for="product_price" class="form-label">Harga Produk</label>
                        <input type="number" 
                               class="form-control" 
                               id="product_price" 
                               name="product_price" 
                               required>
                    </div>

                    <!-- Stok -->
                    <div class="mb-3">
                        <label for="product_stock" class="form-label">Stok Produk</label>
                        <input type="number" 
                               class="form-control" 
                               id="product_stock" 
                               name="product_stock" 
                               required>
                    </div>

                    <!-- Gambar -->
                    <div class="mb-3">
                        <label for="product_image" class="form-label">Gambar Produk</label>
                        <input type="file" 
                               class="form-control" 
                               id="product_image" 
                               name="product_image" 
                               required>
                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">
                        Simpan
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

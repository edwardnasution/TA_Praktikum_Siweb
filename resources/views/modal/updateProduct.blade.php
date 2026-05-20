<div class="modal fade" id="updateProduct{{ $item->product_id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('products.update', $item->product_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Update Produk RedStride</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">

                    <!-- Nama Produk -->
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" 
                               class="form-control" 
                               name="product_name" 
                               value="{{ $item->product_name }}" 
                               required>
                    </div>

                    <!-- Kategori -->
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-control" name="category_id" required>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->category_id }}"
                                    {{ $item->category_id == $cat->category_id ? 'selected' : '' }}>
                                    {{ $cat->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Harga -->
                    <div class="mb-3">
                        <label class="form-label">Harga Produk</label>
                        <input type="number" 
                               class="form-control" 
                               name="product_price" 
                               value="{{ $item->product_price }}" 
                               required>
                    </div>

                    <!-- Stok -->
                    <div class="mb-3">
                        <label class="form-label">Stok Produk</label>
                        <input type="number" 
                               class="form-control" 
                               name="product_stock" 
                               value="{{ $item->product_stock }}" 
                               required>
                    </div>

                    <!-- Gambar -->
                    <div class="mb-3">
                        <label class="form-label">Ganti Gambar (Opsional)</label>

                        <!-- Preview gambar lama -->
                        <div class="mb-2">
                            <img src="{{ $item->product_image 
                                ? asset('storage/' . $item->product_image) 
                                : asset('assets/default.jpg') }}"
                                class="img-thumbnail"
                                style="width: 100px;">
                        </div>

                        <input type="file" class="form-control" name="product_image">
                        <small class="text-muted">
                            Biarkan kosong jika tidak ingin mengganti gambar.
                        </small>
                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">
                        Update
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

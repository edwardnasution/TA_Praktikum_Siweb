(function() {
    'use strict';
    const DEFAULT_CATEGORIES = ['T-Shirt', 'Longsleeve', 'Hoodie'];
    const DARK_MODE_KEY = 'threadstock_dark_mode';
    const WISHLIST_KEY = 'threadstock_wishlist';
    
    // Show More functionality
    let showingAll = false;
    const INITIAL_SHOW = 6; 
    
    /* Ambil data produk dari localStorage */
    function getProducts() {
        const data = localStorage.getItem('products');
        return data ? JSON.parse(data) : [];
    }

    /* Simpan data produk ke localStorage */
    function saveProducts(products) {
        localStorage.setItem('products', JSON.stringify(products));
    }

    /* Ambil data kategori dari localStorage */
    function getCategories() {
        const c = localStorage.getItem('categories');
        return c ? JSON.parse(c) : [];
    }

    /* Simpan data kategori ke localStorage */
    function saveCategories(arr) {
        localStorage.setItem('categories', JSON.stringify(arr));
    }

    /* Pastikan kategori default ada */
    function ensureDefaultCategories() {
        const cats = getCategories();
        if (!cats || cats.length === 0) {
            saveCategories(DEFAULT_CATEGORIES.slice());
        }
    }

    // FUNGSI DARK MODE

    /* Cek apakah dark mode aktif */
    function isDarkMode() {
        return localStorage.getItem(DARK_MODE_KEY) === 'true';
    }

    /* Toggle dark mode on/off */
    function toggleDarkMode() {
        const body = document.body;
        const isDark = body.classList.toggle('dark-mode');
        localStorage.setItem(DARK_MODE_KEY, isDark);
        
        // Update ikon tombol dark mode
        updateDarkModeButton(isDark);
    }

    /* Update tampilan tombol dark mode */
    function updateDarkModeButton(isDark) {
        const btn = document.getElementById('dark-mode-toggle');
        if (btn) {
            btn.innerHTML = isDark ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon"></i>';
        }
    }

    /* Terapkan dark mode dari localStorage saat halaman dimuat */
    function applyDarkMode() {
        if (isDarkMode()) {
            document.body.classList.add('dark-mode');
        }
        updateDarkModeButton(isDarkMode());
    }

    // FUNGSI WISHLIST (sessionStorage)

    /* Ambil wishlist dari sessionStorage */
    function getWishlist() {
        const data = sessionStorage.getItem(WISHLIST_KEY);
        return data ? JSON.parse(data) : [];
    }

    /* Simpan wishlist ke sessionStorage */
    function saveWishlist(wishlist) {
        sessionStorage.setItem(WISHLIST_KEY, JSON.stringify(wishlist));
    }

    /* Tambah produk ke wishlist */
    function addToWishlist(productName) {
        const wishlist = getWishlist();
        
        // Cek apakah produk sudah ada
        if (wishlist.includes(productName)) {
            alert('Produk sudah ada di wishlist!');
            return false;
        }
        
        wishlist.push(productName);
        saveWishlist(wishlist);
        updateWishlistBadge();
        alert('Ditambahkan ke wishlist');
        return true;
    }

    /* Hapus produk dari wishlist */
    function removeFromWishlist(productName) {
        const wishlist = getWishlist();
        const index = wishlist.indexOf(productName);
        
        if (index > -1) {
            wishlist.splice(index, 1);
            saveWishlist(wishlist);
            updateWishlistBadge();
            renderWishlistModal();
        }
    }

    /* Update badge jumlah wishlist di navbar */
    function updateWishlistBadge() {
        const wishlist = getWishlist();
        const badge = document.getElementById('wishlist-badge');
        
        if (badge) {
            badge.textContent = wishlist.length;
            badge.style.display = wishlist.length > 0 ? 'inline-block' : 'none';
        }
    }

    /* Tampilkan item wishlist di modal */
    function renderWishlistModal() {
        const wishlist = getWishlist();
        const container = document.getElementById('wishlist-items');
        
        if (!container) return;
        
        container.innerHTML = '';
        
        if (wishlist.length === 0) {
            container.innerHTML = '<p class="text-muted text-center py-4">Wishlist kosong</p>';
            return;
        }
        
        // Tampilkan setiap item wishlist
        wishlist.forEach(function(productName) {
            const item = document.createElement('div');
            item.className = 'd-flex align-items-center justify-content-between border-bottom py-2';
            
            const nameSpan = document.createElement('span');
            nameSpan.textContent = productName;
            
            const removeBtn = document.createElement('button');
            removeBtn.className = 'btn btn-sm btn-outline-danger';
            removeBtn.innerHTML = '<i class="bi bi-trash"></i>';
            removeBtn.addEventListener('click', function() {
                removeFromWishlist(productName);
            });
            
            item.appendChild(nameSpan);
            item.appendChild(removeBtn);
            container.appendChild(item);
        });
    }

    /* Buka modal wishlist */
    function openWishlistModal() {
        renderWishlistModal();
        const modalEl = document.getElementById('wishlistModal');
        if (modalEl) {
            const bsModal = new bootstrap.Modal(modalEl);
            bsModal.show();
        }
    }

    // FITUR BELI (Pengurangan Stok)

    /* Beli produk - kurangi stok 1 */
    function buyProduct(index) {
        const products = getProducts();
        const product = products[index];
        
        if (!product) {
            alert('Produk tidak ditemukan');
            return;
        }
        
        const currentStock = parseInt(product.stok, 10);
        
        if (currentStock <= 0) {
            alert('Stok habis');
            return;
        }
        
        // Kurangi stok 1
        product.stok = currentStock - 1;
        saveProducts(products);
        
        // Update tampilan stok langsung tanpa reload
        updateStockDisplay(index, product.stok);
        
        alert('Produk berhasil dibeli');
    }

    /* Update tampilan stok untuk produk tertentu */
    function updateStockDisplay(index, newStock) {
        // Cari elemen stok di card tertentu
        const cards = document.querySelectorAll('.product-card');
        if (cards[index]) {
            const stockElement = cards[index].querySelector('.stock-display');
            if (stockElement) {
                stockElement.textContent = newStock;
            }
            
            // Nonaktifkan tombol beli jika stok 0
            const buyBtn = cards[index].querySelector('.btn-buy');
            if (buyBtn) {
                buyBtn.disabled = newStock <= 0;
                if (newStock <= 0) {
                    buyBtn.classList.add('disabled');
                }
            }
        }
    }

    // FUNGSI SHOW MORE

    /* Terapkan show more/hide */
    function applyShowMore() {
        const products = document.querySelectorAll('.product-card');
        const showMoreBtn = document.getElementById('btn-show-more');
        
        if (!showMoreBtn) return;
        
        if (products.length <= INITIAL_SHOW) {
            showMoreBtn.style.display = 'none';
            return;
        }
        
        showMoreBtn.style.display = 'inline-block';
        
        if (!showingAll) {
            // Sembunyikan produk lebih dari INITIAL_SHOW
            products.forEach((product, index) => {
                if (index >= INITIAL_SHOW) {
                    const col = product.closest('.col-md-4');
                    if (col) col.style.display = 'none';
                }
            });
            showMoreBtn.textContent = 'Show More';
        } else {
            // Tampilkan semua
            products.forEach((product) => {
                const col = product.closest('.col-md-4');
                if (col) col.style.display = 'block';
            });
            showMoreBtn.textContent = 'Show Less';
        }
    }

    /* Toggle show more/less */
    function toggleShowMore() {
        showingAll = !showingAll;
        applyShowMore();
    }

    // FUNGSI RENDER

    /* Render daftar kategori */
    function renderCategoryManager() {
        const list = document.getElementById('category-manager-list');
        const cats = getCategories();
        
        if (!list) return;
        
        list.innerHTML = '';
        
        if (!cats || cats.length === 0) {
            list.innerHTML = '<div class="text-muted small">Belum ada kategori.</div>';
            return;
        }

        // Tampilkan setiap kategori
        cats.forEach(function(c, idx) {
            const el = document.createElement('div');
            el.className = 'd-flex align-items-center gap-2 mb-2';
            
            const nameDiv = document.createElement('div');
            nameDiv.className = 'flex-grow-1';
            nameDiv.textContent = c;
            
            const editBtn = document.createElement('button');
            editBtn.className = 'btn btn-sm btn-outline-secondary';
            editBtn.textContent = 'Ubah';
            editBtn.dataset.idx = idx;
            editBtn.dataset.action = 'edit';
            
            const deleteBtn = document.createElement('button');
            deleteBtn.className = 'btn btn-sm btn-outline-danger';
            deleteBtn.textContent = 'Hapus';
            deleteBtn.dataset.idx = idx;
            deleteBtn.dataset.action = 'del';
            
            el.appendChild(nameDiv);
            el.appendChild(editBtn);
            el.appendChild(deleteBtn);
            list.appendChild(el);
        });
    }

    /* Isi dropdown kategori */
    function populateCategorySelect() {
        const select = document.getElementById('input-kategori');
        const cats = getCategories();
        
        if (!select) return;
        
        select.innerHTML = '';
        
        cats.forEach(function(c) {
            const opt = document.createElement('option');
            opt.value = c;
            opt.textContent = c;
            select.appendChild(opt);
        });
    }

    /* Isi dropdown kategori di modal edit */
    function populateModalCategorySelect(selectedCategory) {
        const select = document.getElementById('modal-kategori');
        const cats = getCategories();
        
        if (!select) return;
        
        select.innerHTML = '';
        
        cats.forEach(function(c) {
            const opt = document.createElement('option');
            opt.value = c;
            opt.textContent = c;
            if (c === selectedCategory) {
                opt.selected = true;
            }
            select.appendChild(opt);
        });
    }

    /* Render semua produk sebagai kartu */
    function renderProducts() {
        const products = getProducts();
        const container = document.getElementById('product-list');
        
        if (!container) return;
        
        container.innerHTML = '';
        
        let totalStok = 0;

        // Tampilkan setiap produk
        products.forEach(function(p, index) {
            totalStok += parseInt(p.stok, 10);
            
            // Buat kartu pakai DOM manipulation
            const col = document.createElement('div');
            col.className = 'col-md-4';
            
            const card = document.createElement('div');
            card.className = 'card h-100 shadow-sm border-0 product-card';
            
            // Gambar
            const img = document.createElement('img');
            img.src = 'assets/' + (p.foto || '');
            img.className = 'card-img-top bg-light';
            img.alt = p.nama;
            img.onerror = function() {
                this.src = 'https://via.placeholder.com/300x300?text=Foto+Tidak+Ada';
            };
            
            // Body kartu
            const cardBody = document.createElement('div');
            cardBody.className = 'card-body';
            
            // Judul
            const title = document.createElement('h5');
            title.className = 'fw-bold';
            title.textContent = p.nama;
            
            // Harga
            const price = document.createElement('p');
            price.className = 'product-price';
            price.textContent = 'Rp ' + parseInt(p.harga).toLocaleString('id-ID');
            
            // Info stok & kategori
            const info = document.createElement('p');
            info.className = 'product-info';
            info.innerHTML = 'Stok: <span class="stock-display">' + p.stok + '</span> | ' + p.kategori;
            
            // Container tombol pertama (Detail, Edit, Hapus)
            const btnContainer = document.createElement('div');
            btnContainer.className = 'd-flex gap-2 mb-2';
            
            // Tombol Detail
            const detailBtn = document.createElement('button');
            detailBtn.className = 'btn btn-outline-primary btn-sm';
            detailBtn.textContent = 'Detail';
            detailBtn.addEventListener('click', function() {
                showProductDetail(index);
            });
            
            // Tombol Edit
            const editBtn = document.createElement('button');
            editBtn.className = 'btn btn-outline-secondary btn-sm';
            editBtn.innerHTML = '<i class="bi bi-pencil"></i>';
            editBtn.addEventListener('click', function() {
                showProductEdit(index);
            });
            
            // Tombol Hapus
            const deleteBtn = document.createElement('button');
            deleteBtn.className = 'btn btn-danger btn-sm';
            deleteBtn.innerHTML = '<i class="bi bi-trash"></i>';
            deleteBtn.addEventListener('click', function() {
                deleteProduct(index);
            });
            
            btnContainer.appendChild(detailBtn);
            btnContainer.appendChild(editBtn);
            btnContainer.appendChild(deleteBtn);
            
            // Container tombol kedua (Beli & Wishlist)
            const actionContainer = document.createElement('div');
            actionContainer.className = 'd-flex gap-2 mt-2';
            
            // Tombol Beli
            const buyBtn = document.createElement('button');
            buyBtn.className = 'btn btn-success btn-sm btn-buy';
            buyBtn.innerHTML = '<i class="bi bi-cart-plus me-1"></i> Beli';
            buyBtn.disabled = parseInt(p.stok, 10) <= 0;
            buyBtn.addEventListener('click', function() {
                buyProduct(index);
            });
            
            // Tombol Wishlist
            const wishlistBtn = document.createElement('button');
            wishlistBtn.className = 'btn btn-outline-danger btn-sm';
            wishlistBtn.innerHTML = '<i class="bi bi-heart"></i>';
            wishlistBtn.title = 'Tambah ke Wishlist';
            wishlistBtn.addEventListener('click', function() {
                addToWishlist(p.nama);
            });
            
            actionContainer.appendChild(buyBtn);
            actionContainer.appendChild(wishlistBtn);
            
            // Pasang semua elemen
            cardBody.appendChild(title);
            cardBody.appendChild(price);
            cardBody.appendChild(info);
            cardBody.appendChild(btnContainer);
            cardBody.appendChild(actionContainer);
            
            card.appendChild(img);
            card.appendChild(cardBody);
            
            col.appendChild(card);
            container.appendChild(col);
        });

        // Update statistik
        const totalProdukEl = document.getElementById('stat-total-produk');
        const totalModelEl = document.getElementById('stat-total-model');
        
        if (totalProdukEl) {
            totalProdukEl.textContent = totalStok + ' Pcs';
        }
        if (totalModelEl) {
            totalModelEl.textContent = products.length + ' Model';
        }

        // Reset show more state
        showingAll = false;
        applyShowMore();
    }

    // FUNGSI CRUD PRODUK

    /* Tangani submit form untuk tambah produk baru */
    function handleProductFormSubmit(e) {
        e.preventDefault();
        
        const products = getProducts();
        
        const newProduct = {
            nama: document.getElementById('input-nama').value,
            kategori: document.getElementById('input-kategori').value,
            harga: document.getElementById('input-harga').value,
            stok: document.getElementById('input-stok').value,
            foto: document.getElementById('input-foto').value,
            deskripsi: document.getElementById('input-deskripsi').value,
            ukuran: document.getElementById('input-ukuran').value,
            material: document.getElementById('input-material').value
        };
        
        products.push(newProduct);
        saveProducts(products);
        
        const form = document.getElementById('product-form');
        form.reset();
        
        renderProducts();
        alert('Data Berhasil Disimpan!');
    }

    /* Hapus produk */
    function deleteProduct(index) {
        if (confirm('Hapus produk ini?')) {
            const products = getProducts();
            products.splice(index, 1);
            saveProducts(products);
            renderProducts();
        }
    }

    /* Tampilkan detail produk di modal */
    function showProductDetail(index) {
        const products = getProducts();
        const p = products[index];
        
        if (!p) {
            alert('Produk tidak ditemukan');
            return;
        }
        
        const modalEl = document.getElementById('productDetailModal');
        modalEl.dataset.index = index;
        
        document.getElementById('view-nama').textContent = p.nama || '-';
        document.getElementById('view-harga').textContent = p.harga ? ('Rp ' + parseInt(p.harga).toLocaleString('id-ID')) : '-';
        
        const kategoriEl = document.getElementById('view-kategori');
        kategoriEl.innerHTML = p.kategori ? ('<span class="badge bg-secondary">' + p.kategori + '</span>') : '';
        
        document.getElementById('view-stok').textContent = p.stok ? ('Stok: ' + p.stok) : '';
        document.getElementById('view-deskripsi').textContent = p.deskripsi || '';
        document.getElementById('view-ukuran').textContent = p.ukuran ? ('Ukuran: ' + p.ukuran) : '';
        document.getElementById('view-material').textContent = p.material ? ('Material: ' + p.material) : '';
        document.getElementById('modal-image').src = 'assets/' + (p.foto || '');
        
        document.getElementById('modal-view').classList.remove('d-none');
        document.getElementById('modal-product-form').classList.add('d-none');
        document.getElementById('modal-save-btn').classList.add('d-none');
        
        const bsModal = new bootstrap.Modal(modalEl);
        bsModal.show();
    }

    /* Tampilkan form edit produk di modal */
    function showProductEdit(index) {
        const products = getProducts();
        const p = products[index];
        
        if (!p) {
            alert('Produk tidak ditemukan');
            return;
        }
        
        const modalEl = document.getElementById('productDetailModal');
        modalEl.dataset.index = index;
        
        // Isi field form
        document.getElementById('modal-nama').value = p.nama || '';
        document.getElementById('modal-foto').value = p.foto || '';
        document.getElementById('modal-image-edit').src = 'assets/' + (p.foto || '');
        
        populateModalCategorySelect(p.kategori);
        
        document.getElementById('modal-harga').value = p.harga || '';
        document.getElementById('modal-stok').value = p.stok || '';
        document.getElementById('modal-deskripsi').value = p.deskripsi || '';
        document.getElementById('modal-ukuran').value = p.ukuran || '';
        document.getElementById('modal-material').value = p.material || '';
        
        // Tampilkan form edit, sembunyikan view
        document.getElementById('modal-view').classList.add('d-none');
        document.getElementById('modal-product-form').classList.remove('d-none');
        document.getElementById('modal-save-btn').classList.remove('d-none');
        
        const bsModal = new bootstrap.Modal(modalEl);
        bsModal.show();
    }

    /* Simpan perubahan produk dari modal */
    function saveProductDetail() {
        const modalEl = document.getElementById('productDetailModal');
        const idx = parseInt(modalEl.dataset.index, 10);
        
        if (Number.isNaN(idx)) {
            alert('Index produk tidak valid');
            return;
        }
        
        const products = getProducts();
        const p = products[idx];
        
        if (!p) {
            alert('Produk tidak ditemukan');
            return;
        }
        
        p.nama = document.getElementById('modal-nama').value.trim();
        p.foto = document.getElementById('modal-foto').value.trim();
        p.kategori = document.getElementById('modal-kategori').value;
        p.harga = document.getElementById('modal-harga').value;
        p.stok = document.getElementById('modal-stok').value;
        p.deskripsi = document.getElementById('modal-deskripsi').value.trim();
        p.ukuran = document.getElementById('modal-ukuran').value.trim();
        p.material = document.getElementById('modal-material').value.trim();
        
        // Simpan dan refresh
        saveProducts(products);
        renderProducts();
        
        const bsModal = bootstrap.Modal.getInstance(modalEl);
        if (bsModal) bsModal.hide();
        
        alert('Perubahan produk berhasil disimpan');
    }

    // FUNGSI CRUD KATEGORI

    /* Tambah kategori baru */
    function addCategory() {
        const input = document.getElementById('new-category-name');
        const name = input.value.trim();
        
        if (!name) {
            alert('Masukkan nama kategori');
            return;
        }
        
        const cats = getCategories();
        
        if (cats.includes(name)) {
            alert('Kategori sudah ada');
            return;
        }
        
        cats.push(name);
        saveCategories(cats);
        
        input.value = '';
        
        populateCategorySelect();
        renderCategoryManager();
    }

    /* Tangani aksi kategori (edit/hapus) */
    function handleCategoryAction(action, idx) {
        const cats = getCategories();
        
        if (action === 'del') {
            if (!confirm('Hapus kategori ini?')) return;
            cats.splice(idx, 1);
            saveCategories(cats);
            populateCategorySelect();
            renderCategoryManager();
        } else if (action === 'edit') {
            const newName = prompt('Ubah nama kategori', cats[idx]);
            if (newName && newName.trim()) {
                cats[idx] = newName.trim();
                saveCategories(cats);
                populateCategorySelect();
                renderCategoryManager();
            }
        }
    }

    // SETUP EVENT LISTENER

    /* Setup semua event listener */
    function setupEventListeners() {
        // Submit form produk
        const productForm = document.getElementById('product-form');
        if (productForm) {
            productForm.addEventListener('submit', handleProductFormSubmit);
        }
        
        // Tombol tambah kategori
        const addCategoryBtn = document.getElementById('add-category-btn');
        if (addCategoryBtn) {
            addCategoryBtn.addEventListener('click', addCategory);
        }
        
        // Klik daftar kategori (event delegation)
        const categoryList = document.getElementById('category-manager-list');
        if (categoryList) {
            categoryList.addEventListener('click', function(e) {
                const target = e.target;
                if (target.dataset && target.dataset.action) {
                    const idx = parseInt(target.dataset.idx, 10);
                    handleCategoryAction(target.dataset.action, idx);
                }
            });
        }
        
        // Tombol simpan modal
        const modalSaveBtn = document.getElementById('modal-save-btn');
        if (modalSaveBtn) {
            modalSaveBtn.addEventListener('click', saveProductDetail);
        }
        
        // Input foto modal - preview langsung
        const modalFotoInput = document.getElementById('modal-foto');
        if (modalFotoInput) {
            modalFotoInput.addEventListener('input', function(e) {
                const v = e.target.value.trim();
                const img = document.getElementById('modal-image-edit') || document.getElementById('modal-image');
                if (img) img.src = 'assets/' + (v || '');
            });
        }
        
        // Toggle dark mode
        const darkModeBtn = document.getElementById('dark-mode-toggle');
        if (darkModeBtn) {
            darkModeBtn.addEventListener('click', toggleDarkMode);
        }
        
        // Tombol wishlist navbar
        const wishlistBtn = document.getElementById('wishlist-nav-btn');
        if (wishlistBtn) {
            wishlistBtn.addEventListener('click', openWishlistModal);
        }
        
        // Tombol show more
        const showMoreBtn = document.getElementById('btn-show-more');
        if (showMoreBtn) {
            showMoreBtn.addEventListener('click', toggleShowMore);
        }
    }

    // INISIALISASI

    /* Inisialisasi aplikasi */
    function init() {
        // Inisialisasi kategori default
        ensureDefaultCategories();
        
        // Isi UI
        populateCategorySelect();
        renderCategoryManager();
        renderProducts();
        
        // Terapkan dark mode jika tersimpan
        applyDarkMode();
        
        // Update badge wishlist
        updateWishlistBadge();
        
        // Setup event listener
        setupEventListeners();
    }

    // Jalankan inisialisasi saat DOM siap
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
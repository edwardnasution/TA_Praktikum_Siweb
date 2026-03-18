<?php
session_start();

if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">

</html>

<!doctype html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ThreadStock | Warehouse Management</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#"><i class="bi bi-intersect me-2"></i>THREADSTOCK</a>
      <a class="nav-link text-danger" href="logout.php" onclick="return confirm('Apakah Anda yakin ingin keluar dari halaman ini?');">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
      <div class="navbar-nav ms-auto">
        <a class="nav-link" href="#">Inventory</a>
        <a class="nav-link" href="#form-input">Add Stock</a>
        <!-- Dark Mode Toggle Button -->
        <button
          id="dark-mode-toggle"
          class="btn btn-outline-light btn-sm ms-2"
          title="Toggle Dark Mode">
          <i class="bi bi-moon"></i>
        </button>
        <!-- Wishlist Button with Badge -->
        <button
          id="wishlist-nav-btn"
          class="btn btn-outline-danger btn-sm ms-2 position-relative"
          title="Lihat Wishlist">
          <i class="bi bi-heart"></i>
          <span
            id="wishlist-badge"
            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
            style="display: none">
            0
          </span>
        </button>
      </div>
    </div>
  </nav>

  <header class="hero-section text-center py-5 mb-5">
    <div class="hero-overlay">
      <div class="container py-5">
        <h1 class="display-5 fw-bold text-white">THREADSTOCK</h1>
        <p class="lead text-light">
          Manage and shop the trendiest clothing items.
        </p>
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
              <h2 id="stat-total-produk" class="fw-bold">0 Pcs</h2>
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
              <h2 id="stat-total-model" class="fw-bold">0 Model</h2>
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
              <h2 class="fw-bold">3 Jenis</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="container mb-5">
    <h3 class="fw-bold mb-4 border-start border-4 border-primary ps-3">
      Daftar Katalog Kaos
    </h3>

    <div class="row g-4" id="product-list"></div>

    <!-- Show More Button -->
    <div class="show-more-container text-center mt-4">
      <button id="btn-show-more" class="btn-show-more">Show More</button>
    </div>
  </section>

  <section id="form-input" class="container mb-5 py-5">
    <div class="section-title">
      <i class="bi bi-plus-circle"></i>
      <h3>Add New Product</h3>
    </div>
    <p class="section-desc">
      Manage and browse the available clothing stock below.
    </p>
    <div class="row">
      <div class="col-lg-8 mb-4">
        <!-- CRUD 1: Produk - Form & List (Tambah / Edit / Hapus) -->
        <div class="card border-0 shadow p-4 p-md-5">
          <h3 class="fw-bold mb-4 text-center">Registrasi Produk Baru</h3>
          <form id="product-form">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Nama Model</label>
                <input
                  type="text"
                  id="input-nama"
                  class="form-control"
                  placeholder="e.g. Noir Oversize"
                  required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Kategori</label>
                <select id="input-kategori" class="form-select">
                  <option>T-Shirt</option>
                  <option>Longsleeve</option>
                  <option>Hoodie</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Harga (IDR)</label>
                <input
                  type="number"
                  id="input-harga"
                  class="form-control"
                  placeholder="150000"
                  required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Jumlah Stok</label>
                <input
                  type="number"
                  id="input-stok"
                  class="form-control"
                  placeholder="0"
                  required />
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold">Nama File Foto (mis. .jpg/.png)</label>
                <input
                  type="text"
                  id="input-foto"
                  class="form-control"
                  placeholder="Contoh: kaos-hitam.jpg"
                  required />
                <div class="form-text text-danger">
                  *Pastikan file foto sudah diletakkan di folder assets/
                </div>
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold">Deskripsi singkat</label>
                <textarea
                  id="input-deskripsi"
                  class="form-control"
                  rows="3"
                  placeholder="Tulis deskripsi singkat produk (bahan, fit, catatan)"></textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Ukuran / Size</label>
                <input
                  type="text"
                  id="input-ukuran"
                  class="form-control"
                  placeholder="Contoh: S,M,L,XL" />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Material</label>
                <input
                  type="text"
                  id="input-material"
                  class="form-control"
                  placeholder="Contoh: Katun 100%" />
              </div>
              <div class="col-12 mt-4">
                <button type="submit" class="btn btn-dark w-100 py-2 fw-bold">
                  SIMPAN DATA
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="col-lg-4">
        <!-- CRUD 2: Kategori - Manager (Tambah / Ubah / Hapus) -->
        <div class="card mb-4 p-3">
          <div class="d-flex flex-column gap-3 align-items-start">
            <div class="w-100">
              <label class="form-label fw-semibold">Tambah Kategori</label>
              <div class="d-flex gap-2">
                <input
                  id="new-category-name"
                  type="text"
                  class="form-control"
                  placeholder="Contoh: T-Shirt" />
                <button id="add-category-btn" class="btn btn-primary">
                  Tambah
                </button>
              </div>
            </div>
            <div class="text-muted small">
              Kategori disimpan di browser (localStorage).
            </div>
          </div>

          <div id="category-manager-list" class="mt-3"></div>
        </div>
      </div>
    </div>
  </section>

  <footer class="bg-dark text-white text-center py-4">
    <p class="mb-0 small text-secondary">
      © 2026 THREADSTOCK SYSTEM | Built for Siweb Final Project
    </p>
  </footer>

  <!-- Wishlist Modal -->
  <div class="modal fade" id="wishlistModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            <i class="bi bi-heart-fill text-danger me-2"></i>Daftar Wishlist
          </h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="wishlist-items">
            <p class="text-muted text-center py-4">Wishlist kosong</p>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal">
            Tutup
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal detail produk (lihat seperti pelanggan; klik ikon pensil untuk edit) -->
  <div
    class="modal fade"
    id="productDetailModal"
    tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="productDetailTitle">Detail Produk</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- view mode (default) - tampilkan seperti kartu produk seperti di tampilan pelanggan -->
          <div id="modal-view">
            <div class="card border-0">
              <div class="row g-0">
                <div class="col-md-5 text-center">
                  <img
                    id="modal-image"
                    src=""
                    alt="foto"
                    class="card-img-top p-3"
                    style="max-height: 360px; object-fit: contain"
                    onerror="
                        this.src =
                          'https://via.placeholder.com/400x400?text=Foto+Tidak+Ada'
                      " />
                </div>
                <div class="col-md-7">
                  <div class="card-body">
                    <h5 id="view-nama" class="fw-bold"></h5>
                    <p id="view-harga" class="text-primary fw-bold mb-2"></p>
                    <p id="view-kategori" class="text-muted small mb-2"></p>
                    <p id="view-stok" class="text-muted small mb-2"></p>
                    <p id="view-deskripsi" class="mb-2 text-secondary"></p>
                    <p id="view-ukuran" class="mb-1 small text-secondary"></p>
                    <p
                      id="view-material"
                      class="mb-1 small text-secondary"></p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- edit mode (tersedia, tapi disembunyikan sampai klik pensil) -->
          <form id="modal-product-form" class="d-none">
            <div class="row g-3">
              <div class="col-md-5 text-center">
                <img
                  id="modal-image-edit"
                  src=""
                  alt="foto"
                  class="img-fluid mb-3"
                  onerror="
                      this.src =
                        'https://via.placeholder.com/400x400?text=Foto+Tidak+Ada'
                    " />
                <label class="form-label">Nama file foto</label>
                <input
                  id="modal-foto"
                  class="form-control"
                  placeholder="kaos-hitam.jpg" />
              </div>
              <div class="col-md-7">
                <label class="form-label">Nama model</label>
                <input id="modal-nama" class="form-control" />

                <label class="form-label mt-2">Kategori</label>
                <select id="modal-kategori" class="form-select"></select>

                <div class="row g-2 mt-2">
                  <div class="col-md-6">
                    <label class="form-label">Harga (IDR)</label>
                    <input
                      id="modal-harga"
                      type="number"
                      class="form-control" />
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Stok</label>
                    <input
                      id="modal-stok"
                      type="number"
                      class="form-control" />
                  </div>
                </div>

                <label class="form-label mt-2">Deskripsi</label>
                <textarea
                  id="modal-deskripsi"
                  class="form-control"
                  rows="3"></textarea>

                <div class="row g-2 mt-2">
                  <div class="col-md-6">
                    <label class="form-label">Ukuran</label>
                    <input id="modal-ukuran" class="form-control" />
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Material</label>
                    <input id="modal-material" class="form-control" />
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal">
            Tutup
          </button>
          <button
            type="button"
            id="modal-save-btn"
            class="btn btn-primary d-none">
            Simpan Perubahan
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- External JavaScript -->
  <script src="js/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
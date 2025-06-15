<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDMP Outdoor - Rental & Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>

    <nav class="top-navbar-sibayak">
        <div class="container d-flex align-items-center">
            <a href="<?= base_url('/') ?>">
                <img src="<?= base_url('uploads/logo.png') ?>" alt="PDMP Outdoor Logo" class="logo-brand">
            </a>
            <div class="search-box">
                <input type="text" placeholder="" aria-label="Cari produk">
                <button type="button" aria-label="Search"><i class="fas fa-search"></i></button>
            </div>
            <div class="user-cart-menu">
                <?php if (session()->get('isLoggedIn')): ?>
                    <a href="<?= base_url('keranjang') ?>"><i class="fas fa-shopping-cart"></i> Keranjang</a>
                    <a href="<?= base_url('transaksi') ?>"><i class="fas fa-history"></i> Riwayat</a>
                    <a href="<?= base_url('logout') ?>" class="btn btn-danger btn-sm">Logout</a>
                <?php else: ?>
                    <a href="<?= base_url('login') ?>" class="btn btn-primary btn-sm">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Main Menu (Mirip Sibayak) -->
    <nav class="main-menu-sibayak">
        <div class="container">
            <ul class="ms-auto">
                <li><a href="<?= base_url('/') ?>">Beranda</a></li>
                <li><a href="<?= base_url('produk') ?>">Produk</a></li>
            </ul>
        </div>
    </nav>

    <div class="container main-content-area">
        <div class="row">
            <!-- Main Product Content sekarang mengambil lebar penuh -->
            <div class="col-md-12">
                <div class="product-grid-header">
                    <div class="sort-dropdown">
                        <form action="<?= current_url() ?>" method="get" id="sortForm">
                            <select class="form-select" name="sort" onchange="document.getElementById('sortForm').submit()">
                                <!-- Menghapus opsi "popularitas" dan "terbaru" -->
                                <option value="price_asc" <?= (service('request')->getGet('sort') == 'price_asc') ? 'selected' : '' ?>>Urutkan berdasarkan harga: rendah ke tinggi</option>
                                <option value="price_desc" <?= (service('request')->getGet('sort') == 'price_desc') ? 'selected' : '' ?>>Urutkan berdasarkan harga: tinggi ke rendah</option>
                            </select>
                        </form>
                    </div>
                    <!-- Menghapus div results-info -->
                </div>

                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php if (!empty($produk) && is_array($produk)): ?>
                        <?php foreach ($produk as $item): ?>
                            <div class="col">
                                <div class="product-card-sibayak">
                                    <?php if ($item['gambar']): ?>
                                        <img src="<?= base_url('uploads/' . esc($item['gambar'])) ?>" class="card-img-top" alt="<?= esc($item['nama']) ?>">
                                    <?php else: ?>
                                        <img src="<?= base_url('images/default_product.png') ?>" class="card-img-top" alt="No Image">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <div class="product-name"><?= esc($item['nama']) ?></div>
                                        <div class="product-price">Rp <?= number_format(esc($item['harga']), 0, ',', '.') ?></div>
                                        <a href="<?= base_url('produk/detail/' . esc($item['id'])) ?>" class="btn-detail">Lihat Detail</a>
                                        <form action="<?= base_url('keranjang/tambah') ?>" method="post" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="produk_id" value="<?= esc($item['id']) ?>">
                                            <button type="submit" class="btn-add-cart">Tambah ke Keranjang</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center">
                            <p>Belum ada produk yang tersedia.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <nav aria-label="Product Pagination" class="d-flex pagination-sibayak">
                    <?= $pager->links('default', 'bootstrap_full') ?>
                </nav>

            </div>
        </div>
    </div>

    <?= $this->include('layout/footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

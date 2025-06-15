<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk: <?= esc($produk['nama']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <!-- Style kustom dipindahkan ke public/css/style.css -->
</head>
<body>
    <!-- Top Navbar (Mirip Sibayak) -->
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

    <div class="container my-5">
        <?php if (!empty($produk)): ?>
            <div class="product-detail-card">
                <div class="product-detail-image">
                    <?php if ($produk['gambar']): ?>
                        <img src="<?= base_url('uploads/' . esc($produk['gambar'])) ?>" alt="<?= esc($produk['nama']) ?>">
                    <?php else: ?>
                        <img src="<?= base_url('images/default_product.png') ?>" alt="Gambar Default">
                    <?php endif; ?>
                </div>
                <div class="product-detail-info">
                    <h2><?= esc($produk['nama']) ?></h2>
                    <p class="price">Rp <?= number_format(esc($produk['harga']), 0, ',', '.') ?></p>
                    <p><?= esc($produk['deskripsi']) ?></p>
                    
                    <!-- Wrapper baru untuk tombol aksi agar bisa diatur ke kanan -->
                    <div class="action-buttons-wrapper">
                        <a href="<?= base_url('produk') ?>" class="btn-back-to-products">Kembali ke Daftar Produk</a>
                        <form action="<?= base_url('keranjang/tambah') ?>" method="post" class="d-inline">
                            <?= csrf_field() ?>
                            <input type="hidden" name="produk_id" value="<?= esc($produk['id']) ?>">
                            <button type="submit" class="btn-add-to-cart-detail">Tambah ke Keranjang</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                Produk yang Anda cari tidak ditemukan.
                <br><a href="<?= base_url('produk') ?>" class="btn btn-secondary mt-3">Lihat Semua Produk</a>
            </div>
        <?php endif; ?>
    </div>

    <?= $this->include('layout/footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</ht
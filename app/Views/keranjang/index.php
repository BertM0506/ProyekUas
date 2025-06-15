<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - PDMP Outdoor</title>
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
            <!-- FORMULIR PENCARIAN -->
            <form action="<?= base_url('produk') ?>" method="get" class="search-box" onsubmit="return true;"> <!-- Tambah onsubmit="return true;" -->
                <input type="text" name="keyword" placeholder="" aria-label="Cari produk" value="<?= service('request')->getGet('keyword') ?? '' ?>">
                <button type="submit" aria-label="Search"><i class="fas fa-search"></i></button>
            </form>
            <!-- AKHIR FORMULIR PENCARIAN -->
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
        <h2 class="text-center mb-4">Keranjang Belanja Anda</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($keranjang)): ?>
            <div class="row">
                <div class="col-md-8">
                    <?php foreach ($keranjang as $item): ?>
                        <div class="cart-item">
                            <?php if ($item['gambar']): ?>
                                <img src="<?= base_url('uploads/' . esc($item['gambar'])) ?>" alt="<?= esc($item['nama']) ?>">
                            <?php else: ?>
                                <img src="<?= base_url('images/default_product.png') ?>" alt="Gambar Default">
                            <?php endif; ?>
                            <div class="cart-item-info">
                                <h5><?= esc($item['nama']) ?></h5>
                                <p>Jumlah: <?= esc($item['quantity']) ?></p>
                                <p>Harga Satuan: Rp <?= number_format(esc($item['harga']), 0, ',', '.') ?></p>
                                <p>Subtotal: Rp <?= number_format(esc($item['quantity'] * $item['harga']), 0, ',', '.') ?></p>
                            </div>
                            <div class="cart-item-actions">
                                <a href="<?= base_url('keranjang/hapus/' . esc($item['id'])) ?>" class="btn btn-sm btn-danger">Hapus</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="col-md-4">
                    <div class="cart-summary">
                        <h4>Ringkasan Belanja</h4>
                        <p>Total Item: <?= count($keranjang) ?></p>
                        <p>Total Harga: <strong>Rp <?= number_format(esc($total_keranjang), 0, ',', '.') ?></strong></p>
                        <a href="<?= base_url('checkout') ?>" class="btn btn-checkout mt-3">Lanjutkan ke Checkout</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center" role="alert">
                Keranjang belanja Anda kosong. <a href="<?= base_url('produk') ?>">Yuk, mulai belanja!</a>
            </div>
        <?php endif; ?>
    </div>

    <?= $this->include('layout/footer') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di PDMP Outdoor</title>
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

    <div class="hero-section">
        <h2>Selamat Datang di PDMP Outdoor!</h2>
        <p>Temukan peralatan outdoor terbaik untuk petualangan Anda. Dari tenda hingga perlengkapan masak, kami punya semuanya!</p>
        <a href="<?= base_url('produk') ?>" class="btn btn-lg btn-success">Lihat Semua Produk</a>
    </div>

    <div class="container product-preview-section">
        <h3>Produk Unggulan</h3>
        <div class="product-scroll-wrapper">
            <button class="scroll-button left" onclick="scrollProducts(-300)">&#10094;</button>
            <div class="product-scroll-container" id="productScrollContainer">
                <?php if (!empty($produk_preview) && is_array($produk_preview)): ?>
                    <?php foreach ($produk_preview as $item): ?>
                        <div class="product-card">
                            <?php if ($item['gambar']): ?>
                                <img src="<?= base_url('uploads/' . esc($item['gambar'])) ?>" alt="<?= esc($item['nama']) ?>">
                            <?php else: ?>
                                <img src="<?= base_url('images/default_product.png') ?>" alt="Gambar Default">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5><?= esc($item['nama']) ?></h5>
                                <p class="price">Rp <?= number_format(esc($item['harga']), 0, ',', '.') ?></p>
                                <a href="<?= base_url('produk/detail/' . esc($item['id'])) ?>" class="btn-view">Lihat Barang</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center" style="white-space: normal;">
                        <p>Belum ada produk unggulan untuk ditampilkan.</p>
                    </div>
                <?php endif; ?>
            </div>
            <button class="scroll-button right" onclick="scrollProducts(300)">&#10095;</button>
        </div>
    </div>

    <?= $this->include('layout/footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function scrollProducts(scrollAmount) {
            const container = document.getElementById('productScrollContainer');
            container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - PDMP Outdoor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        <h2 class="text-center mb-4">Konfirmasi Checkout</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($items)): ?>
            <div class="row">
                <div class="col-md-8">
                    <h4>Item di Keranjang</h4>
                    <?php foreach ($items as $item): ?>
                        <div class="checkout-item">
                            <?php if ($item['gambar']): ?>
                                <img src="<?= base_url('uploads/' . esc($item['gambar'])) ?>" alt="<?= esc($item['nama']) ?>">
                            <?php else: ?>
                                <img src="<?= base_url('images/default_product.png') ?>" alt="Gambar Default">
                            <?php endif; ?>
                            <div>
                                <h5><?= esc($item['nama']) ?></h5>
                                <p>Jumlah: <?= esc($item['quantity']) ?> x Rp <?= number_format(esc($item['harga']), 0, ',', '.') ?></p>
                                <p>Subtotal: Rp <?= number_format(esc($item['quantity'] * $item['harga']), 0, ',', '.') ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="col-md-4">
                    <div class="checkout-summary">
                        <h4>Ringkasan Pesanan</h4>
                        <p>Total Item: <?= count($items) ?></p>
                        <p>Total Harga: <strong>Rp <?= number_format(esc($total_checkout), 0, ',', '.') ?></strong></p>

                        <form action="<?= base_url('checkout/process') ?>" method="post" class="mt-3">
                            <?= csrf_field() ?>

                            <!-- BAGIAN PEMILIHAN METODE PEMBAYARAN (DIKEMBALIKAN) -->
                            <h5 class="mt-4 text-start">Pilih Metode Pembayaran</h5>
                            <div class="form-group mb-3 text-start">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="bni" value="BNI_VirtualAccount" required>
                                    <label class="form-check-label" for="bni">
                                        Transfer Bank BNI (Virtual Account)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="bri" value="BRI_VirtualAccount" required>
                                    <label class="form-check-label" for="bri">
                                        Transfer Bank BRI (Virtual Account)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="ovo" value="OVO" required>
                                    <label class="form-check-label" for="ovo">
                                        E-wallet OVO
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="gopay" value="Gopay" required>
                                    <label class="form-check-label" for="gopay">
                                        E-wallet GoPay
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="shopeepay" value="ShopeePay" required>
                                    <label class="form-check-label" for="shopeepay">
                                        E-wallet ShopeePay
                                    </label>
                                </div>
                            </div>
                            <!-- AKHIR BAGIAN PEMILIHAN METODE PEMBAYARAN -->

                            <button type="submit" class="btn btn-process-checkout">Bayar Sekarang</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center" role="alert">
                Tidak ada item untuk di checkout. Silakan kembali ke <a href="<?= base_url('keranjang') ?>">keranjang</a>.
            </div>
        <?php endif; ?>
    </div>

    <?= $this->include('layout/footer') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
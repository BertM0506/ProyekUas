<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - PDMP Outdoor</title>
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
            <form action="<?= base_url('produk') ?>" method="get" class="search-box" onsubmit="return true;">
                <input type="text" name="keyword" placeholder="" aria-label="Cari produk" value="<?= service('request')->getGet('keyword') ?? '' ?>">
                <button type="submit" aria-label="Search"><i class="fas fa-search"></i></button>
            </form>
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

    <nav class="main-menu-sibayak">
        <div class="container">
            <ul class="ms-auto">
                <li><a href="<?= base_url('/') ?>">Beranda</a></li>
                <li><a href="<?= base_url('produk') ?>">Produk</a></li>
            </ul>
        </div>
    </nav>

    <div class="container my-5">
        <h2 class="text-center mb-4">Riwayat Transaksi Anda</h2>

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
        <?php if (session()->getFlashdata('payment_instructions')): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('payment_instructions') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($transaksi)): ?>
            <?php foreach ($transaksi as $trans): ?>
                <div class="transaction-card">
                    <h5>Transaksi #<?= esc($trans['id']) ?> - Tanggal: <?= date('d M Y H:i', strtotime(esc($trans['tanggal']))) ?></h5>
                    <p>Dibeli oleh: <?= esc($trans['username']) ?></p>
                    <p>Metode Pembayaran: <strong><?= esc(str_replace('_', ' ', $trans['metode_pembayaran'] ?? 'Belum Dipilih')) ?></strong></p>
                    <p>Status Pembayaran:
                        <span class="status-badge <?= esc($trans['status_pembayaran'] ?? 'pending') ?>">
                            <?= esc(ucwords($trans['status_pembayaran'] ?? 'pending')) ?>
                        </span>
                    </p>

                    <div class="item-list">
                        <?php if (!empty($trans['items'])): ?>
                            <?php foreach ($trans['items'] as $item_trans): ?>
                                <div class="item-detail">
                                    <?php if ($item_trans['gambar_produk']): ?>
                                        <img src="<?= base_url('uploads/' . esc($item_trans['gambar_produk'])) ?>" alt="<?= esc($item_trans['nama_produk']) ?>">
                                    <?php else: ?>
                                        <img src="<?= base_url('images/default_product.png') ?>" alt="Gambar Default">
                                    <?php endif; ?>
                                    <div>
                                        <p><strong><?= esc($item_trans['nama_produk']) ?></strong></p>
                                        <p><?= esc($item_trans['jumlah']) ?> x Rp <?= number_format(esc($item_trans['harga']), 0, ',', '.') ?> = Rp <?= number_format(esc($item_trans['jumlah'] * $item_trans['harga']), 0, ',', '.') ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Tidak ada item untuk transaksi ini.</p>
                        <?php endif; ?>
                    </div>
                    <div class="total">
                        Total Pembelian: Rp <?= number_format(esc($trans['total_harga']), 0, ',', '.') ?>
                    </div>

                    <?php if (($trans['status_pembayaran'] ?? 'pending') == 'pending'): ?>
                        <div class="transaction-actions">
                            <a href="<?= base_url('transaksi/confirm/' . esc($trans['id'])) ?>" class="btn btn-success btn-sm">
                                Konfirmasi Pembayaran (Simulasi)
                            </a>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info text-center" role="alert">
                Anda belum memiliki riwayat transaksi.
            </div>
        <?php endif; ?>
    </div>

    <?= $this->include('layout/footer') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PDMP Outdoor</title>
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

    <div class="container">
        <div class="login-card">
            <h2>Login ke Akun Anda</h2>
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
            <form action="<?= base_url('login') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn-login">Login</button>
            </form>
        </div>
    </div>

    <?= $this->include('layout/footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

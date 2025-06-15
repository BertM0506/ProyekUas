<header>
    <a href="<?= base_url('/') ?>">
        <img src="<?= base_url('uploads/logo.png') ?>" alt="PDMP Outdoor Logo">
    </a>
    <nav>
        <a href="<?= base_url('produk') ?>">Produk</a>
        <?php if (session()->get('isLoggedIn')): ?>
            <a href="<?= base_url('keranjang') ?>">Keranjang</a>
            <a href="<?= base_url('transaksi') ?>">Riwayat</a>
            <a href="<?= base_url('logout') ?>" class="nav-button logout">Logout</a>
        <?php else: ?>
            <a href="<?= base_url('login') ?>" class="nav-button">Login</a>
        <?php endif; ?>
    </nav>
</header>
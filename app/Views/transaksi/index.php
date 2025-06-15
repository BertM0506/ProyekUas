<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Transaksi</title>
</head>
<body>
    <h2>Riwayat Transaksi Pembelian</h2>
    <a href="<?= base_url('produk') ?>">Kembali ke Produk</a> |
    <a href="<?= base_url('keranjang') ?>">Lihat Keranjang</a> |
    <a href="<?= base_url('auth/logout') ?>">Logout</a><br><br>

    <?php if (empty($transaksi)): ?>
        <p>Belum ada transaksi.</p>
    <?php else: ?>
        <?php foreach ($transaksi as $t): ?>
            <div style="margin-bottom: 20px; border:1px solid #ccc; padding:10px;">
                <strong>Tanggal:</strong> <?= date('d-m-Y H:i', strtotime($t->created_at)) ?><br>
                <strong>Total:</strong> Rp <?= number_format($t->total, 0, ',', '.') ?><br>
                <strong>Item:</strong>
                <ul>
                    <?php foreach ($t->items as $item): ?>
                        <li><?= $item->name ?> (<?= $item->quantity ?> x Rp <?= number_format($item->subtotal / $item->quantity, 0, ',', '.') ?>) = Rp <?= number_format($item->subtotal, 0, ',', '.') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>

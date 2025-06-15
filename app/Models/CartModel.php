<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = 'keranjang'; // Sesuaikan dengan nama tabel di database
    protected $primaryKey = 'id';
    // UBAH DARI 'produk_id' MENJADI 'product_id'
    // UBAH DARI 'jumlah' MENJADI 'quantity'
    protected $allowedFields = ['user_id', 'product_id', 'quantity']; // <--- PERUBAHAN DI BARIS INI

    public function getItems($userId)
    {
        return $this->select('keranjang.*, produk.nama, produk.harga, produk.gambar, produk.deskripsi')
            // UBAH DARI 'keranjang.produk_id' MENJADI 'keranjang.product_id'
            ->join('products as produk', 'produk.id = keranjang.product_id') // <--- PERUBAHAN DI BARIS INI
            ->where('keranjang.user_id', $userId)
            ->findAll();
    }
}
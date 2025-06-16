<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'product_id', 'quantity'];

    public function getItems($userId)
    {
        return $this->select('keranjang.*, produk.nama, produk.harga, produk.gambar, produk.deskripsi')
            ->join('products as produk', 'produk.id = keranjang.product_id')
            ->where('keranjang.user_id', $userId)
            ->findAll();
    }
}

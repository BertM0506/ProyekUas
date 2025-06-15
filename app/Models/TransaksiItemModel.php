<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiItemModel extends Model
{
    // Pastikan ini adalah 'transaksi_item' sesuai nama tabel di database Anda
    protected $table        = 'transaksi_item';
    protected $primaryKey = 'id';

    // Pastikan nama-nama kolom ini sesuai dengan tabel 'transaksi_item' di database Anda
    // transaksi_id, produk_id, jumlah, harga
    protected $allowedFields = ['transaksi_id', 'produk_id', 'jumlah', 'harga'];
    
    // Jika Anda punya kolom created_at/updated_at di tabel ini, Anda bisa aktifkan:
    // protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
}
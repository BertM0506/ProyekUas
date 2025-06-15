<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table        = 'transaksi';
    protected $primaryKey = 'id';

    // PASTIKAN NAMA KOLOM INI ADA DI DATABASE 'transaksi' ANDA
    protected $allowedFields = ['user_id', 'total_harga', 'tanggal', 'metode_pembayaran', 'status_pembayaran', 'bukti_pembayaran'];
    protected $useTimestamps = false; // Tetap false jika tidak ada kolom updated_at

    public function getTransaksiByUser($userId)
    {
        return $this->select('transaksi.*, users.username')
                    ->join('users', 'users.id = transaksi.user_id')
                    ->where('transaksi.user_id', $userId)
                    ->orderBy('transaksi.tanggal', 'DESC')
                    ->findAll();
    }
}
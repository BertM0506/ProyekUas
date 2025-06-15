<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'products'; // SESUAIKAN DENGAN NAMA TABEL DI DATABASE
    protected $primaryKey = 'id';

    protected $allowedFields = ['nama', 'harga', 'deskripsi', 'gambar', 'created_at']; // SESUAIKAN DENGAN NAMA KOLOM DI DATABASE
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
}
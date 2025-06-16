<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nama', 'harga', 'deskripsi', 'gambar', 'created_at']; 
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
}
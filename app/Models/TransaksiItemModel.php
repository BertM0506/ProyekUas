<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiItemModel extends Model
{
    protected $table        = 'transaksi_item';
    protected $primaryKey = 'id';


    protected $allowedFields = ['transaksi_id', 'produk_id', 'jumlah', 'harga'];
    

}
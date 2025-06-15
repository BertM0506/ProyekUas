<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Home extends BaseController
{
    public function index()
    {
        $produkModel = new ProdukModel();
        $data['produk_preview'] = $produkModel->orderBy('created_at', 'DESC')->limit(6)->findAll();
        return view('home/index', $data);
    }
}
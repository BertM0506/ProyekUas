<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Produk extends BaseController
{
    public function index()
    {
        $produkModel = new ProdukModel();
        
        $sort = $this->request->getGet('sort');
        
        $query = $produkModel;

        switch ($sort) {
            case 'price_asc':
                $query = $query->orderBy('harga', 'ASC');
                break;
            case 'price_desc':
                $query = $query->orderBy('harga', 'DESC');
                break;
            case 'latest':
                $query = $query->orderBy('created_at', 'DESC');
                break;
            case 'popularity':
            default:
                $query = $query->orderBy('id', 'ASC');
                break;
        }

        $perPage = 8;
        
        $data['produk'] = $query->paginate($perPage);
        $data['pager'] = $produkModel->pager; 
        
        return view('produk/index', $data);
    }

    public function detail($id = null)
    {
        $produkModel = new ProdukModel();
        $data['produk'] = $produkModel->find($id);

        if (empty($data['produk'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk dengan ID ' . $id . ' tidak ditemukan.');
        }

        return view('produk/detail', $data);
    }
}
<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use CodeIgniter\Pager\Pager;

class Produk extends BaseController
{
    public function index()
    {
        $produkModel = new ProdukModel();
        
        $sort = $this->request->getGet('sort');
        $keyword = $this->request->getGet('keyword');

        $query = $produkModel;

        if (!empty($keyword)) {
            $query = $query->like('nama', $keyword)
                           ->orLike('deskripsi', $keyword);
        }

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
            default: // 'popularity' or any other default
                $query = $query->orderBy('id', 'ASC'); 
                break;
        }

        $perPage = 8; 
        
        $data['produk'] = $query->paginate($perPage);
        $data['pager'] = $produkModel->pager;
        $data['keyword'] = $keyword;

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

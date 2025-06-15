<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use CodeIgniter\Pager\Pager; // Penambahan: Mengimpor kelas Pager

class Produk extends BaseController
{
    public function index()
    {
        $produkModel = new ProdukModel();
        
        $sort = $this->request->getGet('sort');
        $keyword = $this->request->getGet('keyword'); // Penambahan: Mengambil keyword pencarian

        $query = $produkModel;

        // Penambahan: Logika pencarian jika ada keyword
        if (!empty($keyword)) {
            $query = $query->like('nama', $keyword)
                           ->orLike('deskripsi', $keyword);
        }

        // Perubahan: Menerapkan sorting berdasarkan parameter
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
                $query = $query->orderBy('id', 'ASC'); // Default sort
                break;
        }

        // Penambahan: Menentukan jumlah produk per halaman
        $perPage = 8; 
        
        // Perubahan: Mengambil produk dengan pagination
        $data['produk'] = $query->paginate($perPage);
        $data['pager'] = $produkModel->pager; // Penambahan: Mengambil object Pager untuk view
        $data['keyword'] = $keyword; // Penambahan: Mengirim keyword kembali ke view

        // Memuat view 'produk/index' dengan data produk, pager, dan keyword
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

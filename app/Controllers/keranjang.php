<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\ProdukModel; // Pastikan ini dipanggil

class Keranjang extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login untuk melihat keranjang.');
        }

        $model = new CartModel();
        $data['keranjang'] = $model->getItems(session()->get('userId'));

        $total = 0;
        foreach ($data['keranjang'] as $item) {
            // UBAH DARI $item['jumlah'] MENJADI $item['quantity']
            $total += $item['quantity'] * $item['harga']; // <--- PERUBAHAN DI SINI
        }
        $data['total_keranjang'] = $total;

        return view('keranjang/index', $data);
    }


    public function tambah()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login untuk menambahkan produk ke keranjang.');
        }

        $userId = $session->get('userId');
        $produkId = $this->request->getPost('produk_id'); // Nama input dari form ini sudah benar

        $cartModel = new CartModel();

        // Cek apakah produk sudah ada di keranjang
        $existingItem = $cartModel->where('user_id', $userId)
                                  ->where('product_id', $produkId) // <--- PERUBAHAN DI SINI: DARI 'produk_id' MENJADI 'product_id'
                                  ->first();

        if ($existingItem) {
            // Jika sudah ada, update jumlahnya
            // Pastikan kolom 'jumlah' di database adalah 'quantity'
            $cartModel->update($existingItem['id'], ['quantity' => $existingItem['quantity'] + 1]); // <--- PERUBAHAN JUMLAH JUGA
        } else {
            // Jika belum ada, tambahkan baru
            $cartModel->insert([
                'user_id' => $userId,
                'product_id' => $produkId, // <--- PERUBAHAN DI SINI: DARI 'produk_id' MENJADI 'product_id'
                'quantity' => 1 // <--- PERUBAHAN DI SINI: DARI 'jumlah' MENJADI 'quantity'
            ]);
        }

        return redirect()->to('/keranjang')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function hapus($itemId = null)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login untuk menghapus produk dari keranjang.');
        }

        $cartModel = new CartModel();
        $item = $cartModel->find($itemId);

        if ($item && $item['user_id'] == $session->get('userId')) {
            $cartModel->delete($itemId);
            return redirect()->to('/keranjang')->with('success', 'Produk berhasil dihapus dari keranjang.');
        }

        return redirect()->to('/keranjang')->with('error', 'Item keranjang tidak ditemukan atau Anda tidak memiliki izin.');
    }
}
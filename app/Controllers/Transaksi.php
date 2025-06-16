<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\TransaksiItemModel;
use App\Models\ProdukModel;

class Transaksi extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login untuk melihat riwayat transaksi.');
        }

        $transaksiModel = new TransaksiModel();
        $transaksiItemModel = new TransaksiItemModel();
        $produkModel = new ProdukModel();

        $daftarTransaksi = $transaksiModel->getTransaksiByUser(session()->get('userId'));

        foreach ($daftarTransaksi as &$trans) {
            $transaksiItems = $transaksiItemModel->where('transaksi_id', $trans['id'])->findAll();

            foreach ($transaksiItems as &$item) {
                $produkDetail = $produkModel->find($item['produk_id']);
                if ($produkDetail) {
                    $item['nama_produk'] = $produkDetail['nama'];
                    $item['gambar_produk'] = $produkDetail['gambar'];
                } else {
                    $item['nama_produk'] = 'Produk Tidak Ditemukan';
                    $item['gambar_produk'] = 'default_product.png';
                }
            }
            $trans['items'] = $transaksiItems;
        }

        $data['transaksi'] = $daftarTransaksi;

        return view('transaksi/riwayat', $data);
    }

    public function confirmPayment($transaksiId = null)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login untuk konfirmasi pembayaran.');
        }

        if ($transaksiId === null) {
            return redirect()->to('/transaksi')->with('error', 'ID Transaksi tidak valid.');
        }

        $transaksiModel = new TransaksiModel();
        $transaksi = $transaksiModel->find($transaksiId);

        if (empty($transaksi) || $transaksi['user_id'] != $session->get('userId')) {
            return redirect()->to('/transaksi')->with('error', 'Transaksi tidak ditemukan atau Anda tidak memiliki akses.');
        }

        if ($transaksi['status_pembayaran'] == 'pending') {
            $updateData = [
                'status_pembayaran' => 'paid',
            ];

            if ($transaksiModel->update($transaksiId, $updateData)) {
                return redirect()->to('/transaksi')->with('success', 'Status pembayaran transaksi #' . $transaksiId . ' berhasil diperbarui menjadi "Paid".');
            } else {
                $errors = $transaksiModel->errors();
                $dbError = $transaksiModel->db->error();
                $errorMessage = 'Gagal memperbarui status pembayaran.';
                if (!empty($errors)) $errorMessage .= ' Validasi: ' . implode(', ', $errors);
                if (!empty($dbError['message'])) $errorMessage .= ' DB Error: ' . $dbError['message'];

                return redirect()->to('/transaksi')->with('error', $errorMessage);
            }
        } else {
            return redirect()->to('/transaksi')->with('error', 'Status pembayaran transaksi #' . $transaksiId . ' sudah tidak "pending".');
        }
    }
}

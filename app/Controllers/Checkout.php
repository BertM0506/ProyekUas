<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\TransaksiModel;
use App\Models\TransaksiItemModel;
use App\Models\ProdukModel;

class Checkout extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login untuk melanjutkan checkout.');
        }

        $userId = $session->get('userId');
        $cartModel = new CartModel();
        $data['items'] = $cartModel->getItems($userId);

        $total_checkout = 0;
        foreach ($data['items'] as $item) {
            $total_checkout += $item['quantity'] * $item['harga'];
        }
        $data['total_checkout'] = $total_checkout;

        if (empty($data['items'])) {
            return redirect()->to('/keranjang')->with('error', 'Keranjang Anda kosong.');
        }

        return view('checkout/index', $data);
    }

    public function process()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login untuk memproses checkout.');
        }

        $userId = $session->get('userId');
        $cartModel = new CartModel();
        $transaksiModel = new TransaksiModel();
        $transaksiItemModel = new TransaksiItemModel();
        $produkModel = new ProdukModel();

        $cartItems = $cartModel->getItems($userId);

        if (empty($cartItems)) {
            return redirect()->to('/keranjang')->with('error', 'Tidak ada item di keranjang untuk diproses.');
        }

        $totalTransaksi = 0;
        $itemsForTransaksi = [];

        foreach ($cartItems as $item) {
            $product = $produkModel->find($item['product_id']);
            if ($product) {
                $subtotalItem = $item['quantity'] * $product['harga'];
                $totalTransaksi += $subtotalItem;
                $itemsForTransaksi[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'harga_satuan' => $product['harga'],
                    'subtotal' => $subtotalItem,
                ];
            } else {
                return redirect()->back()->with('error', 'Salah satu produk di keranjang tidak valid.');
            }
        }

        $transaksiModel->db->transBegin();

        try {
            $paymentMethod = $this->request->getPost('payment_method'); 
            if (empty($paymentMethod)) { 
                throw new \Exception('Metode pembayaran harus dipilih.');
            }

            $transaksiData = [
                'user_id' => $userId,
                'total_harga' => $totalTransaksi,
                'tanggal' => date('Y-m-d H:i:s'),
                'metode_pembayaran' => $paymentMethod, // Simpan metode pembayaran
                'status_pembayaran' => 'pending', // Status awal
                'bukti_pembayaran' => null, // Default null, akan diisi saat konfirmasi jika diperlukan
            ];

            $transaksiId = $transaksiModel->insert($transaksiData, true);

            if (!$transaksiId) {
                $errors = $transaksiModel->errors();
                $dbError = $transaksiModel->db->error();

                $errorMessage = 'Gagal membuat transaksi.';
                if (!empty($errors)) {
                    $errorMessage .= ' Validasi Model (Transaksi): ' . implode(', ', $errors);
                }
                if (!empty($dbError['message'])) {
                    $errorMessage .= ' Error DB (Transaksi): (' . $dbError['code'] . ') ' . $dbError['message'];
                }
                throw new \Exception($errorMessage);
            }

            foreach ($itemsForTransaksi as $item) {
                $itemInsertData = [
                    'transaksi_id' => $transaksiId,
                    'produk_id' => $item['product_id'],
                    'jumlah' => $item['quantity'],
                    'harga' => $item['subtotal'],
                ];

                $transaksiItemInserted = $transaksiItemModel->insert($itemInsertData);

                if (!$transaksiItemInserted) {
                    $errors = $transaksiItemModel->errors();
                    $dbError = $transaksiItemModel->db->error();

                    $errorMessage = 'Gagal membuat item transaksi.';
                    if (!empty($errors)) {
                        $errorMessage .= ' Validasi Model (Item): ' . implode(', ', $errors);
                    }
                    if (!empty($dbError['message'])) {
                        $errorMessage .= ' Error DB (Item): (' . $dbError['code'] . ') ' . $dbError['message'];
                    }
                    throw new \Exception($errorMessage);
                }
            }

            $cartModel->where('user_id', $userId)->delete();

            $transaksiModel->db->transCommit();

            // --- BAGIAN SIMULASI INSTRUKSI PEMBAYARAN ---
            $instructionMessage = "Pesanan Anda berhasil dibuat! ";
            $formattedTotal = 'Rp ' . number_format($totalTransaksi, 0, ',', '.');
            $transaksiNumber = '#' . $transaksiId;

            switch ($paymentMethod) {
                case 'BNI_VirtualAccount':
                    $vaNumber = '8801' . str_pad($userId, 5, '0', STR_PAD_LEFT) . $transaksiId;
                    $instructionMessage .= "Segera lakukan pembayaran sebesar {$formattedTotal} untuk transaksi {$transaksiNumber} melalui Transfer Bank BNI Virtual Account ke nomor: <strong>{$vaNumber}</strong>. (Simulasi, konfirmasi manual via tombol).";
                    break;
                case 'BRI_VirtualAccount':
                    $vaNumber = '1122' . str_pad($userId, 5, '0', STR_PAD_LEFT) . $transaksiId;
                    $instructionMessage .= "Segera lakukan pembayaran sebesar {$formattedTotal} untuk transaksi {$transaksiNumber} melalui Transfer Bank BRI Virtual Account ke nomor: <strong>{$vaNumber}</strong>. (Simulasi, konfirmasi manual via tombol).";
                    break;
                case 'OVO':
                case 'Gopay':
                case 'ShopeePay':
                    $instructionMessage .= "Segera lakukan pembayaran sebesar {$formattedTotal} untuk transaksi {$transaksiNumber} melalui E-wallet <strong>" . str_replace('_', ' ', $paymentMethod) . "</strong>. Buka aplikasi e-wallet Anda dan scan QR Code (simulasi) atau transfer ke nomor tujuan 0812XXXXXXXX. (Simulasi, konfirmasi manual via tombol).";
                    break;
                default:
                    $instructionMessage .= "Pembayaran sebesar {$formattedTotal} untuk transaksi {$transaksiNumber} sedang menunggu konfirmasi. Metode pembayaran: " . str_replace('_', ' ', $paymentMethod) . ".";
                    break;
            }

            session()->setFlashdata('payment_instructions', $instructionMessage);

            return redirect()->to('/transaksi')->with('success', 'Checkout berhasil!');

        } catch (\Exception $e) {
            $transaksiModel->db->transRollback();
            log_message('error', 'Checkout failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Checkout gagal: ' . $e->getMessage());
        }
    }
}
<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function loginPost()
    {
        $session = session();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            $session->set('isLoggedIn', true);
            $session->set('userId', $user['id']);
            $session->set('username', $user['username']);

            return redirect()->to('/');
        }

        return redirect()->back()->with('error', 'Login gagal. Username atau password salah.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    // --- METODE BARU UNTUK REGISTRASI ---

    /**
     * Menampilkan halaman pendaftaran user baru.
     */
    public function register()
    {
        return view('auth/register'); // Memuat view register.php
    }

    /**
     * Memproses pengiriman form pendaftaran user baru.
     */
    public function registerPost()
    {
        $userModel = new UserModel();

        // Ambil data dari form
        $rules = [
            'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'pass_confirm' => 'required_with[password]|matches[password]', // Konfirmasi password
            'nama'     => 'required|max_length[50]', // Asumsi kolom 'nama' ada di DB
        ];

        // Jalankan validasi
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Siapkan data untuk disimpan
        $data = [
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'), // Password akan dihash otomatis oleh UserModel
            'nama'     => $this->request->getPost('nama'),
        ];

        // Simpan data user ke database
        if ($userModel->insert($data)) {
            // Jika pendaftaran berhasil, arahkan ke halaman login dengan pesan sukses
            return redirect()->to('/login')->with('success', 'Pendaftaran berhasil! Silakan login.');
        } else {
            // Jika gagal menyimpan (misal error DB lainnya), arahkan kembali dengan pesan error
            return redirect()->back()->withInput()->with('error', 'Gagal mendaftar. Silakan coba lagi.');
        }
    }
}

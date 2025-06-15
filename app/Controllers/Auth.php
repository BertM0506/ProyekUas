<?php
// app/Controllers/Auth.php

namespace App\Controllers;

use App\Models\UserModel; // Pastikan ini ada di bagian atas file
use CodeIgniter\Controller; // Pastikan ini ada di bagian atas file

// Pastikan BaseController Anda berada di namespace yang sama atau di-import jika berbeda.
// Untuk CodeIgniter standar, BaseController biasanya ada di App\Controllers.
class Auth extends BaseController
{
    /**
     * Menampilkan halaman login.
     */
    public function login()
    {
        return view('auth/login');
    }

    /**
     * Menangani proses login setelah form disubmit.
     */
    public function loginPost()
    {
        $session = session(); // Mengambil instance session
        $username = $this->request->getPost('username'); // Mengambil username dari POST
        $password = $this->request->getPost('password'); // Mengambil password dari POST

        $userModel = new UserModel(); // Membuat instance UserModel
        $user = $userModel->where('username', $username)->first(); // Mencari user berdasarkan username

        // Memverifikasi password. password_verify() membandingkan password plain-text dengan hash di database.
        if ($user && password_verify($password, $user['password'])) {
            // Jika login berhasil, set session user
            $session->set('isLoggedIn', true);
            $session->set('userId', $user['id']);
            $session->set('username', $user['username']); // Simpan username di session juga

            // Arahkan ke halaman utama ('/') setelah login berhasil
            return redirect()->to('/'); // <--- PERUBAHAN DI SINI: DULU KE '/dashboard', SEKARANG KE '/'
        }

        // Jika login gagal, arahkan kembali ke halaman login dengan pesan error
        return redirect()->back()->with('error', 'Login gagal. Username atau password salah.');
    }

    /**
     * Menangani proses logout.
     */
    public function logout()
    {
        session()->destroy(); // Menghancurkan semua data session
        return redirect()->to('/'); // Arahkan ke halaman utama
    }

    /**
     * METHOD SEMENTARA UNTUK DEBUGGING / MEMBUAT AKUN AWAL.
     * HAPUS METHOD INI SETELAH AKUN BERHASIL DIBUAT DAN BISA LOGIN!
     *
     * Cara menggunakan: Akses URL ini di browser Anda (contoh: http://localhost:8080/auth/createInitialUsers)
     */
    public function createInitialUsers()
    {
        $userModel = new UserModel();

        // Data user yang akan dibuat
        $usersToCreate = [
            [
                'username' => 'testuser', // Username untuk login
                'password' => 'pass123',  // Password plain-text untuk login
                'nama'     => 'User Tes',
            ],
            // Anda bisa menambahkan user lain di sini jika perlu, misalnya:
            /*
            [
                'username' => 'Shucbert',
                'password' => 'Shucbert123',
                'nama'     => 'Shucbert A',
            ],
            [
                'username' => 'Berkath',
                'password' => 'Berkath456',
                'nama'     => 'Berkath B',
            ],
            [
                'username' => 'Manalu',
                'password' => 'Manalu789',
                'nama'     => 'Manalu C',
            ],
            */
        ];

        echo "<h2>Membuat Akun Pengguna Awal:</h2>";
        foreach ($usersToCreate as $userData) {
            $username = $userData['username'];

            // Cek apakah user sudah ada untuk menghindari duplikasi
            $existingUser = $userModel->where('username', $username)->first();

            if ($existingUser) {
                echo "<p style='color: orange;'>User '{$username}' sudah ada. Melewatkan pembuatan.</p>";
            } else {
                // Insert user. UserModel akan secara otomatis menghash password karena ada beforeInsert callback.
                if ($userModel->insert($userData)) {
                    echo "<p style='color: green;'>User '{$username}' berhasil dibuat dengan password yang dihash!</p>";
                } else {
                    echo "<p style='color: red;'>Gagal membuat user '{$username}': " . implode(', ', $userModel->errors()) . "</p>";
                }
            }
        }
        
    }
}
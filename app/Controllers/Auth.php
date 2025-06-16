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


    public function register()
    {
        return view('auth/register'); 
    }

 
    public function registerPost()
    {
        $userModel = new UserModel();

        $rules = [
            'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'pass_confirm' => 'required_with[password]|matches[password]', 
            'nama'     => 'required|max_length[50]', 
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'), 
            'nama'     => $this->request->getPost('nama'),
        ];

        if ($userModel->insert($data)) {
            return redirect()->to('/login')->with('success', 'Pendaftaran berhasil! Silakan login.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mendaftar. Silakan coba lagi.');
        }
    }
}

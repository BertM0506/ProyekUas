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
}

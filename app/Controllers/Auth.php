<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    public function index()
    {
        return view('v_front_end'); // halaman utama (punya tombol login admin & user)
    }

    // ===============================
    // LOGIN ADMIN
    // ===============================
    public function login()
    {
        return view('v_login'); // form login admin
    }

    public function processLogin()
    {
        $session = session();
        $model = new UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cek user di tabel tb_user (username / email)
        $user = $model
            ->groupStart()
            ->where('username', $username)
            ->orWhere('email', $username)
            ->groupEnd()
            ->first();

        if ($user) {
            if ($password === $user['password']) {
                // Set session login admin
                $session->set([
                    'user_id'   => $user['id'],
                    'username'  => $user['username'],
                    'email'     => $user['email'],
                    'role'      => 'admin',  // tambahkan ini
                    'logged_in' => true
                ]);

                // Arahkan ke dashboard admin
                return redirect()->to(base_url('auth/dashboardAdmin'));
            } else {
                $session->setFlashdata('error', 'Password salah.');
                return redirect()->back();
            }
        } else {
            $session->setFlashdata('error', 'Username atau email tidak ditemukan.');
            return redirect()->back();
        }
    }

    public function dashboardAdmin()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('auth/login'));
        }

        return view('v_dashboard_admin');
    }

    // ===============================
    // LOGIN USER (tanpa form)
    // ===============================
    public function loginAsUser()
    {
        $session = session();

        // Langsung buat sesi user tanpa perlu input login
        $session->set([
            'user_id'   => 2,
            'username'  => 'user_demo',
            'email'     => 'user@example.com',
            'logged_in' => true
        ]);

        // Arahkan ke dashboard user
        return redirect()->to(base_url('auth/dashboardUser'));
    }

    public function dashboardUser()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('auth/loginAsUser'));
        }

        return view('v_dashboard_user');
    }

    // ===============================
    // LOGOUT
    // ===============================
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('auth/login'));
    }
}

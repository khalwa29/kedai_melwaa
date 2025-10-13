<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    public function index()
    {
        return view('v_front_end'); // halaman depan (umum)
    }

    public function login()
    {
        return view('v_login'); // form login
    }

    public function processLogin()
    {
        $session = session();
        $model = new UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cek user berdasarkan username
        $user = $model->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                // Set session login
                $session->set([
                    'user_id'   => $user['id'],
                    'username'  => $user['username'],
                    'role'      => $user['role'], // contoh: admin atau user
                    'logged_in' => true
                ]);

                // Arahkan sesuai role
                if ($user['role'] == 'admin') {
                    return redirect()->to(base_url('auth/dashboardAdmin'));
                } else {
                    return redirect()->to(base_url('auth/dashboardUser'));
                }
            } else {
                $session->setFlashdata('error', 'Password salah.');
                return redirect()->back();
            }
        } else {
            $session->setFlashdata('error', 'Username tidak ditemukan.');
            return redirect()->back();
        }
    }

    public function dashboardAdmin()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to(base_url('auth/login'));
        }

        // Muat layout backend + konten dashboard
        return view('v_back_end', [
            'page' => 'v_dashboard_admin'
        ]);
    }

    public function dashboardUser()
    {
        if (session()->get('role') != 'user') {
            return redirect()->to(base_url('auth/login'));
        }

        // Bisa diarahkan ke layout berbeda, atau langsung ke dashboard user
        return view('v_dashboard_user');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('auth/login'));
    }
}

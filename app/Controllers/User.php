<?php

namespace App\Controllers;

class User extends BaseController
{
    public function dashboard()
    {
        $session = session();

        // Jika belum ada session guest/user, set otomatis
        if (!$session->get('isLoggedIn')) {
            $session->set([
                'username' => 'Tamu',
                'role'     => 'user',
                'isLoggedIn' => true
            ]);
        }

        return view('user/dashboard'); // file view: app/Views/user/dashboard.php
    }
}

<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function dashboard()
    {
        // Cek apakah admin sudah login
        if (!session()->get('isAdmin')) {
            return redirect()->to('/login');
        }

        return view('wilayah/v_back_end'); // tampilan back end admin
    }
}

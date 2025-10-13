<?php

namespace App\Controllers;

class User extends BaseController
{
    public function dashboard()
    {
        if (session()->get('role') !== 'user') {
            return redirect()->to('/');
        }

        return view('wilayah/v_front_end'); // tampilan user
    }
}
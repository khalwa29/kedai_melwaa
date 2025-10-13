<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        return view('v_login'); // pastikan ada file v_login.php di app/Views/
    }
}

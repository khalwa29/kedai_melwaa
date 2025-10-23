<?php

namespace App\Controllers;

use App\Models\MenuModel;
use CodeIgniter\Controller;

class Menu extends Controller
{
    public function index()
    {
        $menuModel = new MenuModel();
        $data['menu'] = $menuModel->findAll();
        return view('menu/index', $data);
    }
}

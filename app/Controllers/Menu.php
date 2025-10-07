<?php

namespace App\Controllers;

use App\Models\MenuModel; // kalau pakai model untuk data menu

class Menu extends BaseController
{
    public function index()
    {
        $model = new MenuModel();
        $data['menus'] = $model->findAll(); // ambil semua data menu
        return view('menu/v_menu', $data); // panggil view
    }
}

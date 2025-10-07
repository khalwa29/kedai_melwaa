<?php

namespace App\Controllers;
use App\Models\MenuModel;

class Home extends BaseController
{
    public function index()
    {
        $menuModel = new MenuModel();
        $minuman = $menuModel->where('kategori','Minuman')->findAll();
        $makanan = $menuModel->where('kategori','Makanan')->findAll();

        $data = [
            'minuman' => $minuman,
            'makanan' => $makanan
        ];

        return view('v_front_end', $data);
    }
}

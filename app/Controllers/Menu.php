<?php
namespace App\Controllers;

class Menu extends BaseController
{
    public function index()
    {
        // jika ingin auto-login user, jangan redirect ke login
        $minuman = $this->menuModel->getMinuman();
        $makanan = $this->menuModel->getMakanan();

        return view('menu/v_menu', [
            'minuman' => $minuman,
            'makanan' => $makanan
        ]);
    }
}
